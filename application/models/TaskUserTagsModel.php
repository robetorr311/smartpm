<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TaskUserTagsModel extends CI_Model
{
    private $table = 'task_user_tags';

    public function insertByUserArr($users, $task_id)
    {
        if (is_array($users) && count($users) > 0) {
            $data = $this->buildByUserArr($users, $task_id);
            $insert = $this->db->insert_batch($this->table, $data);
            return $insert;
        } else {
            return false;
        }
    }

    private function buildByUserArr($users, $task_id)
    {
        $return = [];
        foreach ($users as $user) {
            $return[] = [
                'task_id' => $task_id,
                'user_id' => $user
            ];
        }
        return $return;
    }
}
