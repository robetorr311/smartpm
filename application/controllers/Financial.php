<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Financial extends CI_Controller
{
    private $title = 'Financial';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['FinancialModel', 'UserModel', 'LeadModel', 'VendorModel', 'FinancialSubtypesModel', 'FinancialAccCodesModel', 'FinancialMethodsModel', 'FinancialBankAccsModel', 'StatesModel']);
        $this->load->library(['pagination', 'form_validation', 'pdf']);

        $this->financial = new FinancialModel();
        $this->user = new UserModel();
        $this->lead = new LeadModel();
        $this->vendor = new VendorModel();
        // $this->type = new FinancialTypesModel();
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

        $financials = $this->financial->allFinancials();
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
        $types = FinancialModel::getType();
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
        $typeKeys = implode(',', array_keys(FinancialModel::gettype()));
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
            $types = FinancialModel::getType();
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
            $typeKeys = implode(',', array_keys(FinancialModel::gettype()));
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
            $types = FinancialModel::getType();
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

    public function receipt($id)
    {
        authAccess();

        $financial = $this->financial->getFinancialById($id);
        if ($financial) {
            $client = $this->lead->getLeadById($financial->job_id);
            if ($client) {
                $pdfContent = [];
                $pdfContent[] = '<div style="margin-bottom: 20px;">';
                $pdfContent[] = ($this->session->logoUrl != '') ? '<img width="100" src="' . base_url('assets/company_photo/' . $this->session->logoUrl) . '">' : 'LOGO';
                $pdfContent[] = '</div>';
                $pdfContent[] = '<div style="text-align: center; margin-bottom: 20px;">';
                $pdfContent[] = 'Payment Receipt';
                $pdfContent[] = '</div>';
                $pdfContent[] = '<div style="text-align: right; margin-bottom: 20px;">';
                $pdfContent[] = 'Job Number: ' . (1600 + $client->id) . '<br />';
                $pdfContent[] = 'Date: ' . date('M j, Y', strtotime($financial->transaction_date));
                $pdfContent[] = '</div>';
                $pdfContent[] = '<div style="margin-bottom: 20px;">';
                $pdfContent[] = $client->firstname . ' ' . $client->lastname . '<br />';
                $pdfContent[] = $client->address . '<br />';
                if (!empty($client->address_2)) {
                    $pdfContent[] = $client->address_2 . '<br />';
                }
                $pdfContent[] = $client->city . ', ' . $client->state . ' - ' . $client->zip;
                $pdfContent[] = '</div>';
                $pdfContent[] = '<div style="margin-bottom: 20px;">';
                $pdfContent[] = 'Amount Paid: ' . number_format($financial->amount, 2) . '<br />';
                $pdfContent[] = 'Payment Description: ' . FinancialModel::typeToStr($financial->type);
                $pdfContent[] = '</div>';
                $pdfContent[] = '<div>Financial History</div>';
                $pdfContent[] = '<div>';
                $pdfContent[] = '<table border="1" cellpadding="5" style="border-collapse: collapse;"><tr><th style="width: 120px; background-color: #777777; color: #FFFFFF; text-align: left;">Date</th><th style="width: 295px; background-color: #777777; color: #FFFFFF; text-align: left;">Description</th><th style="width: 120px; background-color: #777777; color: #FFFFFF; text-align: right;">Amount</th></tr>';

                $financials = $this->financial->allFinancialsForReceipt($financial->job_id);
                $balance = 0;
                if (!empty($financials)) {
                    foreach ($financials as $financial) {
                        $pdfContent[] = '<tr>';
                        $pdfContent[] = '<td>' . date('M j, Y', strtotime($financial->transaction_date)) . '</td>';
                        $pdfContent[] = '<td>' . FinancialModel::typeToStr($financial->type) . '</td>';
                        $balance += $financial->amount;
                        if (floatval($financial->amount) < 0) {
                            $pdfContent[] = '<td style="text-align: right; color: #FF0000;">- $' . number_format(abs($financial->amount), 2) . '</td>';
                        } else {
                            $pdfContent[] = '<td style="text-align: right;">$' . number_format($financial->amount, 2) . '</td>';
                        }
                        $pdfContent[] = '</tr>';
                    }
                }
                $pdfContent[] = '<tr>';
                // $pdfContent[] = '<td></td>';
                $pdfContent[] = '<td colspan="2" style="text-align: right; background-color: #DDDDDD;">Open Balance</td>';
                if ($balance < 0) {
                    $pdfContent[] = '<td style="text-align: right; background-color: #DDDDDD; color: #FF0000;">- $' . number_format(abs($balance), 2) . '</td>';
                } else {
                    $pdfContent[] = '<td style="text-align: right; background-color: #DDDDDD;">$' . number_format($balance, 2) . '</td>';
                }
                $pdfContent[] = '</tr>';
                $pdfContent[] = '</table>';
                $pdfContent[] = '</div>';
                $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
                $pdf->SetFontSize(11);
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->SetTitle((1600 + $client->id) . ' ' . $client->firstname . ' ' . $client->lastname . ' Payment Receipt');
                $pdf->AddPage();
                $pdf->writeHTML(implode('', $pdfContent), true, false, true, false, '');
                ob_clean();
                $pdf->Output((1600 + $client->id) . '_' . $client->firstname . '_' . $client->lastname . '_payment_receipt.pdf');
            } else {
                $this->session->set_flashdata('errors', '<p>Client Not Found.</p>');
                redirect('financial/records');
            }
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('financial/records');
        }
    }
}
