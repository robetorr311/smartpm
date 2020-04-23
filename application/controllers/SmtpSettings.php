<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SMTPSettings extends CI_Controller
{
    private $title = 'SMTP Settings';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['M_EmailCredModel']);

        $this->m_emailCred = new M_EmailCredModel();
    }

    public function index()
    {
        authAccess();

        $smtpSettings= $this->m_emailCred->getSMTPSettings($this->session->company_code);

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('setting/smtp-settings', [
            'smtpSettings' => $smtpSettings
        ]);
        $this->load->view('footer');
    }

    public function updateSMTPSettings()
    {
        authAccess();

        $this->form_validation->set_rules('smtp_host', 'SMTP Host', 'trim|required');
        $this->form_validation->set_rules('smtp_port', 'SMTP Port', 'trim|required|numeric');
        $this->form_validation->set_rules('smtp_user', 'SMTP User', 'trim|required');
        $this->form_validation->set_rules('smtp_pass', 'SMTP Password', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $update = $this->m_emailCred->update($this->session->company_code, [
                'smtp_crypto' => $data['smtp_crypto'],
                'smtp_host' => $data['smtp_host'],
                'smtp_port' => $data['smtp_port'],
                'smtp_user' => $data['smtp_user'],
                'smtp_pass' => $data['smtp_pass']
            ]);
            if (!$update) {
                $this->session->set_flashdata('errors', '<p>Unable to Update SMTP Settings.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
        }

        redirect('setting/smtp-settings');
    }
}
