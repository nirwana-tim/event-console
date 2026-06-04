<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    const TABLE = 'users';

    public function create_user($data)
    {
        return $this->db->insert(self::TABLE, $data);
    }

    public function find_by_email($email)
    {
        return $this->db
            ->where('email', strtolower(trim($email)))
            ->get(self::TABLE)
            ->row();
    }

    public function email_exists($email)
    {
        return $this->db
            ->where('email', strtolower(trim($email)))
            ->count_all_results(self::TABLE) > 0;
    }

    public function email_exists_except($email, $id)
    {
        return $this->db
            ->where('email', strtolower(trim($email)))
            ->where('id !=', (int) $id)
            ->count_all_results(self::TABLE) > 0;
    }

    public function get_participants()
    {
        return $this->db
            ->select('name, email')
            ->where('role', 'participant')
            ->order_by('name', 'ASC')
            ->get(self::TABLE)
            ->result();
    }

    public function get_users($keyword = null, $role = null)
    {
        $keyword = trim((string) $keyword);
        $role = trim((string) $role);

        if ($keyword !== '') {
            $this->db->group_start();
            $this->db->like('name', $keyword);
            $this->db->or_like('email', $keyword);
            $this->db->group_end();
        }

        if (in_array($role, array('admin', 'participant'), TRUE)) {
            $this->db->where('role', $role);
        }

        return $this->db
            ->order_by('role', 'ASC')
            ->order_by('name', 'ASC')
            ->get(self::TABLE)
            ->result();
    }

    public function register($data)
    {
        return $this->create_user($data);
    }

    public function login($email)
    {
        return $this->find_by_email($email);
    }

    public function find_by_id($id)
    {
        return $this->db
            ->where('id', (int) $id)
            ->get(self::TABLE)
            ->row();
    }

    public function update_user($id, $data)
    {
        return $this->db
            ->where('id', (int) $id)
            ->update(self::TABLE, $data);
    }
}
