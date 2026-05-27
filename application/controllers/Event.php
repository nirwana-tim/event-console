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
        $offset = (int) $this->uri->segment(3, 0);

        $this->pagination->initialize($this->pagination_config($keyword));

        $this->render('event/index', array(
            'page_title' => 'Data Event - EventKu',
            'events' => $this->event_model->get_all(self::PER_PAGE, $offset, $keyword),
            'keyword' => $keyword,
            'offset' => $offset,
        ));
    }

    public function tambah()
    {
        $this->set_active_menu('event');
        $this->set_event_rules();

        if ($this->form_validation->run() === FALSE) {
            $this->render('event/tambah', array('page_title' => 'Tambah Event - EventKu'));
            return;
        }

        $upload = $this->upload_banner();

        if (!$upload) {
            $this->session->set_flashdata('error', trim(strip_tags($this->upload->display_errors('', ''))));
            redirect('event/tambah');
        }

        $data = $this->event_payload();
        $data['banner'] = $upload['file_name'];

        $this->event_model->insert($data);
        $this->session->set_flashdata('success', 'Event berhasil ditambahkan.');

        redirect('event');
    }

    public function edit($id = null)
    {
        $this->set_active_menu('event');

        $event = $this->event_model->get_by_id($id);

        if (!$event) {
            show_404();
        }

        $this->set_event_rules();

        if ($this->form_validation->run() === FALSE) {
            $this->render('event/edit', array(
                'page_title' => 'Edit Event - EventKu',
                'event' => $event,
            ));
            return;
        }

        $data = $this->event_payload();

        if (!empty($_FILES['banner']['name'])) {
            $upload = $this->upload_banner();

            if (!$upload) {
                $this->session->set_flashdata('error', trim(strip_tags($this->upload->display_errors('', ''))));
                redirect('event/edit/' . $id);
            }

            $data['banner'] = $upload['file_name'];
        }

        $this->event_model->update($id, $data);
        $this->session->set_flashdata('success', 'Event berhasil diperbarui.');

        redirect('event');
    }

    public function hapus($id = null)
    {
        $event = $this->event_model->get_by_id($id);

        if (!$event) {
            show_404();
        }

        if ($this->event_model->has_registrations($id)) {
            $this->session->set_flashdata('error', 'Event tidak bisa dihapus karena sudah memiliki pendaftaran.');
            redirect('event');
        }

        $this->event_model->delete($id);
        $this->session->set_flashdata('success', 'Event berhasil dihapus.');

        redirect('event');
    }

    public function pendaftaran($event_id = null)
    {
        $this->set_active_menu('pendaftaran');

        $selected_event_id = $event_id ? (int) $event_id : (int) $this->input->get('event_id', TRUE);
        $selected_event_id = $selected_event_id > 0 ? $selected_event_id : null;

        $this->render('event/pendaftaran', array(
            'page_title' => 'Pendaftaran Peserta - EventKu',
            'events' => $this->event_model->get_options(),
            'selected_event_id' => $selected_event_id,
            'registrations' => $this->event_model->get_registrations($selected_event_id),
        ));
    }

    public function pembayaran()
    {
        $this->set_active_menu('pembayaran');

        $this->render('event/pembayaran', array(
            'page_title' => 'Pembayaran - EventKu',
            'payments' => $this->event_model->get_payments(),
        ));
    }

    public function approve($id = null)
    {
        $payment = $this->event_model->get_payment_by_id($id);

        if (!$payment) {
            show_404();
        }

        if ($payment->status === 'verified') {
            $this->session->set_flashdata('info', 'Pembayaran sudah diverifikasi sebelumnya.');
            redirect('event/pembayaran');
        }

        if ($this->event_model->approve_payment($id)) {
            $this->session->set_flashdata('success', 'Pembayaran berhasil diverifikasi dan sertifikat dibuat.');
        } else {
            $this->session->set_flashdata('error', 'Pembayaran gagal diverifikasi.');
        }

        redirect('event/pembayaran');
    }

    public function sertifikat($id = null)
    {
        $this->load_composer();

        $certificate = $this->event_model->get_certificate_by_id($id);

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

    public function pdf()
    {
        $this->load_composer();

        $events = $this->event_model->get_all();
        $html = $this->load->view('event/pdf', array('events' => $events), TRUE);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('laporan-event.pdf', array('Attachment' => 0));
    }

    public function excel()
    {
        $this->load_composer();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Event');

        $this->write_event_sheet($sheet, $this->event_model->get_all());
        $this->download_excel($spreadsheet, 'laporan-event.xlsx');
    }

    public function export_peserta($event_id = null)
    {
        $this->load_composer();

        $event = $this->event_model->get_by_id($event_id);

        if (!$event) {
            show_404();
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Peserta');

        $headers = array('No', 'Nama', 'Email', 'No HP', 'Instansi', 'Alamat', 'Team', 'Status Daftar', 'Status Bayar');
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
            $sheet->setCellValue('B' . $row, $participant->nama);
            $sheet->setCellValue('C' . $row, $participant->email);
            $sheet->setCellValue('D' . $row, $participant->no_hp);
            $sheet->setCellValue('E' . $row, $participant->instansi);
            $sheet->setCellValue('F' . $row, $participant->alamat);
            $sheet->setCellValue('G' . $row, $participant->team);
            $sheet->setCellValue('H' . $row, $participant->status);
            $sheet->setCellValue('I' . $row, $participant->status_pembayaran ?: 'belum_upload');
            $row++;
        }

        foreach (range('A', 'I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(TRUE);
        }

        $this->download_excel($spreadsheet, 'peserta-event-' . $event->id . '.xlsx');
    }

    private function pagination_config($keyword)
    {
        return array(
            'base_url' => base_url('event/index'),
            'total_rows' => $this->event_model->count_all($keyword),
            'per_page' => self::PER_PAGE,
            'uri_segment' => 3,
            'reuse_query_string' => TRUE,
            'full_tag_open' => '<nav aria-label="Pagination"><ul class="pagination mt-3">',
            'full_tag_close' => '</ul></nav>',
            'first_link' => 'Awal',
            'last_link' => 'Akhir',
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
        $this->form_validation->set_rules('nama_event', 'Nama Event', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
    }

    private function event_payload()
    {
        return array(
            'nama_event' => $this->input->post('nama_event', TRUE),
            'deskripsi' => $this->input->post('deskripsi', TRUE),
            'tanggal' => $this->input->post('tanggal', TRUE),
            'lokasi' => $this->input->post('lokasi', TRUE),
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
        $headers = array('No', 'Nama Event', 'Tanggal', 'Lokasi');
        $column = 'A';

        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $column++;
        }

        $row = 2;
        $number = 1;

        foreach ($events as $event) {
            $sheet->setCellValue('A' . $row, $number++);
            $sheet->setCellValue('B' . $row, $event->nama_event);
            $sheet->setCellValue('C' . $row, $event->tanggal);
            $sheet->setCellValue('D' . $row, $event->lokasi);
            $row++;
        }

        foreach (range('A', 'D') as $column) {
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
