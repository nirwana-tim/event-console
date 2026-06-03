<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendaftaran_model extends CI_Model
{
    public function find_by_user_event($user_id, $event_id)
    {
        return $this->db->get_where('pendaftaran', array(
            'user_id' => (int) $user_id,
            'event_id' => (int) $event_id,
        ))->row();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->get_where('pendaftaran', array('id' => (int) $id))
            ->row();
    }

    public function find_payment($pendaftaran_id)
    {
        return $this->db
            ->get_where('pembayaran', array('pendaftaran_id' => (int) $pendaftaran_id))
            ->row();
    }

    public function user_owns_registration($pendaftaran_id, $user_id)
    {
        return $this->db
            ->where('id', (int) $pendaftaran_id)
            ->where('user_id', (int) $user_id)
            ->count_all_results('pendaftaran') > 0;
    }

    public function create_registration($data)
    {
        $this->db->insert('pendaftaran', $data);

        return $this->db->insert_id();
    }

    public function create_payment($pendaftaran_id, $file_name)
    {
        return $this->db->insert('pembayaran', array(
            'pendaftaran_id' => (int) $pendaftaran_id,
            'bukti_bayar' => $file_name,
            'status' => 'pending',
        ));
    }

    public function daftar_event($data_pendaftaran, $data_pembayaran = null)
    {
        $this->db->trans_start();

        $this->db->insert('pendaftaran', $data_pendaftaran);
        $pendaftaran_id = $this->db->insert_id();

        if ($data_pembayaran) {
            $data_pembayaran['pendaftaran_id'] = $pendaftaran_id;
            $this->db->insert('pembayaran', $data_pembayaran);
        }

        $this->db->trans_complete();

        return $this->db->trans_status() ? $pendaftaran_id : false;
    }

    public function daftarEvent($dataPendaftaran, $dataPembayaran)
    {
        return $this->daftar_event($dataPendaftaran, $dataPembayaran) !== false;
    }
}
