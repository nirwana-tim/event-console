<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peserta extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        check_login();
    }

    public function event()
    {
        $data['event'] = $this->db->get('events')->result();

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('peserta/event', $data);
        $this->load->view('template/footer');
    }

   public function daftar($id)
{
    $cek = $this->db->get_where('pendaftaran', [

        'user_id' => $this->session->userdata('id'),
        'event_id' => $id

    ])->row();

    if($cek){

    $bayar = $this->db->get_where('pembayaran', [

        'pendaftaran_id' => $cek->id

    ])->row();

    if(!$bayar){

        redirect('peserta/upload_bayar/'.$cek->id);

    } else {

        $this->session->set_flashdata(
            'success',
            'Kamu sudah terdaftar dan sudah upload pembayaran'
        );

        redirect('peserta/event');
    }
}
    $data = [

        'user_id' => $this->session->userdata('id'),
        'event_id' => $id,
        'status' => 'pending',

        'no_hp' => $this->input->post('no_hp'),
        'instansi' => $this->input->post('instansi'),
        'alamat' => $this->input->post('alamat'),
        'team' => $this->input->post('team'),
        'catatan' => $this->input->post('catatan')

    ];

    $this->db->insert('pendaftaran', $data);

    $pendaftaran_id = $this->db->insert_id();

    redirect('peserta/upload_bayar/'.$pendaftaran_id);
}

    public function upload_bayar($id)
{
    if($this->input->method() == 'post'){

        $config['upload_path'] = './uploads/pembayaran/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048;

        $this->load->library('upload', $config);

        if($this->upload->do_upload('bukti')){

            $upload = $this->upload->data();

            $data = [

                'pendaftaran_id' => $id,
                'bukti_bayar' => $upload['file_name'],
                'status' => 'pending'

            ];

            $this->db->insert('pembayaran', $data);

            $this->session->set_flashdata(
                'success',
                'Bukti pembayaran berhasil diupload'
            );

            redirect('peserta/event');

        } else {

            echo $this->upload->display_errors();
            die;
        }
    }

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('peserta/upload');
    $this->load->view('template/footer');
}

public function sertifikat()
{
    $this->db->select('
        sertifikat.*,
        events.nama_event,
        users.nama
    ');

    $this->db->from('sertifikat');

    $this->db->join(
        'pendaftaran',
        'pendaftaran.id = sertifikat.pendaftaran_id'
    );

    $this->db->join(
        'users',
        'users.id = pendaftaran.user_id'
    );

    $this->db->join(
        'events',
        'events.id = pendaftaran.event_id'
    );

    $this->db->where(
        'users.id',
        $this->session->userdata('id')
    );

    $data['sertifikat'] = $this->db->get()->result();

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('peserta/sertifikat', $data);
    $this->load->view('template/footer');
}

public function download($id)
{
    require APPPATH . '../vendor/autoload.php';

    $this->db->select('
        sertifikat.*,
        users.nama,
        events.nama_event
    ');

    $this->db->from('sertifikat');

    $this->db->join(
        'pendaftaran',
        'pendaftaran.id = sertifikat.pendaftaran_id'
    );

    $this->db->join(
        'users',
        'users.id = pendaftaran.user_id'
    );

    $this->db->join(
        'events',
        'events.id = pendaftaran.event_id'
    );

    $this->db->where('sertifikat.id', $id);

    $data['sertifikat'] = $this->db->get()->row();

    $dompdf = new \Dompdf\Dompdf();

    $html = $this->load->view(
        'peserta/pdf_sertifikat',
        $data,
        true
    );

    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'landscape');

    $dompdf->render();

    $dompdf->stream(
        'sertifikat.pdf',
        ['Attachment' => 0]
    );
}

public function form_daftar($id)
{
    $data['event'] = $this->db
        ->get_where('events', ['id' => $id])
        ->row();

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('peserta/form_daftar', $data);
    $this->load->view('template/footer');
}
}