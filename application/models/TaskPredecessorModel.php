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
