<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JobsPhotoModel extends CI_Model
{
    private $table = 'jobs_photo';

    public function allPhoto($condition){
		$this->db->where($condition);
		$result = $this->db->get($this->table);
		return $result->result();
	}

    public function getCount($condition)
    {     
        $this->db->where($condition);
        return $this->db->count_all_results($this->table);
    }    
}
