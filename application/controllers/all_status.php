<?php
defined('BASEPATH') or exit('No direct script access allowed');

class All_status extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        authAdminAccess();
		$this->load->model(['LeadModel']);
        $this->load->library(['pagination', 'form_validation']);
		$this->lead = new LeadModel();
    }

	public function index($start = 0)
	{
		$limit = 10;
		$pagiConfig = [
			'base_url' => base_url('lead/all-status'),
			'total_rows' => $this->lead->getJobsCount(),
			'per_page' => $limit
		];
		$this->pagination->initialize($pagiConfig);
		$jobs = $this->lead->allJobs($start, $limit);
		$this->load->view('header', ['title' => 'All Status Jobs']);
		$this->load->view('all_status/index', [
			'jobs' => $jobs,
			'pagiLinks' => $this->pagination->create_links()
		]);
		$this->load->view('footer');
	}
}
