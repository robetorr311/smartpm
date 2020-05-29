<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_TwilioCredModel extends CI_Model
{
	private $table = 'twilio_cred';

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

	public function getTwilioSettings($company_code)
	{
		$this->selected_db->from($this->table);
		$this->selected_db->where('company_id', "(SELECT id FROM companies WHERE company_code=" . $company_code . ")", false);
		$query = $this->selected_db->get();
		$result = $query->first_row();
		return $result ? $result : false;
	}

	public function insert($data)
	{
		$insert = $this->selected_db->insert($this->table, $data);
		return $insert ? $this->selected_db->insert_id() : $insert;
	}

	public function update($company_code, $data)
	{
		$this->selected_db->where('company_id', "(SELECT id FROM companies WHERE company_code=" . $company_code . ")", false);
		$update = $this->selected_db->update($this->table, $data);
		return $update;
	}
}
