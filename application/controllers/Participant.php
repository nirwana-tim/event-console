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

        $keyword = trim((string) $this->input->get('keyword', TRUE));
        $status = trim((string) $this->input->get('status', TRUE));
        $attendance = trim((string) $this->input->get('attendance', TRUE));

        if (!in_array($status, array('pending', 'approved', 'rejected'), TRUE)) {
            $status = '';
        }

        if (!in_array($attendance, array('unconfirmed', 'present', 'absent'), TRUE)) {
            $attendance = '';
        }

        $this->render('participant/registrations/index', array(
            'page_title' => 'My Participants',
            'registrations' => $this->registration_model->get_user_registrations($this->session->userdata('id'), $keyword, $status, $attendance),
            'keyword' => $keyword,
            'selected_status' => $status,
            'selected_attendance' => $attendance,
        ));
    }

    public function events()
    {
        $this->set_active_menu('participant_events');

        $this->load->library('pagination');

        $keyword = trim((string) $this->input->get('keyword', TRUE));
        $status = trim((string) $this->input->get('status', TRUE));
        $limit = 12;
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        if (!in_array($status, array('dibuka', 'ditutup', 'selesai'), TRUE)) {
            $status = '';
        }

        $config['base_url'] = base_url('participant/events');
        $config['total_rows'] = $this->event_model->count_events_with_registration($keyword, $status);
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['reuse_query_string'] = TRUE;
        
        $config['full_tag_open'] = '<ul class="pagination pagination-primary justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-item next">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $this->render('participant/events/index', array(
            'page_title' => 'Events',
            'events' => $this->event_model->get_events_with_registration($this->session->userdata('id'), $limit, $offset, $keyword, $status),
            'pagination' => $this->pagination->create_links(),
            'keyword' => $keyword,
            'selected_status' => $status
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

        if ($event->status !== 'dibuka') {
            $this->session->set_flashdata('error', 'Registration for this event is closed.');
            redirect('participant/events');
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

    public function event_show($id = null)
    {
        $this->set_active_menu('participant_events');
        $event = $this->event_model->get_by_id($id);

        if (!$event) {
            show_404();
        }

        // Check if already registered
        $registration = $this->registration_model->find_by_user_event(
            $this->session->userdata('id'),
            $id
        );

        $this->render('participant/events/show', array(
            'page_title' => 'Event Detail',
            'event' => $event,
            'user_registration' => $registration,
        ));
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

        $this->render('participant/registrations/show', array(
            'page_title' => 'Registration Detail',
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

        if ($event->status !== 'dibuka') {
            $this->session->set_flashdata('error', 'Registration for this event is closed.');
            redirect('participant/events');
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

        $this->registration_model->create_registration($this->registration_payload($id));

        $this->session->set_flashdata('success', 'Successfully registered for the event.');
        redirect('participant');
    }

    public function certificates()
    {
        $this->set_active_menu('certificates');

        $keyword = trim((string) $this->input->get('keyword', TRUE));

        $this->render('participant/certificates/index', array(
            'page_title' => 'My Certificates',
            'certificates' => $this->event_model->get_user_certificates($this->session->userdata('id'), $keyword),
            'keyword' => $keyword,
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
        $html = $this->load->view('certificates/pdf', array('certificate' => $certificate), TRUE);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('certificate-' . $certificate->certificate_number . '.pdf', array('Attachment' => 0));
    }

    private function render_registration_form($event)
    {
        $this->render('participant/events/create', array(
            'page_title' => 'Event Registration Form',
            'event' => $event,
        ));
    }

    private function redirect_existing_registration($registration)
    {
        $this->session->set_flashdata('info', 'You are already registered for this event.');
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
            'status' => 'approved',
            'phone_number' => $this->input->post('phone_number', TRUE),
            'institution' => $this->input->post('institution', TRUE),
            'address' => $this->input->post('address', TRUE),
            'team' => $this->input->post('team', TRUE),
            'notes' => $this->input->post('notes', TRUE),
        );
    }
}
