<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller
{
    public function index()
    {
        redirect($this->session->userdata('login') ? 'dashboard' : 'auth/login');
    }
}
