<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{
	private $table = 'users';

	public static $role_super_admin = 1;
	public static $role_admin = 2;
	public static $role_manager = 3;
	public static $role_team_leader = 4;
	public static $role_user = 5;
	public static $role_non_user = 6;

	public function signup($account)
	{
		$this->db->insert($this->table, $account);
		$insert_id = $this->db->insert_id();
		//$this->db->insert( 'admin_setting', ['user_id'=>$insert_id]);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	public function authenticate($email_id, $password)
	{
		$this->db->where([
			'email_id' => $email_id,
			'is_deleted' => FALSE
		]);
		$user = $this->db->get($this->table)->row();
		if ($user != NULL) {
			if (password_verify($password, $user->password)) {
				return $user;
			} else {
				return false;
			}
		}
	}

    public function getUserList($select = "id, username, CONCAT(first_name, ' ', last_name) AS name")
    {
        $this->db->select($select);
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result();
    }


	function get_crm_data($table, $cols, $condition)
	{
		return $this->db->select($cols)
			->get_where($table, $condition)
			->row_array();
	}
}
