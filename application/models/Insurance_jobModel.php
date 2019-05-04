<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Insurance_jobModel extends CI_Model
{
    private $table = 'jobs';

   	public function get_all_where( $tablename, $condition ){

        $this->db->where($condition);
		$this->db->order_by("id", "desc");
		$result = $this->db->get($tablename);
		return $result->result();	
	}
    
   
}
