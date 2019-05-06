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

    public function deleteRelated($task_id)
    {
        $this->db->where('task_id', $task_id);
        return $this->db->delete($this->table);
    }

    public function getNotesByTaskId($id)
    {
        $this->db->select('task_notes.*, users_created_by.username as created_username');
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'task_notes.created_by=users_created_by.id', 'left');
        $this->db->where('task_id', $id);
        $query = $this->db->get();
        $result = $query->result();
        return (count($result) > 0) ? $result : false;
    }
}
