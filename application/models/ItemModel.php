<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ItemModel extends CI_Model
{
    private $table = 'items';

    public function allItems()
    {
        $this->db->select('items.*, item_groups.name AS item_group_name');
        $this->db->from($this->table);
        $this->db->join('item_groups as item_groups', 'items.item_group_id=item_groups.id', 'left');
        $this->db->where('items.is_deleted', FALSE);
        $this->db->order_by('items.created_at', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getItemList($select = "id, name")
    {
		$this->db->select($select);
		$this->db->from($this->table);
        $this->db->where('is_deleted', FALSE);
		$query = $this->db->get();
		return $query->result();
    }
    
    public function getItemById($id)
    {
        $this->db->select('items.*, item_groups.name AS item_group_name');
        $this->db->from($this->table);
        $this->db->join('item_groups as item_groups', 'items.item_group_id=item_groups.id', 'left');
        $this->db->where([
            'items.id' => $id,
            'items.is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
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
    
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }
}