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

    public function deleteRelated($task_id)
    {
        $this->db->where('task_id', $task_id);
        $this->db->or_where('predecessor_task_id', $task_id);
        return $this->db->delete($this->table);
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
