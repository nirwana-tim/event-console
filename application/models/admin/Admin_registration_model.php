<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_registration_model extends CI_Model
{
    public function get_all($event_id = null, $keyword = null, $attendance = null)
    {
        $this->db->select('
            registrations.*,
            users.name AS user_name,
            users.email,
            events.name AS event_name,
            certificates.id AS certificate_id
        ');
        $this->db->from('registrations');
        $this->db->join('users', 'users.id = registrations.user_id');
        $this->db->join('events', 'events.id = registrations.event_id');
        $this->db->join('certificates', 'certificates.registration_id = registrations.id', 'left');

        if ($event_id) {
            $this->db->where('registrations.event_id', (int) $event_id);
        }

        $keyword = trim((string) $keyword);
        if ($keyword !== '') {
            $this->db->group_start();
            $this->db->like('users.name', $keyword);
            $this->db->or_like('users.email', $keyword);
            $this->db->or_like('events.name', $keyword);
            $this->db->or_like('registrations.phone_number', $keyword);
            $this->db->or_like('registrations.institution', $keyword);
            $this->db->group_end();
        }

        if (in_array($attendance, array('unconfirmed', 'present', 'absent'), TRUE)) {
            $this->db->where('registrations.attendance', $attendance);
        }

        $this->db->order_by('registrations.id', 'DESC');

        return $this->db->get()->result();
    }

    public function update_attendance($registration_id, $attendance)
    {
        if (!in_array($attendance, array('unconfirmed', 'present', 'absent'), TRUE)) {
            return false;
        }

        $updated = $this->db
            ->where('id', (int) $registration_id)
            ->update('registrations', array('attendance' => $attendance));

        if (!$updated) {
            return false;
        }

        $this->load->model('admin/Admin_certificate_model', 'admin_certificate_model');

        if ($attendance === 'present') {
            $this->admin_certificate_model->create_for_registration((int) $registration_id);
        } else {
            $this->admin_certificate_model->delete_by_registration((int) $registration_id);
        }

        return true;
    }

    public function participants_by_event($event_id)
    {
        $this->db->select('
            users.name AS user_name,
            users.email,
            registrations.phone_number,
            registrations.institution,
            registrations.address,
            registrations.team,
            registrations.attendance
        ');
        $this->db->from('registrations');
        $this->db->join('users', 'users.id = registrations.user_id');
        $this->db->where('registrations.event_id', (int) $event_id);
        $this->db->order_by('users.name', 'ASC');

        return $this->db->get()->result();
    }
}
