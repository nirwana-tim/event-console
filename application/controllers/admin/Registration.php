<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registration extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->require_admin();
        $this->load->model('admin/Admin_event_model', 'event_model');
        $this->load->model('admin/Admin_registration_model', 'registration_model');
    }

    public function index($event_id = null)
    {
        $this->set_active_menu('registrations');

        $selected_event_id = $event_id ? (int) $event_id : (int) $this->input->get('event_id', TRUE);
        $selected_event_id = $selected_event_id > 0 ? $selected_event_id : null;
        $keyword = trim((string) $this->input->get('keyword', TRUE));
        $attendance = $this->valid_attendance($this->input->get('attendance', TRUE));

        $this->render('admin/registrations/index', array(
            'page_title' => 'Participant Registrations',
            'events' => $this->event_model->options(),
            'selected_event_id' => $selected_event_id,
            'keyword' => $keyword,
            'selected_attendance' => $attendance,
            'registrations' => $this->registration_model->get_all($selected_event_id, $keyword, $attendance),
        ));
    }

    public function update($id = null, $attendance = null)
    {
        $attendance = $attendance ?: $this->input->post('attendance', TRUE);

        if (!$id || !$attendance) {
            show_404();
        }

        $attendance = $this->valid_attendance($attendance);

        if ($attendance === '') {
            show_404();
        }

        if ($this->registration_model->update_attendance($id, $attendance)) {
            $this->session->set_flashdata('success', 'Attendance updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Attendance update failed.');
        }

        $referrer = $this->input->server('HTTP_REFERER', TRUE);

        redirect($referrer ? $referrer : 'admin/registration');
    }

    public function export($event_id = null)
    {
        $this->load_composer();

        $event = $this->event_model->find($event_id);

        if (!$event) {
            show_404();
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Participants');

        $this->write_headers($sheet, array('No', 'Name', 'Email', 'Phone', 'Institution', 'Address', 'Team', 'Attendance'));

        $row = 2;
        $number = 1;
        $participants = $this->registration_model->participants_by_event($event_id);

        foreach ($participants as $participant) {
            $sheet->setCellValue('A' . $row, $number++);
            $sheet->setCellValue('B' . $row, $participant->user_name);
            $sheet->setCellValue('C' . $row, $participant->email);
            $sheet->setCellValue('D' . $row, $participant->phone_number);
            $sheet->setCellValue('E' . $row, $participant->institution);
            $sheet->setCellValue('F' . $row, $participant->address);
            $sheet->setCellValue('G' . $row, $participant->team);
            $sheet->setCellValue('H' . $row, $participant->attendance);
            $row++;
        }

        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(TRUE);
        }

        $this->download_excel($spreadsheet, 'event-participants-' . $event->id . '.xlsx');
    }

    private function valid_attendance($attendance)
    {
        $attendance = trim((string) $attendance);

        return in_array($attendance, array('unconfirmed', 'present', 'absent'), TRUE) ? $attendance : '';
    }

    private function write_headers($sheet, $headers)
    {
        $column = 'A';

        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $column++;
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
