<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Certificate extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->require_role('participant');
        $this->load->model('participant/Participant_certificate_model', 'certificate_model');
    }

    public function index()
    {
        $this->set_active_menu('certificates');

        $keyword = trim((string) $this->input->get('keyword', TRUE));

        $this->render('participant/certificates/index', array(
            'page_title' => 'My Certificates',
            'certificates' => $this->certificate_model->get_all($this->session->userdata('id'), $keyword),
            'keyword' => $keyword,
        ));
    }

    public function show($id = null)
    {
        $this->load->library('pdf_gen');

        $certificate = $this->certificate_model->find($id, $this->session->userdata('id'));

        if (!$certificate) {
            show_404();
        }

        $this->pdf_gen->generate(
            'certificates/pdf',
            array('certificate' => $certificate),
            'certificate-' . $certificate->certificate_number,
            'A4',
            'landscape'
        );
    }
}
