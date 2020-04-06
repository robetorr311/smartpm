<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Archive_jobs extends CI_Controller
{
	private $title = 'Archive Jobs';

	public function __construct()
	{
		parent::__construct();

		$this->load->model(['LeadModel', 'PartyModel', 'InsuranceJobDetailsModel', 'InsuranceJobAdjusterModel', 'TeamJobTrackModel', 'TeamModel', 'ClientLeadSourceModel', 'ActivityLogsModel']);
		$this->load->library(['form_validation']);

		$this->lead = new LeadModel();
		$this->party = new PartyModel();
		$this->insurance_job_details = new InsuranceJobDetailsModel();
		$this->insurance_job_adjuster = new InsuranceJobAdjusterModel();
		$this->team_job_track = new TeamJobTrackModel();
		$this->team = new TeamModel();
		$this->leadSource = new ClientLeadSourceModel();
		$this->activityLogs = new ActivityLogsModel();
	}

	public function index()
	{
		authAccess();

		$leads = $this->lead->allArchivedJobs();
		$this->load->view('header', [
			'title' => $this->title
		]);
		$this->load->view('archive_jobs/index', [
			'leads' => $leads
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
			if ($job->category === '0') {
				$insurance_job_details = $this->insurance_job_details->getInsuranceJobDetailsByLeadId($jobid);
				$insurance_job_adjusters = $this->insurance_job_adjuster->allAdjusters($jobid);
			}
			$previous_status = '';
			$teams = $this->team->getTeamOnly(['is_deleted' => 0]);
			$job_type_tags = LeadModel::getType();
			$lead_status_tags = LeadModel::getStatus();
			$lead_category_tags = LeadModel::getCategory();
			$clientLeadSource = $this->leadSource->allLeadSource();
			$aLogs = $this->activityLogs->getLogsByLeadId($jobid);

			$this->load->view('header', [
				'title' => $this->title
			]);
			$this->load->view('archive_jobs/show', [
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
				'lead_category_tags' => $lead_category_tags,
				'leadSources' => $clientLeadSource,
				'aLogs' => $aLogs
			]);
			$this->load->view('footer');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('lead/productions-jobs');
		}
	}
}
