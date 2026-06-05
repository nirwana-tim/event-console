<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Participant extends MY_Controller
{
    const EVENT_PER_PAGE = 12;

    public function __construct()
    {
        parent::__construct();

        $this->require_role('participant');
        $this->load->model('Event_model', 'event_model');
        $this->load->model('Registration_model', 'registration_model');
        $this->load->model('Certificate_model', 'certificate_model');
    }

    public function index()
    {
        $this->set_active_menu('my_participants');

        $keyword = trim((string) $this->input->get('keyword', TRUE));
        $status = trim((string) $this->input->get('status', TRUE));
        $attendance = trim((string) $this->input->get('attendance', TRUE));

        if (!in_array($status, array('pending', 'approved'), TRUE)) {
            $status = '';
        }

        if (!in_array($attendance, array('unconfirmed', 'present', 'absent'), TRUE)) {
            $attendance = '';
        }

        $this->render('participant/registrations/index', array(
            'page_title' => 'My Participants',
            'registrations' => $this->registration_model->get_participant_registrations($this->session->userdata('id'), $keyword, $status, $attendance),
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
        $offset = (int) $this->uri->segment(3, 0);

        if (!in_array($status, array('dibuka', 'ditutup', 'selesai'), TRUE)) {
            $status = '';
        }

        $this->pagination->initialize($this->event_pagination_config($keyword, $status));

        $this->render('participant/events/index', array(
            'page_title' => 'Events',
            'events' => $this->event_model->get_events_for_participant($this->session->userdata('id'), self::EVENT_PER_PAGE, $offset, $keyword, $status),
            'pagination' => $this->pagination->create_links(),
            'keyword' => $keyword,
            'selected_status' => $status
        ));
    }

    public function create($id = null)
    {
        $this->set_active_menu('participant_events');
        $event = $this->event_model->get_event_by_id($id);

        if (!$event) {
            show_404();
        }

        if ($event->status !== 'dibuka') {
            $this->session->set_flashdata('error', 'Registration for this event is closed.');
            redirect('participant/events');
        }

        if ($this->registration_model->get_registration_by_user_event($this->session->userdata('id'), $id)) {
            $this->session->set_flashdata('info', 'You are already registered for this event.');
            redirect('participant');
        }

        $this->render('participant/events/create', array(
            'page_title' => 'Event Registration Form',
            'event' => $event,
        ));
    }

    public function event_show($id = null)
    {
        $this->set_active_menu('participant_events');
        $event = $this->event_model->get_event_by_id($id);

        if (!$event) {
            show_404();
        }

        $registration = $this->registration_model->get_registration_by_user_event(
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

        $registration = $this->registration_model->get_participant_registration_detail(
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
        $event = $this->event_model->get_event_by_id($id);

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

        if ($this->registration_model->get_registration_by_user_event($this->session->userdata('id'), $id)) {
            $this->session->set_flashdata('info', 'You are already registered for this event.');
            redirect('participant');
        }

        $this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|max_length[30]');
        $this->form_validation->set_rules('institution', 'Institution', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('team', 'Team', 'trim|max_length[150]');
        $this->form_validation->set_rules('notes', 'Notes', 'trim');

        if ($this->form_validation->run() === FALSE) {
            $this->render('participant/events/create', array(
                'page_title' => 'Event Registration Form',
                'event' => $event,
            ));
            return;
        }

        $data = array(
            'user_id' => (int) $this->session->userdata('id'),
            'event_id' => (int) $id,
            'status' => 'approved',
            'phone_number' => $this->input->post('phone_number', TRUE),
            'institution' => $this->input->post('institution', TRUE),
            'address' => $this->input->post('address', TRUE),
            'team' => $this->input->post('team', TRUE),
            'notes' => $this->input->post('notes', TRUE),
        );

        $this->registration_model->insert_registration($data);

        $this->session->set_flashdata('success', 'Successfully registered for the event.');
        redirect('participant');
    }

    public function certificates()
    {
        $this->set_active_menu('certificates');

        $keyword = trim((string) $this->input->get('keyword', TRUE));

        $this->render('participant/certificates/index', array(
            'page_title' => 'My Certificates',
            'certificates' => $this->certificate_model->get_user_certificates($this->session->userdata('id'), $keyword),
            'keyword' => $keyword,
        ));
    }

    public function download($id = null)
    {
        $this->load->library('pdf_gen');

        $certificate = $this->certificate_model->get_certificate_by_id($id, $this->session->userdata('id'));

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

    private function event_pagination_config($keyword, $status)
    {
        return array(
            'base_url' => base_url('participant/events'),
            'total_rows' => $this->event_model->count_events_for_participant($keyword, $status),
            'per_page' => self::EVENT_PER_PAGE,
            'uri_segment' => 3,
            'reuse_query_string' => TRUE,
            'full_tag_open' => '<ul class="pagination pagination-primary justify-content-center">',
            'full_tag_close' => '</ul>',
            'first_link' => 'First',
            'last_link' => 'Last',
            'first_tag_open' => '<li class="page-item">',
            'first_tag_close' => '</li>',
            'prev_link' => '&laquo;',
            'prev_tag_open' => '<li class="page-item prev">',
            'prev_tag_close' => '</li>',
            'next_link' => '&raquo;',
            'next_tag_open' => '<li class="page-item next">',
            'next_tag_close' => '</li>',
            'last_tag_open' => '<li class="page-item">',
            'last_tag_close' => '</li>',
            'cur_tag_open' => '<li class="page-item active"><a href="#" class="page-link">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li class="page-item">',
            'num_tag_close' => '</li>',
            'attributes' => array('class' => 'page-link'),
        );
    }

}
