<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends MY_Controller
{
    const PER_PAGE = 5;

    public function __construct()
    {
        parent::__construct();

        $this->require_admin();
        $this->load->model('Event_model', 'event_model');
        $this->load->library('pagination');

    }

    public function index()
    {
        $this->set_active_menu('event');

        $keyword = trim((string) $this->input->get('keyword', TRUE));
        $status = trim((string) $this->input->get('status', TRUE));
        $start_date = trim((string) $this->input->get('start_date', TRUE));
        $end_date = trim((string) $this->input->get('end_date', TRUE));
        $offset = (int) $this->uri->segment(3, 0);

        if (!in_array($status, array('dibuka', 'ditutup', 'selesai'), TRUE)) {
            $status = '';
        }

        $this->pagination->initialize($this->pagination_config($keyword, $status, $start_date, $end_date));

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

        $event = $this->event_model->get_by_id($id);

        if (!$event) {
            show_404();
        }

        $this->render('admin/events/show', array(
            'page_title' => 'Event Detail',
            'event' => $event,
        ));
    }

    public function add()
    {
        $this->create();
    }

    public function create()
    {
        $this->set_active_menu('event');
        $this->set_event_rules();

        if ($this->form_validation->run() === FALSE) {
            $this->render('admin/events/create', array('page_title' => 'Create Event'));
            return;
        }

        $upload = $this->upload_banner();

        if (!$upload) {
            $this->session->set_flashdata('error', trim(strip_tags($this->upload->display_errors('', ''))));
            redirect('event/create');
        }

        $data = $this->event_payload();
        $data['banner'] = $upload['file_name'];

        $this->event_model->insert($data);
        $this->session->set_flashdata('success', 'Event added successfully.');

        redirect('event');
    }

    public function edit($id = null)
    {
        $this->update($id);
    }

    public function update($id = null)
    {
        $this->set_active_menu('event');

        $event = $this->event_model->get_by_id($id);

        if (!$event) {
            show_404();
        }

        $this->set_event_rules();

        if ($this->form_validation->run() === FALSE) {
            $this->render('admin/events/update', array(
                'page_title' => 'Update Event',
                'event' => $event,
            ));
            return;
        }

        $data = $this->event_payload();

        if (!empty($_FILES['banner']['name'])) {
            $upload = $this->upload_banner();

            if (!$upload) {
                $this->session->set_flashdata('error', trim(strip_tags($this->upload->display_errors('', ''))));
                redirect('event/update/' . $id);
            }

            $data['banner'] = $upload['file_name'];
        }

        $this->event_model->update($id, $data);
        $this->session->set_flashdata('success', 'Event updated successfully.');

        redirect('event');
    }

    public function delete($id = null)
    {
        $event = $this->event_model->get_by_id($id);

        if (!$event) {
            show_404();
        }

        if ($this->event_model->has_registrations($id)) {
            $this->session->set_flashdata('error', 'This event cannot be deleted because it already has registrations.');
            redirect('event');
        }

        $this->event_model->delete($id);
        $this->session->set_flashdata('success', 'Event deleted successfully.');

        redirect('event');
    }

    public function registrations($event_id = null)
    {
        $this->set_active_menu('registrations');

        $selected_event_id = $event_id ? (int) $event_id : (int) $this->input->get('event_id', TRUE);
        $selected_event_id = $selected_event_id > 0 ? $selected_event_id : null;

        $keyword = trim((string) $this->input->get('keyword', TRUE));
        $status = trim((string) $this->input->get('status', TRUE));
        $attendance = trim((string) $this->input->get('attendance', TRUE));

        if (!in_array($status, array('pending', 'approved', 'rejected'), TRUE)) {
            $status = '';
        }

        if (!in_array($attendance, array('unconfirmed', 'present', 'absent'), TRUE)) {
            $attendance = '';
        }

        $this->render('admin/registrations/index', array(
            'page_title' => 'Participant Registrations',
            'events' => $this->event_model->get_options(),
            'selected_event_id' => $selected_event_id,
            'keyword' => $keyword,
            'selected_status' => $status,
            'selected_attendance' => $attendance,
            'registrations' => $this->event_model->get_registrations($selected_event_id, $keyword, $status, $attendance),
        ));
    }

    public function attendance($registration_id = null, $attendance = null)
    {
        if (!$registration_id || !$attendance) {
            show_404();
        }

        if ($this->event_model->update_attendance($registration_id, $attendance)) {
            $this->session->set_flashdata('success', 'Attendance updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Attendance update failed.');
        }

        $referrer = $this->input->server('HTTP_REFERER', TRUE);

        redirect($referrer ? $referrer : 'event/registrations');
    }

    public function certificates()
    {
        $this->set_active_menu('certificates_admin');

        $selected_event_id = (int) $this->input->get('event_id', TRUE);
        $selected_event_id = $selected_event_id > 0 ? $selected_event_id : null;
        $keyword = trim((string) $this->input->get('keyword', TRUE));

        $this->render('admin/certificates/index', array(
            'page_title' => 'Certificates',
            'events' => $this->event_model->get_options(),
            'selected_event_id' => $selected_event_id,
            'keyword' => $keyword,
            'certificates' => $this->event_model->get_certificates($selected_event_id, $keyword),
        ));
    }

    public function certificate($id = null)
    {
        $this->load_composer();

        $certificate = $this->event_model->get_certificate_by_id($id);

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

    public function pdf()
    {
        $this->load_composer();

        $keyword = trim((string) $this->input->get('keyword', TRUE));
        $status = trim((string) $this->input->get('status', TRUE));
        $start_date = trim((string) $this->input->get('start_date', TRUE));
        $end_date = trim((string) $this->input->get('end_date', TRUE));

        if (!in_array($status, array('dibuka', 'ditutup', 'selesai'), TRUE)) {
            $status = '';
        }

        $events = $this->event_model->get_all(null, 0, $keyword, $status, $start_date, $end_date);
        $html = $this->load->view('admin/events/report_pdf', array('events' => $events), TRUE);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('event-report.pdf', array('Attachment' => 0));
    }

    public function excel()
    {
        $this->load_composer();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Event');

        $keyword = trim((string) $this->input->get('keyword', TRUE));
        $status = trim((string) $this->input->get('status', TRUE));
        $start_date = trim((string) $this->input->get('start_date', TRUE));
        $end_date = trim((string) $this->input->get('end_date', TRUE));

        if (!in_array($status, array('dibuka', 'ditutup', 'selesai'), TRUE)) {
            $status = '';
        }

        $this->write_event_sheet($sheet, $this->event_model->get_all(null, 0, $keyword, $status, $start_date, $end_date));
        $this->download_excel($spreadsheet, 'event-report.xlsx');
    }

    public function export_participants($event_id = null)
    {
        $this->load_composer();

        $event = $this->event_model->get_by_id($event_id);

        if (!$event) {
            show_404();
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Participants');

        $headers = array('No', 'Name', 'Email', 'Phone', 'Institution', 'Address', 'Team', 'Registration Status', 'Attendance');
        $column = 'A';

        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $column++;
        }

        $row = 2;
        $number = 1;
        $participants = $this->event_model->get_participants($event_id);

        foreach ($participants as $participant) {
            $sheet->setCellValue('A' . $row, $number++);
            $sheet->setCellValue('B' . $row, $participant->user_name);
            $sheet->setCellValue('C' . $row, $participant->email);
            $sheet->setCellValue('D' . $row, $participant->phone_number);
            $sheet->setCellValue('E' . $row, $participant->institution);
            $sheet->setCellValue('F' . $row, $participant->address);
            $sheet->setCellValue('G' . $row, $participant->team);
            $sheet->setCellValue('H' . $row, $participant->status);
            $sheet->setCellValue('I' . $row, $participant->attendance);
            $row++;
        }

        foreach (range('A', 'I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(TRUE);
        }

        $this->download_excel($spreadsheet, 'event-participants-' . $event->id . '.xlsx');
    }

    private function pagination_config($keyword, $status = null, $start_date = null, $end_date = null)
    {
        return array(
            'base_url' => base_url('event/index'),
            'total_rows' => $this->event_model->count_all($keyword, $status, $start_date, $end_date),
            'per_page' => self::PER_PAGE,
            'uri_segment' => 3,
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

    private function set_event_rules()
    {
        $this->form_validation->set_rules('name', 'Event Name', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('start_time', 'Start Time', 'trim');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim');
        $this->form_validation->set_rules('location', 'Location', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('quota', 'Quota', 'trim|integer');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[dibuka,ditutup,selesai]');
        $this->form_validation->set_rules('description', 'Description', 'trim');
    }

    private function event_payload()
    {
        return array(
            'user_id' => (int) $this->session->userdata('id'),
            'name' => $this->input->post('name', TRUE),
            'description' => $this->input->post('description', TRUE),
            'date' => $this->input->post('date', TRUE),
            'start_time' => $this->input->post('start_time', TRUE) ?: null,
            'end_time' => $this->input->post('end_time', TRUE) ?: null,
            'location' => $this->input->post('location', TRUE),
            'quota' => $this->input->post('quota', TRUE) !== '' ? (int) $this->input->post('quota', TRUE) : null,
            'status' => $this->input->post('status', TRUE),
        );
    }

    private function upload_banner()
    {
        $upload_path = FCPATH . 'uploads/banner/';

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

    private function write_event_sheet($sheet, $events)
    {
        $headers = array('No', 'Event Name', 'Date', 'Time', 'Location', 'Quota', 'Status');
        $column = 'A';

        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $column++;
        }

        $row = 2;
        $number = 1;

        foreach ($events as $event) {
            $sheet->setCellValue('A' . $row, $number++);
            $sheet->setCellValue('B' . $row, $event->name);
            $sheet->setCellValue('C' . $row, $event->date);
            $sheet->setCellValue('D' . $row, trim(($event->start_time ?: '-') . ' - ' . ($event->end_time ?: '-')));
            $sheet->setCellValue('E' . $row, $event->location);
            $sheet->setCellValue('F' . $row, $event->quota ?: '-');
            $sheet->setCellValue('G' . $row, $event->status);
            $row++;
        }

        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(TRUE);
        }
    }

    private function download_excel($spreadsheet, $filename)
    {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
