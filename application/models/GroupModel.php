<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GroupModel extends CI_Model
{
    private $table = 'groups';

    /*** To list all active groups ***/

    public function allGroups()
    {
        $this->db->select('groups.id,groups.name, COUNT(GI.id) as items_count');
        $this->db->from($this->table);
        $this->db->join('group_items_mapping GI','GI.group_id = groups.id','left');
        $this->db->where('is_deleted', FALSE);
        $this->db->group_by('groups.id');
        $this->db->order_by('created_at', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getGroupList($select = "id, name")
    {
		$this->db->select($select);
		$this->db->from($this->table);
        $this->db->where('is_deleted', FALSE);
		$query = $this->db->get();
		return $query->result();
    }
    
    /*** Get group details by group-id ***/

    public function getGroupById($id)
    {
        $query = $this->db->select("groups.id,groups.name")
                 ->from($this->table)
                 ->where([
                    'id' => $id,
                    'is_deleted' => FALSE
                  ])->get();
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
    
    /*** Validation of Group-name while update ***/

    public function check_group_name($name,$id)
    {
        $this->db->where('name', $name);
        if($id) {
            $this->db->where_not_in('id', $id);
        }
        return $this->db->get($this->table)->num_rows();
    }

    /*** To remove Group items bby group id ***/

    public function removeGroupItemsByGroupId($group_id)
    {
        return $query = $this->db->where('group_id', $group_id)->delete('group_items_mapping');
    }
}
