<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->require_admin();
        $this->load->model('admin/Admin_dashboard_model', 'dashboard_model');
    }

    public function index()
    {
        $this->set_active_menu('dashboard');

        $this->render('dashboard', array(
            'page_title' => 'Dashboard',
            'summary' => $this->dashboard_model->summary(),
            'dashboard_role' => 'admin',
            'latest_events' => $this->dashboard_model->latest_events(5),
            'recent_activities' => $this->dashboard_model->recent_activities(6),
        ));
    }
}
