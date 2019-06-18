<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_DatabaseModel extends CI_Model
{
	private $table = 'database';

	public function __construct()
	{
		parent::__construct();
		$this->selected_db = $this->load->database([
			'dsn'	=> '',
			'hostname' => 'localhost',
			'username' => 'root',  
			'password' => '',
			'database' => 'smartpm_master',
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
		], true);
	}

	public function insert($data)
	{
		$insert = $this->selected_db->insert($this->table, $data);
		return $insert ? $this->selected_db->insert_id() : $insert;
	}
}
