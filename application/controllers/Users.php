<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	 public function __construct()
	    {
	        parent::__construct();
	        authAdminAccess();
	        $this->load->model(['Common_model']);
	    }

	    public function index(){
	    	$params = array();
			$params['is_active'] = 1;
			$params['status'] ='cash';
			$query['jobs'] = $this->Common_model->get_all_where( 'jobs', $params );
			$this->load->view('header',['title' => 'Cash Job']);
			$this->load->view('users/index',$query);
			$this->load->view('footer');
	    }
}