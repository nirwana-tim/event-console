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
            'total_attendance_pending' => $this->db
                ->where('registrations.status', 'approved')
                ->where('registrations.attendance', 'unconfirmed')
                ->count_all_results('registrations'),
            'total_certificates' => $this->db->count_all('certificates'),
        );
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
