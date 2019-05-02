<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TaskJobTagsModel extends CI_Model
{
    private $table = 'task_job_tags';

    public function insertMany($taskId, $jobIds)
    {
        $data = [];
        foreach ($jobIds as $jobId) {
            $data[] = $this->buildInsert($taskId, $jobId);
        }
        return $this->db->insert_batch($this->table, $data);
    }

    private function buildInsert($taskId, $jobId)
    {
        return [
            'task_id' => $taskId,
            'job_id' => $jobId
        ];
    }
}
