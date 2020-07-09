<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Estimate extends CI_Controller
{
    private $title = 'Estimate';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['EstimateModel', 'EstimateDescriptionGroupModel', 'EstimateDescriptionModel', 'LeadModel']);
        $this->load->library(['pagination', 'form_validation', 'pdf']);

        $this->estimate = new EstimateModel();
        $this->estimate_desc_group = new EstimateDescriptionGroupModel();
        $this->estimate_desc = new EstimateDescriptionModel();
        $this->lead = new LeadModel();
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

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('estimate/create', [
            'clients' => $clients
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
                    $this->form_validation->set_rules('desc_group[' . $id_desc_group . '][' . $id_desc . '][description]', 'Description', 'trim|required');
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
                                'description' => $desc['description'],
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
                    $this->form_validation->set_rules('desc_group[' . $id_desc_group . '][' . $id_desc . '][description]', 'Description', 'trim|required');
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
                                            'description' => $desc['description'],
                                            'amount' => empty($desc['amount']) ? NULL : $desc['amount']
                                        ]);
                                    } else {
                                        $insert_desc = $this->estimate_desc->insert([
                                            'description' => $desc['description'],
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
                                        'description' => $desc['description'],
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
                'clients' => $clients
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

        echo "PDF feature is under construction.";

        // $estimate = $this->estimate->getEstimateById($id);

        // if ($estimate) {
        //     $estimate_desc_groups = $this->estimate_desc_group->allEstimateDescGroupsByEstimateId($id);
        //     $estimate_desc_group_ids = array_column($estimate_desc_groups, 'id');
        //     $estimate_descs = $this->estimate_desc->allEstimateDescsByIds($estimate_desc_group_ids);

        //     $descs = [];
        //     if ($estimate_descs) {
        //         foreach ($estimate_descs as $desc) {
        //             if (!isset($descs[$desc->description_group_id])) {
        //                 $descs[$desc->description_group_id] = [];
        //             }
        //             $descs[$desc->description_group_id][] = $desc;
        //         }
        //     }

        //     // =============== GENERATE PDF ===============
        //     $pdfContent = [];

        //     $pdfContent[] = '<div>';
        //     $pdfContent[] = '<table><tr>';
        //     $pdfContent[] = '<td>' . (($this->session->logoUrl != '') ? '<img width="100" src="' . base_url('assets/company_photo/' . $this->session->logoUrl) . '">' : 'LOGO') . '</td>';
        //     $pdfContent[] = '<td align="right" style="line-height: 50px; vertical-align: middle;">Estimate #: ' . $estimate->estimate_number . '</td>';
        //     $pdfContent[] = '</tr></table>';
        //     $pdfContent[] = '</div>';
        //     $pdfContent[] = '<div>';
        //     $pdfContent[] = '<table><tr>';
        //     $pdfContent[] = '<td></td>';
        //     $pdfContent[] = '<td cellpadding="20px">ROOFING ESTIMATE</td>';
        //     $pdfContent[] = '</tr><tr>';
        //     $pdfContent[] = '<td><b>' . $estimate->client_name . '</b><br />Address</td>';
        //     $pdfContent[] = '<td>';
        //     $pdfContent[] = '<div style="border-left: 3px solid #000; background-color: #CCC; padding-left: 20px;">Date: ' . date('M j, Y', strtotime($estimate->date)) . '<br />Done By: ' . $estimate->created_user . '</div>';
        //     $pdfContent[] = '</td>';
        //     $pdfContent[] = '</tr></table>';
        //     $pdfContent[] = '</div>';

        //     // echo implode('', $pdfContent);
        //     // die();

        //     $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        //     $pdf->setPrintHeader(false);
        //     $pdf->setPrintFooter(false);
        //     $pdf->AddPage();
        //     $pdf->writeHTML(implode('', $pdfContent), true, false, true, false, '');
        //     ob_clean();
        //     $pdf->Output('estimate.pdf');
            
        //     // var_dump($estimate);
        //     // var_dump($estimate_desc_groups);
        //     // var_dump($descs);
        //     // =============== GENERATE PDF ===============
        // } else {
        //     $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
        //     redirect('financial/estimates');
        // }
    }
}
