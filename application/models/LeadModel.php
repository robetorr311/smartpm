<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LeadModel extends CI_Model
{
    private $table = 'jobs';

   	public function get_all_where( $tablename, $condition ){

        $this->db->where($condition);
		$this->db->order_by("id", "desc");
		$result = $this->db->get($tablename);
		return $result->result();	
	}
    
    public function getCount()
    {     
        $this->db->where(['status' => 'lead']);
        return $this->db->count_all_results($this->table);
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
