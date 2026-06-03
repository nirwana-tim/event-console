<?php
defined('BASEPATH') OR exit('No direct script access allowed');

<<<<<<< HEAD
class Pendaftaran extends MY_Controller
{
=======
class Pendaftaran extends CI_Controller {
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

    public function __construct()
    {
        parent::__construct();

<<<<<<< HEAD
        $this->require_login();
    }

    public function index()
    {
        redirect('peserta/event');
    }
}
=======
        $this->load->model('Pendaftaran_model');
    }

    public function test_transaction()
    {
        $dataPendaftaran = [
            'user_id' => 1,
            'event_id' => 1,
            'status' => 'pending'
        ];

        $dataPembayaran = [
            'bukti_bayar' => 'bukti.jpg',
            'status' => 'pending'
        ];

        $test = $this->Pendaftaran_model->daftarEvent(
            $dataPendaftaran,
            $dataPembayaran
        );

        if($test){

            echo "TRANSACTION BERHASIL";

        } else {

            echo "TRANSACTION GAGAL & ROLLBACK BERHASIL";

        }
    }
}
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
