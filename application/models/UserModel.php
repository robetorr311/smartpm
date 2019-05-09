<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{
    private $table = 'users';

    public function get_all_where(  $condition ){

        $this->db->where($condition);
        $this->db->order_by("id", "desc");
        $result = $this->db->get($this->table);
        return $result->result();   
    }

    public function add_user($table, $condition){
       
    }

    
    
}
