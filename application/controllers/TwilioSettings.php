<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TwilioSettings extends CI_Controller
{
    private $title = 'Twilio Settings';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['M_TwilioCredModel']);

        $this->m_twilioCred = new M_TwilioCredModel();
    }

    public function index()
    {
        authAccess();

        $twilioSettings= $this->m_twilioCred->getTwilioSettings($this->session->company_code);

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('setting/twilio-settings', [
            'twilioSettings' => $twilioSettings
        ]);
        $this->load->view('footer');
    }

    public function updateTwilioSettings()
    {
        authAccess();

        $this->form_validation->set_rules('account_sid', 'Account SID', 'trim|required');
        $this->form_validation->set_rules('auth_token', 'Auth Token', 'trim|required');
        $this->form_validation->set_rules('twilio_number', 'Twilio Number', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $update = $this->m_twilioCred->update($this->session->company_code, [
                'account_sid' => $data['account_sid'],
                'auth_token' => $data['auth_token'],
                'twilio_number' => $data['twilio_number']
            ]);
            if (!$update) {
                $this->session->set_flashdata('errors', '<p>Unable to Update Twilio Settings.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
        }

        redirect('setting/twilio-settings');
    }
}
