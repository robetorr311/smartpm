<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Signed_jobs extends CI_Controller
{
	private $title = 'Signed Jobs';

	public function __construct()
	{
		parent::__construct();

		$this->load->model(['LeadModel']);
		$this->load->library(['pagination', 'form_validation']);
		$this->lead = new LeadModel();
	}

	public function index($start = 0)
	{
		authAccess();

		$limit = 10;
		$pagiConfig = [
			'base_url' => base_url('lead/all-status'),
			'total_rows' => $this->lead->getSignedJobsCount(),
			'per_page' => $limit
		];
		$this->pagination->initialize($pagiConfig);
		$jobs = $this->lead->allSignedJobs($start, $limit);
		$this->load->view('header', ['title' => $this->title]);
		$this->load->view('signed_job/index', [
			'jobs' => $jobs,
			'pagiLinks' => $this->pagination->create_links()
		]);
		$this->load->view('footer');
	}
}
