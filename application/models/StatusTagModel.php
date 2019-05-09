<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StatusTagModel extends CI_Model
{
    private $table = 'status_tag';

    public function getall()
    {
        
        $this->db->select('status_tag.*, tags_value.value as status_value');
        $this->db->from($this->table);
        $this->db->join('status_tag_type as tags_value', 'status_tag.id=tags_value.status_tag_id', 'left');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        return $query->result();   
    }
}
