<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_profile_model extends CI_Model
{
    const TABLE = 'users';

    public function find($id)
    {
        return $this->db
            ->where('id', (int) $id)
            ->get(self::TABLE)
            ->row();
    }

    public function update($id, $data)
    {
        return $this->db
            ->where('id', (int) $id)
            ->update(self::TABLE, $data);
    }
}
