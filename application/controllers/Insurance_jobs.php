<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insurance_jobs extends CI_Controller {
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
													 'status.job'=>'insurance',
                          							 'status.contract'=>'signed',
                          							 'status.production'=>'pre-production'
                        							]);
			$this->load->view('header',['title' => 'Insurance Jobs']);
			$this->load->view('insurance_job/index',$query);
			$this->load->view('footer');
	    }

	    
		public function view()
		{	
			$query = array('jobid' => $this->uri->segment(2));
			$query['jobs'] = $this->lead->get_all_where( 'jobs', ['id'=>$this->uri->segment(2)] );
			$query['add_info'] = $this->lead->get_all_where( 'job_add_party', array('job_id' => $this->uri->segment(2)) );
			$query['status'] = $this->status->get_all_where(['jobid'=>$this->uri->segment(2)]);
			$query['teams_detail'] = $this->team_job_track->getTeamName($this->uri->segment(2));

			$query['teams'] = $this->team->getTeamOnly(['is_deleted'=>0]);
			$this->load->view('header',['title' => 'Insurance Job']);
			$this->load->view('insurance_job/view',$query);
			$this->load->view('footer');
		}


		public function addTeam(){
	    	$posts = $this->input->post();
	    	$params = array();
			$params['team_id'] 		= $posts['team_id'];
			$params['job_id'] 		= $this->uri->segment(2);
			$params['assign_date'] 		=date('Y-m-d h:i:s');
			$params['is_deleted'] 		= false;
	  		$this->team_job_track->add_record($params);
	  		$this->status->update_record(['production'=>'production'],['jobid'=>$this->uri->segment(2)]);
	  		redirect('insurance-job/'.$this->uri->segment(2));
	    }

	    public function delete(){
	    	$this->team_job_track->remove_team($this->uri->segment(2));
	    	redirect('insurance-job/'.$this->uri->segment(2));
	    }
}