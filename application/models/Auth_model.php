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
}
