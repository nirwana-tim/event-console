<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function get_summary()
    {
        return array(
            'total_events' => $this->db->count_all('events'),
            'total_participants' => $this->db
                ->where('role', 'peserta')
                ->count_all_results('users'),
            'total_registrations' => $this->db->count_all('pendaftaran'),
            'total_payments_pending' => $this->db
                ->where('status', 'pending')
                ->count_all_results('pembayaran'),
        );
    }
}
