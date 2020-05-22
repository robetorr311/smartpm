<?php
defined('BASEPATH') or exit('No direct script access allowed');

class VendorContactModel extends CI_Model
{
	private $table = 'vendors_contacts';

	public function allVendorContactsByVendorId($vendor_id)
	{
		$this->db->from($this->table);
        $this->db->where('vendor_id', $vendor_id);
        $this->db->where('is_deleted', FALSE);
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	// public function getVendorById($id)
	// {
	// 	$this->db->from($this->table);
    //     $this->db->where([
	// 		'id' => $id,
	// 		'is_deleted' => FALSE
	// 	]);
	// 	$query = $this->db->get();
	// 	$result = $query->first_row();
	// 	return $result ? $result : false;
	// }

	public function insert($data)
	{
		$insert = $this->db->insert($this->table, $data);
		return $insert ? $this->db->insert_id() : $insert;
	}

	public function update($vendor_id, $id, $data)
	{
		$this->db->where('vendor_id', $vendor_id);
		$this->db->where('id', $id);
		$update = $this->db->update($this->table, $data);
		return $update;
	}

	public function delete($vendor_id, $id)
	{
		return $this->update($vendor_id, $id, [
			'is_deleted' => TRUE
		]);
	}
}
