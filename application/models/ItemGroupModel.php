<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ItemGroupModel extends CI_Model
{
    private $table = 'item_groups';

    /*** To list all active groups ***/

    public function allItemGroups()
    {
        $this->db->select('item_groups.*, COUNT(igi_map.id) as items_count');
        $this->db->from($this->table);
        $this->db->join('item_groups_items_map igi_map', 'igi_map.group_id = item_groups.id', 'left');
        $this->db->where('is_deleted', FALSE);
        $this->db->group_by('item_groups.id');
        $this->db->order_by('created_at', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getItemGroupList($select = "id, name")
    {
        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->where('is_deleted', FALSE);
        $query = $this->db->get();
        return $query->result();
    }

    /*** Get group details by group-id ***/

    public function getItemGroupById($id)
    {
        $this->db->from($this->table);
        $this->db->where([
            'id' => $id,
            'is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }

    /*** Insert data to groups table ***/

    public function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert ? $this->db->insert_id() : $insert;
    }

    /*** Update data to groups table by id***/

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $update = $this->db->update($this->table, $data);
        return $update;
    }

    /*** To Remove Group (soft-delete) ***/

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }
}
