<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TaskPredecessorModel extends CI_Model
{
    private $table = 'task_predecessor';

    public function insertByTaskArr($tasks, $task_id)
    {
        if (is_array($tasks) && count($tasks) > 0) {
            $data = $this->buildByTaskArr($tasks, $task_id);
            $insert = $this->db->insert_batch($this->table, $data);
            return $insert;
        } else {
            return false;
        }
    }

    public function deleteByTaskArr($tasks, $task_id)
    {
        $this->db->where_in('predecessor_task_id', $tasks);
        $this->db->where('task_id', $task_id);
        return $this->db->delete($this->table);
    }

    public function deleteRelated($task_id)
    {
        $this->db->where('task_id', $task_id);
        $this->db->or_where('predecessor_task_id', $task_id);
        return $this->db->delete($this->table);
    }

    public function getTasksByTaskId($id)
    {
        $this->db->select('tasks.*');
        $this->db->from($this->table);
        $this->db->join('tasks', 'task_predecessor.predecessor_task_id=tasks.id', 'left');
        $this->db->where('task_id', $id);
        $query = $this->db->get();
        $result = $query->result();
        return (count($result) > 0) ? $result : false;
    }

    /**
     * Private Methods
     */

    private function buildByTaskArr($tasks, $task_id)
    {
        $return = [];
        foreach ($tasks as $task) {
            $return[] = [
                'task_id' => $task_id,
                'predecessor_task_id' => $task
            ];
        }
        return $return;
    }
}
