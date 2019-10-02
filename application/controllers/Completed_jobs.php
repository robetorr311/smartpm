<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Completed_jobs extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(['LeadModel', 'TeamJobTrackModel', 'InsuranceJobDetailsModel', 'InsuranceJobAdjusterModel', 'PartyModel']);
		$this->load->library(['pagination', 'form_validation']);
		$this->lead = new LeadModel();
		$this->team_job_track = new TeamJobTrackModel();
		$this->insurance_job_details = new InsuranceJobDetailsModel();
		$this->insurance_job_adjuster = new InsuranceJobAdjusterModel();
		$this->party = new PartyModel();
	}

	public function index($start = 0)
	{
		authAccess();
		
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
		authAccess();
		
		$job = $this->lead->getLeadById($jobid);
		$add_info = $this->party->getPartyByLeadId($jobid);
		$teams_detail = $this->team_job_track->getTeamName($jobid);
		$insurance_job_details = false;
		$insurance_job_adjusters = false;
		if ($job->status == 7) {
			$insurance_job_details = $this->insurance_job_details->getInsuranceJobDetailsByLeadId($jobid);
			$insurance_job_adjusters = $this->insurance_job_adjuster->allAdjusters($jobid);
		}

		$this->load->view('header', ['title' => 'Completed Job Detail']);
		$this->load->view('completed_jobs/show', [
			'jobid' => $jobid,
			'job' => $job,
			'add_info' => $add_info,
			'teams_detail' => $teams_detail,
			'insurance_job_details' => $insurance_job_details,
			'insurance_job_adjusters' => $insurance_job_adjusters
		]);
		$this->load->view('footer');
	}

	public function movePreviousStage($jobid)
	{
		authAccess();
		
		$this->lead->update($jobid, [
			'signed_stage' => 1
		]);
		redirect('lead/production-job/' . $jobid);
	}

	public function moveNextStage($jobid)
	{
		authAccess();
		
		$this->lead->update($jobid, [
			'signed_stage' => 3
		]);
		redirect('lead/closed-job/' . $jobid);
	}
}
