<?php
class Event_model extends CI_Model {

    public function getAll($limit, $start, $keyword = null)
    {
        if($keyword){
            $this->db->like('nama_event', $keyword);
        }

        return $this->db->get('events', $limit, $start)->result();
    }

    public function countData($keyword = null)
    {
        if($keyword){
            $this->db->like('nama_event', $keyword);
        }

        return $this->db->count_all_results('events');
    }

    public function insert($data)
    {
        return $this->db->insert('events', $data);
    }

    public function getById($id)
    {
        return $this->db->get_where('events', ['id' => $id])->row();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('events', $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete('events');
    }
}
