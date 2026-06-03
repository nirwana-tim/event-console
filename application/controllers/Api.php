<?php
defined('BASEPATH') OR exit('No direct script access allowed');

<<<<<<< HEAD
class Api extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Event_model', 'event_model');
        $this->load->model('Auth_model', 'auth_model');
    }

    public function events()
    {
        $this->json_response($this->event_model->get_all());
=======
class Api extends CI_Controller {

    public function events()
    {
        $data = $this->db->get('events')->result();

        header('Content-Type: application/json');

        echo json_encode($data);
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
    }

    public function peserta()
    {
<<<<<<< HEAD
        $this->json_response($this->auth_model->get_participants());
    }
}
=======
        $this->db->select('users.nama, users.email');
        $this->db->from('users');
        $this->db->where('role','peserta');

        $data = $this->db->get()->result();

        header('Content-Type: application/json');

        echo json_encode($data);
    }
}
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
