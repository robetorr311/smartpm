<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardBoxNameModel extends CI_Model
{
    private $table = 'box_names';

    public function allNames()
    {
        $this->db->from($this->table);
        $this->db->where('is_deleted', FALSE);
        $query = $this->db->get();
        return $query->result();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $update = $this->db->update($this->table, $data);
        return $update;
    }
}
