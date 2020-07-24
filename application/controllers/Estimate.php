<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Estimate extends CI_Controller
{
    private $title = 'Estimate';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['EstimateModel', 'EstimateDescriptionGroupModel', 'EstimateDescriptionModel', 'LeadModel', 'UserModel', 'ItemModel', 'AdminSettingModel', 'ActivityLogsModel']);
        $this->load->library(['pagination', 'form_validation', 'pdf']);

        $this->estimate = new EstimateModel();
        $this->estimate_desc_group = new EstimateDescriptionGroupModel();
        $this->estimate_desc = new EstimateDescriptionModel();
        $this->lead = new LeadModel();
        $this->user = new UserModel();
        $this->item = new ItemModel();
        $this->admin_setting = new AdminSettingModel();
        $this->activityLogs = new ActivityLogsModel();
    }

    public function index()
    {
        authAccess();

        $estimates = $this->estimate->allEstimates();
        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('estimate/index', [
            'estimates' => $estimates
        ]);
        $this->load->view('footer');
    }

    public function create()
    {
        authAccess();

        $clients = $this->lead->getLeadList();
        $items = $this->item->getItemList();

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('estimate/create', [
            'clients' => $clients,
            'items' => $items
        ]);
        $this->load->view('footer');
    }

    public function store()
    {
        authAccess();

        $this->form_validation->set_rules('client_id', 'Client Name', 'trim|required|numeric');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        if (isset($_POST['desc_group']) && is_array($_POST['desc_group'])) {
            foreach ($_POST['desc_group'] as $id_desc_group => $desc_group) {
                $this->form_validation->set_rules('desc_group[' . $id_desc_group . '][sub_title]', 'Sub Title', 'trim|required');
                unset($desc_group['sub_title']);
                foreach ($desc_group as $id_desc => $desc) {
                    $this->form_validation->set_rules('desc_group[' . $id_desc_group . '][' . $id_desc . '][item]', 'item', 'trim|required');
                    $this->form_validation->set_rules('desc_group[' . $id_desc_group . '][' . $id_desc . '][amount]', 'Amount', 'trim|numeric');
                }
            }
        }

        if ($this->form_validation->run() == TRUE) {
            $estimate = $this->input->post();
            $insert_estimate = $this->estimate->insert([
                'client_id' => $estimate['client_id'],
                'date' => $estimate['date'],
                'title' => $estimate['title'],
                'note' => $estimate['note']
            ]);

            if ($insert_estimate) {
                foreach ($estimate['desc_group'] as $desc_group) {
                    $insert_desc_group = $this->estimate_desc_group->insert([
                        'sub_title' => $desc_group['sub_title'],
                        'estimate_id' => $insert_estimate
                    ]);

                    if ($insert_desc_group) {
                        unset($desc_group['sub_title']);
                        foreach ($desc_group as $desc) {
                            $insert_desc = $this->estimate_desc->insert([
                                'item' => $desc['item'],
                                'amount' => empty($desc['amount']) ? NULL : $desc['amount'],
                                'description_group_id' => $insert_desc_group
                            ]);
                        }
                    }
                }
            } else {
                $this->session->set_flashdata('errors', '<p>Unable to Create Estimate.</p>');
                redirect('financial/estimate/create');
            }

            redirect('financial/estimates');
        } else {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('financial/estimate/create');
        }
    }

    public function update($id)
    {
        authAccess();

        // $this->form_validation->set_rules('client_id', 'Client Name', 'trim|required|numeric');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        if (isset($_POST['desc_group']) && is_array($_POST['desc_group'])) {
            foreach ($_POST['desc_group'] as $id_desc_group => $desc_group) {
                $this->form_validation->set_rules('desc_group[' . $id_desc_group . '][sub_title]', 'Sub Title', 'trim|required');
                unset($desc_group['id']);
                unset($desc_group['sub_title']);
                foreach ($desc_group as $id_desc => $desc) {
                    $this->form_validation->set_rules('desc_group[' . $id_desc_group . '][' . $id_desc . '][item]', 'item', 'trim|required');
                    $this->form_validation->set_rules('desc_group[' . $id_desc_group . '][' . $id_desc . '][amount]', 'Amount', 'trim|numeric');
                }
            }
        }

        if ($this->form_validation->run() == TRUE) {
            $estimate = $this->estimate->getEstimateById($id);
            if ($estimate) {
                $estimate = $this->input->post();
                $update_estimate = $this->estimate->update($id, [
                    'date' => $estimate['date'],
                    'title' => $estimate['title'],
                    'note' => $estimate['note']
                ]);

                if ($update_estimate) {
                    $exception_ids = array_column($estimate['desc_group'], 'id');
                    $this->estimate_desc->deleteByEstimateIdWithExceptionEstimateGroupIds($id, $exception_ids);
                    $this->estimate_desc_group->deleteByEstimateIdWithExceptionIds($id, $exception_ids);
                    foreach ($estimate['desc_group'] as $desc_group) {
                        if (isset($desc_group['id'])) {
                            $update_desc_group = $this->estimate_desc_group->update($desc_group['id'], [
                                'sub_title' => $desc_group['sub_title']
                            ]);

                            if ($update_desc_group) {
                                $desc_group_id = $desc_group['id'];
                                unset($desc_group['id']);
                                unset($desc_group['sub_title']);
                                $exception_ids = array_column($desc_group, 'id');
                                $this->estimate_desc->deleteByEstimateGroupIdWithExceptionIds($desc_group['id'], $exception_ids);
                                foreach ($desc_group as $desc) {
                                    if (isset($desc['id'])) {
                                        $update_desc = $this->estimate_desc->update($desc['id'], [
                                            'item' => $desc['item'],
                                            'amount' => empty($desc['amount']) ? NULL : $desc['amount']
                                        ]);
                                    } else {
                                        $insert_desc = $this->estimate_desc->insert([
                                            'item' => $desc['item'],
                                            'amount' => empty($desc['amount']) ? NULL : $desc['amount'],
                                            'description_group_id' => $desc_group_id
                                        ]);
                                    }
                                }
                            }
                        } else {
                            $insert_desc_group = $this->estimate_desc_group->insert([
                                'sub_title' => $desc_group['sub_title'],
                                'estimate_id' => $id
                            ]);

                            if ($insert_desc_group) {
                                unset($desc_group['sub_title']);
                                foreach ($desc_group as $desc) {
                                    $insert_desc = $this->estimate_desc->insert([
                                        'item' => $desc['item'],
                                        'amount' => empty($desc['amount']) ? NULL : $desc['amount'],
                                        'description_group_id' => $insert_desc_group
                                    ]);
                                }
                            }
                        }
                    }
                } else {
                    $this->session->set_flashdata('errors', '<p>Unable to Update Estimate.</p>');
                }
            } else {
                $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            }

            redirect('financial/estimate/' . $id);
        } else {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('financial/estimate/' . $id);
        }
    }

    public function show($id)
    {
        authAccess();

        $estimate = $this->estimate->getEstimateById($id);

        if ($estimate) {
            $estimate_desc_groups = $this->estimate_desc_group->allEstimateDescGroupsByEstimateId($id);
            $estimate_desc_group_ids = array_column($estimate_desc_groups, 'id');
            $estimate_descs = $this->estimate_desc->allEstimateDescsByIds($estimate_desc_group_ids);
            $clients = $this->lead->getLeadList();
            $items = $this->item->getItemList();

            $descs = [];
            if ($estimate_descs) {
                foreach ($estimate_descs as $desc) {
                    if (!isset($descs[$desc->description_group_id])) {
                        $descs[$desc->description_group_id] = [];
                    }
                    $descs[$desc->description_group_id][] = $desc;
                }
            }

            $this->load->view('header', [
                'title' => $this->title
            ]);
            $this->load->view('estimate/show', [
                'estimate' => $estimate,
                'estimate_desc_groups' => $estimate_desc_groups,
                'descs' => $descs,
                'clients' => $clients,
                'items' => $items
            ]);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('financial/estimates');
        }
    }

    public function delete($id)
    {
        authAccess();

        $estimate = $this->estimate->getEstimateById($id);

        if ($estimate) {
            $this->estimate_desc->deleteByEstimateId($id);
            $this->estimate_desc_group->deleteByEstimateId($id);
            $delete = $this->estimate->delete($id);

            if (!$delete) {
                $this->session->set_flashdata('errors', '<p>Unable to Delete Estimate.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
        }
        redirect('financial/estimates');
    }

    public function pdf($id)
    {
        authAccess();

        $estimate = $this->estimate->getEstimateById($id);

        if ($estimate) {
            $estimate_desc_groups = $this->estimate_desc_group->allEstimateDescGroupsByEstimateId($id);
            $estimate_desc_group_ids = array_column($estimate_desc_groups, 'id');
            $estimate_descs = $this->estimate_desc->allEstimateDescsByIds($estimate_desc_group_ids);
            $created_by_user = $this->user->getUserById($estimate->created_by);
            $client = $this->lead->getLeadById($estimate->client_id);
            $admin_conf = $this->admin_setting->getAdminSetting();

            $descs = [];
            if ($estimate_descs) {
                foreach ($estimate_descs as $desc) {
                    if (!isset($descs[$desc->description_group_id])) {
                        $descs[$desc->description_group_id] = [];
                    }
                    $descs[$desc->description_group_id][] = $desc;
                }
            }

            $pdfContent = [];

            $pdfContent[] = '<div>';
            $pdfContent[] = '<table><tr>';
            $pdfContent[] = '<td>' . (($this->session->logoUrl != '') ? '<img width="100" src="' . base_url('assets/company_photo/' . $this->session->logoUrl) . '">' : 'LOGO') . '</td>';
            $pdfContent[] = '<td align="right" style="line-height: 50px; vertical-align: middle;">Estimate #: ' . $estimate->estimate_number . '</td>';
            $pdfContent[] = '</tr></table>';
            $pdfContent[] = '</div>';
            $pdfContent[] = '<div>';
            $pdfContent[] = '<table><tr>';
            $pdfContent[] = '<td></td>';
            $pdfContent[] = '<td><b>ROOFING ESTIMATE<br /></b></td>';
            $pdfContent[] = '</tr><tr>';
            $pdfContent[] = '<td><b>' . $estimate->client_name . '</b><br />';
            $pdfContent[] = $client->address . '<br />';
            if (!empty($client->address_2)) {
                $pdfContent[] = $client->address_2 . '<br />';
            }
            $pdfContent[] = $client->city . ', ' . $client->state . ' - ' . $client->zip;
            $pdfContent[] = '</td>';
            $pdfContent[] = '<td style="background-color: #aec5e8; border-left: solid 1px #0e2163;"><table cellspacing="5"><tr><td width="20"></td><td width="100%" style="line-height: 22px;">Date: ' . date('M j, Y', strtotime($estimate->date)) . '<br />Done By: ' . $estimate->created_user . '</td></tr></table></td>';
            $pdfContent[] = '</tr></table>';
            $pdfContent[] = '</div>';
            $pdfContent[] = '<div>';
            $pdfContent[] = $estimate->title . '<br />';
            $pdfContent[] = '<table cellspacing="0" cellpadding="5"><tr style="background-color: #333; color: #FFF;"><th width="400">Item</th><th width="138" align="right">Total</th></tr>';

            $total = 0;
            $background = false;
            foreach ($estimate_desc_groups as $group) {
                $pdfContent[] = '<tr style="background-color: #777; color: #FFF;"><td colspan="2">' . $group->sub_title . '</td></tr>';
                $subTotal = 0;
                if (isset($descs[$group->id])) {
                    foreach ($descs[$group->id] as $desc) {
                        $pdfContent[] = '<tr' . ($background ? ' style="background-color: #EEE;"' : '') . '><td>' . $desc->item_name . '</td>';
                        $pdfContent[] = '<td align="right"></td></tr>';
                        $subTotal += (($desc->amount == 0) ? 0 : (floatval($desc->amount) * floatval($desc->item_unit_price)));
                        $background = !$background;
                    }
                }
                $total += $subTotal;
                $pdfContent[] = '<tr' . ($background ? ' style="background-color: #EEE;"' : '') . '><td align="right">Total - ' . $group->sub_title . ':</td><td align="right">$' . number_format($subTotal, 2) . '</td></tr>';
                $background = !$background;
            }
            $pdfContent[] = '<tr' . ($background ? ' style="background-color: #EEE;"' : '') . '><td align="right">Total:</td><td align="right">$' . number_format($total, 2) . '</td></tr></table>';
            $pdfContent[] = '</div>';
            if (!empty($estimate->note)) {
                $pdfContent[] = '<div>';
                $pdfContent[] = 'Includes:<br />';
                $pdfContent[] = nl2br($estimate->note);
                $pdfContent[] = '</div>';
            }
            $pdfContent[] = '<div><p> </p>';
            $pdfContent[] = '<table width="230" cellpadding="5" style="background-color: #DDD;"><tr><td style="border-left: solid 2px #0e2163; font-size: 9px; line-height: 18px;">';
            $pdfContent[] = '<b>Thank you for your business!</b><br />';
            $pdfContent[] = $estimate->created_user . '<br />';
            $pdfContent[] = $created_by_user->email_id . '<br />';
            $pdfContent[] = $created_by_user->office_phone;
            $pdfContent[] = '</td></tr></table>';
            $pdfContent[] = '</div>';

            // echo implode('', $pdfContent);
            // die();

            // $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf = new Pdf();
            $pdf->setCompanyData($admin_conf->company_name, $admin_conf->company_address, $admin_conf->company_email, $admin_conf->company_phone);
            $pdf->setPrintHeader(false);
            // $pdf->setPrintFooter(false);
            $pdf->AddPage();
            $pdf->writeHTML(implode('', $pdfContent), true, false, true, false, '');
            ob_clean();
            $pdf->Output('estimate.pdf');
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('financial/estimates');
        }
    }

    public function savePDF($id)
    {
        authAccess();

        $estimate = $this->estimate->getEstimateById($id);

        if ($estimate) {
            $estimate_desc_groups = $this->estimate_desc_group->allEstimateDescGroupsByEstimateId($id);
            $estimate_desc_group_ids = array_column($estimate_desc_groups, 'id');
            $estimate_descs = $this->estimate_desc->allEstimateDescsByIds($estimate_desc_group_ids);
            $created_by_user = $this->user->getUserById($estimate->created_by);
            $client = $this->lead->getLeadById($estimate->client_id);
            $admin_conf = $this->admin_setting->getAdminSetting();

            $descs = [];
            if ($estimate_descs) {
                foreach ($estimate_descs as $desc) {
                    if (!isset($descs[$desc->description_group_id])) {
                        $descs[$desc->description_group_id] = [];
                    }
                    $descs[$desc->description_group_id][] = $desc;
                }
            }

            $pdfContent = [];

            $pdfContent[] = '<div>';
            $pdfContent[] = '<table><tr>';
            $pdfContent[] = '<td>' . (($this->session->logoUrl != '') ? '<img width="100" src="' . base_url('assets/company_photo/' . $this->session->logoUrl) . '">' : 'LOGO') . '</td>';
            $pdfContent[] = '<td align="right" style="line-height: 50px; vertical-align: middle;">Estimate #: ' . $estimate->estimate_number . '</td>';
            $pdfContent[] = '</tr></table>';
            $pdfContent[] = '</div>';
            $pdfContent[] = '<div>';
            $pdfContent[] = '<table><tr>';
            $pdfContent[] = '<td></td>';
            $pdfContent[] = '<td><b>ROOFING ESTIMATE<br /></b></td>';
            $pdfContent[] = '</tr><tr>';
            $pdfContent[] = '<td><b>' . $estimate->client_name . '</b><br />';
            $pdfContent[] = $client->address . '<br />';
            if (!empty($client->address_2)) {
                $pdfContent[] = $client->address_2 . '<br />';
            }
            $pdfContent[] = $client->city . ', ' . $client->state . ' - ' . $client->zip;
            $pdfContent[] = '</td>';
            $pdfContent[] = '<td style="background-color: #aec5e8; border-left: solid 1px #0e2163;"><table cellspacing="5"><tr><td width="20"></td><td width="100%" style="line-height: 22px;">Date: ' . date('M j, Y', strtotime($estimate->date)) . '<br />Done By: ' . $estimate->created_user . '</td></tr></table></td>';
            $pdfContent[] = '</tr></table>';
            $pdfContent[] = '</div>';
            $pdfContent[] = '<div>';
            $pdfContent[] = $estimate->title . '<br />';
            $pdfContent[] = '<table cellspacing="0" cellpadding="5"><tr style="background-color: #333; color: #FFF;"><th width="400">Item</th><th width="138" align="right">Total</th></tr>';

            $total = 0;
            $background = false;
            foreach ($estimate_desc_groups as $group) {
                $pdfContent[] = '<tr style="background-color: #777; color: #FFF;"><td colspan="2">' . $group->sub_title . '</td></tr>';
                $subTotal = 0;
                if (isset($descs[$group->id])) {
                    foreach ($descs[$group->id] as $desc) {
                        $pdfContent[] = '<tr' . ($background ? ' style="background-color: #EEE;"' : '') . '><td>' . $desc->item_name . '</td>';
                        $pdfContent[] = '<td align="right"></td></tr>';
                        $subTotal += (($desc->amount == 0) ? 0 : (floatval($desc->amount) * floatval($desc->item_unit_price)));
                        $background = !$background;
                    }
                }
                $total += $subTotal;
                $pdfContent[] = '<tr' . ($background ? ' style="background-color: #EEE;"' : '') . '><td align="right">Total - ' . $group->sub_title . ':</td><td align="right">$' . number_format($subTotal, 2) . '</td></tr>';
                $background = !$background;
            }
            $pdfContent[] = '<tr' . ($background ? ' style="background-color: #EEE;"' : '') . '><td align="right">Total:</td><td align="right">$' . number_format($total, 2) . '</td></tr></table>';
            $pdfContent[] = '</div>';
            if (!empty($estimate->note)) {
                $pdfContent[] = '<div>';
                $pdfContent[] = 'Includes:<br />';
                $pdfContent[] = nl2br($estimate->note);
                $pdfContent[] = '</div>';
            }
            $pdfContent[] = '<div><p> </p>';
            $pdfContent[] = '<table width="230" cellpadding="5" style="background-color: #DDD;"><tr><td style="border-left: solid 2px #0e2163; font-size: 9px; line-height: 18px;">';
            $pdfContent[] = '<b>Thank you for your business!</b><br />';
            $pdfContent[] = $estimate->created_user . '<br />';
            $pdfContent[] = $created_by_user->email_id . '<br />';
            $pdfContent[] = $created_by_user->office_phone;
            $pdfContent[] = '</td></tr></table>';
            $pdfContent[] = '</div>';

            // echo implode('', $pdfContent);
            // die();

            // $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf = new Pdf();
            $pdf->setCompanyData($admin_conf->company_name, $admin_conf->company_address, $admin_conf->company_email, $admin_conf->company_phone);
            $pdf->setPrintHeader(false);
            // $pdf->setPrintFooter(false);
            $pdf->AddPage();
            $pdf->writeHTML(implode('', $pdfContent), true, false, true, false, '');
            ob_clean();
            // ============== save to job_doc folder ==============
            $tmp_i = 1;
            $new_name = 'Estimate ' . $estimate->estimate_number . ' - ' . $estimate->client_name . '.pdf';
            $targetPath = FCPATH . "assets/job_doc/" . $new_name;
            while (file_exists($targetPath)) {
                $new_name = 'Estimate ' . $estimate->estimate_number . ' - ' . $estimate->client_name . '_' . $tmp_i . '.pdf';
                $targetPath = FCPATH . "assets/job_doc/" . $new_name;
                $tmp_i++;
            }
            $pdf->Output($targetPath, 'F');
            // ============== save to jobs_doc database table ==============
            $search = '.' . strtolower(pathinfo($new_name, PATHINFO_EXTENSION));
            $trimmed = str_replace($search, '', $new_name);
            $params = array();
			$params['job_id'] = $estimate->client_id;
			$params['doc_name'] = $new_name;
			$params['name'] = $trimmed;
			$params['entry_date'] = date('Y-m-d h:i:s');
			$params['is_active'] = TRUE;
			$this->db->insert('jobs_doc', $params);
			$al_insert = $this->activityLogs->insert([
				'module' => 0,
				'module_id' => $estimate->client_id,
				'type' => 3
			]);
            redirect('financial/estimate/' . $id);
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('financial/estimates');
        }
    }
}
