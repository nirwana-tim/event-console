<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
    }

    public function register()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() == FALSE) {

            $this->load->view('register');

        } else {

            $data = [
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role' => 'peserta'
            ];

            $this->Auth_model->register($data);

            redirect('auth/login');
        }
    }

    public function login()
    {
        if ($_POST) {

            $user = $this->Auth_model->login($this->input->post('email'));

            if ($user && password_verify($this->input->post('password'), $user->password)) {

                $session = [
                    'id' => $user->id,
                    'nama' => $user->nama,
                    'role' => $user->role,
                    'login' => true
                ];

                $this->session->set_userdata($session);

                redirect('dashboard');

            } else {

                echo "Login gagal";

            }
        }

        $this->load->view('login');
    }

    public function logout()
    {
        $this->session->sess_destroy();

        redirect('auth/login');
    }
}