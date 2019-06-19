<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LeadModel extends CI_Model
{
    private $table = 'jobs';

      /* get All jobs */
    public function getAllJob($start = 0, $limit = 10){

        $this->db->select('jobs.*, status.lead as lead_status, status.job as job_type, status.contract as contract_status');
        $this->db->from($this->table);
        $this->db->join('jobs_status as status', 'jobs.id=status.jobid', 'left'); 
        $this->db->where([
            'lead' => 'open', 'job'=>''
        ]);
        $this->db->order_by('id', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result(); 
            
    }

    public function getAllSignedJob($start = 0, $limit = 10){

        $this->db->select('jobs.*, jobs_status.*');
        $this->db->from($this->table);
        $this->db->join('jobs_status', 'jobs.id=jobs_status.jobid', 'left'); 
        $this->db->where([
            'jobs_status.lead' => 'open', 'jobs_status.contract'=>'signed'
        ]);
        $this->db->order_by('jobs.id', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result(); 
            
    }

    public function getSignedJobCount()
    {     
        $this->db->where(['contract' => 'signed']);
        return $this->db->count_all_results('jobs_status');
    }
    
   	public function get_all_where( $tablename, $condition ){

        $this->db->where($condition);
		$this->db->order_by("id", "desc");
		$result = $this->db->get($tablename);
		return $result->result();	
	}
  
    /* get job based on job type */
    public function getJobType($start = 0, $limit = 10, $condition ){

        $this->db->select('jobs.*, status.lead as lead_status, status.job as job_type, status.contract as contract_status');
        $this->db->from($this->table);
        $this->db->join('jobs_status as status', 'jobs.id=status.jobid', 'left');
        $this->db->where($condition);
         $this->db->order_by('id', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();     
    }
    
    public function getCount()
    {     
        $this->db->where(['contract' => 'unsigned','lead' => 'open']);
        return $this->db->count_all_results('jobs_status');
    }

     public function getCountBasedJobType($type)
    {     
        $this->db->where(['job' => $type, 'lead' => 'open']);
        return $this->db->count_all_results('jobs_status');
    }
     public function getCountBasedJobStatus($status)
    {     
        $this->db->where(['production' => $status]);
        return $this->db->count_all_results('jobs_status');
    }


    public function add_record( $array ){
    
        $this->db->insert($this->table, $array);
        
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false; 
        }
    }
    
    public function getClosedJob($start = 0, $limit = 10){

        $this->db->select('jobs.*, status.lead as lead_status, status.job as job_type, status.contract as contract_status, status.close_at as date');
        $this->db->from($this->table);
        $this->db->join('jobs_status as status', 'jobs.id=status.jobid', 'left'); 
        $this->db->where([
            'status.closeout' => 'yes'
        ]);
        $this->db->order_by('id', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result(); 
            
    }

    public function archiveJob($start = 0, $limit = 10){

        $this->db->select('jobs.*, status.lead as lead_status, status.job as job_type, status.contract as contract_status, status.close_at as date');
        $this->db->from($this->table);
        $this->db->join('jobs_status as status', 'jobs.id=status.jobid', 'left'); 
        $this->db->where([
            'status.closeout' => 'yes'
        ]);
        $this->db->order_by('id', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result(); 
            
    }

    public function getCountClosedJob()
    {     
        $this->db->where(['closeout' => 'yes']);
        return $this->db->count_all_results('jobs_status');
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
