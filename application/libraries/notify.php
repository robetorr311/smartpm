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
            'smtp_host' => 'ssl://smtp.zoho.com',
            'smtp_port' => 465,
            'smtp_user' => 'info@membo.org',
            'smtp_pass' => 'heqCRB92y%p49gU2',
            'mailtype' => 'html'
        ]);
        $this->CI->email->set_newline("\r\n");
        $this->CI->email->from('info@membo.org', 'SmartPM Notification');
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
        $this->CI->email->message('<p>You can verify your email by visiting to the url given below.</p><p><a href="' . $tokenUrl . '">' . $tokenUrl . '</a></p>');
        $this->CI->email->send();
    }
}
