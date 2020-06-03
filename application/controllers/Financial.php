<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Financial extends CI_Controller
{
    private $title = 'Financial';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['FinancialModel', 'UserModel', 'LeadModel', 'VendorModel', 'FinancialTypesModel', 'FinancialSubtypesModel', 'FinancialAccCodesModel', 'FinancialMethodsModel', 'FinancialBankAccsModel', 'StatesModel']);
        $this->load->library(['pagination', 'form_validation']);

        $this->financial = new FinancialModel();
        $this->user = new UserModel();
        $this->lead = new LeadModel();
        $this->vendor = new VendorModel();
        $this->type = new FinancialTypesModel();
        $this->subtype = new FinancialSubtypesModel();
        $this->accCode = new FinancialAccCodesModel();
        $this->method = new FinancialMethodsModel();
        $this->bankAcc = new FinancialBankAccsModel();
        $this->state = new StatesModel();
    }

    public function index()
    {
        redirect('financial/records');
    }

    public function records()
    {
        authAccess();

        $financials = $this->financial->allFinancialWithLeads();
        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('financial/index', [
            'financials' => $financials
        ]);
        $this->load->view('footer');
    }

    public function create()
    {
        authAccess();

        $jobs = $this->lead->getLeadList();
        $vendors = $this->vendor->getVendorList();
        $types = $this->type->allTypes();
        $subTypes = $this->subtype->allSubtypes();
        $accountingCodes = $this->accCode->allAccCodes();
        $methods = $this->method->allMethods();
        $bankAccounts = $this->bankAcc->allBankAccs();
        $states = $this->state->allStates();

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('financial/create', [
            'jobs' => $jobs,
            'vendors' => $vendors,
            'clients' => $jobs,
            'types' => $types,
            'subTypes' => $subTypes,
            'accountingCodes' => $accountingCodes,
            'methods' => $methods,
            'bankAccounts' => $bankAccounts,
            'states' => $states
        ]);
        $this->load->view('footer');
    }

    public function store()
    {
        authAccess();

        $vendorKeys = implode(',', array_column($this->vendor->getVendorList(), 'id'));
        $jobKeys = implode(',', array_column($this->lead->getLeadList(), 'id'));
        $typeKeys = implode(',', array_column($this->type->allTypes(), 'id'));
        $subtypeKeys = implode(',', array_column($this->subtype->allSubtypes(), 'id'));
        $accountingCodeKeys = implode(',', array_column($this->accCode->allAccCodes(), 'id'));
        $methodKeys = implode(',', array_column($this->method->allMethods(), 'id'));
        $bankAccountKeys = implode(',', array_column($this->bankAcc->allBankAccs(), 'id'));
        $stateKeys = implode(',', array_column($this->state->allStates(), 'id'));

        $this->form_validation->set_rules('party', 'Party', 'trim|required|numeric|in_list[1,2]');
        $this->form_validation->set_rules('vendor_id', 'Party Name', 'trim|numeric|in_list[' . $vendorKeys . ']');
        $this->form_validation->set_rules('client_id', 'Party Name', 'trim|numeric|in_list[' . $jobKeys . ']');
        $this->form_validation->set_rules('transaction_date', 'Transaction Date', 'trim|required');
        $this->form_validation->set_rules('job_id', 'Job', 'trim|required|numeric|in_list[' . $jobKeys . ']');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');
        $this->form_validation->set_rules('type', 'Type', 'trim|required|numeric|in_list[' . $typeKeys . ']');
        $this->form_validation->set_rules('subtype', 'Sub Type', 'trim|required|numeric|in_list[' . $subtypeKeys . ']');
        $this->form_validation->set_rules('accounting_code', 'Accounting Code', 'trim|required|numeric|in_list[' . $accountingCodeKeys . ']');
        $this->form_validation->set_rules('method', 'Method', 'trim|required|numeric|in_list[' . $methodKeys . ']');
        $this->form_validation->set_rules('bank_account', 'Bank Account', 'trim|required|numeric|in_list[' . $bankAccountKeys . ']');
        $this->form_validation->set_rules('state', 'State', 'trim|required|numeric|in_list[' . $stateKeys . ']');
        $this->form_validation->set_rules('notes', 'Notes', 'trim');

        if ($this->form_validation->run() == TRUE) {
            $financialData = $this->input->post();
            $insertData = [
                'party' => $financialData['party'],
                'transaction_date' => $financialData['transaction_date'],
                'job_id' => $financialData['job_id'],
                'amount' => $financialData['amount'],
                'type' => $financialData['type'],
                'subtype' => $financialData['subtype'],
                'accounting_code' => $financialData['accounting_code'],
                'method' => $financialData['method'],
                'bank_account' => $financialData['bank_account'],
                'state' => $financialData['state'],
                'notes' => $financialData['notes']
            ];

            if ($financialData['party'] == 1) {
                $insertData['vendor_id'] = $financialData['vendor_id'];
                $insertData['client_id'] = null;
            } else {
                $insertData['client_id'] = $financialData['client_id'];
                $insertData['vendor_id'] = null;
            }

            $insert = $this->financial->insert($insertData);

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

    public function edit($id)
    {
        authAccess();

        $financial = $this->financial->getFinancialById($id);
        if ($financial) {
            $jobs = $this->lead->getLeadList();
            $types = $this->type->allTypes();
            $subTypes = $this->subtype->allSubtypes();
            $accountingCodes = $this->accCode->allAccCodes();
            $methods = $this->method->allMethods();
            $bankAccounts = $this->bankAcc->allBankAccs();
            $states = $this->state->allStates();

            $this->load->view('header', [
                'title' => $this->title
            ]);
            $this->load->view('financial/edit', [
                'financial' => $financial,
                'jobs' => $jobs,
                'types' => $types,
                'subTypes' => $subTypes,
                'accountingCodes' => $accountingCodes,
                'methods' => $methods,
                'bankAccounts' => $bankAccounts,
                'states' => $states
            ]);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('financial/records');
        }
    }

    public function update($id)
    {
        authAccess();

        $financial = $this->financial->getFinancialById($id);
        if ($financial) {

            $vendorKeys = implode(',', array_column($this->vendor->getVendorList(), 'id'));
            $jobKeys = implode(',', array_column($this->lead->getLeadList(), 'id'));
            $typeKeys = implode(',', array_column($this->type->allTypes(), 'id'));
            $subtypeKeys = implode(',', array_column($this->subtype->allSubtypes(), 'id'));
            $accountingCodeKeys = implode(',', array_column($this->accCode->allAccCodes(), 'id'));
            $methodKeys = implode(',', array_column($this->method->allMethods(), 'id'));
            $bankAccountKeys = implode(',', array_column($this->bankAcc->allBankAccs(), 'id'));
            $stateKeys = implode(',', array_column($this->state->allStates(), 'id'));

            $this->form_validation->set_rules('party', 'Party', 'trim|required|numeric|in_list[1,2]');
            $this->form_validation->set_rules('vendor_id', 'Party Name', 'trim|numeric|in_list[' . $vendorKeys . ']');
            $this->form_validation->set_rules('client_id', 'Party Name', 'trim|numeric|in_list[' . $jobKeys . ']');
            $this->form_validation->set_rules('transaction_date', 'Transaction Date', 'trim|required');
            $this->form_validation->set_rules('job_id', 'Job', 'trim|required|numeric|in_list[' . $jobKeys . ']');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');
            $this->form_validation->set_rules('type', 'Type', 'trim|required|numeric|in_list[' . $typeKeys . ']');
            $this->form_validation->set_rules('subtype', 'Sub Type', 'trim|required|numeric|in_list[' . $subtypeKeys . ']');
            $this->form_validation->set_rules('accounting_code', 'Accounting Code', 'trim|required|numeric|in_list[' . $accountingCodeKeys . ']');
            $this->form_validation->set_rules('method', 'Method', 'trim|required|numeric|in_list[' . $methodKeys . ']');
            $this->form_validation->set_rules('bank_account', 'Bank Account', 'trim|required|numeric|in_list[' . $bankAccountKeys . ']');
            $this->form_validation->set_rules('state', 'State', 'trim|required|numeric|in_list[' . $stateKeys . ']');
            $this->form_validation->set_rules('notes', 'Notes', 'trim');

            if ($this->form_validation->run() == TRUE) {
                $financialData = $this->input->post();
                $updateData = [
                    'party' => $financialData['party'],
                    'transaction_date' => $financialData['transaction_date'],
                    'job_id' => $financialData['job_id'],
                    'amount' => $financialData['amount'],
                    'type' => $financialData['type'],
                    'subtype' => $financialData['subtype'],
                    'accounting_code' => $financialData['accounting_code'],
                    'method' => $financialData['method'],
                    'bank_account' => $financialData['bank_account'],
                    'state' => $financialData['state'],
                    'notes' => $financialData['notes']
                ];

                if ($financialData['party'] == 1) {
                    $updateData['vendor_id'] = $financialData['vendor_id'];
                    $updateData['client_id'] = null;
                } else {
                    $updateData['client_id'] = $financialData['client_id'];
                    $updateData['vendor_id'] = null;
                }

                $update = $this->financial->update($id, $updateData);

                if (!$update) {
                    $this->session->set_flashdata('errors', '<p>Unable to Update Financial Record.</p>');
                }
            } else {
                $this->session->set_flashdata('errors', validation_errors());
            }
            redirect('financial/record/' . $id);
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('financial/records');
        }
    }

    public function show($id)
    {
        authAccess();

        $financial = $this->financial->getFinancialById($id);
        if ($financial) {
            $jobs = $this->lead->getLeadList();
            $vendors = $this->vendor->getVendorList();
            $types = $this->type->allTypes();
            $subTypes = $this->subtype->allSubtypes();
            $accountingCodes = $this->accCode->allAccCodes();
            $methods = $this->method->allMethods();
            $bankAccounts = $this->bankAcc->allBankAccs();
            $states = $this->state->allStates();

            $this->load->view('header', [
                'title' => $this->title
            ]);
            $this->load->view('financial/show', [
                'financial' => $financial,
                'jobs' => $jobs,
                'vendors' => $vendors,
                'clients' => $jobs,
                'types' => $types,
                'subTypes' => $subTypes,
                'accountingCodes' => $accountingCodes,
                'methods' => $methods,
                'bankAccounts' => $bankAccounts,
                'states' => $states
            ]);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('financial/records');
        }
    }

    public function delete($id)
    {
        authAccess();

        $financial = $this->financial->getFinancialById($id);
        if ($financial) {
            $delete = $this->financial->delete($id);
            if (!$delete) {
                $this->session->set_flashdata('errors', '<p>Unable to delete Task.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
        }
        redirect('financial/records');
    }
}
