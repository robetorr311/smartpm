<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	    public function __construct()
	    {
	        parent::__construct();
	        authAdminAccess();
	    }

	    public function index(){
	    	$query['data'] = $this->db->query("SELECT * FROM admin_setting;");
			$this->load->view('header',['title' => 'Setting']);
			$this->load->view('setting/index',$query);
			$this->load->view('footer');
	    }

}