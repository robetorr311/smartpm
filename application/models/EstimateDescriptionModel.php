<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EstimateDescriptionModel extends CI_Model
{
    private $table = 'estimate_descriptions';

    public function allEstimateDescsByIds($ids)
    {
        $this->db->select("
            estimate_descriptions.*,
            items.name AS item_name,
            items.unit_price AS item_unit_price,
            items.quantity_units AS item_quantity_units
        ");
        $this->db->from($this->table);
        $this->db->join('items as items', 'estimate_descriptions.item=items.id', 'left');
        $this->db->where_in('description_group_id', $ids);
        $this->db->where('estimate_descriptions.is_deleted', FALSE);
        $this->db->order_by('estimate_descriptions.created_at', 'ASC');
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
        $this->db->where('description_group_id IN (SELECT id FROM estimate_description_groups WHERE estimate_id=' . $estimate_id . ')');
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }

    public function deleteByEstimateIdWithExceptionEstimateGroupIds($estimate_id, $exception_ids)
    {
        $this->db->where('description_group_id IN (SELECT id FROM estimate_description_groups WHERE estimate_id=' . $estimate_id . ')');
        $this->db->where_not_in('description_group_id', $exception_ids);
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }

    public function deleteByEstimateGroupIdWithExceptionIds($estimate_group_id, $exception_ids)
    {
        $this->db->where('description_group_id', $estimate_group_id);
        $this->db->where_not_in('id', $exception_ids);
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }
}
