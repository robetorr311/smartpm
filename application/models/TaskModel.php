<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TaskModel extends CI_Model
{
    private $table = 'tasks';

    private static $type = [
        1 => 'Type 1',
        2 => 'Type 2',
        3 => 'Type 3',
        4 => 'Type 4',
        5 => 'Type 5'
    ];
    private static $level = [
        1 => 'Low',
        2 => 'Normal',
        3 => 'High'
    ];

    public function allTasks($start = 0, $limit = 10)
    {
        $this->db->select('tasks.*, users_created_by.username as created_username, users_assigned_to.username as assigned_username');
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'tasks.created_by=users_created_by.id', 'left');
        $this->db->join('users as users_assigned_to', 'tasks.assigned_to=users_assigned_to.id', 'left');
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function getCount()
    {
        return $this->db->count_all('tasks');
    }

    public function getTaskList($select = 'id, name')
    {
        $this->db->select($select);
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result();
    }

    public function insert($data)
    {
        $data['status'] = '0';
        $data['created_by'] = $this->session->userdata('admininfo')['id'];
        $insert = $this->db->insert($this->table, $data);
        return $insert ? $this->db->insert_id() : $insert;
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, [
            'id' => $id
        ]);
    }

    /**
     * Static Methods
     */
    public static function typetostr($id)
    {
        return self::$type[$id];
    }

    public static function getTypes()
    {
        return self::$type;
    }
    
    public static function leveltostr($id)
    {
        return self::$level[$id];
    }

    public static function getLevels()
    {
        return self::$level;
    }
}
