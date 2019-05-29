<?php
defined('BASEPATH') or exit('No direct script access allowed');
class UserModel extends CI_Model
{
	private $table = 'users';
	public static $level_super_admin = 1;
	public static $level_admin = 2;
	public static $level_manager = 3;
	public static $level_team_leader = 4;
	public static $level_user = 5;
	public static $level_non_user = 6;
	public function signup($data)
	{
		$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT, [
			'cost' => 12,
			'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
		]);
		$data['level'] = self::$level_super_admin;
		return $this->insert($data);
		//$this->db->insert( 'admin_setting', ['user_id'=>$insert_id]);
	}
	public function insert($data)
	{
		$data['username'] = $this->genUserName($data['first_name'], $data['last_name']);
		$insert = $this->db->insert($this->table, $data);
		return $insert ? $this->db->insert_id() : $insert;
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
	public function get_all_where(  $condition ){

        $this->db->where($condition);
        $this->db->order_by("id", "desc");
        $result = $this->db->get($this->table);
        return $result->result();   
    }
	/**
	 * Private Methods
	 */
	private function genUserName($first_name, $last_name)
	{
		$userName = strtolower($first_name . '_' . $last_name);
		$this->db->like('username', $userName);
		$count = $this->db->count_all_results($this->table);
		return $userName . ($count > 0 ? ('_' . ($count + 1)) : '');
	}
}