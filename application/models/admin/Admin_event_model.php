<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_event_model extends CI_Model
{
    public function get_all($limit = null, $offset = 0, $keyword = null, $status = null, $start_date = null, $end_date = null)
    {
        $this->event_query($keyword, $status, $start_date, $end_date);
        $this->db->order_by('events.date', 'DESC');
        $this->db->order_by('events.id', 'DESC');

        if ($limit !== null) {
            $this->db->limit((int) $limit, (int) $offset);
        }

        return $this->db->get()->result();
    }

    public function count_all($keyword = null, $status = null, $start_date = null, $end_date = null)
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

        if ($start_date) {
            $this->db->where('date >=', $start_date);
        }

        if ($end_date) {
            $this->db->where('date <=', $end_date);
        }

        return $this->db->count_all_results('events');
    }

    public function find($id)
    {
        $this->event_query();
        $this->db->where('events.id', (int) $id);

        return $this->db->get()->row();
    }

    public function create($data)
    {
        return $this->db->insert('events', $data);
    }

    public function update($id, $data)
    {
        return $this->db
            ->where('id', (int) $id)
            ->update('events', $data);
    }

    public function delete($id)
    {
        return $this->db
            ->where('id', (int) $id)
            ->delete('events');
    }

    public function has_registrations($event_id)
    {
        return $this->db
            ->where('event_id', (int) $event_id)
            ->count_all_results('registrations') > 0;
    }

    public function options()
    {
        return $this->db
            ->order_by('name', 'ASC')
            ->get('events')
            ->result();
    }

    private function event_query($keyword = null, $status = null, $start_date = null, $end_date = null)
    {
        $this->db->select('
            events.*,
            users.name AS creator_name,
            (SELECT COUNT(*) FROM registrations WHERE registrations.event_id = events.id) AS total_registrations
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

        if ($start_date) {
            $this->db->where('events.date >=', $start_date);
        }

        if ($end_date) {
            $this->db->where('events.date <=', $end_date);
        }
    }
}
