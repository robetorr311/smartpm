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
    
    public function getStatusByLeadId($jobid)
    {
        $this->db->where([
            'jobid' => $jobid
        ]);
		$query = $this->db->get($this->table);
        $result = $query->first_row();
        return $result ? $result : false;
    }

    public function allJobStatus(){
        $this->db->select("SUM(if(contract='unsigned',1,NULL)) as OPEN, SUM(if(job='labor only' AND lead='open',1,NULL)) as LABOR, SUM(if(job='insurance' AND lead='open',1,NULL)) as INSURANCE, SUM(if(job='cash' AND lead='open',1,NULL)) as CASH , SUM(if(production='complete' AND closeout='yes',1,NULL)) as CLOSED, SUM(if(production='complete' AND closeout='no',1,NULL)) as COMPLETE,"); 
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result(); 
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
