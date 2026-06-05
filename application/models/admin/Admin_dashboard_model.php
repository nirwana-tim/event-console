<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_dashboard_model extends CI_Model
{
    public function summary()
    {
        return array(
            'total_events' => $this->db->count_all('events'),
            'total_participants' => $this->db
                ->where('role', 'participant')
                ->count_all_results('users'),
            'total_registrations' => $this->db->count_all('registrations'),
            'total_certificates' => $this->db->count_all('certificates'),
        );
    }

    public function latest_events($limit = 5)
    {
        $this->db->select('
            events.*,
            users.name AS creator_name,
            (SELECT COUNT(*) FROM registrations WHERE registrations.event_id = events.id) AS total_registrations
        ');
        $this->db->from('events');
        $this->db->join('users', 'users.id = events.user_id', 'left');

        return $this->db
            ->order_by('events.created_at', 'DESC')
            ->order_by('events.id', 'DESC')
            ->limit((int) $limit)
            ->get()
            ->result();
    }

    public function recent_activities($limit = 6)
    {
        $this->db->select('
            registrations.id,
            registrations.attendance,
            registrations.created_at,
            users.name AS participant_name,
            users.email AS participant_email,
            events.name AS event_name,
            events.id AS event_id
        ');
        $this->db->from('registrations');
        $this->db->join('users', 'users.id = registrations.user_id');
        $this->db->join('events', 'events.id = registrations.event_id');

        return $this->db
            ->order_by('registrations.created_at', 'DESC')
            ->order_by('registrations.id', 'DESC')
            ->limit((int) $limit)
            ->get()
            ->result();
    }
}
