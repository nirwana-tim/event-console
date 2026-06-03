<?php
defined('BASEPATH') OR exit('No direct script access allowed');

<<<<<<< HEAD
class Peserta extends MY_Controller
{
=======
class Peserta extends CI_Controller {

>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
    public function __construct()
    {
        parent::__construct();

<<<<<<< HEAD
        $this->require_role('peserta');
        $this->load->model('Event_model', 'event_model');
        $this->load->model('Pendaftaran_model', 'pendaftaran_model');
=======
        check_login();
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
    }

    public function event()
    {
<<<<<<< HEAD
        $this->set_active_menu('peserta_event');

        $this->render('peserta/event', array(
            'page_title' => 'Event - EventConsole',
            'events' => $this->event_model->get_all(),
        ));
    }

    public function form_daftar($id = null)
    {
        $this->set_active_menu('peserta_event');
        $event = $this->event_model->get_by_id($id);

        if (!$event) {
            show_404();
        }

        $existing_registration = $this->pendaftaran_model->find_by_user_event(
            $this->session->userdata('id'),
            $id
        );

        if ($existing_registration) {
            $this->redirect_existing_registration($existing_registration);
        }

        $this->render_registration_form($event);
    }

    public function daftar($id = null)
    {
        $this->set_active_menu('peserta_event');
        $event = $this->event_model->get_by_id($id);

        if (!$event) {
            show_404();
        }

        if ($this->input->method() !== 'post') {
            redirect('peserta/form_daftar/' . $id);
        }

        $existing_registration = $this->pendaftaran_model->find_by_user_event(
            $this->session->userdata('id'),
            $id
        );

        if ($existing_registration) {
            $this->redirect_existing_registration($existing_registration);
        }

        $this->set_registration_rules();

        if ($this->form_validation->run() === FALSE) {
            $this->render_registration_form($event);
            return;
        }

        $registration_id = $this->pendaftaran_model->create_registration($this->registration_payload($id));

        redirect('peserta/upload_bayar/' . $registration_id);
    }

    public function upload_bayar($id = null)
    {
        $this->set_active_menu('peserta_event');

        if (!$this->pendaftaran_model->user_owns_registration($id, $this->session->userdata('id'))) {
            show_404();
        }

        if ($this->pendaftaran_model->find_payment($id)) {
            $this->session->set_flashdata('info', 'Bukti pembayaran sudah pernah diupload.');
            redirect('peserta/event');
        }

        if ($this->input->method() === 'post') {
            $upload = $this->upload_payment();

            if (!$upload) {
                $this->session->set_flashdata('error', trim(strip_tags($this->upload->display_errors('', ''))));
                redirect('peserta/upload_bayar/' . $id);
            }

            $this->pendaftaran_model->create_payment($id, $upload['file_name']);
            $this->session->set_flashdata('success', 'Bukti pembayaran berhasil diupload.');

            redirect('peserta/event');
        }

        $this->render('peserta/upload', array(
            'page_title' => 'Upload Bukti Pembayaran - EventConsole',
        ));
    }

    public function sertifikat()
    {
        $this->set_active_menu('sertifikat');

        $this->render('peserta/sertifikat', array(
            'page_title' => 'Sertifikat Saya - EventConsole',
            'certificates' => $this->event_model->get_user_certificates($this->session->userdata('id')),
        ));
    }

    public function download($id = null)
    {
        $this->load_composer();

        $certificate = $this->event_model->get_certificate_by_id($id, $this->session->userdata('id'));

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

    private function render_registration_form($event)
    {
        $this->render('peserta/form_daftar', array(
            'page_title' => 'Form Pendaftaran Event - EventConsole',
            'event' => $event,
        ));
    }

    private function redirect_existing_registration($registration)
    {
        if (!$this->pendaftaran_model->find_payment($registration->id)) {
            redirect('peserta/upload_bayar/' . $registration->id);
        }

        $this->session->set_flashdata('info', 'Kamu sudah terdaftar dan sudah upload pembayaran.');
        redirect('peserta/event');
    }

    private function set_registration_rules()
    {
        $this->form_validation->set_rules('no_hp', 'No HP', 'trim|required|max_length[30]');
        $this->form_validation->set_rules('instansi', 'Instansi', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('team', 'Team', 'trim|max_length[150]');
        $this->form_validation->set_rules('catatan', 'Catatan', 'trim');
    }

    private function registration_payload($event_id)
    {
        return array(
            'user_id' => (int) $this->session->userdata('id'),
            'event_id' => (int) $event_id,
            'status' => 'pending',
            'no_hp' => $this->input->post('no_hp', TRUE),
            'instansi' => $this->input->post('instansi', TRUE),
            'alamat' => $this->input->post('alamat', TRUE),
            'team' => $this->input->post('team', TRUE),
            'catatan' => $this->input->post('catatan', TRUE),
        );
    }

    private function upload_payment()
    {
        $upload_path = FCPATH . 'uploads/pembayaran/';

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

        if (!$this->upload->do_upload('bukti')) {
            return false;
        }

        return $this->upload->data();
    }
}
=======
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
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
