<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Participant extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->require_role('participant');
        $this->load->model('Event_model', 'event_model');
        $this->load->model('Registration_model', 'registration_model');
    }

    public function index()
    {
        $this->set_active_menu('my_participants');

        $this->render('participant/index', array(
            'page_title' => 'My Participants - EventConsole',
            'registrations' => $this->registration_model->get_user_registrations($this->session->userdata('id')),
        ));
    }

    public function events()
    {
        $this->set_active_menu('participant_events');

        $this->render('participant/events/index', array(
            'page_title' => 'Events - EventConsole',
            'events' => $this->event_model->get_all(),
        ));
    }

    public function create($id = null)
    {
        $this->registration_form($id);
    }

    public function registration_form($id = null)
    {
        $this->set_active_menu('participant_events');
        $event = $this->event_model->get_by_id($id);

        if (!$event) {
            show_404();
        }

        $existing_registration = $this->registration_model->find_by_user_event(
            $this->session->userdata('id'),
            $id
        );

        if ($existing_registration) {
            $this->redirect_existing_registration($existing_registration);
        }

        $this->render_registration_form($event);
    }

    public function show($id = null)
    {
        $this->set_active_menu('my_participants');

        $registration = $this->registration_model->get_user_registration_detail(
            $id,
            $this->session->userdata('id')
        );

        if (!$registration) {
            show_404();
        }

        $this->render('participant/show', array(
            'page_title' => 'Registration Detail - EventConsole',
            'registration' => $registration,
        ));
    }

    public function register($id = null)
    {
        $this->set_active_menu('participant_events');
        $event = $this->event_model->get_by_id($id);

        if (!$event) {
            show_404();
        }

        if ($this->input->method() !== 'post') {
            redirect('participant/create/' . $id);
        }

        $existing_registration = $this->registration_model->find_by_user_event(
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

        $registration_id = $this->registration_model->create_registration($this->registration_payload($id));

        redirect('participant/upload_payment_proof/' . $registration_id);
    }

    public function upload_payment_proof($id = null)
    {
        $this->set_active_menu('my_participants');

        if (!$this->registration_model->user_owns_registration($id, $this->session->userdata('id'))) {
            show_404();
        }

        if ($this->registration_model->find_payment($id)) {
            $this->session->set_flashdata('info', 'Payment proof has already been uploaded.');
            redirect('participant');
        }

        if ($this->input->method() === 'post') {
            $upload = $this->upload_payment();

            if (!$upload) {
                $this->session->set_flashdata('error', trim(strip_tags($this->upload->display_errors('', ''))));
                redirect('participant/upload_payment_proof/' . $id);
            }

            $this->registration_model->create_payment($id, $upload['file_name']);
            $this->session->set_flashdata('success', 'Payment proof uploaded successfully.');

            redirect('participant');
        }

        $this->render('participant/payments/create', array(
            'page_title' => 'Upload Payment Proof - EventConsole',
        ));
    }

    public function certificates()
    {
        $this->set_active_menu('certificates');

        $this->render('participant/certificates/index', array(
            'page_title' => 'My Certificates - EventConsole',
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
        $html = $this->load->view('participant/certificate_pdf', array('certificate' => $certificate), TRUE);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('certificate-' . $certificate->certificate_number . '.pdf', array('Attachment' => 0));
    }

    private function render_registration_form($event)
    {
        $this->render('participant/events/create', array(
            'page_title' => 'Event Registration Form - EventConsole',
            'event' => $event,
        ));
    }

    private function redirect_existing_registration($registration)
    {
        if (!$this->registration_model->find_payment($registration->id)) {
            redirect('participant/upload_payment_proof/' . $registration->id);
        }

        $this->session->set_flashdata('info', 'You are already registered and have uploaded payment proof.');
        redirect('participant');
    }

    private function set_registration_rules()
    {
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|max_length[30]');
        $this->form_validation->set_rules('institution', 'Institution', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('team', 'Team', 'trim|max_length[150]');
        $this->form_validation->set_rules('notes', 'Notes', 'trim');
    }

    private function registration_payload($event_id)
    {
        return array(
            'user_id' => (int) $this->session->userdata('id'),
            'event_id' => (int) $event_id,
            'status' => 'pending',
            'phone_number' => $this->input->post('phone_number', TRUE),
            'institution' => $this->input->post('institution', TRUE),
            'address' => $this->input->post('address', TRUE),
            'team' => $this->input->post('team', TRUE),
            'notes' => $this->input->post('notes', TRUE),
        );
    }

    private function upload_payment()
    {
        $upload_path = FCPATH . 'uploads/payments/';

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

        if (!$this->upload->do_upload('payment_proof')) {
            return false;
        }

        return $this->upload->data();
    }
}
