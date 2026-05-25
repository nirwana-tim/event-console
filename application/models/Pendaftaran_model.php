<?php
class Pendaftaran_model extends CI_Model {

    public function daftarEvent($dataPendaftaran, $dataPembayaran)
    {
        $this->db->trans_start();

        $this->db->insert('pendaftaran', $dataPendaftaran);

        $pendaftaran_id = $this->db->insert_id();

        $dataPembayaran['pendaftaran_id'] = $pendaftaran_id;

        $this->db->insert('pembayaran_salah', $dataPembayaran);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}