<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ClientNoticeModel extends CI_Model
{
    private $table = 'client_notice';

    public function allNotices($clientId)
    {
        $this->db->select("
            client_notice.*,
            notice_type.name AS type_name
        ");
        $this->db->from($this->table);
        $this->db->join('client_notice_type as notice_type', 'client_notice.type=notice_type.id', 'left');
        $this->db->where([
            'client_notice.client_id' => $clientId,
            'client_notice.is_deleted' => FALSE
        ]);
        $this->db->order_by('client_notice.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert ? $this->db->insert_id() : $insert;
    }
}
