<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GroupItemsMappingModel extends CI_Model
{
    private $table = 'group_items_mapping';

    /*** To insert a batch in to a table*/

    public function insert_batch($data)
    {
        $this->db->insert_batch($this->table, $data);
    }

    /*** To remove Group items bby group id ***/

    public function removeGroupItemsByGroupId($group_id)
    {
        return $query = $this->db->where('group_id', $group_id)->delete($this->table);
    }

    /*** Get Items by group-id ***/

    public function getItemsByGroupId($group_id)
    {
        $query = $this->db->select('items.id, items.name')
                 ->from($this->table)
                 ->join('items','items.id = group_items_mapping.item_id')
                 ->where('items.is_deleted', FALSE)
                 ->where('group_items_mapping.group_id',$group_id)
                 ->get();
        
        return ($query->num_rows() > 0) ? $query->result() : [];
    }
}
