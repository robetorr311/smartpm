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

    public function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert ? $this->db->insert_id() : $insert;
    }

    public function updateByLeadId($id, $data)
    {
        $this->db->where('job_id', $id);
        $update = $this->db->update($this->table, $data);
        return $update;
    }
}
