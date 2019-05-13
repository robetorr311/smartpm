<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LeadStatusModel extends CI_Model
{
    private $table = 'jobs_status';

   	public function get_all_where( $condition ){

        $this->db->where($condition);
		$result = $this->db->get($this->table);
		return $result->result();	
	}
    
    public function add_record( $array ){
    
        $this->db->insert($this->table, $array);
        
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false; 
        }
    }

    public function update_record($updatedArray, $condition){
        $this->db->where($condition);
        $this->db->update($this->table, $updatedArray);
        if ( $this->db->affected_rows() > 0 ) {
            return TRUE;
        } else {
            return FALSE;  
        }
    }

    
    public function delete($id)
    {
        return $this->db->delete($this->table, [
            'id' => $id
        ]);
    }
}
