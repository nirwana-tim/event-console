<?php
<<<<<<< HEAD
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model
{
    const TABLE = 'events';

    public function get_all($limit = null, $offset = 0, $keyword = null)
    {
        $this->apply_search($keyword);
        $this->db->order_by('tanggal', 'DESC');
        $this->db->order_by('id', 'DESC');

        if ($limit !== null) {
            return $this->db->get(self::TABLE, (int) $limit, (int) $offset)->result();
        }

        return $this->db->get(self::TABLE)->result();
    }

    public function count_all($keyword = null)
    {
        $this->apply_search($keyword);

        return $this->db->count_all_results(self::TABLE);
    }

    public function get_by_id($id)
    {
        return $this->db->get_where(self::TABLE, array('id' => (int) $id))->row();
    }

    public function insert($data)
    {
        return $this->db->insert(self::TABLE, $data);
    }

    public function update($id, $data)
    {
        return $this->db
            ->where('id', (int) $id)
            ->update(self::TABLE, $data);
    }

    public function delete($id)
    {
        return $this->db
            ->where('id', (int) $id)
            ->delete(self::TABLE);
    }

    public function has_registrations($event_id)
    {
        return $this->db
            ->where('event_id', (int) $event_id)
            ->count_all_results('pendaftaran') > 0;
    }

    public function get_options()
    {
        return $this->db
            ->order_by('nama_event', 'ASC')
            ->get(self::TABLE)
            ->result();
    }

    public function get_registrations($event_id = null)
    {
        $this->db->select('
            pendaftaran.*,
            users.nama,
            users.email,
            events.nama_event,
            pembayaran.status AS status_pembayaran
        ');
        $this->db->from('pendaftaran');
        $this->db->join('users', 'users.id = pendaftaran.user_id');
        $this->db->join('events', 'events.id = pendaftaran.event_id');
        $this->db->join('pembayaran', 'pembayaran.pendaftaran_id = pendaftaran.id', 'left');

        if ($event_id) {
            $this->db->where('pendaftaran.event_id', (int) $event_id);
        }

        return $this->db
            ->order_by('pendaftaran.id', 'DESC')
            ->get()
            ->result();
    }

    public function get_payments()
    {
        $this->db->select('
            pembayaran.*,
            users.nama,
            events.nama_event,
            sertifikat.id AS sertifikat_id,
            sertifikat.nomor_sertifikat
        ');
        $this->db->from('pembayaran');
        $this->db->join('pendaftaran', 'pendaftaran.id = pembayaran.pendaftaran_id');
        $this->db->join('users', 'users.id = pendaftaran.user_id');
        $this->db->join('events', 'events.id = pendaftaran.event_id');
        $this->db->join('sertifikat', 'sertifikat.pendaftaran_id = pendaftaran.id', 'left');

        return $this->db
            ->order_by('pembayaran.id', 'DESC')
            ->get()
            ->result();
    }

    public function get_payment_by_id($id)
    {
        return $this->db
            ->get_where('pembayaran', array('id' => (int) $id))
            ->row();
    }

    public function approve_payment($id)
    {
        $payment = $this->get_payment_by_id($id);

        if (!$payment) {
            return false;
        }

        $this->db->trans_start();

        $this->db
            ->where('id', (int) $id)
            ->update('pembayaran', array('status' => 'verified'));

        $this->db
            ->where('id', (int) $payment->pendaftaran_id)
            ->update('pendaftaran', array('status' => 'approved'));

        $certificate = $this->db
            ->get_where('sertifikat', array('pendaftaran_id' => (int) $payment->pendaftaran_id))
            ->row();

        if (!$certificate) {
            $certificate_number = 'SRT-' . $payment->pendaftaran_id . '-' . date('YmdHis');

            $this->db->insert('sertifikat', array(
                'pendaftaran_id' => (int) $payment->pendaftaran_id,
                'nomor_sertifikat' => $certificate_number,
                'file_sertifikat' => $certificate_number . '.pdf',
            ));
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function get_certificate_by_id($id, $user_id = null)
    {
        $this->db->select('sertifikat.*, users.nama, events.nama_event');
        $this->db->from('sertifikat');
        $this->db->join('pendaftaran', 'pendaftaran.id = sertifikat.pendaftaran_id');
        $this->db->join('users', 'users.id = pendaftaran.user_id');
        $this->db->join('events', 'events.id = pendaftaran.event_id');
        $this->db->where('sertifikat.id', (int) $id);

        if ($user_id !== null) {
            $this->db->where('users.id', (int) $user_id);
        }

        return $this->db->get()->row();
    }

    public function get_user_certificates($user_id)
    {
        $this->db->select('sertifikat.*, events.nama_event, users.nama');
        $this->db->from('sertifikat');
        $this->db->join('pendaftaran', 'pendaftaran.id = sertifikat.pendaftaran_id');
        $this->db->join('users', 'users.id = pendaftaran.user_id');
        $this->db->join('events', 'events.id = pendaftaran.event_id');
        $this->db->where('users.id', (int) $user_id);

        return $this->db
            ->order_by('sertifikat.id', 'DESC')
            ->get()
            ->result();
    }

    public function get_participants($event_id)
    {
        $this->db->select('
            users.nama,
            users.email,
            pendaftaran.no_hp,
            pendaftaran.instansi,
            pendaftaran.alamat,
            pendaftaran.team,
            pendaftaran.status,
            pembayaran.status AS status_pembayaran
        ');
        $this->db->from('pendaftaran');
        $this->db->join('users', 'users.id = pendaftaran.user_id');
        $this->db->join('pembayaran', 'pembayaran.pendaftaran_id = pendaftaran.id', 'left');
        $this->db->where('pendaftaran.event_id', (int) $event_id);

        return $this->db
            ->order_by('users.nama', 'ASC')
            ->get()
            ->result();
    }

    public function getAll($limit, $start, $keyword = null)
    {
        return $this->get_all($limit, $start, $keyword);
=======
class Event_model extends CI_Model {

    public function getAll($limit, $start, $keyword = null)
    {
        if($keyword){
            $this->db->like('nama_event', $keyword);
        }

        return $this->db->get('events', $limit, $start)->result();
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
    }

    public function countData($keyword = null)
    {
<<<<<<< HEAD
        return $this->count_all($keyword);
=======
        if($keyword){
            $this->db->like('nama_event', $keyword);
        }

        return $this->db->count_all_results('events');
    }

    public function insert($data)
    {
        return $this->db->insert('events', $data);
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
    }

    public function getById($id)
    {
<<<<<<< HEAD
        return $this->get_by_id($id);
    }

    private function apply_search($keyword)
    {
        $keyword = trim((string) $keyword);

        if ($keyword === '') {
            return;
        }

        $this->db->group_start();
        $this->db->like('nama_event', $keyword);
        $this->db->or_like('lokasi', $keyword);
        $this->db->group_end();
=======
        return $this->db->get_where('events', ['id' => $id])->row();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('events', $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete('events');
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
    }
}
