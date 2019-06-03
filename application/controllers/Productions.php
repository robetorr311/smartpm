<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productions extends CI_Controller {
	 public function __construct()
	    {
	        parent::__construct();
	        authAdminAccess();
	        $this->load->model(['LeadModel','LeadStatusModel','TeamJobTrackModel']);
	        $this->load->library(['pagination', 'form_validation']);
        	$this->lead = new LeadModel();
        	$this->status = new LeadStatusModel();
        	$this->team_job_track = new TeamJobTrackModel();
	    }

	    public function index($start = 0){
			$limit = 10; 
	    	$pagiConfig = [
            'base_url' => base_url('productions'),
            'total_rows' => $this->lead->getCountBasedJobStatus('production'),
            'per_page' => $limit
        	];
        	$this->pagination->initialize($pagiConfig);
			$jobs = $this->lead->getJobType($start, $limit,[
                          							 'status.contract'=>'signed',
                          							 'status.production'=>'production'
                        							]);
			$this->load->view('header',['title' => 'All Production Jobs']);
			$this->load->view('productions/index',[
				'jobs' => $jobs,
				'pagiLinks' => $this->pagination->create_links()
			]);
			$this->load->view('footer');
	    }

	    public function view($jobid)
		{	
			$query = array('jobid' => $jobid);
			$query['jobs'] = $this->lead->get_all_where( 'jobs', ['id'=>$jobid] );
			$query['add_info'] = $this->lead->get_all_where( 'job_add_party', array('job_id' => $jobid) );
			$query['status'] = $this->status->get_all_where(['jobid'=>$jobid]);
			$query['teams_detail'] = $this->team_job_track->getTeamName($jobid);
			$this->load->view('header',['title' => 'Production Jobs Detail']);
			$this->load->view('productions/view',$query);
			$this->load->view('footer');
		}

		public function complete($jobid)
		{	
	    	$this->status->update_record(['production'=>'complete','closeout'=>'no'],['jobid'=>$jobid]);
			redirect('production/'.$jobid);
		}

		public function incomplete($jobid)
		{	
	    	$this->status->update_record(['production'=>'production','closeout'=>'no'],['jobid'=>$jobid]);
			redirect('production/'.$jobid);
		}

	    
	
}