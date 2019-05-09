<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TaskJobTagsModel extends CI_Model
{
    private $table = 'task_job_tags';

    public function insertByJobArr($jobs, $task_id)
    {
        print_r($jobs); die();
        if (is_array($jobs) && count($jobs) > 0) {
            $data = $this->buildByUserArr($jobs, $task_id);
            $insert = $this->db->insert_batch($this->table, $data);
            return $insert;
        } else {
            return false;
        }
    }

    public function deleteRelated($task_id)
    {
        $this->db->where('task_id', $task_id);
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }

    /**
     * Private Methods
     */

    private function buildByUserArr($jobs, $task_id)
    {
        $return = [];
        foreach ($jobs as $job) {
            $return[] = [
                'task_id' => $task_id,
                'job_id' => $job
            ];
        }
        return $return;
    }
}
