<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Archive_jobs extends CI_Controller
{
	private $title = 'Archive Jobs';

	public function __construct()
	{
		parent::__construct();

		$this->load->model(['LeadModel', 'PartyModel', 'InsuranceJobDetailsModel', 'InsuranceJobAdjusterModel', 'TeamJobTrackModel']);
		$this->load->library(['pagination', 'form_validation']);

		$this->lead = new LeadModel();
		$this->party = new PartyModel();
		$this->insurance_job_details = new InsuranceJobDetailsModel();
		$this->insurance_job_adjuster = new InsuranceJobAdjusterModel();
		$this->team_job_track = new TeamJobTrackModel();
	}

	public function index($start = 0)
	{
		authAccess();

		$limit = 10;
		$pagiConfig = [
			'base_url' => base_url('lead/archive-jobs'),
			'total_rows' => $this->lead->getArchivedJobsCount(),
			'per_page' => $limit
		];
		$this->pagination->initialize($pagiConfig);

		$leads = $this->lead->allArchivedJobs($start, $limit);
		$this->load->view('header', [
			'title' => $this->title
		]);
		$this->load->view('archive_jobs/index', [
			'leads' => $leads,
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

		$this->load->view('header', [
			'title' => $this->title
		]);
		$this->load->view('archive_jobs/show', [
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
			'signed_stage' => 3
		]);
		redirect('lead/closed-job/' . $jobid);
	}
}
