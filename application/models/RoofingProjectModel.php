<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RoofingProjectModel extends CI_Model
{
    private $table = 'roofing_project';

    public function allProject($condition)
    {
        $this->db->where($condition);
        $this->db->order_by("id", "desc");
        $result = $this->db->get($this->table);
        return $result->result();   
    }

    public function get_all_where( $condition ){

        $this->db->where($condition);
        $result = $this->db->get($this->table);
        return $result->result();   
    }

    public function insert($data)
    {
        $result = $this->db->insert($this->table, $data);
        return $result ? $this->db->insert_id() : $result;
    }

    
    
}
