<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TaskNotesModel extends CI_Model
{
    private $table = 'task_notes';

    public function insert($data)
    {
        $data['created_by'] = $this->session->userdata('admininfo')->id;
        $insert = $this->db->insert($this->table, $data);
        return $insert ? $this->db->insert_id() : $insert;
    }
}
