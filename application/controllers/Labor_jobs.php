<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Labor_jobs extends CI_Controller
{
	private $title = 'Labor Only Jobs';

	public function __construct()
	{
		parent::__construct();

		$this->load->model(['LeadModel', 'TeamModel', 'TeamJobTrackModel', 'PartyModel', 'ClientLeadSourceModel']);
		$this->load->library(['form_validation']);
		$this->lead = new LeadModel();
		$this->team = new TeamModel();
		$this->team_job_track = new TeamJobTrackModel();
		$this->party = new PartyModel();
		$this->leadSource = new ClientLeadSourceModel();
	}

	public function index()
	{
		authAccess();

		$jobs = $this->lead->allLaborOnlyJobs();
		$this->load->view('header', ['title' => $this->title]);
		$this->load->view('labor_jobs/index', [
			'jobs' => $jobs
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
			$teams = $this->team->getTeamOnly(['is_deleted' => 0]);
			$insurance_job_details = false;
			$insurance_job_adjusters = false;
			$job_type_tags = LeadModel::getType();
			$lead_status_tags = LeadModel::getStatus();
			$clientLeadSource = $this->leadSource->allLeadSource();

			$this->load->view('header', ['title' => $this->title]);
			$this->load->view('labor_jobs/show', [
				'jobid' => $jobid,
				'job' => $job,
				'add_info' => $add_info,
				'teams_detail' => $teams_detail,
				'teams' => $teams,
				'insurance_job_details' => $insurance_job_details,
				'insurance_job_adjusters' => $insurance_job_adjusters,
				'job_type_tags' => $job_type_tags,
				'lead_status_tags' => $lead_status_tags,
				'leadSources' => $clientLeadSource
			]);
			$this->load->view('footer');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('lead/labor-jobs');
		}
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
