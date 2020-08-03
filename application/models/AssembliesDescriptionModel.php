<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AssembliesDescriptionModel extends CI_Model
{
    private $table = 'assemblies_descriptions';

    public function allAssembliesDescsByAssemblyId($id)
    {
        $this->db->select("
            assemblies_descriptions.*,
            items.name AS item_name
        ");
        $this->db->from($this->table);
        $this->db->join('items as items', 'assemblies_descriptions.item=items.id', 'left');
        $this->db->where('assemblies_id', $id);
        $this->db->where('assemblies_descriptions.is_deleted', FALSE);
        $this->db->order_by('assemblies_descriptions.created_at', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert ? $this->db->insert_id() : $insert;
    }

    // public function insertByItemArr($items, $assembly_id)
    // {
    //     if (is_array($items) && count($items) > 0) {
    //         $data = $this->buildByItemArr($items, $assembly_id);
    //         $insert = $this->db->insert_batch($this->table, $data);
    //         return $insert;
    //     } else {
    //         return false;
    //     }
    // }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $update = $this->db->update($this->table, $data);
        return $update;
    }

    public function deleteByAssemblyIdWithExceptionIds($assembly_id, $exception_ids)
    {
        $this->db->where('assemblies_id', $assembly_id);
        $this->db->where_not_in('id', $exception_ids);
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }

    public function deleteByAssemblyId($assembly_id)
    {
        $this->db->where('assemblies_id', $assembly_id);
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }

    /**
     * Private Methods
     */

    // private function buildByItemArr($items, $assembly_id)
    // {
    //     $return = [];
    //     foreach ($items as $item) {
    //         $return[] = [
    //             'item' => $item,
    //             'assembly_id' => $assembly_id
    //         ];
    //     }
    //     return $return;
    // }
}
