<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration_model extends CI_Model
{
    public function find_by_user_event($user_id, $event_id)
    {
        return $this->db->get_where('registrations', array(
            'user_id' => (int) $user_id,
            'event_id' => (int) $event_id,
        ))->row();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->get_where('registrations', array('id' => (int) $id))
            ->row();
    }

    public function get_user_registrations($user_id)
    {
        $this->db->select('
            registrations.*,
            events.name AS event_name,
            events.date,
            events.location,
            events.banner,
            payments.status AS payment_status,
            payments.payment_proof,
            certificates.id AS certificate_id,
            certificates.certificate_number
        ');
        $this->db->from('registrations');
        $this->db->join('events', 'events.id = registrations.event_id');
        $this->db->join('payments', 'payments.registration_id = registrations.id', 'left');
        $this->db->join('certificates', 'certificates.registration_id = registrations.id', 'left');
        $this->db->where('registrations.user_id', (int) $user_id);

        return $this->db
            ->order_by('registrations.id', 'DESC')
            ->get()
            ->result();
    }

    public function get_user_registration_detail($registration_id, $user_id)
    {
        $this->db->select('
            registrations.*,
            events.name AS event_name,
            events.description,
            events.date,
            events.location,
            events.banner,
            payments.status AS payment_status,
            payments.payment_proof,
            certificates.id AS certificate_id,
            certificates.certificate_number
        ');
        $this->db->from('registrations');
        $this->db->join('events', 'events.id = registrations.event_id');
        $this->db->join('payments', 'payments.registration_id = registrations.id', 'left');
        $this->db->join('certificates', 'certificates.registration_id = registrations.id', 'left');
        $this->db->where('registrations.id', (int) $registration_id);
        $this->db->where('registrations.user_id', (int) $user_id);

        return $this->db->get()->row();
    }

    public function find_payment($registration_id)
    {
        return $this->db
            ->get_where('payments', array('registration_id' => (int) $registration_id))
            ->row();
    }

    public function user_owns_registration($registration_id, $user_id)
    {
        return $this->db
            ->where('id', (int) $registration_id)
            ->where('user_id', (int) $user_id)
            ->count_all_results('registrations') > 0;
    }

    public function create_registration($data)
    {
        $this->db->insert('registrations', $data);

        return $this->db->insert_id();
    }

    public function create_payment($registration_id, $file_name)
    {
        return $this->db->insert('payments', array(
            'registration_id' => (int) $registration_id,
            'payment_proof' => $file_name,
            'status' => 'pending',
        ));
    }

    public function save_payment($registration_id, $file_name)
    {
        $payment = $this->find_payment($registration_id);

        if (!$payment) {
            return $this->create_payment($registration_id, $file_name);
        }

        return $this->db
            ->where('registration_id', (int) $registration_id)
            ->update('payments', array(
                'payment_proof' => $file_name,
                'status' => 'pending',
            ));
    }

    public function register_event($registration_data, $payment_data = null)
    {
        $this->db->trans_start();

        $this->db->insert('registrations', $registration_data);
        $registration_id = $this->db->insert_id();

        if ($payment_data) {
            $payment_data['registration_id'] = $registration_id;
            $this->db->insert('payments', $payment_data);
        }

        $this->db->trans_complete();

        return $this->db->trans_status() ? $registration_id : false;
    }

    public function registerEvent($registrationData, $paymentData)
    {
        return $this->register_event($registrationData, $paymentData) !== false;
    }
}
