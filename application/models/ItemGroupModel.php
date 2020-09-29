<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ItemGroupModel extends CI_Model
{
    private $table = 'item_groups';

    /*** To list all active groups ***/

    public function allItemGroups()
    {
        $this->db->from($this->table);
        $this->db->where('is_deleted', FALSE);
        $query = $this->db->get();
        return $query->result();
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
        $update = $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
        return $update;
    }
}
