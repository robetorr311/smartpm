<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Financial extends CI_Controller
{
    private $title = 'Financial';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['FinancialModel', 'UserModel', 'LeadModel']);
        $this->load->library(['pagination', 'form_validation']);

        $this->financial = new FinancialModel();
        $this->user = new UserModel();
        $this->lead = new LeadModel();
    }

    public function index()
    {
        redirect('financial/records');
    }

    public function records($start = 0)
    {
        authAccess();

        $limit = 10;
        $pagiConfig = [
            'base_url' => base_url('financial'),
            'total_rows' => $this->financial->getCount(),
            'per_page' => $limit
        ];
        $this->pagination->initialize($pagiConfig);
        $financials = $this->financial->allFinancialWithLeads($start, $limit);
        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('financial/index', [
            'financials' => $financials,
            'pagiLinks' => $this->pagination->create_links()
        ]);
        $this->load->view('footer');
    }

    public function create()
    {
        authAccess();

        $jobs = $this->lead->getLeadList();
        $users = $this->user->getUserList();

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('financial/create', [
            'jobs' => $jobs,
            'types' => $this->financial->types,
            'subTypes' => $this->financial->subTypes,
            'accountingCodes' => $this->financial->accountingCodes,
            'methods' => $this->financial->methods,
            'bankAccounts' => $this->financial->bankAccounts,
            'states' => $this->financial->states,
            'users' => $users
        ]);
        $this->load->view('footer');
    }

    public function store()
    {
        authAccess();

        $this->form_validation->set_rules('transaction_date', 'Transaction Date', 'trim|required');
        $this->form_validation->set_rules('transaction_number', 'Transaction Number', 'trim|required');
        $this->form_validation->set_rules('job_id', 'Job', 'trim|required|numeric');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');
        $this->form_validation->set_rules('type', 'Type', 'trim|required|numeric');
        $this->form_validation->set_rules('subtype', 'Type', 'trim|required|numeric');
        $this->form_validation->set_rules('accounting_code', 'Accounting Code', 'trim|required|numeric');
        $this->form_validation->set_rules('method', 'Method', 'trim|required|numeric');
        $this->form_validation->set_rules('bank_account', 'Bank Account', 'trim|required|numeric');
        $this->form_validation->set_rules('state', 'State', 'trim|required|numeric');
        $this->form_validation->set_rules('sales_rep', 'Sales Representative', 'trim|required|numeric');
        $this->form_validation->set_rules('notes', 'Notes', 'trim');

        if ($this->form_validation->run() == TRUE) {
            $financialData = $this->input->post();
            $insert = $this->financial->insert([
                'transaction_date' => $financialData['transaction_date'],
                'transaction_number' => $financialData['transaction_number'],
                'job_id' => $financialData['job_id'],
                'amount' => $financialData['amount'],
                'type' => $financialData['type'],
                'subtype' => $financialData['subtype'],
                'accounting_code' => $financialData['accounting_code'],
                'method' => $financialData['method'],
                'bank_account' => $financialData['bank_account'],
                'state' => $financialData['state'],
                'sales_rep' => $financialData['sales_rep'],
                'notes' => $financialData['notes']
            ]);

            if ($insert) {
                redirect('financial/record/' . $insert);
            } else {
                $this->session->set_flashdata('errors', '<p>Unable to Create Financial Record.</p>');
                redirect('financial/record/create');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('financial/record/create');
        }
    }

    public function show($id)
    {
        authAccess();

        $financial = $this->financial->getFinancialById($id);

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('financial/show', [
            'financial' => $financial
        ]);
        $this->load->view('footer');
    }
}
