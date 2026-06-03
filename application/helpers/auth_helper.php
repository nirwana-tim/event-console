<?php
<<<<<<< HEAD
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('check_login')) {
    function check_login()
    {
        $CI =& get_instance();

        if (!$CI->session->userdata('login')) {
            redirect('auth/login');
            exit;
        }
    }
}

if (!function_exists('check_admin')) {
    function check_admin()
    {
        $CI =& get_instance();

        if ($CI->session->userdata('role') !== 'admin') {
            redirect('dashboard');
            exit;
        }
    }
}
=======

function check_login()
{
    $CI =& get_instance();

    if(!$CI->session->userdata('login')){

        redirect('auth/login');
    }
}

function check_admin()
{
    $CI =& get_instance();

    if($CI->session->userdata('role') != 'admin'){

        redirect('dashboard');
    }
}
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
