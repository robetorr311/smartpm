<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {

	
	public function __construct() {
        parent::__construct();
		$this->load->database();
    }
	
	/******************************
	*	Save Record			
	*	params : string, array
	*******************************/
	
	public function add_record( $table, $array ){
	
		$this->db->insert($table, $array);
		
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false; 
		}
	}
	
	/******************************
	*	Get Record			
	*	params : string, array
	*******************************/
	
	public function get_all_where( $table, $condition ){
		
		$this->db->where($condition);
		//$this->db->order_by("id", "desc");
		$result = $this->db->get($table);
		
		return $result->result();
		
	}
	public function get_all_where_cols( $table, $cols, $condition ){
	
		$this->db->where($condition);
		$this->db->select($cols);
		$result = $this->db->get($table);
		return $result->result();
		
	}
	
	public function update_record($table,$updatedArray,$condition){
		$this->db->where($condition);
		$this->db->update($table, $updatedArray);
		if ( $this->db->affected_rows() > 0 ) {
			return TRUE;
		} else {
			return FALSE;  
		}
	}
	
	/******************************
	*	Get Row Where Condition			
	*******************************/
	
	public function get_row_cols_where($table,$cols,$condition){
		$this->db->select($cols);
		$this->db->from($table);
		$this->db->where($condition);
		$res = $this->db->get();
		return $res->row();
	}
	
	public function get_row_where($table, $condition){
		$this->db->where($condition);
		$res = $this->db->get($table);
		return $res->row();
	}

	public function customQuery($query){
		$query = $this->db->query($query);
		return $query->result();
	}

	public function customQueryRow($query){
		$query = $this->db->query($query);
		return $query->row();
	}
	public function get_all( $table ){
		
		//$this->db->where($condition);
		$this->db->order_by("batch_name", "desc");
		$result = $this->db->get($table);
		
		return $result->result();
		
	}
		
}
