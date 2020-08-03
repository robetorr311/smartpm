<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AssembliesModel extends CI_Model
{
    private $table = 'assemblies';

    public function allAssemblies()
    {
        $this->db->select("
            assemblies.*,
            COUNT(items.item) AS items_count
        ");
        $this->db->from($this->table);
        $this->db->join('assemblies_descriptions as items', 'assemblies.id=items.assemblies_id', 'left');
        $this->db->where('assemblies.is_deleted', FALSE);
        $this->db->where('items.is_deleted', FALSE);
        $this->db->group_by('assemblies.id');
        $this->db->order_by('assemblies.created_at', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAssembliesList($select = "id, name")
    {
		$this->db->select($select);
		$this->db->from($this->table);
        $this->db->where('is_deleted', FALSE);
		$query = $this->db->get();
		return $query->result();
    }
    
    public function getAssemblyById($id)
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
}
