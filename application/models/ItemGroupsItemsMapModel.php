<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ItemGroupsItemsMapModel extends CI_Model
{
    private $table = 'item_groups_items_map';

    /*** To insert a batch in to a table ***/

    public function insertByItemArr($items, $group_id)
    {
        if (is_array($items) && count($items) > 0) {
            $data = $this->buildByItemArr($items, $group_id);
            $insert = $this->db->insert_batch($this->table, $data);
            return $insert;
        } else {
            return false;
        }
    }

    /*** To remove by Item IDs ***/

    public function removeByItemArrId($items, $group_id)
    {
        $this->db->where_in('item_id', $items);
        return $this->deleteRelated($group_id);
    }

    public function deleteRelated($group_id)
    {
        $this->db->where('group_id', $group_id);
        return $this->db->delete($this->table);
    }

    /*** Get Items by group-id ***/

    public function getItemsByItemGroupId($group_id)
    {
        $query = $this->db->select('items.id, items.name')
            ->from($this->table)
            ->join('items', 'item_groups_items_map.item_id=items.id', 'left')
            ->where('items.is_deleted', FALSE)
            ->where('item_groups_items_map.group_id', $group_id)
            ->get();

        return $query->result();
    }

    /**
     * Private Methods
     */
    private function buildByItemArr($items, $group_id)
    {
        $return = [];
        foreach ($items as $item) {
            $return[] = [
                'group_id' => $group_id,
                'item_id' => $item
            ];
        }
        return $return;
    }
}
