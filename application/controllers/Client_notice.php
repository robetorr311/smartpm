<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client_notice extends CI_Controller
{
    private $title = 'Client Notice';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['ClientNoticeModel', 'LeadModel', 'ClientNoticeTypeModel', 'FinancialModel', 'LeadMaterialModel']);
        $this->load->library(['form_validation', 'notify']);

        $this->client_notice = new ClientNoticeModel();
        $this->lead = new LeadModel();
        $this->noticeType = new ClientNoticeTypeModel();
        $this->financial = new FinancialModel();
        $this->lead_material = new LeadMaterialModel();
    }

    public function index($job_id, $sub_base_path = '')
	{
		authAccess();

        $sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
        $lead = $this->lead->getLeadById($job_id);
        $financial_record = $this->financial->getContractDetailsByJobId($job_id);
        $notices = $this->client_notice->allNotices($job_id);
        $noticeTypes = $this->noticeType->allNoticeTypes();
        $primary_material_info = $this->lead_material->getPrimaryMaterialInfoByLeadId($job_id);
        $financials = $this->financial->allFinancialsForReceipt($job_id);

		$this->load->view('header', [
			'title' => $this->title
		]);
		$this->load->view('client_notice/index', [
            'lead' => $lead,
            'financial_record' => $financial_record,
            'notices' => $notices,
            'noticeTypes' => $noticeTypes,
            'primary_material_info' => $primary_material_info,
            'financials' => $financials,
            'sub_base_path' => $sub_base_path
		]);
		$this->load->view('footer');
    }
    
    public function store($job_id, $sub_base_path = '')
    {
        authAccess();

        $sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
        $this->form_validation->set_rules('type', 'Type', 'trim|required|numeric');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $notice = $this->input->post();
            $insert = $this->client_notice->insert([
                'type' => $notice['type'],
                'date' => $notice['date'],
                'expected_date' => empty($notice['expected_date']) ? null : $notice['expected_date'],
                'note' => $notice['note'],
                'client_id' => $job_id
            ]);

            if (!$insert) {
                $this->session->set_flashdata('errors', '<p>Unable to Create Notice.</p>');
            } else {
                $lead = $this->lead->getLeadById($job_id);
                if (!empty($lead->email)) {
                    $this->notify = new Notify();
                    $this->notify->sendClientNotice($lead->email, $notice['type'], $notice['note']);
                }
            }
        } else {
			$this->session->set_flashdata('errors', validation_errors());
        }

        redirect('lead/' . $sub_base_path . $job_id . '/client-notices');
    }
}
