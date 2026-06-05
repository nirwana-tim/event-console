<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Participant_certificate_model extends CI_Model
{
    public function get_all($user_id, $keyword = null)
    {
        $this->certificate_query($user_id);

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

    public function find($id, $user_id)
    {
        $this->certificate_query($user_id);
        $this->db->where('certificates.id', (int) $id);

        return $this->db->get()->row();
    }

    private function certificate_query($user_id)
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
    }
}
