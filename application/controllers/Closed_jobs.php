<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Closed_jobs extends CI_Controller
{
    private $title = 'Closed Jobs';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['LeadModel', 'PartyModel', 'InsuranceJobDetailsModel', 'TeamJobTrackModel']);
        $this->load->library(['pagination', 'form_validation']);

        $this->lead = new LeadModel();
		$this->party = new PartyModel();
		$this->insurance_job_details = new InsuranceJobDetailsModel();
		$this->team_job_track = new TeamJobTrackModel();
    }

	public function index($start = 0)
	{
		authAccess();
		
		$limit = 10;
		$pagiConfig = [
			'base_url' => base_url('lead/closed-jobs'),
			'total_rows' => $this->lead->getClosedJobsCount(),
			'per_page' => $limit
		];
		$this->pagination->initialize($pagiConfig);

		$leads = $this->lead->allClosedJobs($start, $limit);
		$this->load->view('header', [
			'title' => $this->title
		]);
		$this->load->view('closed_jobs/index', [
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
		if ($job->status == 7) {
			$insurance_job_details = $this->insurance_job_details->getInsuranceJobDetailsByLeadId($jobid);
		}

		$this->load->view('header', [
            'title' => $this->title
        ]);
		$this->load->view('closed_jobs/show', [
			'jobid' => $jobid,
			'job' => $job,
			'add_info' => $add_info,
			'teams_detail' => $teams_detail,
			'insurance_job_details' => $insurance_job_details
		]);
		$this->load->view('footer');
	}

	public function movePreviousStage($jobid)
	{
		authAccess();
		
		$this->lead->update($jobid, [
			'signed_stage' => 2
		]);
		redirect('lead/completed-job/' . $jobid);
	}

	public function moveNextStage($jobid)
	{
		authAccess();
		
		$this->lead->update($jobid, [
			'signed_stage' => 4
		]);
		redirect('lead/archive-job/' . $jobid);
	}
}
