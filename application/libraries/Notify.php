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
        $tokenUrl = base_url('reset-password/' . $token);
        $this->CI->email->to($email);
        $this->CI->email->subject('Reset Password - SmartPM');
        $this->CI->email->message('<p>You can reset your password by visiting to the url given below.</p><p><a href="' . $tokenUrl . '">' . $tokenUrl . '</a></p>');
        $this->CI->email->send();
    }

    public function emailVerification($email, $company_code, $token)
    {
        $tokenUrl = base_url('verification/' . $company_code . '/' . $token);
        $this->CI->email->to($email);
        $this->CI->email->subject('Email Verification - SmartPM');
        $this->CI->email->message('<p>Your Company Code is <b>' . $company_code . '</b></p><br /><p>You can verify your email by visiting to the url given below.</p><p><a href="' . $tokenUrl . '">' . $tokenUrl . '</a></p>');
        $this->CI->email->send();
    }
}