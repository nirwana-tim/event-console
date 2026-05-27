<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
    }

    public function peserta()
    {
        $this->json_response($this->auth_model->get_participants());
    }
}
