<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TaskModel extends CI_Model
{
    private $table = 'tasks';

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

    public function allTasks()
    {
        $this->db->select("
            tasks.*,
            CONCAT(users_created_by.first_name, ' ', users_created_by.last_name, ' (@', users_created_by.username, ')') as created_user_fullname,
            CONCAT(users_assigned_to.first_name, ' ', users_assigned_to.last_name, ' (@', users_assigned_to.username, ')') as assigned_user_fullname,
            task_types.name as type_name
        ");
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'tasks.created_by=users_created_by.id', 'left');
        $this->db->join('users as users_assigned_to', 'tasks.assigned_to=users_assigned_to.id', 'left');
        $this->db->join('task_types', 'tasks.type=task_types.id', 'left');
        $this->db->where('tasks.is_deleted', FALSE);
        $this->db->order_by('created_at', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function allTasksByStatus($status)
    {
        $this->db->select("
            tasks.*,
            CONCAT(users_created_by.first_name, ' ', users_created_by.last_name, ' (@', users_created_by.username, ')') as created_user_fullname,
            CONCAT(users_assigned_to.first_name, ' ', users_assigned_to.last_name, ' (@', users_assigned_to.username, ')') as assigned_user_fullname,
            task_types.name as type_name
        ");
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'tasks.created_by=users_created_by.id', 'left');
        $this->db->join('users as users_assigned_to', 'tasks.assigned_to=users_assigned_to.id', 'left');
        $this->db->join('task_types', 'tasks.type=task_types.id', 'left');
        $this->db->where('tasks.status', $status);
        $this->db->where('tasks.is_deleted', FALSE);
        $this->db->order_by('created_at', 'ASC');
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
        $this->db->select("
            tasks.*,
            CONCAT(users_created_by.first_name, ' ', users_created_by.last_name, ' (@', users_created_by.username, ')') as created_user_fullname,
            CONCAT(users_assigned_to.first_name, ' ', users_assigned_to.last_name, ' (@', users_assigned_to.username, ')') as assigned_user_fullname,
            task_types.name as type_name
        ");
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'tasks.created_by=users_created_by.id', 'left');
        $this->db->join('users as users_assigned_to', 'tasks.assigned_to=users_assigned_to.id', 'left');
        $this->db->join('task_types', 'tasks.type=task_types.id', 'left');
        $this->db->where([
            'tasks.id' => $id,
            'tasks.is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
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
        $this->db->where('id !=', $id);
        return $this->getTaskList($select);
    }

    public function insert($data)
    {
        $data['status'] = '0';
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

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }

    public function predecessorCheck($task_id)
    {
        $this->db->where('id IN (SELECT predecessor_task_id FROM task_predecessor WHERE task_id=' . $task_id . ' AND is_deleted=FALSE)');
        $this->db->where('status !=', 4);
        $count = $this->db->count_all_results($this->table);
        return ($count === 0);
    }


    public function getTasksByAssignedTo($id)
    {
        $this->db->where('assigned_to', $id);
        $query = $this->db->get($this->table);
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

    public function getDashboardStatusCount()
    {
        $this->db->select("
            COUNT(IF(status=0, 1, NULL)) as created,
            COUNT(IF(status=1, 1, NULL)) as working,
            COUNT(IF(status=2, 1, NULL)) as stuck,
            COUNT(IF(status=3, 1, NULL)) as hold,
            COUNT(IF(status=4, 1, NULL)) as completed
        ", FALSE);
        $this->db->from($this->table);
        $this->db->where('is_deleted', FALSE);
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }

    public function search($keywords)
    {
        if (count($keywords) <= 0) {
            return [];
        }
        $this->db->select("
            tasks.id,
            tasks.name,
            CONCAT(users_assigned_to.first_name, ' ', users_assigned_to.last_name, ' (@', users_assigned_to.username, ')') as assigned_user_fullname
        ");
        $this->db->from($this->table);
        $this->db->join('users as users_assigned_to', 'tasks.assigned_to=users_assigned_to.id', 'left');
        $this->db->where([
            'tasks.is_deleted' => FALSE
        ]);
        $this->db->group_start();
        foreach ($keywords as $k) {
            $this->db->or_like('name', $k);
            $this->db->or_where("assigned_to IN (SELECT id FROM users WHERE first_name LIKE '%" . $k . "%' OR last_name LIKE '%" . $k . "%' OR username LIKE '%" . $k . "%')");
        }
        $this->db->group_end();
        $this->db->order_by('tasks.created_at', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Static Methods
     */
    public static function levelToStr($id)
    {
        return isset(self::$level[$id]) ? self::$level[$id] : $id;
    }

    public static function getLevels()
    {
        return self::$level;
    }

    public static function statusToStr($id)
    {
        return isset(self::$status[$id]) ? self::$status[$id] : $id;
    }

    public static function getStatus()
    {
        return self::$status;
    }
}
