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

        $this->render('dashboard', array(
            'page_title' => 'Dashboard - EventConsole',
            'summary' => $this->dashboard_model->get_summary(),
        ));
    }
}
