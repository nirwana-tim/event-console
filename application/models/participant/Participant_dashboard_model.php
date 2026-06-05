<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Participant_dashboard_model extends CI_Model
{
    public function summary($user_id)
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
