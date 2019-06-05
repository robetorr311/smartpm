<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		authAdminAccess();
	}
	public function index()
	{
		$data = $this->db->query("select SUM(if(lead='open',1,NULL)) as OPEN, SUM(if(job='labor only' AND lead='open',1,NULL)) as LABOR, SUM(if(job='insurance' AND lead='open',1,NULL)) as INSURANCE, SUM(if(job='cash' AND lead='open',1,NULL)) as CASH , SUM(if(closeout='yes',1,NULL)) as CLOSED from jobs_status");
		$this->load->view('header',['title' => 'Dashboard']);
		$this->load->view('dashboard/index',['data' => $data]);
		$this->load->view('footer'); 
	}

	

}
