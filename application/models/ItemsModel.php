<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ItemsModel extends CI_Model
{
    private $table = 'items';

    public function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert ? $this->db->insert_id() : $insert;

    }

    public function allItems()
    {
        $this->db->from($this->table);
        $this->db->order_by('created_at', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    public function getItemById($id){
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $update = $this->db->update($this->table, $data);
        return $update;
    }
    public function delete($id){
        $this->db->where('id', $id);
        $delete = $this->db->delete($this->table);
        return $delete;
    }
}
