<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LeadModel extends CI_Model
{
    private $table = 'jobs';

      /* get All jobs */
    public function getAllJob($condition){

        $this->db->select('jobs.*, status.lead as lead_status, status.job as job_type, status.contract as contract_status');
        $this->db->from($this->table);
        $this->db->join('jobs_status as status', 'jobs.id=status.jobid', 'left'); 
        $this->db->where([
            'lead' => $condition
        ]);
        $query = $this->db->get();
        return $query->result(); 
            
    }

    
   	public function get_all_where( $tablename, $condition ){

        $this->db->where($condition);
		$this->db->order_by("id", "desc");
		$result = $this->db->get($tablename);
		return $result->result();	
	}
  
    /* get job based on job type */
    public function getJobType($condition ){

        $this->db->select('jobs.*, status.lead as lead_status, status.job as job_type, status.contract as contract_status');
        $this->db->from($this->table);
        $this->db->join('jobs_status as status', 'jobs.id=status.jobid', 'left');
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->result();     
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
    
    public function getClosedJob(){

        $this->db->select('jobs.*, status.lead as lead_status, status.job as job_type, status.contract as contract_status');
        $this->db->from($this->table);
        $this->db->join('jobs_status as status', 'jobs.id=status.jobid', 'left'); 
        $this->db->where([
            'status.closeout' => 'yes'
        ]);
        $query = $this->db->get();
        return $query->result(); 
            
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
