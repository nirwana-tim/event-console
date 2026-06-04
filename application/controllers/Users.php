<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->require_admin();
        $this->load->model('Auth_model', 'auth_model');
    }

    public function index()
    {
        $this->set_active_menu('users');

        $keyword = trim((string) $this->input->get('keyword', TRUE));
        $role = trim((string) $this->input->get('role', TRUE));

        $this->render('admin/users/index', array(
            'page_title' => 'User Management - EventConsole',
            'users' => $this->auth_model->get_users($keyword, $role),
            'keyword' => $keyword,
            'role' => $role,
        ));
    }

    public function create()
    {
        $this->set_active_menu('users');
        $this->set_user_rules();
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() === FALSE) {
            $this->render('admin/users/create', array(
                'page_title' => 'Create User - EventConsole',
            ));
            return;
        }

        $data = array(
            'name' => trim($this->input->post('name', TRUE)),
            'email' => strtolower(trim($this->input->post('email', TRUE))),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role' => $this->input->post('role', TRUE),
        );

        $this->auth_model->create_user($data);
        $this->session->set_flashdata('success', 'User account created successfully.');

        redirect('users');
    }

    public function update($id = null)
    {
        $user = $this->auth_model->find_by_id($id);

        if (!$user) {
            show_404();
        }

        if ((int) $user->id === (int) $this->session->userdata('id')) {
            $this->session->set_flashdata('error', 'Manage your own account from Settings.');
            redirect('users');
        }

        $this->set_active_menu('users');
        $this->set_user_rules($id);

        if ($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'New Password', 'min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        }

        if ($this->form_validation->run() === FALSE) {
            $this->render('admin/users/update', array(
                'page_title' => 'Update User - EventConsole',
                'user' => $user,
            ));
            return;
        }

        $data = array(
            'name' => trim($this->input->post('name', TRUE)),
            'email' => strtolower(trim($this->input->post('email', TRUE))),
            'role' => $this->input->post('role', TRUE),
        );

        if ($this->input->post('password')) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }

        $this->auth_model->update_user($id, $data);
        $this->session->set_flashdata('success', 'User account updated successfully.');

        redirect('users');
    }

    public function show($id = null)
    {
        $this->set_active_menu('users');

        $user = $this->auth_model->find_by_id($id);

        if (!$user) {
            show_404();
        }

        $this->render('admin/users/show', array(
            'page_title' => 'User Detail - EventConsole',
            'user' => $user,
        ));
    }

    public function check_unique_email($email, $id = null)
    {
        if ($id) {
            $exists = $this->auth_model->email_exists_except($email, $id);
        } else {
            $exists = $this->auth_model->email_exists($email);
        }

        if ($exists) {
            $this->form_validation->set_message('check_unique_email', 'The {field} field must contain a unique value.');
            return false;
        }

        return true;
    }

    private function set_user_rules($id = null)
    {
        $email_rule = 'trim|required|valid_email|callback_check_unique_email';

        if ($id) {
            $email_rule .= '[' . (int) $id . ']';
        }

        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', $email_rule);
        $this->form_validation->set_rules('role', 'Role', 'trim|required|in_list[admin,participant]');
    }
}
