<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notify
{
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library('email', [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'user1@yourdomainname.com',
            'smtp_pass' => 'YOURMAILPASSWORD',
            'mailtype' => 'html'
        ]);
        $this->CI->email->set_newline("\r\n");
        $this->CI->email->from('user1@yourdomainname.com', 'SmartPM Notification');
    }

    public function resetPassword($email, $token)
    {
        $this->CI->email->to($email);
        $this->CI->email->subject('Reset Password - SmartPM');
        $this->CI->email->message('<p>The HTML Message Body</p>');
        $this->CI->email->send();
    }
}
