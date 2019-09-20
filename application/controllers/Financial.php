<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Financial extends CI_Controller
{
    private $title = 'Financial';

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
            'base_url' => base_url('financial'),
            'total_rows' => $this->lead->getJobsCount(),
            'per_page' => $limit
        ];
        $this->pagination->initialize($pagiConfig);
        $leads = $this->lead->allJobs($start, $limit);
        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('financial/index', [
            'leads' => $leads,
            'pagiLinks' => $this->pagination->create_links()
        ]);
        $this->load->view('footer');
    }

    public function show($jobid)
    {
        authAccess();
        
        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('financial/show', [
            // 'leads' => $leads,
            // 'pagiLinks' => $this->pagination->create_links()
        ]);
        $this->load->view('footer');
    }
}
