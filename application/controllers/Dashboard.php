<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model(['LeadModel']);
		$this->lead = new LeadModel();
	}

	public function index()
	{
		authAccess();
		
		$this->load->view('header', ['title' => 'Dashboard']);
		$this->load->view('dashboard/index', [
			'leads' => $this->lead->getLeadsCount(),
			'cashJobs' => $this->lead->getCashJobsCount(),
			'insuranceJobs' => $this->lead->getInsuranceJobsCount(),
			'completedJobs' => $this->lead->getCompletedJobsCount()
		]);
		$this->load->view('footer');
	}
}
