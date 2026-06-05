<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends MY_Controller
{
	public function index()
	{
		if (!$this->session->userdata('login')) {
			redirect('auth/login');
		}

		$route = $this->session->userdata('role') === 'participant'
			? 'participant/dashboard'
			: 'admin/dashboard';

		redirect($route);
	}
}
