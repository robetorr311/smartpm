<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Financial extends CI_Controller
{
    private $title = 'Financial';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['FinancialModel', 'UserModel', 'LeadModel', 'FinancialTypesModel', 'FinancialSubtypesModel', 'FinancialAccCodesModel', 'FinancialMethodsModel', 'FinancialBankAccsModel', 'StatesModel','ItemsModel']);
        $this->load->library(['pagination', 'form_validation','Pdf']);

        $this->financial = new FinancialModel();
        $this->user = new UserModel();
        $this->lead = new LeadModel();
        $this->type = new FinancialTypesModel();
        $this->subtype = new FinancialSubtypesModel();
        $this->accCode = new FinancialAccCodesModel();
        $this->method = new FinancialMethodsModel();
        $this->bankAcc = new FinancialBankAccsModel();
        $this->state = new StatesModel();
        $this->items = new ItemsModel();
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

        $jobKeys = implode(',', array_column($this->lead->getLeadList(), 'id'));
        $typeKeys = implode(',', array_column($this->type->allTypes(), 'id'));
        $subtypeKeys = implode(',', array_column($this->subtype->allSubtypes(), 'id'));
        $accountingCodeKeys = implode(',', array_column($this->accCode->allAccCodes(), 'id'));
        $methodKeys = implode(',', array_column($this->method->allMethods(), 'id'));
        $bankAccountKeys = implode(',', array_column($this->bankAcc->allBankAccs(), 'id'));
        $stateKeys = implode(',', array_column($this->state->allStates(), 'id'));

        $this->form_validation->set_rules('vendor', 'Vendor / Payee', 'trim|required');
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
            $insert = $this->financial->insert([
                'vendor' => $financialData['vendor'],
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

            $jobKeys = implode(',', array_column($this->lead->getLeadList(), 'id'));
            $typeKeys = implode(',', array_column($this->type->allTypes(), 'id'));
            $subtypeKeys = implode(',', array_column($this->subtype->allSubtypes(), 'id'));
            $accountingCodeKeys = implode(',', array_column($this->accCode->allAccCodes(), 'id'));
            $methodKeys = implode(',', array_column($this->method->allMethods(), 'id'));
            $bankAccountKeys = implode(',', array_column($this->bankAcc->allBankAccs(), 'id'));
            $stateKeys = implode(',', array_column($this->state->allStates(), 'id'));

            $this->form_validation->set_rules('vendor', 'Vendor / Payee', 'trim|required');
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
                $update = $this->financial->update($id, [
                    'vendor' => $financialData['vendor'],
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
                ]);

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
    
    public function itemindex()
    {
        authAccess();
        $items = $this->items->allItems();
        $this->load->view('header', ['title' => $this->title]);
        $this->load->view('financial/items', [
            'items' => $items
        ]);
        $this->load->view('footer');
    }

    public function createitem()
    {
        authAccess();
        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('financial/itemcreate');
        $this->load->view('footer');
    }

    public function storeitem()
    {   
        authAccess();

        $this->form_validation->set_rules('item_name', 'Item Display Name', 'trim|required');
        $this->form_validation->set_rules('item_line', 'Item Line/ Style / Type', 'trim|required');
        $this->form_validation->set_rules('internal_parts', 'Internal Part', 'trim|required');
        $this->form_validation->set_rules('quantity_units', 'Quantity Units', 'trim|required|numeric');
        $this->form_validation->set_rules('unit_price', 'Unit Price', 'trim|required|numeric');
        $this->form_validation->set_rules('item_desc', 'item_desc', 'trim');

        if ($this->form_validation->run() == TRUE) {
            $itemsData = $this->input->post();
            $insert = $this->items->insert([
                'item_name' => $itemsData['item_name'],
                'item_type' => $itemsData['item_line'],
                'internal_part' => $itemsData['internal_parts'],
                'quantity_units' => $itemsData['quantity_units'],
                'unit_price' => $itemsData['unit_price'],
                'item_description' => $itemsData['item_desc']
            ]);

            if ($insert) {
                redirect('financial/items');
            } else {
                $this->session->set_flashdata('errors', '<p>Unable to Create items.</p>');
                redirect('financial/items/create');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('financial/items/create');
        }
    }
}
