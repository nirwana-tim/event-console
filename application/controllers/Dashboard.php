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
        $data = array(
            'page_title' => 'Dashboard',
            'summary' => $role === 'participant'
                ? $this->dashboard_model->get_participant_summary($this->session->userdata('id'))
                : $this->dashboard_model->get_summary(),
            'dashboard_role' => $role,
        );

        if ($role === 'participant') {
            $this->load->model('Event_model', 'event_model');
            $data['latest_events'] = $this->event_model->get_events_with_registration($this->session->userdata('id'), 4);
        } else {
            $data['latest_events'] = $this->dashboard_model->get_latest_events(5);
            $data['recent_activities'] = $this->dashboard_model->get_recent_activities(6);
        }

        $this->render('dashboard', $data);
    }
}
