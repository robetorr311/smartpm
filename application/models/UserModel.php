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
	private static $levels = [
		1 => 'Super Admin',
		2 => 'Admin',
		3 => 'Manager',
		4 => 'Team Leader',
		5 => 'User',
		6 => 'Non User'
	];
	private static $notifications = [
		1 => 'Off',
		2 => 'Text Only',
		3 => 'Email Only',
		4 => 'Both'
	];
	public function signup($data)
	{
		$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT, [
			'cost' => 12,
			'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
		]);
		$data['level'] = self::$level_super_admin;
		return $this->insert($data);
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
	public function allUsers($start = 0, $limit = 10)
	{
		$this->db->from($this->table);
		$this->db->where('is_deleted', FALSE);
		$this->db->order_by('id', 'ASC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
	}
	public function getCount()
	{
		$this->db->where('is_deleted', FALSE);
		return $this->db->count_all_results($this->table);
	}
	public function getUserById($id)
	{
		$this->db->from($this->table);
		$this->db->where([
			'id' => $id,
			'is_deleted' => FALSE
		]);
		$query = $this->db->get();
		$result = $query->first_row();
		return $result ? $result : false;
	}
	public function insert($data)
	{
		$data['username'] = $this->genUserName($data['first_name'], $data['last_name']);
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
	public function getUserList($select = "id, username, CONCAT(first_name, ' ', last_name) AS name")
	{
		$this->db->select($select);
		$this->db->from($this->table);
		$query = $this->db->get();
		return $query->result();
	}
	public function get_crm_data($table, $cols, $condition)
	{
		return $this->db->select($cols)
			->get_where($table, $condition)
			->row_array();
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
	/**
	 * Static Methods
	 */
	public static function leveltostr($level)
	{
		return (self::$levels[$level]) ? self::$levels[$level] : $level;
	}
	public static function getLevels()
	{
		return self::$levels;
	}
	public static function activetostr($active)
	{
		return $active ? 'Active' : 'Inactive';
	}
	public static function notificationstostr($id)
	{
		return (self::$notifications[$id]) ? self::$notifications[$id] : $id;
	}
	public static function getNotifications()
	{
		return self::$notifications;
	}
}