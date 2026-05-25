<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function events()
    {
        $data = $this->db->get('events')->result();

        header('Content-Type: application/json');

        echo json_encode($data);
    }

    public function peserta()
    {
        $this->db->select('users.nama, users.email');
        $this->db->from('users');
        $this->db->where('role','peserta');

        $data = $this->db->get()->result();

        header('Content-Type: application/json');

        echo json_encode($data);
    }
}