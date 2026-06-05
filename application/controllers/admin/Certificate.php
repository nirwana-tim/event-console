<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Certificate extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->require_admin();
        $this->load->model('admin/Admin_event_model', 'event_model');
        $this->load->model('admin/Admin_certificate_model', 'certificate_model');
    }

    public function index()
    {
        $this->set_active_menu('certificates_admin');

        $selected_event_id = (int) $this->input->get('event_id', TRUE);
        $selected_event_id = $selected_event_id > 0 ? $selected_event_id : null;
        $keyword = trim((string) $this->input->get('keyword', TRUE));

        $this->render('admin/certificates/index', array(
            'page_title' => 'Certificates',
            'events' => $this->event_model->options(),
            'selected_event_id' => $selected_event_id,
            'keyword' => $keyword,
            'certificates' => $this->certificate_model->get_all($selected_event_id, $keyword),
        ));
    }

    public function show($id = null)
    {
        $this->load->library('pdf_gen');

        $certificate = $this->certificate_model->find($id);

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
