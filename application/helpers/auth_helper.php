<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('check_login')) {
    function check_login()
    {
        $CI = &get_instance();

        if (!$CI->session->userdata('login')) {
            redirect('auth/login');
            exit;
        }
    }
}

if (!function_exists('check_admin')) {
    function check_admin()
    {
        $CI = &get_instance();

        if ($CI->session->userdata('role') !== 'admin') {
            $route = $CI->session->userdata('role') === 'participant'
                ? 'participant/dashboard'
                : 'admin/dashboard';

            redirect($route);
            exit;
        }
    }
}
