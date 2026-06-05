<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function get_summary()
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

    public function get_latest_events($limit = 5)
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

    public function get_recent_activities($limit = 6)
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

    public function get_participant_summary($user_id)
    {
        return array(
            'registered_events' => $this->db
                ->where('user_id', (int) $user_id)
                ->count_all_results('registrations'),

            'attendance_present' => $this->db
                ->where('user_id', (int) $user_id)
                ->where('attendance', 'present')
                ->count_all_results('registrations'),
            'certificates' => $this->db
                ->join('registrations', 'registrations.id = certificates.registration_id')
                ->where('registrations.user_id', (int) $user_id)
                ->count_all_results('certificates'),
        );
    }
}
