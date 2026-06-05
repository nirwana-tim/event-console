<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model
{
    // Mengambil daftar event untuk halaman admin
    public function get_all_events($limit = null, $offset = 0, $keyword = null, $status = null, $start_date = null, $end_date = null)
    {
        $this->db->select('
            events.*,
            users.name AS creator_name,
            (SELECT COUNT(*) FROM registrations WHERE registrations.event_id = events.id) AS total_registrations
        ');
        $this->db->from('events');
        $this->db->join('users', 'users.id = events.user_id', 'left');

        $keyword = trim((string) $keyword);
        if ($keyword !== '') {
            $this->db->group_start();
            $this->db->like('events.name', $keyword);
            $this->db->or_like('events.location', $keyword);
            $this->db->group_end();
        }

        if (in_array($status, array('dibuka', 'ditutup', 'selesai'), TRUE)) {
            $this->db->where('events.status', $status);
        }

        if ($start_date) {
            $this->db->where('events.date >=', $start_date);
        }

        if ($end_date) {
            $this->db->where('events.date <=', $end_date);
        }

        $this->db->order_by('events.date', 'DESC');
        $this->db->order_by('events.id', 'DESC');

        if ($limit !== null) {
            $this->db->limit((int) $limit, (int) $offset);
        }

        return $this->db->get()->result();
    }

    // Menghitung total event untuk pagination
    public function count_events($keyword = null, $status = null, $start_date = null, $end_date = null)
    {
        $keyword = trim((string) $keyword);
        if ($keyword !== '') {
            $this->db->group_start();
            $this->db->like('name', $keyword);
            $this->db->or_like('location', $keyword);
            $this->db->group_end();
        }

        if (in_array($status, array('dibuka', 'ditutup', 'selesai'), TRUE)) {
            $this->db->where('status', $status);
        }

        if ($start_date) {
            $this->db->where('date >=', $start_date);
        }

        if ($end_date) {
            $this->db->where('date <=', $end_date);
        }

        return $this->db->count_all_results('events');
    }

    // Mengambil detail satu event berdasarkan ID
    public function get_event_by_id($id)
    {
        $this->db->select('
            events.*,
            users.name AS creator_name,
            (SELECT COUNT(*) FROM registrations WHERE registrations.event_id = events.id) AS total_registrations
        ');
        $this->db->from('events');
        $this->db->join('users', 'users.id = events.user_id', 'left');
        $this->db->where('events.id', (int) $id);

        return $this->db->get()->row();
    }

    // Menambah event baru
    public function insert_event($data)
    {
        return $this->db->insert('events', $data);
    }

    // Mengupdate event
    public function update_event($id, $data)
    {
        return $this->db
            ->where('id', (int) $id)
            ->update('events', $data);
    }

    // Menghapus event
    public function delete_event($id)
    {
        return $this->db
            ->where('id', (int) $id)
            ->delete('events');
    }

    // Mengecek apakah event sudah punya peserta yang mendaftar
    public function event_has_registrations($event_id)
    {
        return $this->db
            ->where('event_id', (int) $event_id)
            ->count_all_results('registrations') > 0;
    }

    // Mengambil semua event untuk pilihan dropdown
    public function get_event_options()
    {
        return $this->db
            ->order_by('name', 'ASC')
            ->get('events')
            ->result();
    }

    // Mengambil daftar event untuk peserta, sekaligus cek apakah peserta sudah daftar
    public function get_events_for_participant($user_id, $limit = null, $offset = 0, $keyword = null, $status = null)
    {
        $this->db->select('
            events.*,
            users.name AS creator_name,
            (SELECT COUNT(*) FROM registrations WHERE registrations.event_id = events.id) AS total_registrations,
            (SELECT id FROM registrations WHERE registrations.event_id = events.id AND registrations.user_id = ' . (int) $user_id . ' LIMIT 1) AS user_registration_id
        ');
        $this->db->from('events');
        $this->db->join('users', 'users.id = events.user_id', 'left');

        $keyword = trim((string) $keyword);
        if ($keyword !== '') {
            $this->db->group_start();
            $this->db->like('events.name', $keyword);
            $this->db->or_like('events.location', $keyword);
            $this->db->group_end();
        }

        if (in_array($status, array('dibuka', 'ditutup', 'selesai'), TRUE)) {
            $this->db->where('events.status', $status);
        }

        $this->db->order_by('events.date', 'DESC');
        $this->db->order_by('events.id', 'DESC');

        if ($limit !== null) {
            $this->db->limit((int) $limit, (int) $offset);
        }

        return $this->db->get()->result();
    }

    // Menghitung total event untuk pagination halaman peserta
    public function count_events_for_participant($keyword = null, $status = null)
    {
        $keyword = trim((string) $keyword);
        if ($keyword !== '') {
            $this->db->group_start();
            $this->db->like('name', $keyword);
            $this->db->or_like('location', $keyword);
            $this->db->group_end();
        }

        if (in_array($status, array('dibuka', 'ditutup', 'selesai'), TRUE)) {
            $this->db->where('status', $status);
        }

        return $this->db->count_all_results('events');
    }

    // Mengambil daftar registrasi peserta untuk admin
    public function get_event_registrations($event_id = null, $keyword = null, $attendance = null)
    {
        $this->db->select('
            registrations.*,
            users.name AS user_name,
            users.email,
            events.name AS event_name,
            certificates.id AS certificate_id
        ');
        $this->db->from('registrations');
        $this->db->join('users', 'users.id = registrations.user_id');
        $this->db->join('events', 'events.id = registrations.event_id');
        $this->db->join('certificates', 'certificates.registration_id = registrations.id', 'left');

        if ($event_id) {
            $this->db->where('registrations.event_id', (int) $event_id);
        }

        $keyword = trim((string) $keyword);
        if ($keyword !== '') {
            $this->db->group_start();
            $this->db->like('users.name', $keyword);
            $this->db->or_like('users.email', $keyword);
            $this->db->or_like('events.name', $keyword);
            $this->db->or_like('registrations.phone_number', $keyword);
            $this->db->or_like('registrations.institution', $keyword);
            $this->db->group_end();
        }

        if (in_array($attendance, array('unconfirmed', 'present', 'absent'), TRUE)) {
            $this->db->where('registrations.attendance', $attendance);
        }

        $this->db->order_by('registrations.id', 'DESC');

        return $this->db->get()->result();
    }

    // Mengubah status kehadiran peserta
    public function update_registration_attendance($registration_id, $attendance)
    {
        if (!in_array($attendance, array('unconfirmed', 'present', 'absent'), TRUE)) {
            return false;
        }

        $updated = $this->db
            ->where('id', (int) $registration_id)
            ->update('registrations', array('attendance' => $attendance));

        if (!$updated) {
            return false;
        }

        $this->load->model('Certificate_model', 'certificate_model');

        if ($attendance === 'present') {
            $this->certificate_model->create_certificate_for_registration((int) $registration_id);
        } else {
            $this->certificate_model->delete_certificate_by_registration((int) $registration_id);
        }

        return true;
    }

    // Mengambil daftar peserta untuk export Excel per event
    public function get_event_participants($event_id)
    {
        $this->db->select('
            users.name AS user_name,
            users.email,
            registrations.phone_number,
            registrations.institution,
            registrations.address,
            registrations.team,
            registrations.attendance
        ');
        $this->db->from('registrations');
        $this->db->join('users', 'users.id = registrations.user_id');
        $this->db->where('registrations.event_id', (int) $event_id);
        $this->db->order_by('users.name', 'ASC');

        return $this->db->get()->result();
    }
}
