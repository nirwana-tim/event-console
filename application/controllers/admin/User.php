<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->require_admin();
        $this->load->model('admin/Admin_user_model', 'user_model');
    }

    public function index()
    {
        $this->set_active_menu('users');

        $keyword = trim((string) $this->input->get('keyword', TRUE));
        $role = trim((string) $this->input->get('role', TRUE));

        $this->render('admin/users/index', array(
            'page_title' => 'User Management',
            'users' => $this->user_model->get_all($keyword, $role),
            'keyword' => $keyword,
            'role' => $role,
        ));
    }

    public function show($id = null)
    {
        $this->set_active_menu('users');

        $user = $this->user_model->find($id);

        if (!$user) {
            show_404();
        }

        $this->render('admin/users/show', array(
            'page_title' => 'User Detail',
            'user' => $user,
        ));
    }

    public function create()
    {
        $this->set_active_menu('users');

        $this->render('admin/users/create', array(
            'page_title' => 'Create User',
        ));
    }

    public function store()
    {
        $this->set_active_menu('users');

        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_unique_email');
        $this->form_validation->set_rules('role', 'Role', 'trim|required|in_list[admin,participant]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() === FALSE) {
            $this->render('admin/users/create', array(
                'page_title' => 'Create User',
            ));
            return;
        }

        $data = array(
            'name' => trim($this->input->post('name', TRUE)),
            'email' => strtolower(trim($this->input->post('email', TRUE))),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role' => $this->input->post('role', TRUE),
        );

        if ($this->user_model->create($data)) {
            $this->session->set_flashdata('success', 'User account created successfully.');
        } else {
            $this->session->set_flashdata('error', 'User account creation failed.');
        }

        redirect('admin/user');
    }

    public function edit($id = null)
    {
        $this->set_active_menu('users');

        $user = $this->editable_user($id);

        $this->render('admin/users/update', array(
            'page_title' => 'Update User',
            'user' => $user,
        ));
    }

    public function update($id = null)
    {
        $user = $this->editable_user($id);

        $this->set_active_menu('users');

        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_unique_email[' . (int) $id . ']');
        $this->form_validation->set_rules('role', 'Role', 'trim|required|in_list[admin,participant]');

        if ($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'New Password', 'min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        }

        if ($this->form_validation->run() === FALSE) {
            $this->render('admin/users/update', array(
                'page_title' => 'Update User',
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

        if ($this->user_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'User account updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'User account update failed.');
        }

        redirect('admin/user');
    }

    public function check_unique_email($email, $id = null)
    {
        $exists = $id
            ? $this->user_model->email_exists_except($email, $id)
            : $this->user_model->email_exists($email);

        if ($exists) {
            $this->form_validation->set_message('check_unique_email', 'The {field} field must contain a unique value.');
            return false;
        }

        return true;
    }

    private function editable_user($id)
    {
        $user = $this->user_model->find($id);

        if (!$user) {
            show_404();
        }

        if ((int) $user->id === (int) $this->session->userdata('id')) {
            $this->session->set_flashdata('error', 'Manage your own account from Settings.');
            redirect('admin/user');
        }

        return $user;
    }
}
