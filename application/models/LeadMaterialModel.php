<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LeadMaterialModel extends CI_Model
{
    private $table = 'jobs_material';

    public function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert ? $this->db->insert_id() : $insert;
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $update = $this->db->update($this->table, $data);
        return $update;
    }

    public function delete($id, $lead_id = false)
    {
        $this->db->where('id', $id);
        if ($lead_id) {
            $this->db->where('job_id', $lead_id);
        }
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }

    public function getMaterialsByLeadId($id)
    {
        $this->db->from($this->table);
        $this->db->where([
            'job_id' => $id,
            'is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->result();
        return (count($result) > 0) ? $result : false;
    }

    public function getMaterialsById($id, $jobid)
    {
        $this->db->from($this->table);
        $this->db->where([
            'id' => $id,
            'job_id' => $jobid,
            'is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->result();
        return (count($result) > 0) ? $result : false;
    }
}
