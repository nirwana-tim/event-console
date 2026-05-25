<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        check_login();
        check_admin();

        $this->load->model('Event_model');
        $this->load->library('pagination');
    }

    public function index()
    {
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
    }

    public function tambah()
    {
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

        redirect('event');
    }

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

        redirect('event');
    }

    public function hapus($id)
    {
        $event = $this->Event_model->getById($id);

        if (!$event) {
            show_404();
        }

        $used = $this->db
            ->where('event_id', $id)
            ->count_all_results('pendaftaran');

        if ($used > 0) {
            $this->session->set_flashdata('error', 'Event tidak bisa dihapus karena sudah memiliki pendaftaran');
            redirect('event');
        }

        $this->Event_model->delete($id);
        $this->session->set_flashdata('success', 'Event berhasil dihapus');

        redirect('event');
    }

    public function pendaftaran($event_id = null)
    {
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
    }

    public function pembayaran()
    {
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

        redirect('event/pembayaran');
    }

    public function sertifikat($id)
    {
        require APPPATH . '../vendor/autoload.php';

        $data['sertifikat'] = $this->_get_sertifikat($id);

        if (!$data['sertifikat']) {
            show_404();
        }

        $dompdf = new \Dompdf\Dompdf();
        $html = $this->load->view('peserta/pdf_sertifikat', $data, true);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('sertifikat-'.$data['sertifikat']->nomor_sertifikat.'.pdf', ['Attachment' => 0]);
    }

    public function pdf()
    {
        require_once APPPATH . '../vendor/autoload.php';

        $dompdf = new \Dompdf\Dompdf();

        $data['event'] = $this->db->get('events')->result();
        $html = $this->load->view('event/pdf', $data, true);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('laporan-event.pdf', ['Attachment' => 0]);
    }

    public function excel()
    {
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

        if (!$event) {
            show_404();
        }

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

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Peserta');

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
            $row++;
        }

        foreach (range('A', 'I') as $column) {
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

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('banner')) {
            return false;
        }

        $upload = $this->upload->data();

        $this->load->library('image_lib');
        $this->image_lib->clear();

        $resize['image_library'] = 'gd2';
        $resize['source_image'] = './uploads/banner/' . $upload['file_name'];
        $resize['maintain_ratio'] = TRUE;
        $resize['width'] = 300;
        $resize['height'] = 300;

        $this->image_lib->initialize($resize);
        $this->image_lib->resize();

        return $upload;
    }

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
            ob_end_clean();
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
