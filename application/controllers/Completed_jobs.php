<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Completed_jobs extends CI_Controller
{
	private $title = 'Completed Jobs';

	public function __construct()
	{
		parent::__construct();

		$this->load->model(['LeadModel', 'TeamJobTrackModel', 'InsuranceJobDetailsModel', 'InsuranceJobAdjusterModel', 'PartyModel', 'TeamModel', 'ClientLeadSourceModel']);
		$this->load->library(['pagination', 'form_validation']);
		$this->lead = new LeadModel();
		$this->team_job_track = new TeamJobTrackModel();
		$this->insurance_job_details = new InsuranceJobDetailsModel();
		$this->insurance_job_adjuster = new InsuranceJobAdjusterModel();
		$this->party = new PartyModel();
		$this->team = new TeamModel();
		$this->leadSource = new ClientLeadSourceModel();
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
		$this->load->view('header', ['title' => $this->title]);
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
		if ($job) {
			$add_info = $this->party->getPartyByLeadId($jobid);
			$teams_detail = $this->team_job_track->getTeamName($jobid);
			$insurance_job_details = false;
			$insurance_job_adjusters = false;
			if ($job->status == 7) {
				$insurance_job_details = $this->insurance_job_details->getInsuranceJobDetailsByLeadId($jobid);
				$insurance_job_adjusters = $this->insurance_job_adjuster->allAdjusters($jobid);
			}
			$previous_status = '';
			$teams = $this->team->getTeamOnly(['is_deleted' => 0]);
			$job_type_tags = LeadModel::getType();
			$lead_status_tags = LeadModel::getStatus();
			$clientLeadSource = $this->leadSource->allLeadSource();

			$this->load->view('header', ['title' => $this->title]);
			$this->load->view('completed_jobs/show', [
				'jobid' => $jobid,
				'job' => $job,
				'add_info' => $add_info,
				'teams_detail' => $teams_detail,
				'insurance_job_details' => $insurance_job_details,
				'insurance_job_adjusters' => $insurance_job_adjusters,
				'previous_status' => $previous_status,
				'teams' => $teams,
				'job_type_tags' => $job_type_tags,
				'lead_status_tags' => $lead_status_tags,
				'leadSources' => $clientLeadSource
			]);
			$this->load->view('footer');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('lead/completed-jobs');
		}
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
