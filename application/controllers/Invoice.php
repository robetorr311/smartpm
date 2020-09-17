<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller
{
    private $title = 'Invoice';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['InvoiceModel', 'InvoiceItemModel', 'LeadModel', 'UserModel', 'ItemModel', 'AdminSettingModel', 'ActivityLogsModel', 'AssembliesModel', 'FinancialModel', 'LeadMaterialModel']);
        $this->load->library(['pagination', 'form_validation', 'pdf', 'notify']);

        $this->invoice = new InvoiceModel();
        $this->invoice_items = new InvoiceItemModel();
        $this->lead = new LeadModel();
        $this->user = new UserModel();
        $this->item = new ItemModel();
        $this->admin_setting = new AdminSettingModel();
        $this->activityLogs = new ActivityLogsModel();
        $this->assemblies = new AssembliesModel();
        $this->financial = new FinancialModel();
        $this->lead_material = new LeadMaterialModel();
    }

    public function index($clientId = false, $sub_base_path = '')
    {
        authAccess();

        $o_sub_base_path = $sub_base_path;
        $sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
        $vars = [];
        if ($clientId) {
            $lead = $this->lead->getLeadById($clientId);
            if ($lead) {
                $invoices = $this->invoice->allInvoicesByClientId($clientId);
                $financial_record = $this->financial->getContractDetailsByJobId($clientId);
                $primary_material_info = $this->lead_material->getPrimaryMaterialInfoByLeadId($clientId);
                $contract_price_financials = $this->financial->allContractPriceFinancialsForReceipt($clientId);
                $financials = $this->financial->allFinancialsForReceipt($clientId);
                $vars['lead'] = $lead;
                $vars['financial_record'] = $financial_record;
                $vars['primary_material_info'] = $primary_material_info;
                $vars['contract_price_financials'] = $contract_price_financials;
                $vars['financials'] = $financials;
            } else {
                $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
                redirect($o_sub_base_path != '' ? ('lead/' . $o_sub_base_path . 's') : 'leads');
            }
        } else {
            $invoices = $this->invoice->allInvoices();
        }

        $vars['invoices'] = $invoices;
        $vars['clientId'] = $clientId;
        $vars['sub_base_path'] = $sub_base_path;

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('invoice/index', $vars);
        $this->load->view('footer');
    }

    public function create($clientId = false, $sub_base_path = '')
    {
        authAccess();

        $o_sub_base_path = $sub_base_path;
        $sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
        if ($clientId) {
            $lead = $this->lead->getLeadById($clientId);
            if (!$lead) {
                $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
                redirect($o_sub_base_path != '' ? ('lead/' . $o_sub_base_path . 's') : 'leads');
            }
        }

        $clients = $this->lead->getLeadList();

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('invoice/create', [
            'clients' => $clients,
            'clientId' => $clientId,
            'sub_base_path' => $sub_base_path
        ]);
        $this->load->view('footer');
    }

    public function store($clientId = false, $sub_base_path = '')
    {
        authAccess();

        $o_sub_base_path = $sub_base_path;
        $sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
        if ($clientId) {
            $lead = $this->lead->getLeadById($clientId);
            if (!$lead) {
                $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
                redirect($o_sub_base_path != '' ? ('lead/' . $o_sub_base_path . 's') : 'leads');
            }
        }

        $this->form_validation->set_rules('client_id', 'Client', 'trim|required|numeric');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        if (isset($_POST['items']) && is_array($_POST['items'])) {
            foreach ($_POST['items'] as $id_item => $item) {
                $this->form_validation->set_rules('items[' . $id_item . '][name]', 'Item', 'trim|required');
                $this->form_validation->set_rules('items[' . $id_item . '][amount]', 'Amount', 'trim|required|numeric');
            }
        }

        if ($this->form_validation->run() == TRUE) {
            $invoice = $this->input->post();
            $insert_invoice = $this->invoice->insert([
                'client_id' => $invoice['client_id'],
                'date' => $invoice['date']
            ]);

            if ($insert_invoice) {
                foreach ($invoice['items'] as $invoice_items) {
                    $insert_item = $this->invoice_items->insert([
                        'name' => $invoice_items['name'],
                        'amount' => $invoice_items['amount'],
                        'invoice_id' => $insert_invoice
                    ]);
                }
            } else {
                $this->session->set_flashdata('errors', '<p>Unable to Create Invoice.</p>');
                if ($clientId) {
                    redirect('lead/' . $sub_base_path . $clientId . '/invoice/create');
                } else {
                    redirect('financial/invoice/create');
                }
            }

            if ($clientId) {
                redirect('lead/' . $sub_base_path . $clientId . '/invoices');
            } else {
                redirect('financial/invoices');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
            if ($clientId) {
                redirect('lead/' . $sub_base_path . $clientId . '/invoice/create');
            } else {
                redirect('financial/invoice/create');
            }
        }
    }

    public function update($id, $clientId = false, $sub_base_path = '')
    {
        authAccess();

        $o_sub_base_path = $sub_base_path;
        $sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
        if ($clientId) {
            $lead = $this->lead->getLeadById($clientId);
            if (!$lead) {
                $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
                redirect($o_sub_base_path != '' ? ('lead/' . $o_sub_base_path . 's') : 'leads');
            }
        }

        // $this->form_validation->set_rules('client_id', 'Client Name', 'trim|required|numeric');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        if (isset($_POST['items']) && is_array($_POST['items'])) {
            foreach ($_POST['items'] as $id_item => $item) {
                $this->form_validation->set_rules('items[' . $id_item . '][name]', 'Item', 'trim|required');
                $this->form_validation->set_rules('items[' . $id_item . '][amount]', 'Amount', 'trim|required|numeric');
            }
        }

        if ($this->form_validation->run() == TRUE) {
            if ($clientId) {
                $invoice = $this->invoice->getInvoiceByClientIdAndId($clientId, $id);
            } else {
                $invoice = $this->invoice->getInvoiceById($id);
            }
            if ($invoice) {
                $invoice = $this->input->post();
                $update_invoice = $this->invoice->update($id, [
                    'date' => $invoice['date']
                ]);

                if ($update_invoice) {
                    $exception_ids = array_column($invoice['items'], 'id');
                    $this->invoice_items->deleteByInvoiceIdWithExceptionIds($id, $exception_ids);
                    foreach ($invoice['items'] as $invoice_item) {
                        if (isset($invoice_item['id'])) {
                            $update_item = $this->invoice_items->update($invoice_item['id'], [
                                'name' => $invoice_item['name'],
                                'amount' => $invoice_item['amount']
                            ]);
                        } else {
                            $insert_item = $this->invoice_items->insert([
                                'name' => $invoice_item['name'],
                                'amount' => $invoice_item['amount'],
                                'invoice_id' => $id
                            ]);
                        }
                    }
                } else {
                    $this->session->set_flashdata('errors', '<p>Unable to Update Invoice.</p>');
                }
            } else {
                $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
        }

        if ($clientId) {
            redirect('lead/' . $sub_base_path . $clientId . '/invoice/' . $id);
        } else {
            redirect('financial/invoice/' . $id);
        }
    }

    public function show($id, $clientId = false, $sub_base_path = '')
    {
        authAccess();

        $o_sub_base_path = $sub_base_path;
        $sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
        $vars = [];
        if ($clientId) {
            $lead = $this->lead->getLeadById($clientId);
            if ($lead) {
                $invoice = $this->invoice->getInvoiceByClientIdAndId($clientId, $id);
                $financial_record = $this->financial->getContractDetailsByJobId($clientId);
                $primary_material_info = $this->lead_material->getPrimaryMaterialInfoByLeadId($clientId);
                $contract_price_financials = $this->financial->allContractPriceFinancialsForReceipt($clientId);
                $financials = $this->financial->allFinancialsForReceipt($clientId);
                $vars['lead'] = $lead;
                $vars['financial_record'] = $financial_record;
                $vars['primary_material_info'] = $primary_material_info;
                $vars['contract_price_financials'] = $contract_price_financials;
                $vars['financials'] = $financials;
            } else {
                $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
                redirect($o_sub_base_path != '' ? ('lead/' . $o_sub_base_path . 's') : 'leads');
            }
        } else {
            $invoice = $this->invoice->getInvoiceById($id);
        }

        if ($invoice) {
            $invoice_items = $this->invoice_items->allInvoiceItemsById($id);
            $clients = $this->lead->getLeadList();

            $vars['invoice'] = $invoice;
            $vars['invoice_items'] = $invoice_items;
            $vars['clients'] = $clients;
            $vars['clientId'] = $clientId;
            $vars['sub_base_path'] = $sub_base_path;

            $this->load->view('header', [
                'title' => $this->title
            ]);
            $this->load->view('invoice/show', $vars);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            if ($clientId) {
                redirect('lead/' . $sub_base_path . $clientId . '/invoices');
            } else {
                redirect('financial/invoices');
            }
        }
    }

    public function delete($id, $clientId = false, $sub_base_path = '')
    {
        authAccess();

        $o_sub_base_path = $sub_base_path;
        $sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
        if ($clientId) {
            $lead = $this->lead->getLeadById($clientId);
            if ($lead) {
                $invoice = $this->invoice->getInvoiceByClientIdAndId($clientId, $id);
            } else {
                $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
                redirect($o_sub_base_path != '' ? ('lead/' . $o_sub_base_path . 's') : 'leads');
            }
        } else {
            $invoice = $this->invoice->getInvoiceById($id);
        }

        if ($invoice) {
            $this->invoice_items->deleteByInvoiceId($id);
            $delete = $this->invoice->delete($id);

            if (!$delete) {
                $this->session->set_flashdata('errors', '<p>Unable to Delete Invoice.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
        }

        if ($clientId) {
            redirect('lead/' . $sub_base_path . $clientId . '/invoices');
        } else {
            redirect('financial/invoices');
        }
    }

    public function pdf($id, $clientId = false, $sub_base_path = '')
    {
        authAccess();

        $o_sub_base_path = $sub_base_path;
        $sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
        if ($clientId) {
            $lead = $this->lead->getLeadById($clientId);
            if ($lead) {
                $invoice = $this->invoice->getInvoiceByClientIdAndId($clientId, $id);
            } else {
                $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
                redirect($o_sub_base_path != '' ? ('lead/' . $o_sub_base_path . 's') : 'leads');
            }
        } else {
            $invoice = $this->invoice->getInvoiceById($id);
        }

        if ($invoice) {
            $invoice_items = $this->invoice_items->allInvoiceItemsById($id);
            $contract_price_financials = $this->financial->allContractPriceFinancialsForReceipt($invoice->client_id);
            $financials = $this->financial->allFinancialsForReceipt($invoice->client_id);
            $created_by_user = $this->user->getUserById($invoice->created_by);
            $client = $this->lead->getLeadById($invoice->client_id);
            $admin_conf = $this->admin_setting->getAdminSetting();

            $pdfContent = [];

            $pdfContent[] = '<div>';
            $pdfContent[] = '<table><tr>';
            $pdfContent[] = '<td width="150" rowspan="2">' . (($this->session->logoUrl != '') ? '<img width="100" src="' . base_url('assets/company_photo/' . $this->session->logoUrl) . '">' : 'LOGO') . '</td>';
            $pdfContent[] = '<td width="389" align="right"><br /><br />Invoice #: ' . $invoice->id . '<br />Date: ' . date('M j, Y', strtotime($invoice->date)) . '</td>';
            $pdfContent[] = '</tr><tr>';
            $pdfContent[] = '<td><b>' . $invoice->client_name . '</b><br />';
            $pdfContent[] = $client->address . '<br />';
            if (!empty($client->address_2)) {
                $pdfContent[] = $client->address_2 . '<br />';
            }
            $pdfContent[] = $client->city . ', ' . $client->state . ' - ' . $client->zip;
            $pdfContent[] = '</td>';
            $pdfContent[] = '</tr></table>';
            $pdfContent[] = '</div>';
            $pdfContent[] = '<div style="text-align: center;"><b>INVOICE</b></div>';
            $pdfContent[] = '<div>';
            $pdfContent[] = '<table cellspacing="0" cellpadding="5"><tr style="background-color: #333; color: #FFF;"><th width="458">Item</th><th width="80" align="right">Amount</th></tr>';

            $total = 0;
            $background = false;
            foreach ($invoice_items as $invoice_item) {
                $pdfContent[] = '<tr' . ($background ? ' style="background-color: #EEE;"' : '') . '><td>' . $invoice_item->name . '</td>';
                $pdfContent[] = '<td align="right">$' . number_format($invoice_item->amount, 2) . '</td></tr>';
                $total += $invoice_item->amount;
                $background = !$background;
            }
            $pdfContent[] = '<tr' . ($background ? ' style="background-color: #EEE;"' : '') . '><td align="right">Invoice Balance Due:</td><td align="right">$' . number_format($total, 2) . '</td></tr></table>';
            $pdfContent[] = '</div>';
            $pdfContent[] = '<div>';
            $pdfContent[] = '<p><b>Financial Summary (Does not include this Invoice)</b></p>';
            $pdfContent[] = '<table width="262">';
            $balance = 0;
            if (!empty($contract_price_financials)) {
                foreach ($contract_price_financials as $financial) {
                    $balance += $financial->amount;
                    $pdfContent[] = '<tr>';
                    $pdfContent[] = '<td>' . FinancialModel::typeToStr($financial->type) . '</td>';
                    $pdfContent[] = '<td style="text-align: right;"><b>' . (floatval($financial->amount) < 0 ? '- $' . number_format(abs($financial->amount), 2) : '$' . number_format($financial->amount, 2)) . '</b></td>';
                    $pdfContent[] = '</tr>';
                }
            } else {
                $pdfContent[] = '<tr>';
                $pdfContent[] = '<td>' . FinancialModel::typeToStr(5) . '</td>';
                $pdfContent[] = '<td style="text-align: right;"><b>$0.00</b></td>';
                $pdfContent[] = '</tr>';
            }
            foreach ($financials as $financial) {
                $balance += $financial->amount;
                $pdfContent[] = '<tr>';
                $pdfContent[] = '<td>' . FinancialModel::typeToStr($financial->type) . '</td>';
                $pdfContent[] = '<td style="text-align: right;"><b>' . (floatval($financial->amount) < 0 ? '- $' . number_format(abs($financial->amount), 2) : '$' . number_format($financial->amount, 2)) . '</b></td>';
                $pdfContent[] = '</tr>';
            }
            $pdfContent[] = '<tr>';
            $pdfContent[] = '<td>Balance Due</td>';
            $pdfContent[] = '<td style="text-align: right; border-top: solid 1px #000;"><b>' . (floatval($balance) < 0 ? '- $' . number_format(abs($balance), 2) : '$' . number_format($balance, 2)) . '</b></td>';
            $pdfContent[] = '</tr>';
            $pdfContent[] = '</table>';
            $pdfContent[] = '</div>';
            $pdfThankYouContent[] = '<p> </p>';
            $pdfThankYouContent[] = '<div>';
            $pdfThankYouContent[] = '<table width="230" cellpadding="5" style="background-color: #DDD;"><tr><td style="border-left: solid 2px #0e2163; font-size: 9px; line-height: 18px;">';
            $pdfThankYouContent[] = '<b>Thank you for your business!</b><br />';
            $pdfThankYouContent[] = $invoice->created_user . '<br />';
            $pdfThankYouContent[] = $created_by_user->email_id . '<br />';
            $pdfThankYouContent[] = $created_by_user->office_phone;
            $pdfThankYouContent[] = '</td></tr></table>';
            $pdfThankYouContent[] = '</div>';

            // echo implode('', $pdfContent);
            // die();

            // $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf = new Pdf();
            $pdf->SetAutoPageBreak(TRUE, 27);
            $pdf->SetFontSize(11);
            $pdf->setCompanyData($admin_conf->company_name, $admin_conf->company_address, $admin_conf->company_email, $admin_conf->company_phone);
            $pdf->setPrintHeader(false);
            // $pdf->setPrintFooter(false);
            $pdf->AddPage();
            $pdf->writeHTML(implode('', $pdfContent), true, false, true, false, '');
            $pdf->keepTogether(35);
            $pdf->writeHTML(implode('', $pdfThankYouContent), true, false, true, false, '');
            ob_clean();
            $pdf->Output('invoice.pdf');
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            if ($clientId) {
                redirect('lead/' . $sub_base_path . $clientId . '/invoices');
            } else {
                redirect('financial/invoices');
            }
        }
    }

    public function savePDF($id, $clientId = false, $sub_base_path = '')
    {
        authAccess();

        $o_sub_base_path = $sub_base_path;
        $sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
        if ($clientId) {
            $lead = $this->lead->getLeadById($clientId);
            if ($lead) {
                $invoice = $this->invoice->getInvoiceByClientIdAndId($clientId, $id);
            } else {
                $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
                redirect($o_sub_base_path != '' ? ('lead/' . $o_sub_base_path . 's') : 'leads');
            }
        } else {
            $invoice = $this->invoice->getInvoiceById($id);
        }

        if ($invoice) {
            $invoice_items = $this->invoice_items->allInvoiceItemsById($id);
            $contract_price_financials = $this->financial->allContractPriceFinancialsForReceipt($invoice->client_id);
            $financials = $this->financial->allFinancialsForReceipt($invoice->client_id);
            $created_by_user = $this->user->getUserById($invoice->created_by);
            $client = $this->lead->getLeadById($invoice->client_id);
            $admin_conf = $this->admin_setting->getAdminSetting();

            $pdfContent = [];

            $pdfContent[] = '<div>';
            $pdfContent[] = '<table><tr>';
            $pdfContent[] = '<td width="150" rowspan="2">' . (($this->session->logoUrl != '') ? '<img width="100" src="' . base_url('assets/company_photo/' . $this->session->logoUrl) . '">' : 'LOGO') . '</td>';
            $pdfContent[] = '<td width="389" align="right"><br /><br />Invoice #: ' . $invoice->id . '<br />Date: ' . date('M j, Y', strtotime($invoice->date)) . '</td>';
            $pdfContent[] = '</tr><tr>';
            $pdfContent[] = '<td><b>' . $invoice->client_name . '</b><br />';
            $pdfContent[] = $client->address . '<br />';
            if (!empty($client->address_2)) {
                $pdfContent[] = $client->address_2 . '<br />';
            }
            $pdfContent[] = $client->city . ', ' . $client->state . ' - ' . $client->zip;
            $pdfContent[] = '</td>';
            $pdfContent[] = '</tr></table>';
            $pdfContent[] = '</div>';
            $pdfContent[] = '<div style="text-align: center;"><b>INVOICE</b></div>';
            $pdfContent[] = '<div>';
            $pdfContent[] = '<table cellspacing="0" cellpadding="5"><tr style="background-color: #333; color: #FFF;"><th width="458">Item</th><th width="80" align="right">Amount</th></tr>';

            $total = 0;
            $background = false;
            foreach ($invoice_items as $invoice_item) {
                $pdfContent[] = '<tr' . ($background ? ' style="background-color: #EEE;"' : '') . '><td>' . $invoice_item->name . '</td>';
                $pdfContent[] = '<td align="right">$' . number_format($invoice_item->amount, 2) . '</td></tr>';
                $total += $invoice_item->amount;
                $background = !$background;
            }
            $pdfContent[] = '<tr' . ($background ? ' style="background-color: #EEE;"' : '') . '><td align="right">Invoice Balance Due:</td><td align="right">$' . number_format($total, 2) . '</td></tr></table>';
            $pdfContent[] = '</div>';
            $pdfContent[] = '<div>';
            $pdfContent[] = '<p><b>Financial Summary (Does not include this Invoice)</b></p>';
            $pdfContent[] = '<table width="262">';
            $balance = 0;
            if (!empty($contract_price_financials)) {
                foreach ($contract_price_financials as $financial) {
                    $balance += $financial->amount;
                    $pdfContent[] = '<tr>';
                    $pdfContent[] = '<td>' . FinancialModel::typeToStr($financial->type) . '</td>';
                    $pdfContent[] = '<td style="text-align: right;"><b>' . (floatval($financial->amount) < 0 ? '- $' . number_format(abs($financial->amount), 2) : '$' . number_format($financial->amount, 2)) . '</b></td>';
                    $pdfContent[] = '</tr>';
                }
            } else {
                $pdfContent[] = '<tr>';
                $pdfContent[] = '<td>' . FinancialModel::typeToStr(5) . '</td>';
                $pdfContent[] = '<td style="text-align: right;"><b>$0.00</b></td>';
                $pdfContent[] = '</tr>';
            }
            foreach ($financials as $financial) {
                $balance += $financial->amount;
                $pdfContent[] = '<tr>';
                $pdfContent[] = '<td>' . FinancialModel::typeToStr($financial->type) . '</td>';
                $pdfContent[] = '<td style="text-align: right;"><b>' . (floatval($financial->amount) < 0 ? '- $' . number_format(abs($financial->amount), 2) : '$' . number_format($financial->amount, 2)) . '</b></td>';
                $pdfContent[] = '</tr>';
            }
            $pdfContent[] = '<tr>';
            $pdfContent[] = '<td>Balance Due</td>';
            $pdfContent[] = '<td style="text-align: right; border-top: solid 1px #000;"><b>' . (floatval($balance) < 0 ? '- $' . number_format(abs($balance), 2) : '$' . number_format($balance, 2)) . '</b></td>';
            $pdfContent[] = '</tr>';
            $pdfContent[] = '</table>';
            $pdfContent[] = '</div>';
            $pdfThankYouContent[] = '<p> </p>';
            $pdfThankYouContent[] = '<div>';
            $pdfThankYouContent[] = '<table width="230" cellpadding="5" style="background-color: #DDD;"><tr><td style="border-left: solid 2px #0e2163; font-size: 9px; line-height: 18px;">';
            $pdfThankYouContent[] = '<b>Thank you for your business!</b><br />';
            $pdfThankYouContent[] = $invoice->created_user . '<br />';
            $pdfThankYouContent[] = $created_by_user->email_id . '<br />';
            $pdfThankYouContent[] = $created_by_user->office_phone;
            $pdfThankYouContent[] = '</td></tr></table>';
            $pdfThankYouContent[] = '</div>';

            // echo implode('', $pdfContent);
            // die();

            // $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf = new Pdf();
            $pdf->SetAutoPageBreak(TRUE, 27);
            $pdf->SetFontSize(11);
            $pdf->setCompanyData($admin_conf->company_name, $admin_conf->company_address, $admin_conf->company_email, $admin_conf->company_phone);
            $pdf->setPrintHeader(false);
            // $pdf->setPrintFooter(false);
            $pdf->AddPage();
            $pdf->writeHTML(implode('', $pdfContent), true, false, true, false, '');
            $pdf->keepTogether(35);
            $pdf->writeHTML(implode('', $pdfThankYouContent), true, false, true, false, '');
            ob_clean();
            // ============== save to job_doc folder ==============
            $tmp_i = 1;
            $new_name = 'Invoice ' . $invoice->id . ' - ' . $invoice->client_name . '.pdf';
            $targetPath = FCPATH . "assets/job_doc/" . $new_name;
            while (file_exists($targetPath)) {
                $new_name = 'Invoice ' . $invoice->id . ' - ' . $invoice->client_name . '_' . $tmp_i . '.pdf';
                $targetPath = FCPATH . "assets/job_doc/" . $new_name;
                $tmp_i++;
            }
            $pdf->Output($targetPath, 'F');
            // ============== save to jobs_doc database table ==============
            $search = '.' . strtolower(pathinfo($new_name, PATHINFO_EXTENSION));
            $trimmed = str_replace($search, '', $new_name);
            $params = array();
            $params['job_id'] = $invoice->client_id;
            $params['doc_name'] = $new_name;
            $params['name'] = $trimmed;
            $params['entry_date'] = date('Y-m-d h:i:s');
            $params['is_active'] = TRUE;
            $this->db->insert('jobs_doc', $params);
            $al_insert = $this->activityLogs->insert([
                'module' => 0,
                'module_id' => $invoice->client_id,
                'type' => 3
            ]);
            $this->session->set_flashdata('errors', '<p>PDF Saved.</p>');

            if ($clientId) {
                redirect('lead/' . $sub_base_path . $clientId . '/invoice/' . $id);
            } else {
                redirect('financial/invoice/' . $id);
            }
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            if ($clientId) {
                redirect('lead/' . $sub_base_path . $clientId . '/invoices');
            } else {
                redirect('financial/invoices');
            }
        }
    }

    public function sendPDF($id, $clientId = false, $sub_base_path = '')
    {
        authAccess();

        $o_sub_base_path = $sub_base_path;
        $sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
        if ($clientId) {
            $lead = $this->lead->getLeadById($clientId);
            if ($lead) {
                $invoice = $this->invoice->getInvoiceByClientIdAndId($clientId, $id);
            } else {
                $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
                redirect($o_sub_base_path != '' ? ('lead/' . $o_sub_base_path . 's') : 'leads');
            }
        } else {
            $invoice = $this->invoice->getInvoiceById($id);
        }

        if ($invoice) {
            $invoice_items = $this->invoice_items->allInvoiceItemsById($id);
            $contract_price_financials = $this->financial->allContractPriceFinancialsForReceipt($invoice->client_id);
            $financials = $this->financial->allFinancialsForReceipt($invoice->client_id);
            $created_by_user = $this->user->getUserById($invoice->created_by);
            $client = $this->lead->getLeadById($invoice->client_id);
            $admin_conf = $this->admin_setting->getAdminSetting();

            $pdfContent = [];

            $pdfContent[] = '<div>';
            $pdfContent[] = '<table><tr>';
            $pdfContent[] = '<td width="150" rowspan="2">' . (($this->session->logoUrl != '') ? '<img width="100" src="' . base_url('assets/company_photo/' . $this->session->logoUrl) . '">' : 'LOGO') . '</td>';
            $pdfContent[] = '<td width="389" align="right"><br /><br />Invoice #: ' . $invoice->id . '<br />Date: ' . date('M j, Y', strtotime($invoice->date)) . '</td>';
            $pdfContent[] = '</tr><tr>';
            $pdfContent[] = '<td><b>' . $invoice->client_name . '</b><br />';
            $pdfContent[] = $client->address . '<br />';
            if (!empty($client->address_2)) {
                $pdfContent[] = $client->address_2 . '<br />';
            }
            $pdfContent[] = $client->city . ', ' . $client->state . ' - ' . $client->zip;
            $pdfContent[] = '</td>';
            $pdfContent[] = '</tr></table>';
            $pdfContent[] = '</div>';
            $pdfContent[] = '<div style="text-align: center;"><b>INVOICE</b></div>';
            $pdfContent[] = '<div>';
            $pdfContent[] = '<table cellspacing="0" cellpadding="5"><tr style="background-color: #333; color: #FFF;"><th width="458">Item</th><th width="80" align="right">Amount</th></tr>';

            $total = 0;
            $background = false;
            foreach ($invoice_items as $invoice_item) {
                $pdfContent[] = '<tr' . ($background ? ' style="background-color: #EEE;"' : '') . '><td>' . $invoice_item->name . '</td>';
                $pdfContent[] = '<td align="right">$' . number_format($invoice_item->amount, 2) . '</td></tr>';
                $total += $invoice_item->amount;
                $background = !$background;
            }
            $pdfContent[] = '<tr' . ($background ? ' style="background-color: #EEE;"' : '') . '><td align="right">Invoice Balance Due:</td><td align="right">$' . number_format($total, 2) . '</td></tr></table>';
            $pdfContent[] = '</div>';
            $pdfContent[] = '<div>';
            $pdfContent[] = '<p><b>Financial Summary (Does not include this Invoice)</b></p>';
            $pdfContent[] = '<table width="262">';
            $balance = 0;
            if (!empty($contract_price_financials)) {
                foreach ($contract_price_financials as $financial) {
                    $balance += $financial->amount;
                    $pdfContent[] = '<tr>';
                    $pdfContent[] = '<td>' . FinancialModel::typeToStr($financial->type) . '</td>';
                    $pdfContent[] = '<td style="text-align: right;"><b>' . (floatval($financial->amount) < 0 ? '- $' . number_format(abs($financial->amount), 2) : '$' . number_format($financial->amount, 2)) . '</b></td>';
                    $pdfContent[] = '</tr>';
                }
            } else {
                $pdfContent[] = '<tr>';
                $pdfContent[] = '<td>' . FinancialModel::typeToStr(5) . '</td>';
                $pdfContent[] = '<td style="text-align: right;"><b>$0.00</b></td>';
                $pdfContent[] = '</tr>';
            }
            foreach ($financials as $financial) {
                $balance += $financial->amount;
                $pdfContent[] = '<tr>';
                $pdfContent[] = '<td>' . FinancialModel::typeToStr($financial->type) . '</td>';
                $pdfContent[] = '<td style="text-align: right;"><b>' . (floatval($financial->amount) < 0 ? '- $' . number_format(abs($financial->amount), 2) : '$' . number_format($financial->amount, 2)) . '</b></td>';
                $pdfContent[] = '</tr>';
            }
            $pdfContent[] = '<tr>';
            $pdfContent[] = '<td>Balance Due</td>';
            $pdfContent[] = '<td style="text-align: right; border-top: solid 1px #000;"><b>' . (floatval($balance) < 0 ? '- $' . number_format(abs($balance), 2) : '$' . number_format($balance, 2)) . '</b></td>';
            $pdfContent[] = '</tr>';
            $pdfContent[] = '</table>';
            $pdfContent[] = '</div>';
            $pdfThankYouContent[] = '<p> </p>';
            $pdfThankYouContent[] = '<div>';
            $pdfThankYouContent[] = '<table width="230" cellpadding="5" style="background-color: #DDD;"><tr><td style="border-left: solid 2px #0e2163; font-size: 9px; line-height: 18px;">';
            $pdfThankYouContent[] = '<b>Thank you for your business!</b><br />';
            $pdfThankYouContent[] = $invoice->created_user . '<br />';
            $pdfThankYouContent[] = $created_by_user->email_id . '<br />';
            $pdfThankYouContent[] = $created_by_user->office_phone;
            $pdfThankYouContent[] = '</td></tr></table>';
            $pdfThankYouContent[] = '</div>';

            // echo implode('', $pdfContent);
            // die();

            // $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf = new Pdf();
            $pdf->SetAutoPageBreak(TRUE, 27);
            $pdf->SetFontSize(11);
            $pdf->setCompanyData($admin_conf->company_name, $admin_conf->company_address, $admin_conf->company_email, $admin_conf->company_phone);
            $pdf->setPrintHeader(false);
            // $pdf->setPrintFooter(false);
            $pdf->AddPage();
            $pdf->writeHTML(implode('', $pdfContent), true, false, true, false, '');
            $pdf->keepTogether(35);
            $pdf->writeHTML(implode('', $pdfThankYouContent), true, false, true, false, '');
            ob_clean();
            // ============== save to job_doc folder ==============
            $tmp_i = 1;
            $new_name = 'Invoice ' . $invoice->id . ' - ' . $invoice->client_name . '.pdf';
            $targetPath = FCPATH . "assets/job_doc/" . $new_name;
            while (file_exists($targetPath)) {
                $new_name = 'Invoice ' . $invoice->id . ' - ' . $invoice->client_name . '_' . $tmp_i . '.pdf';
                $targetPath = FCPATH . "assets/job_doc/" . $new_name;
                $tmp_i++;
            }
            $pdf->Output($targetPath, 'F');
            // ============== save to jobs_doc database table ==============
            // $search = '.' . strtolower(pathinfo($new_name, PATHINFO_EXTENSION));
            // $trimmed = str_replace($search, '', $new_name);
            // $params = array();
            // $params['job_id'] = $invoice->client_id;
            // $params['doc_name'] = $new_name;
            // $params['name'] = $trimmed;
            // $params['entry_date'] = date('Y-m-d h:i:s');
            // $params['is_active'] = TRUE;
            // $this->db->insert('jobs_doc', $params);
            $al_insert = $this->activityLogs->insert([
                'module' => 0,
                'module_id' => $invoice->client_id,
                'type' => 11,
                'activity_data' => json_encode([
                    'invoie_id' => $id
                ])
            ]);
            $this->session->set_flashdata('errors', '<p>Invoie PDF Sent.</p>');

            // ============== Send Email ==============
            $this->notify = new Notify();
            $this->notify->sendInvoice($client->email, $invoice->client_name, $invoice->created_user, $targetPath);
            // ============== Send Email ==============
            
            // ============== Delete PDF ==============
            unlink($targetPath);

            if ($clientId) {
                redirect('lead/' . $sub_base_path . $clientId . '/invoice/' . $id);
            } else {
                redirect('financial/invoice/' . $id);
            }
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            if ($clientId) {
                redirect('lead/' . $sub_base_path . $clientId . '/invoices');
            } else {
                redirect('financial/invoices');
            }
        }
    }
}
