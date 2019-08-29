<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Insurance_jobs extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		authAdminAccess();
		$this->load->model(['LeadModel', 'TeamModel', 'TeamJobTrackModel', 'InsuranceJobDetailsModel']);
		$this->load->library(['pagination', 'form_validation']);
		$this->lead = new LeadModel();
		$this->team = new TeamModel();
		$this->team_job_track = new TeamJobTrackModel();
		$this->insurance_job_details = new InsuranceJobDetailsModel();
	}

	public function index($start = 0)
	{
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
		$job = $this->lead->getLeadById($jobid);
		$add_info = $this->lead->get_all_where('job_add_party', array('job_id' => $jobid));
		$teams_detail = $this->team_job_track->getTeamName($jobid);
		$teams = $this->team->getTeamOnly(['is_deleted' => 0]);
		$insurance_job_details = false;
		if ($job->status == 7) {
			$insurance_job_details = $this->insurance_job_details->getInsuranceJobDetailsByLeadId($jobid);
		}

		$this->load->view('header', ['title' => 'Insurance Job Detail']);
		$this->load->view('insurance_job/show', [
			'jobid' => $jobid,
			'job' => $job,
			'add_info' => $add_info,
			'teams_detail' => $teams_detail,
			'teams' => $teams,
			'insurance_job_details' => $insurance_job_details
		]);
		$this->load->view('footer');
	}

	public function addTeam($jobid)
	{
		$this->form_validation->set_rules('team_id', 'Team', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$posts = $this->input->post();
			$params = array();
			$params['team_id'] = $posts['team_id'];
			$params['job_id'] = $jobid;
			$params['assign_date'] = date('Y-m-d h:i:s');
			$params['is_deleted'] = false;
			$this->team_job_track->add_record($params);
		} else {
			$this->session->set_flashdata('errors', validation_errors());
		}
		redirect('lead/insurance-job/' . $jobid);
	}

	public function removeTeam($jobid)
	{
		$this->team_job_track->remove_team($jobid);
		redirect('lead/insurance-job/' . $jobid);
	}

	public function moveNextStage($jobid)
	{
		$this->lead->update($jobid, [
			'signed_stage' => 1
		]);
		redirect('lead/production-job/' . $jobid);
	}

	public function insertInsuranceDetails($jobid, $sub_base_path)
	{
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
}
