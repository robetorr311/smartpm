<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notify
{
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library('email');
        $this->CI->email->initialize([
            'protocol' => 'smtp',
            'smtp_host' => getenv('EMAIL_SMTP_HOST'),
            'smtp_port' => intval(getenv('EMAIL_SMTP_PORT')),
            'smtp_user' => getenv('EMAIL_SMTP_USER'),
            'smtp_pass' => getenv('EMAIL_SMTP_PASS'),
            'mailtype' => 'html'
        ]);
        $this->CI->email->set_newline("\r\n");
        $this->CI->email->from(getenv('EMAIL_SMTP_USER'), 'SmartPM Notification');
    }

    public function resetPassword($email, $token)
    {
        $this->CI->email->to($email);
        $this->CI->email->subject('Reset Password - SmartPM');
        $html_message = $this->CI->load->view('template/email/reset-password.php', [
            'token' => $token
        ], true);
        $this->CI->email->message($html_message);
        $this->CI->email->send();
    }

    public function createPassword($email, $token, $logoUrl)
    {
        $this->CI->email->to($email);
        $this->CI->email->subject('Welcome to SmartPM');
        $html_message = $this->CI->load->view('template/email/create-password.php', [
            'token' => $token,
            'logoUrl' => $logoUrl
        ], true);
        $this->CI->email->message($html_message);
        $this->CI->email->send();
    }

    public function emailVerification($email, $company_code, $token)
    {
        $this->CI->email->to($email);
        $this->CI->email->subject('Email Verification - SmartPM');
        $html_message = $this->CI->load->view('template/email/email-verification.php', [
            'company_code' => $company_code,
            'token' => $token
        ], true);
        $this->CI->email->message($html_message);
        $this->CI->email->send();
    }

    public function sendCompanyCode($email, $company_code)
    {
        $this->CI->email->to($email);
        $this->CI->email->subject('Forgot Company Code - SmartPM');
        $html_message = $this->CI->load->view('template/email/forgot-company-code.php', [
            'company_code' => $company_code
        ], true);
        $this->CI->email->message($html_message);
        $this->CI->email->send();
    }
}
