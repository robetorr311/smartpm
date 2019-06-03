<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Closed extends CI_Controller {
	 public function __construct()
	    {
	        parent::__construct();
	        authAdminAccess();
	        $this->load->model(['LeadModel','LeadStatusModel']);
       		$this->load->library(['pagination', 'form_validation']);

        	$this->lead = new LeadModel();
        	$this->status = new LeadStatusModel();
	    }
 
	    public function index($start = 0){
        	$limit = 10;
	    	$pagiConfig = [
            'base_url' => base_url('closed'),
            'total_rows' => $this->lead->getCountClosedJob(),
            'per_page' => $limit
        	];
        	$this->pagination->initialize($pagiConfig);
			$leads = $this->lead->getClosedJob($start, $limit);
			$this->load->view('header',['title' => 'All Closed Job']);
			$this->load->view('closed/index',['leads' => $leads,'pagiLinks' => $this->pagination->create_links()]);
			$this->load->view('footer');
	    }

	    public function view($jobid){
			$leads = $this->lead->get_all_where('jobs',['id' => $jobid]);
			$add_info = $this->lead->get_all_where( 'job_add_party', ['job_id' => $jobid] );
			$leadstatus = $this->status->get_all_where(['jobid' => $jobid]);
			$this->load->view('header',['title' => 'Lead Detail']);
			$this->load->view('closed/view',['leadstatus' => $leadstatus,'leads' => $leads,'add_info' => $add_info,'jobid' => $jobid]);
			$this->load->view('footer');
	    }

	    public function archiveJob($jobid){
			$leads = $this->lead->getArchiveJob();
			$this->load->view('header',['title' => 'Lead Detail']);
			$this->load->view('closed/view',['leadstatus' => $leadstatus,'leads' => $leads,'add_info' => $add_info,'jobid' => $jobid]);
			$this->load->view('footer');
	    }
 
}