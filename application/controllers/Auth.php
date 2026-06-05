<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model', 'auth_model');
    }

    public function register()
    {
        if ($this->session->userdata('login')) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_message('is_unique', '{field} is already registered.');

        if ($this->form_validation->run() === FALSE) {
            $this->render_auth('register', array('page_title' => 'Register'));
            return;
        }

        $data = array(
            'name' => trim($this->input->post('name', TRUE)),
            'email' => strtolower(trim($this->input->post('email', TRUE))),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role' => 'participant',
        );

        if ($this->auth_model->create_user($data)) {
            $this->session->set_flashdata('success', 'Registration successful. Please log in.');
        } else {
            $this->session->set_flashdata('error', 'Registration failed.');
        }

        redirect('auth/login');
    }

    public function login()
    {
        if ($this->session->userdata('login')) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->input->method() === 'post' && $this->form_validation->run() === TRUE) {
            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password');
            $user = $this->auth_model->find_by_email($email);

            if ($user && password_verify($password, $user->password)) {
                $session_data = array(
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role,
                    'login' => TRUE,
                );

                $this->session->sess_regenerate(TRUE);
                $this->session->set_userdata($session_data);

                redirect('dashboard');
            }

            $this->session->set_flashdata('error', 'Email or password is incorrect.');
            redirect('auth/login');
        }

        $this->render_auth('login', array('page_title' => 'Login'));
    }

    public function logout()
    {
        $this->session->sess_destroy();

        redirect('auth/login');
    }
}
