<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Completed_jobs extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		authAdminAccess();
		$this->load->model(['LeadModel', 'TeamJobTrackModel']);
		$this->load->library(['pagination', 'form_validation']);
		$this->lead = new LeadModel();
		$this->team_job_track = new TeamJobTrackModel();
	}

	public function index($start = 0)
	{
		$limit = 10;
		$pagiConfig = [
			'base_url' => base_url('lead/completed-jobs'),
			'total_rows' => $this->lead->getCompletedJobsCount(),
			'per_page' => $limit
		];
		$this->pagination->initialize($pagiConfig);
		$jobs = $this->lead->allCompletedJobs($start, $limit);
		$this->load->view('header', ['title' => 'Completed Jobs']);
		$this->load->view('completed_jobs/index', [
			'jobs' => $jobs,
			'pagiLinks' => $this->pagination->create_links()
		]);
		$this->load->view('footer');
	}

	public function view($jobid)
	{
		$job = $this->lead->getLeadById($jobid);
		$add_info = $this->lead->get_all_where('job_add_party', array('job_id' => $jobid));
		$teams_detail = $this->team_job_track->getTeamName($jobid);

		$this->load->view('header', ['title' => 'Completed Job Detail']);
		$this->load->view('completed_jobs/show', [
			'jobid' => $jobid,
			'job' => $job,
			'add_info' => $add_info,
			'teams_detail' => $teams_detail
		]);
		$this->load->view('footer');
	}

	public function movePreviousStage($jobid)
	{
		$this->lead->update($jobid, [
			'signed_stage' => 0
		]);
		redirect('lead/production-job/' . $jobid);
	}
}
