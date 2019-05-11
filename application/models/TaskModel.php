<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TaskModel extends CI_Model
{
    private $table = 'tasks';

    private static $type = [
        0 => 'Call',
        1 => 'Meeting',
        2 => 'Bid/Estimate',
        3 => 'Site Visit',
        4 => 'Follow Up',
        5 => 'Send Document'
    ];
    private static $level = [
        0 => 'Low',
        1 => 'Normal',
        2 => 'High'
    ];
    private static $status = [
        0 => 'Created',
        1 => 'Working',
        2 => 'Stuck',
        3 => 'Hold',
        4 => 'Completed'
    ];

    public function allTasks($start = 0, $limit = 10)
    {
        $this->db->select('tasks.*, users_created_by.username as created_username, users_assigned_to.username as assigned_username');
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'tasks.created_by=users_created_by.id', 'left');
        $this->db->join('users as users_assigned_to', 'tasks.assigned_to=users_assigned_to.id', 'left');
        $this->db->where('is_deleted', FALSE);
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function getCount()
    {
        $this->db->where('is_deleted', FALSE);
        return $this->db->count_all_results('tasks');
    }

    public function getTaskById($id)
    {
        $this->db->select('tasks.*, users_created_by.username as created_username, users_assigned_to.username as assigned_username');
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'tasks.created_by=users_created_by.id', 'left');
        $this->db->join('users as users_assigned_to', 'tasks.assigned_to=users_assigned_to.id', 'left');
        $this->db->where([
            'tasks.id' => $id,
            'is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->result();
        return (count($result) > 0) ? $result[0] : false;
    }

    public function getTaskList($select = 'id, name')
    {
        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->where('is_deleted', FALSE);
        $query = $this->db->get();
        return $query->result();
    }

    public function getTaskListExcept($id, $select = 'id, name')
    {
        $this->db->where([
            'id !=' => $id,
            'is_deleted' => FALSE
        ]);
        return $this->getTaskList($select);
    }

    public function insert($data)
    {
        $data['status'] = '0';
        $data['created_by'] = $this->session->userdata('admininfo')->id;
        $insert = $this->db->insert($this->table, $data);
        return $insert ? $this->db->insert_id() : $insert;
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $update = $this->db->update($this->table, $data);
        return $update;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }

    public function isAllowedToDelete($task_id)
    {
        $this->db->where('id IN (SELECT predecessor_task_id FROM task_predecessor WHERE task_id=' . $task_id . ' AND is_deleted=FALSE)');
        $this->db->where('status !=', 4);
        $count = $this->db->count_all_results($this->table);
        return ($count === 0);
    }


     public function getTaskByUserId($id)
    {
        $this->db->where('assigned_to', $id);
        $query = $this->db->get('tasks');
        return $result = $query->result();
        
}
    public function complete($id)
    {
        $this->db->where([
            'id' => $id,
            'is_deleted' => FALSE
        ]);
        return $this->db->update($this->table, [
            'status' => 4
        ]);
    }

    /**
     * Static Methods
     */
    public static function typetostr($id)
    {
        return isset(self::$type[$id]) ? self::$type[$id] : $id;
    }

    public static function getTypes()
    {
        return self::$type;
    }

    public static function leveltostr($id)
    {
        return isset(self::$level[$id]) ? self::$level[$id] : $id;
    }

    public static function getLevels()
    {
        return self::$level;
    }

    public static function statustostr($id)
    {
        return isset(self::$status[$id]) ? self::$status[$id] : $id;
    }

    public static function getStatus()
    {
        return self::$status;
    }
}
