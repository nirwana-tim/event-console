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

    public function get_participants()
    {
        return $this->db
            ->select('name, email')
            ->where('role', 'participant')
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
}
