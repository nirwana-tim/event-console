<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->require_role('participant');
        $this->load->model('participant/Participant_dashboard_model', 'dashboard_model');
        $this->load->model('participant/Participant_event_model', 'event_model');
    }

    public function index()
    {
        $this->set_active_menu('dashboard');

        $user_id = $this->session->userdata('id');

        $this->render('dashboard', array(
            'page_title' => 'Dashboard',
            'summary' => $this->dashboard_model->summary($user_id),
            'dashboard_role' => 'participant',
            'latest_events' => $this->event_model->get_all($user_id, 4),
        ));
    }
}
