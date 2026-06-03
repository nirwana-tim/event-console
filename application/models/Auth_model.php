<?php
<<<<<<< HEAD
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
            ->select('nama, email')
            ->where('role', 'peserta')
            ->order_by('nama', 'ASC')
            ->get(self::TABLE)
            ->result();
    }

    public function register($data)
    {
        return $this->create_user($data);
=======
class Auth_model extends CI_Model {

    public function register($data)
    {
        return $this->db->insert('users', $data);
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
    }

    public function login($email)
    {
<<<<<<< HEAD
        return $this->find_by_email($email);
    }
}
=======
        return $this->db->get_where('users', ['email' => $email])->row();
    }
}
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
