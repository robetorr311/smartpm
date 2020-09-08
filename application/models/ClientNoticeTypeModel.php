<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ClientNoticeTypeModel extends CI_Model
{
    private $table = 'client_notice_type';

    public function allNoticeTypes()
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

    /***  Get Notice type by id ***/
    public function getNoticeTypeById($id = '')
    {

        $query = $this->db->select('id, name')
                            ->from($this->table)
                            ->where('is_deleted',0)
                            ->where('id',$id)
                            ->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }
}
