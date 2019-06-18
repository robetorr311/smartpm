<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_CompanyModel extends CI_Model
{
	private $table = 'companies';

	public function __construct()
	{
		parent::__construct();
		$this->selected_db = $this->load->database([
			'dsn'	=> '',
            'hostname' => $this->db->hostname,
            'username' => $this->db->username,  
            'password' => $this->db->password,
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
	
	public function updateCompanyCode($id)
	{
		$this->selected_db->set('company_code', 'id+154236', false);
		$this->selected_db->where('id', $id);
		$this->selected_db->update($this->table);
	}
}
