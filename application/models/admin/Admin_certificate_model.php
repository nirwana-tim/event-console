<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_certificate_model extends CI_Model
{
    public function create_for_registration($registration_id)
    {
        $registration = $this->db
            ->where('id', (int) $registration_id)
            ->get('registrations')
            ->row();

        if (!$registration || $registration->attendance !== 'present') {
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

        return $this->db->insert('certificates', array(
            'registration_id' => (int) $registration_id,
            'certificate_number' => $certificate_number,
            'certificate_file' => $certificate_number . '.pdf',
            'verification_code' => 'VERIFY-' . $certificate_number,
        ));
    }

    public function delete_by_registration($registration_id)
    {
        return $this->db
            ->where('registration_id', (int) $registration_id)
            ->delete('certificates');
    }

    public function find($id)
    {
        $this->certificate_query();
        $this->db->where('certificates.id', (int) $id);

        return $this->db->get()->row();
    }

    public function get_all($event_id = null, $keyword = null)
    {
        $this->certificate_query();

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

    private function certificate_query()
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
    }
}
