<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Email extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {


        $msg = $this->load->view('template/email', '', true);
        // echo $msg;
        // die();
        $this->load->library('email');

        $this->email->initialize([
            'protocol' => 'smtp',
            'smtp_host' => getenv('EMAIL_SMTP_HOST'),
            'smtp_port' => intval(getenv('EMAIL_SMTP_PORT')),
            'smtp_user' => getenv('EMAIL_SMTP_USER'),
            'smtp_pass' => getenv('EMAIL_SMTP_PASS'),
            'mailtype' => 'html'
        ]);
        $this->email->set_newline("\r\n");

        $this->email->from(getenv('EMAIL_SMTP_USER'), 'SmartPM Notification');
        $this->email->to('ankur2194@gmail.com');
        $this->email->subject('Email Test');
        $this->email->message($msg);
        $this->email->send();
    }
}
