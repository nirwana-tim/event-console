<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendaftaran extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

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