<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ItemModel extends CI_Model
{
    private $table = 'items';

    public function allItems()
    {
        $this->db->from($this->table);
        $this->db->where('is_deleted', FALSE);
        $this->db->order_by('created_at', 'ASC');
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
        $this->db->from($this->table);
        $this->db->where([
            'id' => $id,
            'is_deleted' => FALSE
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

    /*** Get Items by group-id ***/

    public function getItemsByGroupId($group_id)
    {
        $query = $this->db->select('items.id, items.name')
                 ->from('group_items_mapping')
                 ->join('items','items.id = group_items_mapping.item_id')
                 ->where('items.is_deleted', FALSE)
                 ->where('group_items_mapping.group_id',$group_id)
                 ->get();
        
        return ($query->num_rows() > 0) ? $query->result() : [];
    }
}
