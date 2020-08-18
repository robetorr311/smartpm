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

    public function getMaterialsByLeadId($lead_id)
    {
        $this->db->select('
            jobs_material.*,
            material_item.name AS material_name,
            material_installer.name AS installer_name,
        ');
        $this->db->from($this->table);
        $this->db->join('items as material_item', 'jobs_material.material=material_item.id', 'left');
        $this->db->join('vendors as material_installer', 'jobs_material.installer=material_installer.id', 'left');
        $this->db->where([
            'jobs_material.job_id' => $lead_id,
            'jobs_material.is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->result();
        return (count($result) > 0) ? $result : false;
    }

    public function getPrimaryMaterialInfoByLeadId($lead_id)
    {
        $this->db->select('
            jobs_material.*,
            material_item.name AS material_name,
            material_installer.name AS installer_name,
        ');
        $this->db->from($this->table);
        $this->db->join('items as material_item', 'jobs_material.material=material_item.id', 'left');
        $this->db->join('vendors as material_installer', 'jobs_material.installer=material_installer.id', 'left');
        $this->db->where([
            'primary_material_info' => 1,
            'jobs_material.job_id' => $lead_id,
            'jobs_material.is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }

    public function getMaterialsById($id, $jobid)
    {
        $this->db->select('
            jobs_material.*,
            material_item.name AS material_name,
            material_installer.name AS installer_name,
        ');
        $this->db->from($this->table);
        $this->db->join('items as material_item', 'jobs_material.material=material_item.id', 'left');
        $this->db->join('vendors as material_installer', 'jobs_material.installer=material_installer.id', 'left');
        $this->db->where([
            'jobs_material.id' => $id,
            'jobs_material.job_id' => $jobid,
            'jobs_material.is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }
}
