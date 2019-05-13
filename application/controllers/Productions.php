<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productions extends CI_Controller {
	 public function __construct()
	    {
	        parent::__construct();
	        authAdminAccess();
	        $this->load->model(['LeadModel','LeadStatusModel','TeamModel','TeamJobTrackModel']);
	        $this->load->library(['pagination', 'form_validation']);
        	$this->lead = new LeadModel();
        	$this->status = new LeadStatusModel();
        	$this->team = new TeamModel();
        	$this->team_job_track = new TeamJobTrackModel();
	    }

	    public function index(){
			$query['jobs'] = $this->lead->getJobType([
                          							 'status.contract'=>'signed',
                          							 'status.lead'=>'production'
                        							]);
			$this->load->view('header',['title' => 'All Production Jobs']);
			$this->load->view('productions/index',$query);
			$this->load->view('footer');
	    }

	    public function view()
		{	
			$query = array('jobid' => $this->uri->segment(2));
			$query['jobs'] = $this->lead->get_all_where( 'jobs', ['id'=>$this->uri->segment(2)] );
			$query['add_info'] = $this->lead->get_all_where( 'job_add_party', array('job_id' => $this->uri->segment(2)) );
			$query['status'] = $this->status->get_all_where(['jobid'=>$this->uri->segment(2)]);
			$query['teams_detail'] = $this->team_job_track->getTeamName($this->uri->segment(2));

			$query['teams'] = $this->team->get_all_where(['is_active'=>1]);
			$this->load->view('header',['title' => 'Production Jobs Detail']);
			$this->load->view('productions/view',$query);
			$this->load->view('footer');
		}

	    
	
}