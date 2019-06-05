<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		authAdminAccess();
		$this->load->model(['LeadStatusModel']);
		$this->status = new LeadStatusModel();
	}
	public function index()
	{
		$data = $this->status->allJobStatus();
		$this->load->view('header',['title' => 'Dashboard']);
		$this->load->view('dashboard/index',['data' => $data]);
		$this->load->view('footer'); 
	}

	

}
