<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Productions extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		authAdminAccess();
		$this->load->model(['LeadModel', 'TeamJobTrackModel', 'InsuranceJobDetailsModel', 'PartyModel']);
		$this->load->library(['pagination', 'form_validation']);
		$this->lead = new LeadModel();
		$this->team_job_track = new TeamJobTrackModel();
		$this->insurance_job_details = new InsuranceJobDetailsModel();
		$this->party = new PartyModel();
	}

	public function index($start = 0)
	{
		$limit = 10;
		$pagiConfig = [
			'base_url' => base_url('lead/productions'),
			'total_rows' => $this->lead->getProductionJobsCount(),
			'per_page' => $limit
		];
		$this->pagination->initialize($pagiConfig);
		$jobs = $this->lead->allProductionJobs($start, $limit);
		$this->load->view('header', ['title' => 'Production Jobs']);
		$this->load->view('productions/index', [
			'jobs' => $jobs,
			'pagiLinks' => $this->pagination->create_links()
		]);
		$this->load->view('footer');
	}

	public function view($jobid)
	{
		$job = $this->lead->getLeadById($jobid);
		$add_info = $this->party->getPartyByLeadId($jobid);
		$teams_detail = $this->team_job_track->getTeamName($jobid);
		$previous_status = '';
		$insurance_job_details = false;

		switch ($job->status) {
			case 7:
				$previous_status = 'Insurance';
				$insurance_job_details = $this->insurance_job_details->getInsuranceJobDetailsByLeadId($jobid);
				break;

			case 8:
				$previous_status = 'Cash';
				break;

			case 9:
				$previous_status = 'Labor';
				break;

			default:
				$previous_status = 'Previous Status';
				break;
		}

		$this->load->view('header', ['title' => 'Production Job Detail']);
		$this->load->view('productions/show', [
			'jobid' => $jobid,
			'job' => $job,
			'add_info' => $add_info,
			'teams_detail' => $teams_detail,
			'previous_status' => $previous_status,
			'insurance_job_details' => $insurance_job_details
		]);
		$this->load->view('footer');
	}

	public function movePreviousStage($jobid)
	{
		$job = $this->lead->getLeadById($jobid);
		$status_url = '';

		switch ($job->status) {
			case 7:
				$status_url = 'insurance-job/';
				break;

			case 8:
				$status_url = 'cash-job/';
				break;

			case 9:
				$status_url = 'labor-job/';
				break;

			default:
				$status_url = '';
				break;
		}

		$this->lead->update($jobid, [
			'signed_stage' => 0
		]);
		redirect('lead/' . $status_url . $jobid);
	}

	public function moveNextStage($jobid)
	{
		$this->lead->update($jobid, [
			'signed_stage' => 2
		]);
		redirect('lead/completed-job/' . $jobid);
	}
}
