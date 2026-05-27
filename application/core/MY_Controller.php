<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $active_menu = '';

    public function __construct()
    {
        parent::__construct();
    }

    protected function render($view, $data = array())
    {
        $data = array_merge($this->layout_data(), $data);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view($view, $data);
        $this->load->view('template/footer', $data);
    }

    protected function render_auth($view, $data = array())
    {
        $this->load->view($view, array_merge($this->layout_data(), $data));
    }

    protected function require_login()
    {
        if (!$this->session->userdata('login')) {
            redirect('auth/login');
            exit;
        }
    }

    protected function require_admin()
    {
        $this->require_login();

        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
            exit;
        }
    }

    protected function require_role($role)
    {
        $this->require_login();

        if ($this->session->userdata('role') !== $role) {
            redirect('dashboard');
            exit;
        }
    }

    protected function set_active_menu($menu)
    {
        $this->active_menu = $menu;
    }

    protected function json_response($data, $status_code = 200)
    {
        $this->output
            ->set_status_header($status_code)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data));
    }

    protected function load_composer()
    {
        $autoload_path = APPPATH . '../vendor/autoload.php';

        if (!file_exists($autoload_path)) {
            show_error('Composer autoload tidak ditemukan. Jalankan composer install terlebih dahulu.');
        }

        require_once $autoload_path;
    }

    protected function layout_data()
    {
        $name = (string) $this->session->userdata('nama');

        return array(
            'active_menu' => $this->active_menu,
            'current_user_id' => $this->session->userdata('id'),
            'current_user_name' => $name,
            'current_user_initial' => $name !== '' ? strtoupper(substr($name, 0, 1)) : 'U',
            'current_user_role' => $this->session->userdata('role'),
            'page_title' => isset($this->page_title) ? $this->page_title : 'EventKu',
        );
    }
}
