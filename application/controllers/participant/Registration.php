<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registration extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->require_role('participant');
        $this->load->model('participant/Participant_event_model', 'event_model');
        $this->load->model('participant/Participant_registration_model', 'registration_model');
    }

    public function index()
    {
        $this->set_active_menu('my_participants');

        $keyword = trim((string) $this->input->get('keyword', TRUE));
        $attendance = $this->valid_attendance($this->input->get('attendance', TRUE));

        $this->render('participant/registrations/index', array(
            'page_title' => 'My Participants',
            'registrations' => $this->registration_model->get_all($this->session->userdata('id'), $keyword, $attendance),
            'keyword' => $keyword,
            'selected_attendance' => $attendance,
        ));
    }

    public function show($id = null)
    {
        $this->set_active_menu('my_participants');

        $registration = $this->registration_model->find(
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

    public function create($event_id = null)
    {
        $this->set_active_menu('participant_events');

        $event = $this->open_event($event_id);

        if ($this->registration_model->find_by_user_event($this->session->userdata('id'), $event_id)) {
            $this->session->set_flashdata('info', 'You are already registered for this event.');
            redirect('participant/registration');
        }

        $this->render('participant/events/create', array(
            'page_title' => 'Event Registration Form',
            'event' => $event,
        ));
    }

    public function store($event_id = null)
    {
        $this->set_active_menu('participant_events');

        $event = $this->open_event($event_id);

        if ($this->input->method() !== 'post') {
            redirect('participant/registration/create/' . (int) $event_id);
        }

        if ($this->registration_model->find_by_user_event($this->session->userdata('id'), $event_id)) {
            $this->session->set_flashdata('info', 'You are already registered for this event.');
            redirect('participant/registration');
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

        $this->registration_model->create(array(
            'user_id' => (int) $this->session->userdata('id'),
            'event_id' => (int) $event_id,
            'status' => 'approved',
            'phone_number' => $this->input->post('phone_number', TRUE),
            'institution' => $this->input->post('institution', TRUE),
            'address' => $this->input->post('address', TRUE),
            'team' => $this->input->post('team', TRUE),
            'notes' => $this->input->post('notes', TRUE),
        ));

        $this->session->set_flashdata('success', 'Successfully registered for the event.');
        redirect('participant/registration');
    }

    private function open_event($event_id)
    {
        $event = $this->event_model->find($event_id);

        if (!$event) {
            show_404();
        }

        if ($event->status !== 'dibuka') {
            $this->session->set_flashdata('error', 'Registration for this event is closed.');
            redirect('participant/event');
        }

        return $event;
    }

    private function valid_attendance($attendance)
    {
        $attendance = trim((string) $attendance);

        return in_array($attendance, array('unconfirmed', 'present', 'absent'), TRUE) ? $attendance : '';
    }
}
