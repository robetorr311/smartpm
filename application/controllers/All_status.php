<?php
defined('BASEPATH') or exit('No direct script access allowed');

class All_status extends CI_Controller
{
	private $title = 'All Status Jobs';

	public function __construct()
	{
		parent::__construct();

		$this->load->model(['LeadModel']);
		$this->load->library(['pagination', 'form_validation']);
		$this->lead = new LeadModel();
	}

	public function index()
	{
		authAccess();

		$jobs = $this->lead->allJobs();
		$this->load->view('header', ['title' => $this->title]);
		$this->load->view('all_status/index', [
			'jobs' => $jobs
		]);
		$this->load->view('footer');
	}
}
