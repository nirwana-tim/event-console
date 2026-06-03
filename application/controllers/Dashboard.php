<?php
<<<<<<< HEAD
defined('BASEPATH') OR exit('No direct script access allowed');

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
=======
class Dashboard extends CI_Controller {

    public function index()
    {
        if(!$this->session->userdata('login')){
            redirect('auth/login');
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('dashboard');
        $this->load->view('template/footer');
    }
}
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
