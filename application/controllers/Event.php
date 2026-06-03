<?php
defined('BASEPATH') OR exit('No direct script access allowed');

<<<<<<< HEAD
class Event extends MY_Controller
{
    const PER_PAGE = 5;
=======
class Event extends CI_Controller {
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

    public function __construct()
    {
        parent::__construct();

<<<<<<< HEAD
        $this->require_admin();
        $this->load->model('Event_model', 'event_model');
=======
        check_login();
        check_admin();

        $this->load->model('Event_model');
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
        $this->load->library('pagination');
    }

    public function index()
    {
<<<<<<< HEAD
        $this->set_active_menu('event');

        $keyword = trim((string) $this->input->get('keyword', TRUE));
        $offset = (int) $this->uri->segment(3, 0);

        $this->pagination->initialize($this->pagination_config($keyword));

        $this->render('event/index', array(
            'page_title' => 'Data Event - EventConsole',
            'events' => $this->event_model->get_all(self::PER_PAGE, $offset, $keyword),
            'keyword' => $keyword,
            'offset' => $offset,
        ));
=======
        $keyword = $this->input->get('keyword');

        $config['base_url'] = base_url('event/index');
        $config['total_rows'] = $this->Event_model->countData($keyword);
        $config['per_page'] = 5;

        $this->pagination->initialize($config);

        $start = $this->uri->segment(3);

        $data['event'] = $this->Event_model->getAll(
            $config['per_page'],
            $start,
            $keyword
        );

        $this->_view('event/index', $data);
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
    }

    public function tambah()
    {
<<<<<<< HEAD
        $this->set_active_menu('event');
        $this->set_event_rules();

        if ($this->form_validation->run() === FALSE) {
            $this->render('event/tambah', array('page_title' => 'Tambah Event - EventConsole'));
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
=======
        $this->_set_event_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->_view('event/tambah');
            return;
        }

        $upload = $this->_upload_banner();

        if (!$upload) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('event/tambah');
        }

        $data = [
            'nama_event' => $this->input->post('nama_event'),
            'deskripsi' => $this->input->post('deskripsi'),
            'tanggal' => $this->input->post('tanggal'),
            'lokasi' => $this->input->post('lokasi'),
            'banner' => $upload['file_name']
        ];

        $this->Event_model->insert($data);
        $this->session->set_flashdata('success', 'Event berhasil ditambahkan');
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

        redirect('event');
    }

<<<<<<< HEAD
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
                'page_title' => 'Edit Event - EventConsole',
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
=======
    public function edit($id)
    {
        $data['event'] = $this->Event_model->getById($id);

        if (!$data['event']) {
            show_404();
        }

        $this->_set_event_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->_view('event/edit', $data);
            return;
        }

        $update = [
            'nama_event' => $this->input->post('nama_event'),
            'deskripsi' => $this->input->post('deskripsi'),
            'tanggal' => $this->input->post('tanggal'),
            'lokasi' => $this->input->post('lokasi')
        ];

        if (!empty($_FILES['banner']['name'])) {
            $upload = $this->_upload_banner();

            if (!$upload) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('event/edit/'.$id);
            }

            $update['banner'] = $upload['file_name'];
        }

        $this->Event_model->update($id, $update);
        $this->session->set_flashdata('success', 'Event berhasil diupdate');
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

        redirect('event');
    }

