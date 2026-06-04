<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property Dashboard_model $dashboard_model
 */
class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->require_login();
        $this->load->model('Dashboard_model', 'dashboard_model');
    }

    public function index()
    {
        $this->set_active_menu('dashboard');

        $role = $this->session->userdata('role');

        $this->render('dashboard', array(
            'page_title' => 'Dashboard - EventConsole',
            'summary' => $role === 'participant'
                ? $this->dashboard_model->get_participant_summary($this->session->userdata('id'))
                : $this->dashboard_model->get_summary(),
            'dashboard_role' => $role,
        ));
    }
}
