<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Event_report extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->require_admin();
        $this->load->model('admin/Admin_event_model', 'event_model');
    }

    public function pdf()
    {
        $this->load->library('pdf_gen');

        $events = $this->event_model->get_all(
            null,
            0,
            $this->keyword(),
            $this->status(),
            $this->start_date(),
            $this->end_date()
        );

        $this->pdf_gen->generate('admin/events/report_pdf', array('events' => $events), 'event-report', 'A4', 'portrait');
    }

    public function excel()
    {
        $this->load_composer();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Event');

        $events = $this->event_model->get_all(
            null,
            0,
            $this->keyword(),
            $this->status(),
            $this->start_date(),
            $this->end_date()
        );

        $this->write_event_sheet($sheet, $events);
        $this->download_excel($spreadsheet, 'event-report.xlsx');
    }

    private function keyword()
    {
        return trim((string) $this->input->get('keyword', TRUE));
    }

    private function status()
    {
        $status = trim((string) $this->input->get('status', TRUE));

        return in_array($status, array('dibuka', 'ditutup', 'selesai'), TRUE) ? $status : '';
    }

    private function start_date()
    {
        return trim((string) $this->input->get('start_date', TRUE));
    }

    private function end_date()
    {
        return trim((string) $this->input->get('end_date', TRUE));
    }

    private function write_event_sheet($sheet, $events)
    {
        $this->write_headers($sheet, array('No', 'Event Name', 'Date', 'Time', 'Location', 'Quota', 'Status'));

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
