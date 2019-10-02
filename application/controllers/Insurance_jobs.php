<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Insurance_jobs extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(['LeadModel', 'TeamModel', 'TeamJobTrackModel', 'InsuranceJobDetailsModel', 'InsuranceJobAdjusterModel', 'PartyModel']);
		$this->load->library(['pagination', 'form_validation']);
		$this->lead = new LeadModel();
		$this->team = new TeamModel();
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
			'base_url' => base_url('lead/insurance-jobs'),
			'total_rows' => $this->lead->getInsuranceJobsCount(),
			'per_page' => $limit
		];
		$this->pagination->initialize($pagiConfig);
		$jobs = $this->lead->allInsuranceJobs($start, $limit);
		$this->load->view('header', ['title' => 'Insurance Jobs']);
		$this->load->view('insurance_job/index', [
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
		$insurance_job_details = false;
		$insurance_job_adjusters = false;
		if ($job->status == 7) {
			$insurance_job_details = $this->insurance_job_details->getInsuranceJobDetailsByLeadId($jobid);
			$insurance_job_adjusters = $this->insurance_job_adjuster->allAdjusters($jobid);
		}

		$this->load->view('header', ['title' => 'Insurance Job Detail']);
		$this->load->view('insurance_job/show', [
			'jobid' => $jobid,
			'job' => $job,
			'add_info' => $add_info,
			'teams_detail' => $teams_detail,
			'teams' => $teams,
			'insurance_job_details' => $insurance_job_details,
			'insurance_job_adjusters' => $insurance_job_adjusters
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

	public function insertInsuranceDetails($jobid, $sub_base_path)
	{
		authAccess();
		
		$posts = $this->input->post();
		$insert = $this->insurance_job_details->insert([
			'insurance_carrier' => $posts['insurance_carrier'],
			'carrier_phone' => $posts['carrier_phone'],
			'carrier_email' => $posts['carrier_email'],
			'policy_number' => $posts['policy_number'],
			'date_of_loss' => $posts['date_of_loss'],
			'adjuster' => $posts['adjuster'],
			'adjuster_phone' => $posts['adjuster_phone'],
			'adjuster_email' => $posts['adjuster_email'],
			'job_id' => $jobid
		]);
		redirect('lead/' . $sub_base_path . '/' . $jobid . '/edit');
	}

	public function updateInsuranceDetails($jobid, $sub_base_path)
	{
		authAccess();
		
		$posts = $this->input->post();
		$update = $this->insurance_job_details->updateByLeadId($jobid, [
			'insurance_carrier' => $posts['insurance_carrier'],
			'carrier_phone' => $posts['carrier_phone'],
			'carrier_email' => $posts['carrier_email'],
			'policy_number' => $posts['policy_number'],
			'date_of_loss' => $posts['date_of_loss'],
			'adjuster' => $posts['adjuster'],
			'adjuster_phone' => $posts['adjuster_phone'],
			'adjuster_email' => $posts['adjuster_email']
		]);
		redirect('lead/' . $sub_base_path . '/' . $jobid . '/edit');
	}

	public function insertAdjuster($jobid, $sub_base_path)
	{
		authAccess();

		$posts = $this->input->post();
		$insert = $this->insurance_job_adjuster->insertAdjuster([
			'adjuster' => $posts['adjuster'],
			'adjuster_phone' => $posts['adjuster_phone'],
			'adjuster_email' => $posts['adjuster_email'],
			'job_id' => $jobid
		]);
		redirect('lead/' . $sub_base_path . '/' . $jobid . '/edit');
	}

	public function deleteAdjuster($jobid, $id, $sub_base_path)
	{
		authAccess();

		$delete = $this->insurance_job_adjuster->deleteAdjuster($id, $jobid);
		redirect('lead/' . $sub_base_path . '/' . $jobid . '/edit');
	}
}
