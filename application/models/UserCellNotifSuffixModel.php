<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserCellNotifSuffixModel extends CI_Model
{
    private $table = 'user_cell_notif_suffixs';

    public function allCellNotifSuffix()
    {
        $this->db->from($this->table);
        $this->db->where('is_deleted', FALSE);
        $query = $this->db->get();
        return $query->result();
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
        $update = $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
        return $update;
    }
}
