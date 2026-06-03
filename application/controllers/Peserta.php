<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peserta extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->require_role('peserta');
        $this->load->model('Event_model', 'event_model');
        $this->load->model('Pendaftaran_model', 'pendaftaran_model');
    }

    public function event()
    {
        $this->set_active_menu('peserta_event');

        $this->render('peserta/event', array(
            'page_title' => 'Event - EventConsole',
            'events' => $this->event_model->get_all(),
        ));
    }

    public function form_daftar($id = null)
    {
        $this->set_active_menu('peserta_event');
        $event = $this->event_model->get_by_id($id);

        if (!$event) {
            show_404();
        }

        $existing_registration = $this->pendaftaran_model->find_by_user_event(
            $this->session->userdata('id'),
            $id
        );

        if ($existing_registration) {
            $this->redirect_existing_registration($existing_registration);
        }

        $this->render_registration_form($event);
    }

    public function daftar($id = null)
    {
        $this->set_active_menu('peserta_event');
        $event = $this->event_model->get_by_id($id);

        if (!$event) {
            show_404();
        }

        if ($this->input->method() !== 'post') {
            redirect('peserta/form_daftar/' . $id);
        }

        $existing_registration = $this->pendaftaran_model->find_by_user_event(
            $this->session->userdata('id'),
            $id
        );

        if ($existing_registration) {
            $this->redirect_existing_registration($existing_registration);
        }

        $this->set_registration_rules();

        if ($this->form_validation->run() === FALSE) {
            $this->render_registration_form($event);
            return;
        }

        $registration_id = $this->pendaftaran_model->create_registration($this->registration_payload($id));

        redirect('peserta/upload_bayar/' . $registration_id);
    }

    public function upload_bayar($id = null)
    {
        $this->set_active_menu('peserta_event');

        if (!$this->pendaftaran_model->user_owns_registration($id, $this->session->userdata('id'))) {
            show_404();
        }

        if ($this->pendaftaran_model->find_payment($id)) {
            $this->session->set_flashdata('info', 'Bukti pembayaran sudah pernah diupload.');
            redirect('peserta/event');
        }

        if ($this->input->method() === 'post') {
            $upload = $this->upload_payment();

            if (!$upload) {
                $this->session->set_flashdata('error', trim(strip_tags($this->upload->display_errors('', ''))));
                redirect('peserta/upload_bayar/' . $id);
            }

            $this->pendaftaran_model->create_payment($id, $upload['file_name']);
            $this->session->set_flashdata('success', 'Bukti pembayaran berhasil diupload.');

            redirect('peserta/event');
        }

        $this->render('peserta/upload', array(
            'page_title' => 'Upload Bukti Pembayaran - EventConsole',
        ));
    }

    public function sertifikat()
    {
        $this->set_active_menu('sertifikat');

        $this->render('peserta/sertifikat', array(
            'page_title' => 'Sertifikat Saya - EventConsole',
            'certificates' => $this->event_model->get_user_certificates($this->session->userdata('id')),
        ));
    }

    public function download($id = null)
    {
        $this->load_composer();

        $certificate = $this->event_model->get_certificate_by_id($id, $this->session->userdata('id'));

        if (!$certificate) {
            show_404();
        }

        $dompdf = new \Dompdf\Dompdf();
        $html = $this->load->view('peserta/pdf_sertifikat', array('certificate' => $certificate), TRUE);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('sertifikat-' . $certificate->nomor_sertifikat . '.pdf', array('Attachment' => 0));
    }

    private function render_registration_form($event)
    {
        $this->render('peserta/form_daftar', array(
            'page_title' => 'Form Pendaftaran Event - EventConsole',
            'event' => $event,
        ));
    }

    private function redirect_existing_registration($registration)
    {
        if (!$this->pendaftaran_model->find_payment($registration->id)) {
            redirect('peserta/upload_bayar/' . $registration->id);
        }

        $this->session->set_flashdata('info', 'Kamu sudah terdaftar dan sudah upload pembayaran.');
        redirect('peserta/event');
    }

    private function set_registration_rules()
    {
        $this->form_validation->set_rules('no_hp', 'No HP', 'trim|required|max_length[30]');
        $this->form_validation->set_rules('instansi', 'Instansi', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('team', 'Team', 'trim|max_length[150]');
        $this->form_validation->set_rules('catatan', 'Catatan', 'trim');
    }

    private function registration_payload($event_id)
    {
        return array(
            'user_id' => (int) $this->session->userdata('id'),
            'event_id' => (int) $event_id,
            'status' => 'pending',
            'no_hp' => $this->input->post('no_hp', TRUE),
            'instansi' => $this->input->post('instansi', TRUE),
            'alamat' => $this->input->post('alamat', TRUE),
            'team' => $this->input->post('team', TRUE),
            'catatan' => $this->input->post('catatan', TRUE),
        );
    }

    private function upload_payment()
    {
        $upload_path = FCPATH . 'uploads/pembayaran/';

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, TRUE);
        }

        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => 'jpg|jpeg|png',
            'max_size' => 2048,
            'encrypt_name' => TRUE,
            'file_ext_tolower' => TRUE,
        );

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('bukti')) {
            return false;
        }

        return $this->upload->data();
    }
}
