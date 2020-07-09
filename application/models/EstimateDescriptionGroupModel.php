<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EstimateDescriptionGroupModel extends CI_Model
{
    private $table = 'estimate_description_groups';

    public function allEstimateDescGroupsByEstimateId($estimate_id)
    {
        $this->db->from($this->table);
        $this->db->where('estimate_id', $estimate_id);
        $this->db->where('is_deleted', FALSE);
        $this->db->order_by('created_at', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

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

    public function deleteByEstimateId($estimate_id)
    {
        $this->db->where('estimate_id', $estimate_id);
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }

    public function deleteByEstimateIdWithExceptionIds($estimate_id, $exception_ids)
    {
        $this->db->where('estimate_id', $estimate_id);
        $this->db->where_not_in('id', $exception_ids);
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }
}
