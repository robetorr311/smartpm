<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PartyModel extends CI_Model
{
    private $table = 'job_add_party';

    public function getPartyByLeadId($jobid)
    {
        $this->db->where([
            'job_id' => $jobid
        ]);
        $query = $this->db->get($this->table);
        $result = $query->first_row();
        return $result ? $result : false;
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
    
}
