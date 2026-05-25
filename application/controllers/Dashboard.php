<?php
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