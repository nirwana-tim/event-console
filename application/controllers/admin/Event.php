<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Event extends MY_Controller
{
    const PER_PAGE = 10;

    public function __construct()
    {
        parent::__construct();

        $this->require_admin();
        $this->load->model('admin/Admin_event_model', 'event_model');
        $this->load->library('pagination');
    }

    public function index($offset = 0)
    {
        $this->set_active_menu('event');

        $keyword = trim((string) $this->input->get('keyword', TRUE));
        $status = $this->valid_status($this->input->get('status', TRUE));
        $start_date = trim((string) $this->input->get('start_date', TRUE));
        $end_date = trim((string) $this->input->get('end_date', TRUE));
        $offset = (int) $offset;

        $this->pagination->initialize($this->pagination_config($keyword, $status, $start_date, $end_date, $offset));

        $this->render('admin/events/index', array(
            'page_title' => 'Event Data',
            'events' => $this->event_model->get_all(self::PER_PAGE, $offset, $keyword, $status, $start_date, $end_date),
            'keyword' => $keyword,
            'status' => $status,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'offset' => $offset,
        ));
    }

    public function show($id = null)
    {
        $this->set_active_menu('event');

        $event = $this->event_model->find($id);

        if (!$event) {
            show_404();
        }

        $this->render('admin/events/show', array(
            'page_title' => 'Event Detail',
            'event' => $event,
        ));
    }

    public function create()
    {
        $this->set_active_menu('event');
        $this->render('admin/events/create', array('page_title' => 'Create Event'));
    }

    public function store()
    {
        $this->set_active_menu('event');

        $this->form_validation->set_rules('name', 'Event Name', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('start_time', 'Start Time', 'trim');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim');
        $this->form_validation->set_rules('location', 'Location', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('quota', 'Quota', 'trim|integer');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[dibuka,ditutup,selesai]');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        if ($this->form_validation->run() === FALSE) {
            $this->render('admin/events/create', array('page_title' => 'Create Event'));
            return;
        }

        $upload = $this->upload_banner();

        if (!$upload) {
            $this->session->set_flashdata('error', trim(strip_tags($this->upload->display_errors('', ''))));
            redirect('admin/event/create');
        }

        $quota = trim((string) $this->input->post('quota', TRUE));
        $data = array(
            'user_id' => (int) $this->session->userdata('id'),
            'name' => $this->input->post('name', TRUE),
            'description' => $this->input->post('description', TRUE),
            'date' => $this->input->post('date', TRUE),
            'start_time' => $this->input->post('start_time', TRUE) ?: null,
            'end_time' => $this->input->post('end_time', TRUE) ?: null,
            'location' => $this->input->post('location', TRUE),
            'quota' => $quota !== '' ? (int) $quota : null,
            'status' => $this->input->post('status', TRUE),
            'banner' => $upload['file_name'],
        );

        $this->event_model->create($data);
        $this->session->set_flashdata('success', 'Event added successfully.');

        redirect('admin/event');
    }

    public function edit($id = null)
    {
        $this->set_active_menu('event');

        $event = $this->event_model->find($id);

        if (!$event) {
            show_404();
        }

        $this->render('admin/events/update', array(
            'page_title' => 'Update Event',
            'event' => $event,
        ));
    }

    public function update($id = null)
    {
        $this->set_active_menu('event');

        $event = $this->event_model->find($id);

        if (!$event) {
            show_404();
        }

        $this->form_validation->set_rules('name', 'Event Name', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('start_time', 'Start Time', 'trim');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim');
        $this->form_validation->set_rules('location', 'Location', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('quota', 'Quota', 'trim|integer');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[dibuka,ditutup,selesai]');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        if ($this->form_validation->run() === FALSE) {
            $this->render('admin/events/update', array(
                'page_title' => 'Update Event',
                'event' => $event,
            ));
            return;
        }

        $quota = trim((string) $this->input->post('quota', TRUE));
        $data = array(
            'user_id' => (int) $this->session->userdata('id'),
            'name' => $this->input->post('name', TRUE),
            'description' => $this->input->post('description', TRUE),
            'date' => $this->input->post('date', TRUE),
            'start_time' => $this->input->post('start_time', TRUE) ?: null,
            'end_time' => $this->input->post('end_time', TRUE) ?: null,
            'location' => $this->input->post('location', TRUE),
            'quota' => $quota !== '' ? (int) $quota : null,
            'status' => $this->input->post('status', TRUE),
        );

        if (!empty($_FILES['banner']['name'])) {
            $upload = $this->upload_banner();

            if (!$upload) {
                $this->session->set_flashdata('error', trim(strip_tags($this->upload->display_errors('', ''))));
                redirect('admin/event/edit/' . (int) $id);
            }

            $data['banner'] = $upload['file_name'];
        }

        $this->event_model->update($id, $data);
        $this->session->set_flashdata('success', 'Event updated successfully.');

        redirect('admin/event');
    }

    public function delete($id = null)
    {
        $event = $this->event_model->find($id);

        if (!$event) {
            show_404();
        }

        if ($this->event_model->has_registrations($id)) {
            $this->session->set_flashdata('error', 'This event cannot be deleted because it already has registrations.');
            redirect('admin/event');
        }

        $this->event_model->delete($id);
        $this->session->set_flashdata('success', 'Event deleted successfully.');

        redirect('admin/event');
    }

    private function valid_status($status)
    {
        $status = trim((string) $status);

        return in_array($status, array('dibuka', 'ditutup', 'selesai'), TRUE) ? $status : '';
    }

    private function pagination_config($keyword, $status = null, $start_date = null, $end_date = null, $offset = 0)
    {
        return array(
            'base_url' => base_url('admin/event/index'),
            'total_rows' => $this->event_model->count_all($keyword, $status, $start_date, $end_date),
            'per_page' => self::PER_PAGE,
            'uri_segment' => 4,
            'cur_page' => $offset > 0 ? (string) $offset : '00',
            'reuse_query_string' => TRUE,
            'full_tag_open' => '<nav aria-label="Pagination"><ul class="pagination mt-3">',
            'full_tag_close' => '</ul></nav>',
            'first_link' => 'First',
            'last_link' => 'Last',
            'next_link' => '&raquo;',
            'prev_link' => '&laquo;',
            'cur_tag_open' => '<li class="page-item active"><span class="page-link">',
            'cur_tag_close' => '</span></li>',
            'num_tag_open' => '<li class="page-item">',
            'num_tag_close' => '</li>',
            'next_tag_open' => '<li class="page-item">',
            'next_tag_close' => '</li>',
            'prev_tag_open' => '<li class="page-item">',
            'prev_tag_close' => '</li>',
            'first_tag_open' => '<li class="page-item">',
            'first_tag_close' => '</li>',
            'last_tag_open' => '<li class="page-item">',
            'last_tag_close' => '</li>',
            'attributes' => array('class' => 'page-link'),
        );
    }

    private function upload_banner()
    {
        $upload_path = FCPATH . 'uploads/banner/';

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, TRUE);
        }

        $this->load->library('upload');
        $this->upload->initialize(array(
            'upload_path' => $upload_path,
            'allowed_types' => 'jpg|jpeg|png',
            'max_size' => 2048,
            'encrypt_name' => TRUE,
            'file_ext_tolower' => TRUE,
        ));

        if (!$this->upload->do_upload('banner')) {
            return false;
        }

        $upload = $this->upload->data();

        $this->load->library('image_lib');
        $this->image_lib->clear();
        $this->image_lib->initialize(array(
            'image_library' => 'gd2',
            'source_image' => $upload_path . $upload['file_name'],
            'maintain_ratio' => TRUE,
            'width' => 1200,
            'height' => 675,
        ));
        $this->image_lib->resize();

        return $upload;
    }
}
