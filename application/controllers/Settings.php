<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property Auth_model $auth_model
 */
class Settings extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->require_login();
        $this->load->model('Auth_model', 'auth_model');
    }

    public function index()
    {
        $user_id = $this->session->userdata('id');
        $user = $this->auth_model->find_by_id($user_id);

        if (!$user) {
            show_error('User not found.');
        }

        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]|max_length[100]');

        $change_password = FALSE;
        if ($this->input->post('old_password') || $this->input->post('new_password') || $this->input->post('confirm_password')) {
            $change_password = TRUE;
            $this->form_validation->set_rules('old_password', 'Current Password', 'required');
            $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'required|matches[new_password]');
        }

        if ($this->input->method() === 'post' && $this->form_validation->run() === TRUE) {
            $update_data = array(
                'name' => trim($this->input->post('name', TRUE)),
            );

            $password_valid = TRUE;
            if ($change_password) {
                if (password_verify($this->input->post('old_password'), $user->password)) {
                    $update_data['password'] = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
                } else {
                    $password_valid = FALSE;
                    $this->session->set_flashdata('error', 'Current Password is incorrect.');
                }
            }

            if ($password_valid) {
                $this->auth_model->update_user($user_id, $update_data);
                
                // Update session variable immediately
                $this->session->set_userdata('name', $update_data['name']);
                
                $this->session->set_flashdata('success', 'Settings updated successfully.');
                redirect('settings');
            }
        }

        $this->set_active_menu('');
        $this->render('settings', array(
            'page_title' => 'Settings - EventConsole',
            'user' => $user,
        ));
    }
}
