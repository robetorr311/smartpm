<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TaskNotesModel extends CI_Model
{
    private $table = 'task_notes';

    public function insert($data)
    {
        $data['created_by'] = $this->session->id;
        $insert = $this->db->insert($this->table, $data);
        return $insert ? $this->db->insert_id() : $insert;
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $update = $this->db->update($this->table, $data);
        return $update;
    }

    public function delete($id, $task_id = false)
    {
        $this->db->where('id', $id);
        if ($task_id) {
            $this->db->where('task_id', $task_id);
        }
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }

    public function deleteRelated($task_id)
    {
        $this->db->where('task_id', $task_id);
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }

    public function getNotesByTaskId($id)
    {
        $this->db->select("task_notes.*, CONCAT(users_created_by.first_name, ' ', users_created_by.last_name, ' (@', users_created_by.username, ')') as created_user_fullname");
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'task_notes.created_by=users_created_by.id', 'left');
        $this->db->where([
            'task_notes.task_id' => $id,
            'task_notes.is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->result();
        return (count($result) > 0) ? $result : false;
    }
}
