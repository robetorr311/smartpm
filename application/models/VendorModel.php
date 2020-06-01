<?php
defined('BASEPATH') or exit('No direct script access allowed');

class VendorModel extends CI_Model
{
	private $table = 'vendors';

	public function allVendors()
	{
		$this->db->from($this->table);
        $this->db->where('is_deleted', FALSE);
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

    public function getVendorList($select = "id, name")
    {
		$this->db->select($select);
		$this->db->from($this->table);
        $this->db->where('is_deleted', FALSE);
		$query = $this->db->get();
		return $query->result();
    }

	public function getVendorById($id)
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
