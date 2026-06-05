<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Participant_registration_model extends CI_Model
{
    public function find_by_user_event($user_id, $event_id)
    {
        return $this->db
            ->where('user_id', (int) $user_id)
            ->where('event_id', (int) $event_id)
            ->get('registrations')
            ->row();
    }

    public function get_all($user_id, $keyword = null, $attendance = null)
    {
        $this->db->select('
            registrations.*,
            events.name AS event_name,
            events.date,
            events.location,
            events.banner,
            certificates.id AS certificate_id,
            certificates.certificate_number
        ');
        $this->db->from('registrations');
        $this->db->join('events', 'events.id = registrations.event_id');
        $this->db->join('certificates', 'certificates.registration_id = registrations.id', 'left');
        $this->db->where('registrations.user_id', (int) $user_id);

        $keyword = trim((string) $keyword);
        if ($keyword !== '') {
            $this->db->group_start();
            $this->db->like('events.name', $keyword);
            $this->db->or_like('events.location', $keyword);
            $this->db->or_like('registrations.institution', $keyword);
            $this->db->or_like('registrations.team', $keyword);
            $this->db->group_end();
        }

        if (in_array($attendance, array('unconfirmed', 'present', 'absent'), TRUE)) {
            $this->db->where('registrations.attendance', $attendance);
        }

        $this->db->order_by('registrations.id', 'DESC');

        return $this->db->get()->result();
    }

    public function find($registration_id, $user_id)
    {
        $this->db->select('
            registrations.*,
            events.name AS event_name,
            events.description,
            events.date,
            events.location,
            events.banner,
            certificates.id AS certificate_id,
            certificates.certificate_number
        ');
        $this->db->from('registrations');
        $this->db->join('events', 'events.id = registrations.event_id');
        $this->db->join('certificates', 'certificates.registration_id = registrations.id', 'left');
        $this->db->where('registrations.id', (int) $registration_id);
        $this->db->where('registrations.user_id', (int) $user_id);

        return $this->db->get()->row();
    }

    public function create($data)
    {
        $this->db->insert('registrations', $data);

        return $this->db->insert_id();
    }
}
