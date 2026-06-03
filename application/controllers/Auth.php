<?php
defined('BASEPATH') OR exit('No direct script access allowed');

<<<<<<< HEAD
class Auth extends MY_Controller
{
=======
class Auth extends CI_Controller {
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

    public function __construct()
    {
        parent::__construct();
<<<<<<< HEAD
        $this->load->model('Auth_model', 'auth_model');
=======
        $this->load->model('Auth_model');
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
    }

    public function register()
    {
<<<<<<< HEAD
        if ($this->session->userdata('login')) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_message('is_unique', '{field} sudah terdaftar.');

        if ($this->form_validation->run() === FALSE) {
            $this->render_auth('register', array('page_title' => 'Register - EventConsole'));
            return;
        }

        $data = array(
            'nama' => trim($this->input->post('nama', TRUE)),
            'email' => strtolower(trim($this->input->post('email', TRUE))),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role' => 'peserta',
        );

        $this->auth_model->create_user($data);
        $this->session->set_flashdata('success', 'Registrasi berhasil. Silakan login.');

        redirect('auth/login');
=======
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
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
    }

    public function login()
    {
<<<<<<< HEAD
        if ($this->session->userdata('login')) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->input->method() === 'post' && $this->form_validation->run() === TRUE) {
            $user = $this->auth_model->find_by_email($this->input->post('email', TRUE));

            if ($user && password_verify($this->input->post('password'), $user->password)) {
                $this->session->sess_regenerate(TRUE);
                $this->session->set_userdata(array(
                    'id' => $user->id,
                    'nama' => $user->nama,
                    'role' => $user->role,
                    'login' => TRUE,
                ));

                redirect('dashboard');
            }

            $this->session->set_flashdata('error', 'Email atau password tidak sesuai.');
            redirect('auth/login');
        }

        $this->render_auth('login', array('page_title' => 'Login - EventConsole'));
=======
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
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
    }

    public function logout()
    {
        $this->session->sess_destroy();

        redirect('auth/login');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