<<<<<<< HEAD
    public function hapus($id = null)
    {
        $event = $this->event_model->get_by_id($id);
=======
    public function hapus($id)
    {
        $event = $this->Event_model->getById($id);
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

        if (!$event) {
            show_404();
        }

<<<<<<< HEAD
        if ($this->event_model->has_registrations($id)) {
            $this->session->set_flashdata('error', 'Event tidak bisa dihapus karena sudah memiliki pendaftaran.');
            redirect('event');
        }

        $this->event_model->delete($id);
        $this->session->set_flashdata('success', 'Event berhasil dihapus.');
=======
        $used = $this->db
            ->where('event_id', $id)
            ->count_all_results('pendaftaran');

        if ($used > 0) {
            $this->session->set_flashdata('error', 'Event tidak bisa dihapus karena sudah memiliki pendaftaran');
            redirect('event');
        }

        $this->Event_model->delete($id);
        $this->session->set_flashdata('success', 'Event berhasil dihapus');
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

        redirect('event');
    }

    public function pendaftaran($event_id = null)
    {
<<<<<<< HEAD
        $this->set_active_menu('pendaftaran');

        $selected_event_id = $event_id ? (int) $event_id : (int) $this->input->get('event_id', TRUE);
        $selected_event_id = $selected_event_id > 0 ? $selected_event_id : null;

        $this->render('event/pendaftaran', array(
            'page_title' => 'Pendaftaran Peserta - EventConsole',
            'events' => $this->event_model->get_options(),
            'selected_event_id' => $selected_event_id,
            'registrations' => $this->event_model->get_registrations($selected_event_id),
        ));
=======
        $data['events'] = $this->db->order_by('nama_event', 'ASC')->get('events')->result();
        $data['selected_event_id'] = $event_id ?: $this->input->get('event_id');

        $this->db->select('
            pendaftaran.*,
            users.nama,
            users.email,
            events.nama_event,
            pembayaran.status AS status_pembayaran
        ');
        $this->db->from('pendaftaran');
        $this->db->join('users', 'users.id = pendaftaran.user_id');
        $this->db->join('events', 'events.id = pendaftaran.event_id');
        $this->db->join('pembayaran', 'pembayaran.pendaftaran_id = pendaftaran.id', 'left');

        if ($data['selected_event_id']) {
            $this->db->where('pendaftaran.event_id', $data['selected_event_id']);
        }

        $this->db->order_by('pendaftaran.id', 'DESC');
        $data['pendaftaran'] = $this->db->get()->result();

        $this->_view('event/pendaftaran', $data);
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
    }

    public function pembayaran()
    {
<<<<<<< HEAD
        $this->set_active_menu('pembayaran');

        $this->render('event/pembayaran', array(
            'page_title' => 'Pembayaran - EventConsole',
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
=======
        $this->db->select('
            pembayaran.*,
            users.nama,
            events.nama_event,
            sertifikat.id AS sertifikat_id,
            sertifikat.nomor_sertifikat
        ');
        $this->db->from('pembayaran');
        $this->db->join('pendaftaran', 'pendaftaran.id = pembayaran.pendaftaran_id');
        $this->db->join('users', 'users.id = pendaftaran.user_id');
        $this->db->join('events', 'events.id = pendaftaran.event_id');
        $this->db->join('sertifikat', 'sertifikat.pendaftaran_id = pendaftaran.id', 'left');
        $this->db->order_by('pembayaran.id', 'DESC');

        $data['pembayaran'] = $this->db->get()->result();

        $this->_view('event/pembayaran', $data);
    }

    public function approve($id)
    {
        $pembayaran = $this->db->get_where('pembayaran', ['id' => $id])->row();

        if (!$pembayaran) {
            show_404();
        }

        $this->db->trans_start();

        $this->db->where('id', $id)->update('pembayaran', ['status' => 'verified']);
        $this->db->where('id', $pembayaran->pendaftaran_id)->update('pendaftaran', ['status' => 'approved']);

        $existing = $this->db
            ->get_where('sertifikat', ['pendaftaran_id' => $pembayaran->pendaftaran_id])
            ->row();

        if (!$existing) {
            $nomor = 'SRT-' . $pembayaran->pendaftaran_id . '-' . date('YmdHis');

            $this->db->insert('sertifikat', [
                'pendaftaran_id' => $pembayaran->pendaftaran_id,
                'nomor_sertifikat' => $nomor,
                'file_sertifikat' => $nomor . '.pdf'
            ]);
        }

        $this->db->trans_complete();

        $this->session->set_flashdata('success', 'Pembayaran berhasil diapprove dan sertifikat dibuat');
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

        redirect('event/pembayaran');
    }

<<<<<<< HEAD
    public function sertifikat($id = null)
    {
        $this->load_composer();

        $certificate = $this->event_model->get_certificate_by_id($id);

        if (!$certificate) {
=======
    public function sertifikat($id)
    {
        require APPPATH . '../vendor/autoload.php';

        $data['sertifikat'] = $this->_get_sertifikat($id);

        if (!$data['sertifikat']) {
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
            show_404();
        }

        $dompdf = new \Dompdf\Dompdf();
<<<<<<< HEAD
        $html = $this->load->view('peserta/pdf_sertifikat', array('certificate' => $certificate), TRUE);
=======
        $html = $this->load->view('peserta/pdf_sertifikat', $data, true);
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
<<<<<<< HEAD
        $dompdf->stream('sertifikat-' . $certificate->nomor_sertifikat . '.pdf', array('Attachment' => 0));
=======
        $dompdf->stream('sertifikat-'.$data['sertifikat']->nomor_sertifikat.'.pdf', ['Attachment' => 0]);
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
    }

    public function pdf()
    {
<<<<<<< HEAD
        $this->load_composer();

        $events = $this->event_model->get_all();
        $html = $this->load->view('event/pdf', array('events' => $events), TRUE);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('laporan-event.pdf', array('Attachment' => 0));
=======
        require_once APPPATH . '../vendor/autoload.php';

        $dompdf = new \Dompdf\Dompdf();

        $data['event'] = $this->db->get('events')->result();
        $html = $this->load->view('event/pdf', $data, true);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('laporan-event.pdf', ['Attachment' => 0]);
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
    }

    public function excel()
    {
<<<<<<< HEAD
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
=======
        require APPPATH . '../vendor/autoload.php';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Event');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Lokasi');

        $event = $this->db->get('events')->result();
        $row = 2;
        $no = 1;

        foreach ($event as $e) {
            $sheet->setCellValue('A'.$row, $no++);
            $sheet->setCellValue('B'.$row, $e->nama_event);
            $sheet->setCellValue('C'.$row, $e->tanggal);
            $sheet->setCellValue('D'.$row, $e->lokasi);
            $row++;
        }

        $this->_download_excel($spreadsheet, 'laporan-event.xlsx');
    }

    public function export_peserta($event_id)
    {
        require APPPATH . '../vendor/autoload.php';

        $event = $this->Event_model->getById($event_id);
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

        if (!$event) {
            show_404();
        }

<<<<<<< HEAD
=======
        $this->db->select('
            users.nama,
            users.email,
            pendaftaran.no_hp,
            pendaftaran.instansi,
            pendaftaran.alamat,
            pendaftaran.team,
            pendaftaran.status,
            pembayaran.status AS status_pembayaran
        ');
        $this->db->from('pendaftaran');
        $this->db->join('users', 'users.id = pendaftaran.user_id');
        $this->db->join('pembayaran', 'pembayaran.pendaftaran_id = pendaftaran.id', 'left');
        $this->db->where('pendaftaran.event_id', $event_id);
        $peserta = $this->db->get()->result();

>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Peserta');

<<<<<<< HEAD
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
=======
        $headers = ['No', 'Nama', 'Email', 'No HP', 'Instansi', 'Alamat', 'Team', 'Status Daftar', 'Status Bayar'];
        $col = 'A';

        foreach ($headers as $header) {
            $sheet->setCellValue($col.'1', $header);
            $col++;
        }

        $row = 2;
        $no = 1;

        foreach ($peserta as $p) {
            $sheet->setCellValue('A'.$row, $no++);
            $sheet->setCellValue('B'.$row, $p->nama);
            $sheet->setCellValue('C'.$row, $p->email);
            $sheet->setCellValue('D'.$row, $p->no_hp);
            $sheet->setCellValue('E'.$row, $p->instansi);
            $sheet->setCellValue('F'.$row, $p->alamat);
            $sheet->setCellValue('G'.$row, $p->team);
            $sheet->setCellValue('H'.$row, $p->status);
            $sheet->setCellValue('I'.$row, $p->status_pembayaran ?: 'belum_upload');
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
            $row++;
        }

        foreach (range('A', 'I') as $column) {
<<<<<<< HEAD
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
=======
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $this->_download_excel($spreadsheet, 'peserta-event-'.$event_id.'.xlsx');
    }

    private function _view($view, $data = [])
    {
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view($view, $data);
        $this->load->view('template/footer');
    }

    private function _set_event_rules()
    {
        $this->form_validation->set_rules('nama_event', 'Nama Event', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
    }

    private function _upload_banner()
    {
        $config['upload_path'] = './uploads/banner/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048;
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('banner')) {
            return false;
        }

        $upload = $this->upload->data();

        $this->load->library('image_lib');
        $this->image_lib->clear();
<<<<<<< HEAD
        $this->image_lib->initialize(array(
            'image_library' => 'gd2',
            'source_image' => $upload_path . $upload['file_name'],
            'maintain_ratio' => TRUE,
            'width' => 1200,
            'height' => 675,
        ));
=======

        $resize['image_library'] = 'gd2';
        $resize['source_image'] = './uploads/banner/' . $upload['file_name'];
        $resize['maintain_ratio'] = TRUE;
        $resize['width'] = 300;
        $resize['height'] = 300;

        $this->image_lib->initialize($resize);
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
        $this->image_lib->resize();

        return $upload;
    }

<<<<<<< HEAD
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
=======
    private function _get_sertifikat($id)
    {
        $this->db->select('sertifikat.*, users.nama, events.nama_event');
        $this->db->from('sertifikat');
        $this->db->join('pendaftaran', 'pendaftaran.id = sertifikat.pendaftaran_id');
        $this->db->join('users', 'users.id = pendaftaran.user_id');
        $this->db->join('events', 'events.id = pendaftaran.event_id');
        $this->db->where('sertifikat.id', $id);

        return $this->db->get()->row();
    }

    private function _download_excel($spreadsheet, $filename)
    {
        if (ob_get_length()) {
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
            ob_end_clean();
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
<<<<<<< HEAD
        header('Content-Disposition: attachment;filename="' . $filename . '"');
=======
        header('Content-Disposition: attachment;filename="'.$filename.'"');
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
