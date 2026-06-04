<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model
{
    const TABLE = 'events';

    public function get_all($limit = null, $offset = 0, $keyword = null)
    {
        $this->apply_search($keyword);
        $this->db->order_by('date', 'DESC');
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
            ->count_all_results('registrations') > 0;
    }

    public function get_options()
    {
        return $this->db
            ->order_by('name', 'ASC')
            ->get(self::TABLE)
            ->result();
    }

    public function get_registrations($event_id = null)
    {
        $this->db->select('
            registrations.*,
            users.name AS user_name,
            users.email,
            events.name AS event_name,
            payments.status AS status_payment
        ');
        $this->db->from('registrations');
        $this->db->join('users', 'users.id = registrations.user_id');
        $this->db->join('events', 'events.id = registrations.event_id');
        $this->db->join('payments', 'payments.registration_id = registrations.id', 'left');

        if ($event_id) {
            $this->db->where('registrations.event_id', (int) $event_id);
        }

        return $this->db
            ->order_by('registrations.id', 'DESC')
            ->get()
            ->result();
    }

    public function get_payments()
    {
        $this->db->select('
            payments.*,
            users.name AS user_name,
            events.name AS event_name,
            certificates.id AS certificate_id,
            certificates.certificate_number
        ');
        $this->db->from('payments');
        $this->db->join('registrations', 'registrations.id = payments.registration_id');
        $this->db->join('users', 'users.id = registrations.user_id');
        $this->db->join('events', 'events.id = registrations.event_id');
        $this->db->join('certificates', 'certificates.registration_id = registrations.id', 'left');

        return $this->db
            ->order_by('payments.id', 'DESC')
            ->get()
            ->result();
    }

    public function get_payment_by_id($id)
    {
        return $this->db
            ->get_where('payments', array('id' => (int) $id))
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
            ->update('payments', array('status' => 'verified'));

        $this->db
            ->where('id', (int) $payment->registration_id)
            ->update('registrations', array('status' => 'approved'));

        $certificate = $this->db
            ->get_where('certificates', array('registration_id' => (int) $payment->registration_id))
            ->row();

        if (!$certificate) {
            $certificate_number = 'SRT-' . $payment->registration_id . '-' . date('YmdHis');

            $this->db->insert('certificates', array(
                'registration_id' => (int) $payment->registration_id,
                'certificate_number' => $certificate_number,
                'certificate_file' => $certificate_number . '.pdf',
            ));
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function get_certificate_by_id($id, $user_id = null)
    {
        $this->db->select('certificates.*, users.name AS user_name, events.name AS event_name');
        $this->db->from('certificates');
        $this->db->join('registrations', 'registrations.id = certificates.registration_id');
        $this->db->join('users', 'users.id = registrations.user_id');
        $this->db->join('events', 'events.id = registrations.event_id');
        $this->db->where('certificates.id', (int) $id);

        if ($user_id !== null) {
            $this->db->where('users.id', (int) $user_id);
        }

        return $this->db->get()->row();
    }

    public function get_user_certificates($user_id)
    {
        $this->db->select('certificates.*, events.name AS event_name, users.name AS user_name');
        $this->db->from('certificates');
        $this->db->join('registrations', 'registrations.id = certificates.registration_id');
        $this->db->join('users', 'users.id = registrations.user_id');
        $this->db->join('events', 'events.id = registrations.event_id');
        $this->db->where('users.id', (int) $user_id);

        return $this->db
            ->order_by('certificates.id', 'DESC')
            ->get()
            ->result();
    }

    public function get_participants($event_id)
    {
        $this->db->select('
            users.name AS user_name,
            users.email,
            registrations.phone_number,
            registrations.institution,
            registrations.address,
            registrations.team,
            registrations.status,
            payments.status AS status_payment
        ');
        $this->db->from('registrations');
        $this->db->join('users', 'users.id = registrations.user_id');
        $this->db->join('payments', 'payments.registration_id = registrations.id', 'left');
        $this->db->where('registrations.event_id', (int) $event_id);

        return $this->db
            ->order_by('users.name', 'ASC')
            ->get()
            ->result();
    }

    public function getAll($limit, $start, $keyword = null)
    {
        return $this->get_all($limit, $start, $keyword);
    }

    public function countData($keyword = null)
    {
        return $this->count_all($keyword);
    }

    public function getById($id)
    {
        return $this->get_by_id($id);
    }

    private function apply_search($keyword)
    {
        $keyword = trim((string) $keyword);

        if ($keyword === '') {
            return;
        }

        $this->db->group_start();
        $this->db->like('name', $keyword);
        $this->db->or_like('location', $keyword);
        $this->db->group_end();
    }
}
