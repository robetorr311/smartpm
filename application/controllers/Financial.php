<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Financial extends CI_Controller
{
    private $title = 'Financial';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['FinancialModel', 'UserModel', 'LeadModel', 'FinancialTypesModel', 'FinancialSubtypesModel', 'FinancialAccCodesModel', 'FinancialMethodsModel', 'FinancialBankAccsModel', 'StatesModel']);
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
    public function estimate(){
        authAccess();
        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('financial/estimate');
    }

   public function downloadestimate(){

    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $obj_pdf->SetCreator(PDF_CREATOR);
    $obj_pdf->SetTitle('Thisi is Serena first PDF example');
    $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '',PDF_FONT_SIZE_MAIN));
    $obj_pdf->SetFooterFont(Array(PDF_FONT_NAME_DATA, '',PDF_FONT_SIZE_DATA));
    $obj_pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
    $obj_pdf->SetPrintHeader(false);
    $obj_pdf->SetPrintFooter(false); //true
    $obj_pdf->SetAutoPageBreak(TRUE, 10);
    // $obj_pdf->SetFont('dejavusans', '', 14);
    $obj_pdf->AddPage();

    $content = '
                <h3 align="center"> </h3>
                <table border="" cellspacing="" cellpadding="4">
                    <tr>
                        <th width="25%" align="center"></th>
                        <th width="25%"></th>
                        <th width="10%"></th>
                        <th width="10%"></th>
                        <th width="10%"></th>
                        <th width="40%">Estimate #:1682</th>                           
                    </tr>
                    <tr>
                    <th width="25%" align="center"></th>
                    <th width="25%"></th>
                    <th width="10%"></th>
                    <th width="10%"></th>
                    <th width="10%"></th>
                    <th width="40%"></th>                           
                </tr>
                <tr>
                <th width="25%" align="center"></th>
                <th width="25%"></th>
                <th width="10%"></th>
                <th width="10%"></th>
                <th width="10%"></th>
                <th width="40%"></th>                           
            </tr>
            <tr>
            <th width="25%" align="center"></th>
            <th width="10%"></th>
            <th width="70%"><h4 class="title">ROOFING ESTIMATE</h4></center></th>
            <th width="10%"></th>
            <th width="10%"></th>
            <th width="40%"></th>                           
        </tr>
        <tr>
            <th width="25%" align="left"><h5>Chris Jones</h5>
            17 Mayfair St<br>S Burlington, VT</th>
            <th width="1%"></th>
            <th width="10%"></th>
            <th width="10%"></th>
            <th width="30%"></th>
            <th width="40%">  Date: 04/14/2020
            <br>
            Done By: Brian H.</th>                           
        </tr>
        <tr>
        <th width="25%" align="left"><h5>Main House Only</h5>
        </th>
        <th width="1%"></th>
        <th width="10%"></th>
        <th width="10%"></th>
        <th width="30%"></th>
        <th width="40%"></th>                           
    </tr>     
    <tr style="background-color:rgb(189, 189, 189)">
        <th width="80%" align="left" ><h5>Description</h5>
       </th>      
        <th width="20%"><h5>Total</h5></th>                           
    </tr>     
    <tr>/.
        <th width="90%" align="left"><h5>Remove existing roof and haul off debris</h5>
       </th>
        <th width="10%"></th>                           
    </tr>   
    <tr style="background-color:rgb(189, 189, 189)">
    <th width="100%" align="left" ><h5>Install new asphalt shingles – color specified by customer</h5>
   </th>
</tr> 
<tr>
<th width="90%" align="left"><h5>Install ice and water protectant barrier – perimeter & valleys</h5>
</th>
<th width="10%"></th>                           
</tr> 
<tr style="background-color:rgb(189, 189, 189)">
<th width="100%" align="left" ><h5>Install New Drip Edge Metal</h5>
</th>
                       
</tr> 
<tr>
<th width="90%" align="left"><h5>Shingle Spec: IKO “Dynasty” or Owens Corning “Duration”</h5>
</th>
<th width="10%"></th>                           
</tr> 
<tr style="background-color:rgb(189, 189, 189)">
<th width="100%" align="left" >
</th>               
</tr>
<tr>
<th width="90%" align="left"><h5></h5>
</th>
<th width="10%"></th>                           
</tr> 
<tr style="background-color:rgb(189, 189, 189)">
<th width="100%" align="left" >
</th>               
</tr>   
<tr>
<th  width="60%"></th>
<th width="25%">Subtotal - Garage</th>
<th width="15%" align="left">$3,626.00</th>                           
</tr> 
<tr>
<th  width="55%"></th>
<th width="30%" align="left">Subtotal – Main House</th>
<th width="15%" style="background-color:rgb(189, 189, 189)" align="left">$3,626.00</th>                           
</tr>
<tr>
<th  width="55%"></th>
<th width="30%" align="left"></th>
<th width="15%"></th>                           
</tr> 
<tr>
<th  width="55%" ><p>s3-year labor “no-leak” warranty (Included) Total $15,540.00
Shingles include “Lifetime” manufacturer’s warranty
130 mph wind uplift warranty</p></th>

<th width="30%" align="right">Total</th>
<th width="15%"style="background-color:rgb(189, 189, 189);height:10px;" align="left">$3,626.00</th>                           
</tr> 
<tr>
<th  width="55%"><h3>Thank you for your business!</h3>
<br>Brian H.
<br>info@champlainroofing.com<br>
802.417.9113</th>
<th width="45%" align="right"></th>
</tr> 
<tr>
<br><br><br><br><br>
<th  width="10%"></th>
C h a m p l a i n R o o f i n g , L L C | 145 Pine Haven Shores Rd #1191, Shelburne, VT 05482
i n f o @ c h a m p l a i n r o o f i n g . c o m | 8 0 2 . 4 1 7 . 9 1 1 3
<th width="45%" align="right"></th>
</tr></table>ss';

                    $obj_pdf->WriteHTML($content, true, false, true, false, '');
                    ob_end_clean();

                    $obj_pdf->Output('sample.pdf', 'I');
    
    }
}
