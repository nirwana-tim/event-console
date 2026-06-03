<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->require_login();
    }

    public function index()
    {
        redirect('participant/events');
    }
}
