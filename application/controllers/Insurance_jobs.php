<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insurance_jobs extends CI_Controller {
	 public function __construct()
	    {
	        parent::__construct();
	        authAdminAccess();
	        $this->load->model(['LeadModel','LeadStatusModel']);
	        $this->load->library(['pagination', 'form_validation']);
        	$this->lead = new LeadModel();
        	$this->status = new LeadStatusModel();
	     
	    }

	    public function index(){
	    	$job_type='insurance';
			$query['jobs'] = $this->lead->getJob($job_type);
			$this->load->view('header',['title' => 'Insurance Jobs']);
			$this->load->view('insurance_job/index',$query);
			$this->load->view('footer');
	    }

	    public function view()
		{	
			$query = array('jobid' => $this->uri->segment(2));
			$params = array();
			$params['id'] =$this->uri->segment(2);
			$query['jobs'] = $this->lead->get_all_where( 'jobs', $params );
			$query['add_info'] = $this->lead->get_all_where( 'job_add_party', array('job_id' => $this->uri->segment(2)) );
			$query['status'] = $this->status->get_all_where(['jobid'=>$this->uri->segment(2)]);
			$this->load->view('header',['title' => 'Cash Job']);
			$this->load->view('insurance_job/view',$query);
			$this->load->view('footer');
		}
}