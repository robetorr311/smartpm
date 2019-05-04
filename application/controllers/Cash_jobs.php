<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_jobs extends CI_Controller {
	 public function __construct()
	    {
	        parent::__construct();
	        authAdminAccess();
	        $this->load->model(['Cash_jobModel']);
	        $this->load->library(['pagination', 'form_validation']);
        	$this->cash = new Cash_jobModel();
	    }

	    public function index(){
	    	$params = array();
			$params['is_active'] = 1;
			$params['status'] ='cash';
			$query['jobs'] = $this->cash->get_all_where( 'jobs', $params );
			$this->load->view('header',['title' => 'Cash Job']);
			$this->load->view('cash_job/index',$query);
			$this->load->view('footer');
	    }

	    public function view()
		{	
			$query = array('jobid' => $this->uri->segment(2));
			$params = array();
			$params['id'] =$this->uri->segment(2);
			$query['jobs'] = $this->cash->get_all_where( 'jobs', $params );
			$query['add_info'] = $this->cash->get_all_where( 'job_add_party', array('job_id' => $this->uri->segment(2)) );

			$this->load->view('header',['title' => 'Cash Job']);
			$this->load->view('cash_job/view',$query);
			$this->load->view('footer');
		}
}