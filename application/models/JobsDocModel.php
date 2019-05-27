<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JobsDocModel extends CI_Model
{
    private $table = 'jobs_doc';

    public function getCount($condition)
    {     
        $this->db->where($condition);
        return $this->db->count_all_results($this->table);
    }    
}
