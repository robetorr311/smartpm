<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model(['LeadModel', 'TaskModel', 'DashboardBoxNameModel', 'ActivityLogsModel']);
		$this->lead = new LeadModel();
		$this->task = new TaskModel();
		$this->dashboardBoxName = new DashboardBoxNameModel();
		$this->activityLogs = new ActivityLogsModel();
	}

	public function index()
	{
		authAccess();

		$leadStatusCount = $this->lead->getDashboardStatusCount();
		$taskStatusCount = $this->task->getDashboardStatusCount();
		$boxNames = $this->dashboardBoxName->allNames();

		$this->load->view('header', ['title' => 'Dashboard']);
		$this->load->view('dashboard/index', [
			'newLeads' => $leadStatusCount->new,
			'appointmentScheduledLeads' => $leadStatusCount->appointment_scheduled,
			'followUpLeads' => $leadStatusCount->follow_up,
			'needsSiteVisitLeads' => $leadStatusCount->needs_site_visit,
			'estimateBidLeads' => $leadStatusCount->needs_estimate,
			'estimateSentLeads' => $leadStatusCount->estimate_sent,
			'readyToSignLeads' => $leadStatusCount->ready_to_sign,
			'coldLeads' => $leadStatusCount->cold,
			'postponedLeads' => $leadStatusCount->postponed,
			'lostLeads' => $leadStatusCount->lostLeads,
			'signedJobs' => $leadStatusCount->signed,
			'productionJobs' => $leadStatusCount->production,
			'completedJobs' => $leadStatusCount->completed,
			'closedJobs' => $leadStatusCount->closed,
			'archiveJobs' => $leadStatusCount->archive,
			'punchList' => $leadStatusCount->punchList,
			'createdTasks' => $taskStatusCount->created,
			'workingTasks' => $taskStatusCount->working,
			'stuckTasks' => $taskStatusCount->stuck,
			'holdTasks' => $taskStatusCount->hold,
			'completedTasks' => $taskStatusCount->completed,
			'boxNames' => $boxNames,
			'aLogs' => $this->activityLogs->getLast50()
		]);
		$this->load->view('footer');
	}
}
