<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate_model extends CI_Model
{
    // Membuat sertifikat otomatis berdasarkan data registrasi
    public function create_certificate_for_registration($registration_id)
    {
        $registration = $this->db
            ->where('id', (int) $registration_id)
            ->get('registrations')
            ->row();

        if (!$registration) {
            return false;
        }

        if ($registration->status !== 'approved' || $registration->attendance !== 'present') {
            return false;
        }

        $certificate = $this->db
            ->where('registration_id', (int) $registration_id)
            ->get('certificates')
            ->row();

        if ($certificate) {
            return true;
        }

        $certificate_number = 'SRT-' . (int) $registration_id . '-' . date('YmdHis');

        $data = array(
            'registration_id' => (int) $registration_id,
            'certificate_number' => $certificate_number,
            'certificate_file' => $certificate_number . '.pdf',
            'verification_code' => 'VERIFY-' . $certificate_number,
        );

        return $this->db->insert('certificates', $data);
    }

    // Menghapus sertifikat saat peserta tidak hadir
    public function delete_certificate_by_registration($registration_id)
    {
        return $this->db
            ->where('registration_id', (int) $registration_id)
            ->delete('certificates');
    }

    // Mengambil detail sertifikat untuk ditampilkan sebagai PDF
    public function get_certificate_by_id($id, $user_id = null)
    {
        $this->db->select('
            certificates.*,
            users.name AS user_name,
            events.name AS event_name
        ');
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

    // Mengambil daftar sertifikat milik peserta
    public function get_user_certificates($user_id, $keyword = null)
    {
        $this->db->select('
            certificates.*,
            users.name AS user_name,
            events.name AS event_name,
            events.banner,
            events.date
        ');
        $this->db->from('certificates');
        $this->db->join('registrations', 'registrations.id = certificates.registration_id');
        $this->db->join('users', 'users.id = registrations.user_id');
        $this->db->join('events', 'events.id = registrations.event_id');
        $this->db->where('users.id', (int) $user_id);

        $keyword = trim((string) $keyword);
        if ($keyword !== '') {
            $this->db->group_start();
            $this->db->like('events.name', $keyword);
            $this->db->or_like('certificates.certificate_number', $keyword);
            $this->db->or_like('certificates.verification_code', $keyword);
            $this->db->group_end();
        }

        $this->db->order_by('certificates.id', 'DESC');

        return $this->db->get()->result();
    }

    // Mengambil daftar semua sertifikat untuk admin
    public function get_all_certificates($event_id = null, $keyword = null)
    {
        $this->db->select('
            certificates.*,
            users.name AS user_name,
            events.name AS event_name
        ');
        $this->db->from('certificates');
        $this->db->join('registrations', 'registrations.id = certificates.registration_id');
        $this->db->join('users', 'users.id = registrations.user_id');
        $this->db->join('events', 'events.id = registrations.event_id');

        if ($event_id) {
            $this->db->where('registrations.event_id', (int) $event_id);
        }

        $keyword = trim((string) $keyword);
        if ($keyword !== '') {
            $this->db->group_start();
            $this->db->like('certificates.certificate_number', $keyword);
            $this->db->or_like('certificates.verification_code', $keyword);
            $this->db->or_like('users.name', $keyword);
            $this->db->or_like('events.name', $keyword);
            $this->db->group_end();
        }

        $this->db->order_by('certificates.id', 'DESC');

        return $this->db->get()->result();
    }
}
