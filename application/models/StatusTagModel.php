<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StatusTagModel extends CI_Model
{
    private $table = 'status_tag';

    public function getall($condition)
    {
        
        $this->db->select('status_tag.*, tags_value.value as status_value, tags_value.id as status_id');
        $this->db->from($this->table);
        $this->db->join('status_tag_types as tags_value', 'status_tag.id=tags_value.status_tag_id', 'left');
        $this->db->where([
            'name' => $condition,
            'is_active' => 1
        ]);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        return $query->result();   
    }

    public function addTag($data)
    {
        $this->db->insert( 'status_tag_types', $data);
        $insert_id = $this->db->insert_id();
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false; 
        }
    }


     public function delete_record($condition){
        $this->db->where($condition);
        $this->db->update('status_tag_types', ['is_active'=> 0]);
        if ( $this->db->affected_rows() > 0 ) {
            return TRUE;
        } else {
            return FALSE;  
        }
    }
}
