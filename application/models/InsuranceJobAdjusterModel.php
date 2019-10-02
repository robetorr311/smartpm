<?php
defined('BASEPATH') or exit('No direct script access allowed');

class InsuranceJobAdjusterModel extends CI_Model
{
    private $table = 'insurance_job_adjuster';

    public function allAdjusters($jobid)
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'job_id' => $jobid
        ]);
        $this->db->order_by('created_at', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function insertAdjuster($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert ? $this->db->insert_id() : $insert;
    }

    public function deleteAdjuster($id, $jobid)
    {
        $this->db->where([
            'id' => $id,
            'job_id' => $jobid
        ]);
        $update = $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
        return $update;
    }
}
