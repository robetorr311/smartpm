<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cash_jobs extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		authAdminAccess();
		$this->load->model(['LeadModel', 'LeadStatusModel', 'TeamModel', 'TeamJobTrackModel']);
		$this->load->library(['pagination', 'form_validation']);
		$this->lead = new LeadModel();
		$this->status = new LeadStatusModel();
		$this->team = new TeamModel();
		$this->team_job_track = new TeamJobTrackModel();
	}

	public function index($start = 0)
	{
		$limit = 10;
		$pagiConfig = [
			'base_url' => base_url('cash-jobs'),
			'total_rows' => $this->lead->getCountBasedJobType('cash'),
			'per_page' => $limit
		];
		$this->pagination->initialize($pagiConfig);
		$jobs = $this->lead->getJobType($start, $limit, [
			'status.job' => 'cash',
			'status.contract' => 'signed',
			'status.production' => 'pre-production'
		]);
		$this->load->view('header', ['title' => 'Cash Job']);
		$this->load->view('cash_job/index', [
			'jobs' => $jobs,
			'pagiLinks' => $this->pagination->create_links()
		]);
		$this->load->view('footer');
	}

	public function view($jobid)
	{
		$jobs = $this->lead->get_all_where('jobs', ['id' => $jobid]);
		$add_info = $this->lead->get_all_where('job_add_party', array('job_id' => $jobid));
		$status = $this->status->get_all_where(['jobid' => $jobid]);
		$teams_detail = $this->team_job_track->getTeamName($jobid);
		$teams = $this->team->getTeamOnly(['is_deleted' => 0]);

		$this->load->view('header', ['title' => 'Cash Job Detail']);
		$this->load->view('cash_job/view', [
			'jobid' => $jobid,
			'jobs' => $jobs,
			'add_info' => $add_info,
			'status' => $status,
			'teams_detail' => $teams_detail,
			'teams' => $teams
		]);
		$this->load->view('footer');
	}


	public function addTeam($jobid)
	{
		if (isset($_POST) && count($_POST) > 0) {
			$posts = $this->input->post();
			$params = array();
			$params['team_id'] 		= $posts['team_id'];
			$params['job_id'] 		= $jobid;
			$params['assign_date'] 		= date('Y-m-d h:i:s');
			$params['is_deleted'] 		= false;
			$this->team_job_track->add_record($params);
			$this->status->update_record(['production' => 'production'], ['jobid' => $jobid]);
			redirect('cash-job/' . $jobid);
		} else {
			redirect('cash-jobs');
		}
	}

	public function delete($jobid)
	{
		$this->team_job_track->remove_team($jobid);
		$this->status->update_record(['production' => 'pre-production'], ['jobid' => $jobid]);
		redirect('cash-job/' . $jobid);
	}
}
