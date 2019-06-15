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

	public function __construct($database = null)
	{
		parent::__construct();
		$this->selected_db = $this->load->database([
			'dsn'	=> '',
			'hostname' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => ($database ?? $this->db->database),
			'dbdriver' => 'mysqli',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => (ENVIRONMENT !== 'production'),
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'utf8',
			'dbcollat' => 'utf8_general_ci',
			'swap_pre' => '',
			'encrypt' => FALSE,
			'compress' => FALSE,
			'stricton' => FALSE,
			'failover' => array(),
			'save_queries' => TRUE
		], TRUE);
	}

	public function signup($data)
	{
		$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
		$data['level'] = self::$level_super_admin;
		return $this->insert($data);
	}

	public function authenticate($email_id, $password)
	{
		$this->selected_db->where([
			'email_id' => $email_id,
			'is_deleted' => FALSE
		]);
		$user = $this->selected_db->get($this->table)->row();
		if ($user != NULL) {
			if (password_verify($password, $user->password)) {
				return $user;
			} else {
				return false;
			}
		}
	}

	public function setVerificationToken($user)
	{
		$token = $user->username . '_' . rand() . '_' . $user->email_id . '_' . rand() . '_' . $user->notifications . '_' . rand() . '_' . time();
		$this->update($user->id, [
			'verification_token' => md5($user->email_id) . time() . $user->id . hash('sha256', $token) . md5('user_verification') . rand()
		]);
	}

	public function setPasswordToken($user)
	{
		$token = $user->username . '_' . rand() . '_' . $user->email_id . '_' . rand() . '_' . $user->notifications . '_' . rand() . '_' . time();
		$this->selected_db->set('token_expiry', 'DATE_ADD(NOW(), INTERVAL 1 HOUR)', FALSE);
		$this->update($user->id, [
			'password_token' => md5($user->email_id) . time() . $user->id . hash('sha256', $token) . md5('password_reset') . rand()
		]);
	}

	public function resetPassword($user, $password)
	{
		$this->selected_db->where('is_deleted', FALSE);
		$password = password_hash($password, PASSWORD_BCRYPT);
		$this->update($user->id, [
			'password' => $password,
			'password_token' => '',
			'token_expiry' => ''
		]);
	}

	public function verifyUser($user)
	{
		$this->selected_db->where('is_deleted', FALSE);
		$this->update($user->id, [
			'verification_token' => '',
			'is_active' => TRUE
		]);
	}

	public function allUsers($start = 0, $limit = 10)
	{
		$this->selected_db->from($this->table);
		$this->selected_db->where('is_deleted', FALSE);
		$this->selected_db->order_by('id', 'ASC');
		$this->selected_db->limit($limit, $start);
		$query = $this->selected_db->get();
		return $query->result();
	}

	public function getCount()
	{
		$this->selected_db->where('is_deleted', FALSE);
		return $this->selected_db->count_all_results($this->table);
	}

	public function getUserById($id)
	{
		$this->selected_db->from($this->table);
		$this->selected_db->where([
			'id' => $id,
			'is_deleted' => FALSE
		]);
		$query = $this->selected_db->get();
		$result = $query->first_row();
		return $result ? $result : false;
	}

	public function getUserByEmailId($email_id)
	{
		$this->selected_db->from($this->table);
		$this->selected_db->where([
			'email_id' => $email_id,
			'is_deleted' => FALSE
		]);
		$query = $this->selected_db->get();
		$result = $query->first_row();
		return $result ? $result : false;
	}

	public function getUserByPasswordToken($token)
	{
		$this->selected_db->from($this->table);
		$this->selected_db->where([
			'password_token' => $token,
			'is_deleted' => FALSE
		]);
		$query = $this->selected_db->get();
		$result = $query->first_row();
		return $result ? $result : false;
	}

	public function getUserByVerificationToken($token)
	{
		$this->selected_db->from($this->table);
		$this->selected_db->where([
			'verification_token' => $token,
			'is_deleted' => FALSE
		]);
		$query = $this->selected_db->get();
		$result = $query->first_row();
		return $result ? $result : false;
	}

	public function insert($data)
	{
		$data['username'] = $this->genUserName($data['first_name'], $data['last_name']);
		$insert = $this->selected_db->insert($this->table, $data);
		return $insert ? $this->selected_db->insert_id() : $insert;
	}

	public function update($id, $data)
	{
		$this->selected_db->where('id', $id);
		$update = $this->selected_db->update($this->table, $data);
		return $update;
	}

	public function delete($id)
	{
		$this->selected_db->where('id', $id);
		return $this->selected_db->update($this->table, [
			'is_deleted' => TRUE
		]);
	}

	public function getUserList($select = "id, username, CONCAT(first_name, ' ', last_name) AS name")
	{
		$this->selected_db->select($select);
		$this->selected_db->from($this->table);
		$query = $this->selected_db->get();
		return $query->result();
	}

	public function getUserIdArrByUserNames($usernames)
	{
		$this->selected_db->select('id');
		$this->selected_db->where_in('username', $usernames);
		$this->selected_db->from($this->table);
		$query = $this->selected_db->get();
		return array_column($query->result_array(), 'id');
	}

	public function get_crm_data($table, $cols, $condition)
	{
		return $this->selected_db->select($cols)
			->get_where($table, $condition)
			->row_array();
	}

	/**
	 * Private Methods
	 */
	private function genUserName($first_name, $last_name)
	{
		$userName = strtolower($first_name . '_' . $last_name);
		$this->selected_db->like('username', $userName);
		$count = $this->selected_db->count_all_results($this->table);
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
