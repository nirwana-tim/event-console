<?php
// Load header
$this->load->view('layouts/header');

// Load sidebar (includes topbar and main content wrapper start)
$this->load->view('layouts/sidebar');

// Load the actual page content
echo $content;

// Load footer (includes main content wrapper end)
$this->load->view('layouts/footer');
