<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration_model extends CI_Model
{
    public function find_by_user_event($user_id, $event_id)
    {
        return $this->db->get_where('pendaftaran', array(
            'user_id' => (int) $user_id,
            'event_id' => (int) $event_id,
        ))->row();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->get_where('pendaftaran', array('id' => (int) $id))
            ->row();
    }

    public function find_payment($registration_id)
    {
        return $this->db
            ->get_where('pembayaran', array('pendaftaran_id' => (int) $registration_id))
            ->row();
    }

    public function user_owns_registration($registration_id, $user_id)
    {
        return $this->db
            ->where('id', (int) $registration_id)
            ->where('user_id', (int) $user_id)
            ->count_all_results('pendaftaran') > 0;
    }

    public function create_registration($data)
    {
        $this->db->insert('pendaftaran', $data);

        return $this->db->insert_id();
    }

    public function create_payment($registration_id, $file_name)
    {
        return $this->db->insert('pembayaran', array(
            'pendaftaran_id' => (int) $registration_id,
            'bukti_bayar' => $file_name,
            'status' => 'pending',
        ));
    }

    public function register_event($registration_data, $payment_data = null)
    {
        $this->db->trans_start();

        $this->db->insert('pendaftaran', $registration_data);
        $registration_id = $this->db->insert_id();

        if ($payment_data) {
            $payment_data['pendaftaran_id'] = $registration_id;
            $this->db->insert('pembayaran', $payment_data);
        }

        $this->db->trans_complete();

        return $this->db->trans_status() ? $registration_id : false;
    }

    public function registerEvent($registrationData, $paymentData)
    {
        return $this->register_event($registrationData, $paymentData) !== false;
    }
}
