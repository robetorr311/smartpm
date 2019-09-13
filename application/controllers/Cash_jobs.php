<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cash_jobs extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(['LeadModel', 'TeamModel', 'TeamJobTrackModel', 'PartyModel']);
		$this->load->library(['pagination', 'form_validation']);
		$this->lead = new LeadModel();
		$this->team = new TeamModel();
		$this->team_job_track = new TeamJobTrackModel();
		$this->party = new PartyModel();
	}

	public function index($start = 0)
	{
		authAccess();
		
		$limit = 10;
		$pagiConfig = [
			'base_url' => base_url('lead/cash-jobs'),
			'total_rows' => $this->lead->getCashJobsCount(),
			'per_page' => $limit
		];
		$this->pagination->initialize($pagiConfig);
		$jobs = $this->lead->allCashJobs($start, $limit);
		$this->load->view('header', ['title' => 'Cash Jobs']);
		$this->load->view('cash_job/index', [
			'jobs' => $jobs,
			'pagiLinks' => $this->pagination->create_links()
		]);
		$this->load->view('footer');
	}

	public function view($jobid)
	{
		authAccess();
		
		$job = $this->lead->getLeadById($jobid);
		$add_info = $this->party->getPartyByLeadId($jobid);
		$teams_detail = $this->team_job_track->getTeamName($jobid);
		$teams = $this->team->getTeamOnly(['is_deleted' => 0]);

		$this->load->view('header', ['title' => 'Cash Job Detail']);
		$this->load->view('cash_job/show', [
			'jobid' => $jobid,
			'job' => $job,
			'add_info' => $add_info,
			'teams_detail' => $teams_detail,
			'teams' => $teams
		]);
		$this->load->view('footer');
	}

	public function moveNextStage($jobid)
	{
		authAccess();
		
		$this->lead->update($jobid, [
			'signed_stage' => 1
		]);
		redirect('lead/production-job/' . $jobid);
	}
}
