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
}
