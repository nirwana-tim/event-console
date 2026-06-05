<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Participant_event_model extends CI_Model
{
    public function get_all($user_id, $limit = null, $offset = 0, $keyword = null, $status = null)
    {
        $this->event_query($user_id, $keyword, $status);
        $this->db->order_by('events.date', 'DESC');
        $this->db->order_by('events.id', 'DESC');

        if ($limit !== null) {
            $this->db->limit((int) $limit, (int) $offset);
        }

        return $this->db->get()->result();
    }

    public function count_all($keyword = null, $status = null)
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

    public function find($id)
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

    private function event_query($user_id, $keyword = null, $status = null)
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
    }
}
