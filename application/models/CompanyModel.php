<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CompanyModel extends CI_Model
{
	private $table = 'companies';

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

	public function insert($data)
	{
		$insert = $this->selected_db->insert($this->table, $data);
		return $insert ? $this->selected_db->insert_id() : $insert;
	}
}
