<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notify
{
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library('email');
        $this->CI->load->model(['M_EmailCredModel']);

        $this->m_emailCred = new M_EmailCredModel();

        if (isset($this->CI->session->company_id)) {
            $smtpSettings = $this->m_emailCred->getSMTPSettings($this->CI->session->company_id);
        }
        $this->CI->email->initialize([
            'protocol' => 'smtp',
            'smtp_crypto' => (isset($smtpSettings) && !empty($smtpSettings->smtp_host)) ? $smtpSettings->smtp_crypto : getenv('EMAIL_SMTP_CRYPTO'),
            'smtp_host' => (isset($smtpSettings) && !empty($smtpSettings->smtp_host)) ? $smtpSettings->smtp_host : getenv('EMAIL_SMTP_HOST'),
            'smtp_port' => intval((isset($smtpSettings) && $smtpSettings->smtp_port != 0) ? $smtpSettings->smtp_port : getenv('EMAIL_SMTP_PORT')),
            'smtp_user' => (isset($smtpSettings) && !empty($smtpSettings->smtp_user)) ? $smtpSettings->smtp_user : getenv('EMAIL_SMTP_USER'),
            'smtp_pass' => (isset($smtpSettings) && !empty($smtpSettings->smtp_pass)) ? $smtpSettings->smtp_pass : getenv('EMAIL_SMTP_PASS'),
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
        $this->CI->email->subject('Create Password - SmartPM');
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

    public function sendNoteTagNotification($email, $task_name)
    {
        $this->CI->email->to($email);
        $this->CI->email->subject('You have been tagged in a Note - SmartPM');
        $html_message = $this->CI->load->view('template/email/note-tag-notification.php', [
            'task_name' => $task_name
        ], true);
        $this->CI->email->message($html_message);
        $this->CI->email->send();
    }

    public function sendNoteTagNotificationMob($email, $task_name)
    {
        $this->CI->email->to($email);
        $this->CI->email->subject('You have been tagged in a Note - SmartPM');
        $text_message = 'You have been tagged in a Note of client ' . $task_name;
        $this->CI->email->message($text_message);
        $this->CI->email->send();
    }

    public function sendTaskTagNotification($email, $task_id, $task_name)
    {
        $this->CI->email->to($email);
        $this->CI->email->subject('You have been tagged in a Task - SmartPM');
        $html_message = $this->CI->load->view('template/email/task-tag-notification.php', [
            'task_id' => $task_id,
            'task_name' => $task_name
        ], true);
        $this->CI->email->message($html_message);
        $this->CI->email->send();
    }

    public function sendTaskTagNotificationMob($email, $task_id, $task_name)
    {
        $this->CI->email->to($email);
        $this->CI->email->subject('You have been tagged in a Task - SmartPM');
        $text_message = 'You have been tagged in Task #' . $task_id . ' ' . $task_name;
        $this->CI->email->message($text_message);
        $this->CI->email->send();
    }

    public function sendTaskAssignNotification($email, $task_id, $task_name)
    {
        $this->CI->email->to($email);
        $this->CI->email->subject('A Task has been assign to You - SmartPM');
        $html_message = $this->CI->load->view('template/email/task-assign-notification.php', [
            'task_id' => $task_id,
            'task_name' => $task_name
        ], true);
        $this->CI->email->message($html_message);
        $this->CI->email->send();
    }

    public function sendWelcomeUserNotification($email, $name, $logoUrl = false)
    {
        $this->CI->email->to($email);
        $this->CI->email->subject('Welcome to SmartPM');
        $html_message = $this->CI->load->view('template/email/welcome-user-notification.php', [
            'name' => $name,
            'logoUrl' => $logoUrl
        ], true);
        $this->CI->email->message($html_message);
        $this->CI->email->send();
    }
}
