<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TeamModel extends CI_Model
{
    private $table = 'teams';

   	public function get_all_where( $condition ){

        $this->db->where($condition);
		$this->db->order_by("id", "desc");
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
    
    public function getCount()
    {     
        $this->db->where(['is_active' => 1]);
        return $this->db->count_all_results($this->table);
    }
    
    public function delete($id)
    {
        return $this->db->delete($this->table, [
            'id' => $id
        ]);
    }
}
