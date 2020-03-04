<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Signed_jobs extends CI_Controller
{
	private $title = 'Signed Jobs';

	public function __construct()
	{
		parent::__construct();

		$this->load->model(['LeadModel']);
		$this->load->library(['form_validation']);
		$this->lead = new LeadModel();
	}

	public function index()
	{
		authAccess();

		$jobs = $this->lead->allSignedJobs();
		$this->load->view('header', ['title' => $this->title]);
		$this->load->view('signed_job/index', [
			'jobs' => $jobs
		]);
		$this->load->view('footer');
	}
}
