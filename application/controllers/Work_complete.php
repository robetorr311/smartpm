<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Work_complete extends CI_Controller {
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
            'base_url' => base_url('work-completed'),
            'total_rows' => $this->lead->getCountBasedJobStatus('complete'),
            'per_page' => $limit
        	];
        	$this->pagination->initialize($pagiConfig);
			$jobs = $this->lead->getJobType($start, $limit,[
                          							 'status.contract'=>'signed',
                          							 'status.production'=>'complete',
                          							 'status.closeout'=>'no'
                        							]);
			$this->load->view('header',['title' => 'Work Complete']);
			$this->load->view('work_complete/index',[
				'jobs' => $jobs,
				'pagiLinks' => $this->pagination->create_links()
			]);
			$this->load->view('footer');
	    }

	    public function view($jobid)
		{	
			$query = array('jobid' => $this->uri->segment(2));
			$query['jobs'] = $this->lead->get_all_where( 'jobs', ['id'=>$jobid] );
			$query['add_info'] = $this->lead->get_all_where( 'job_add_party', array('job_id' => $jobid) );
			$query['status'] = $this->status->get_all_where(['jobid'=>$jobid]);
			$query['teams_detail'] = $this->team_job_track->getTeamName($jobid);
			$this->load->view('header',['title' => 'Job Detail']);
			$this->load->view('work_complete/view',$query);
			$this->load->view('footer');
		}

		public function complete($jobid)
		{	
	    	$this->status->update_record(['closeout'=>'yes','lead'=>'complete'],['jobid'=>$jobid]);
			redirect('work-complete/'.$jobid);
		}
		public function incomplete($jobid)
		{	
	    	$this->status->update_record(['closeout'=>'no','lead'=>'production'],['jobid'=>$jobid]);
			redirect('work-complete/'.$jobid);
		}
	    
	
}