<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Event extends MY_Controller
{
    const PER_PAGE = 12;

    public function __construct()
    {
        parent::__construct();

        $this->require_role('participant');
        $this->load->model('participant/Participant_event_model', 'event_model');
        $this->load->model('participant/Participant_registration_model', 'registration_model');
    }

    public function index($offset = 0)
    {
        $this->set_active_menu('participant_events');
        $this->load->library('pagination');

        $keyword = trim((string) $this->input->get('keyword', TRUE));
        $status = $this->valid_status($this->input->get('status', TRUE));
        $offset = (int) $offset;

        $this->pagination->initialize($this->pagination_config($keyword, $status, $offset));

        $this->render('participant/events/index', array(
            'page_title' => 'Events',
            'events' => $this->event_model->get_all($this->session->userdata('id'), self::PER_PAGE, $offset, $keyword, $status),
            'pagination' => $this->pagination->create_links(),
            'keyword' => $keyword,
            'selected_status' => $status,
        ));
    }

    public function show($id = null)
    {
        $this->set_active_menu('participant_events');

        $event = $this->event_model->find($id);

        if (!$event) {
            show_404();
        }

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

    private function valid_status($status)
    {
        $status = trim((string) $status);

        return in_array($status, array('dibuka', 'ditutup', 'selesai'), TRUE) ? $status : '';
    }

    private function pagination_config($keyword, $status, $offset = 0)
    {
        return array(
            'base_url' => base_url('participant/event/index'),
            'total_rows' => $this->event_model->count_all($keyword, $status),
            'per_page' => self::PER_PAGE,
            'uri_segment' => 4,
            'cur_page' => $offset > 0 ? (string) $offset : '00',
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
