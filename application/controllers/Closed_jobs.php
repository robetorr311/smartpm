<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Closed_jobs extends CI_Controller
{
	private $title = 'Closed Jobs';

	public function __construct()
	{
		parent::__construct();

		$this->load->model(['LeadModel', 'PartyModel', 'FinancialModel', 'InsuranceJobDetailsModel', 'InsuranceJobAdjusterModel', 'TeamJobTrackModel', 'TeamModel', 'ClientLeadSourceModel',  'ClientClassificationModel', 'ActivityLogsModel', 'VendorModel', 'ItemModel', 'LeadMaterialModel', 'UserModel']);
		$this->load->library(['form_validation']);

		$this->lead = new LeadModel();
		$this->party = new PartyModel();
		$this->financial = new FinancialModel();
		$this->insurance_job_details = new InsuranceJobDetailsModel();
		$this->insurance_job_adjuster = new InsuranceJobAdjusterModel();
		$this->team_job_track = new TeamJobTrackModel();
		$this->team = new TeamModel();
		$this->leadSource = new ClientLeadSourceModel();
		$this->classification = new ClientClassificationModel();
		$this->user = new UserModel();
		$this->activityLogs = new ActivityLogsModel();
		$this->vendor = new VendorModel();
		$this->item = new ItemModel();
		$this->lead_material = new LeadMaterialModel();
	}

	public function index()
	{
		authAccess();

		$leads = $this->lead->allClosedJobs();
		$this->load->view('header', [
			'title' => $this->title
		]);
		$this->load->view('closed_jobs/index', [
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
			$financial_record = $this->financial->getContractDetailsByJobId($jobid);
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
			$classification = $this->classification->allClassification();
			$users = $this->user->getUserList();
			$aLogs = $this->activityLogs->getLogsByLeadId($jobid);
			$vendors = $this->vendor->getVendorList();
			$items = $this->item->getItemList();
			$materials = $this->lead_material->getMaterialsByLeadId($jobid);
			$primary_material_info = $this->lead_material->getPrimaryMaterialInfoByLeadId($jobid);
			$financials = $this->financial->allFinancialsForReceipt($jobid);

			$this->load->view('header', [
				'title' => $this->title
			]);
			$this->load->view('closed_jobs/show', [
				'jobid' => $jobid,
				'job' => $job,
				'add_info' => $add_info,
				'financial_record' => $financial_record,
				'teams_detail' => $teams_detail,
				'insurance_job_details' => $insurance_job_details,
				'insurance_job_adjusters' => $insurance_job_adjusters,
				'previous_status' => $previous_status,
				'teams' => $teams,
				'job_type_tags' => $job_type_tags,
				'lead_status_tags' => $lead_status_tags,
				'lead_category_tags' => $lead_category_tags,
				'leadSources' => $clientLeadSource,
				'classification' => $classification,
				'users' => $users,
				'aLogs' => $aLogs,
				'items' => $items,
				'vendors' => $vendors,
				'primary_material_info' => $primary_material_info,
				'materials' => $materials,
				'financials' => $financials
			]);
			$this->load->view('footer');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('lead/closed-jobs');
		}
	}
}
