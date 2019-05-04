<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AccountModel extends CI_Model {
	private $table = 'users';

	public function signup($account)
	{
		$this->db->insert( $this->table, $account);
		$insert_id = $this->db->insert_id();
		//$this->db->insert( 'admin_setting', ['user_id'=>$insert_id]);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false; 
		}
	}

	public function login($username, $password)
	{
		$this->db->where('username', $username);
		$account = $this->db->get($this->table)->row();
		if($account !=NULL){
			if(password_verify($_POST['password'], $account->password)){

				$this->session->set_userdata('isLoggedIn','true');
				$this->session->set_userdata('admininfo',$account);
				return TRUE;
			}else{
				return NULL;
			}
		}
		
	}


	function get_crm_data( $table, $cols,$condition ){
        return $this->db->select($cols)
                        ->get_where($table,$condition)
                        ->row_array();    
    }

    function mail_exists($key)
	{
	    $this->db->where('username',$key);
	    $query = $this->db->get($this->table);
	    if ($query->num_rows() > 0){
	        return TRUE;
	    }
	    else{
	        return FALSE;
	    }
	}
}


