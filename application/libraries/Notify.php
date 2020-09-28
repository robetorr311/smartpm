<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notify
{
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library('email');
        $this->CI->load->model(['M_EmailCredModel', 'M_TwilioCredModel']);

        $this->m_emailCred = new M_EmailCredModel();
        $this->m_twilioCred = new M_TwilioCredModel();

        $this->twilioClient = false;
        

        // Email template - header color
        $admindata = $this->CI->session->userdata('admindata');
        if(!empty($admindata['color'])) {
            $this->theme_color = $admindata['color'];
        } else {
            $this->theme_color = DEFAULT_THEME_COLOR;
        }

        // Email template  - header logo
        if (isset($this->CI->session->logoUrl) && $this->CI->session->logoUrl != '') {
            $this->logoUrl = base_url('assets/company_photo/' . $this->CI->session->logoUrl);
        } else {
            $this->logoUrl = base_url(COMPANY_LOGO_PATH);
        }

        if (isset($this->CI->session->company_code)) {
            $smtpSettings = $this->m_emailCred->getSMTPSettings($this->CI->session->company_code);
            $twilioSettings = $this->m_twilioCred->getTwilioSettings($this->CI->session->company_code);
            if ($twilioSettings && !empty($twilioSettings->account_sid) && !empty($twilioSettings->auth_token)) {
                $this->twilioClient = new Twilio\Rest\Client($twilioSettings->account_sid, $twilioSettings->auth_token);
                $this->twilio_number = $twilioSettings->twilio_number;
            }
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
        $this->CI->email->from(((isset($smtpSettings) && !empty($smtpSettings->smtp_user)) ? $smtpSettings->smtp_user : getenv('EMAIL_SMTP_USER')), 'SmartPM Notification');
    }

    public function resetPassword($email, $token)
    {
        $this->CI->email->to($email);
        $this->CI->email->subject('Reset Password - SmartPM');
        $html_message = $this->CI->load->view('template/email/reset-password.php', [
            'token' => $token,
            'theme_color' => $this->theme_color,
            'logoUrl' => $this->logoUrl
        ], true);
        $this->CI->email->message($html_message);
        if (!$this->CI->email->send(false)) {
            $this->CI->email->print_debugger();
            die();
        }
    }

    /*** Sends an email to user to generate password ***/
    
    public function createPassword($email, $token, $logoUrl)
    {
        $this->CI->email->to($email);
        $this->CI->email->from(getenv('EMAIL_SMTP_USER'), 'SmartPM Notification');
        $this->CI->email->subject('Create Password - SmartPM');
        $html_message = $this->CI->load->view('template/email/create-password.php', [
            'token' => $token,
            'logoUrl' => $logoUrl,
            'theme_color' => $this->theme_color
        ], true);
        
        $this->CI->email->message($html_message);
        $this->CI->email->send();
    }

    
    public function emailVerification($email, $company_code, $token)
    {
        $this->CI->email->to($email);
        $this->CI->email->from(getenv('EMAIL_SMTP_USER'), 'SmartPM Notification');
        $this->CI->email->subject('Email Verification - SmartPM');
        $html_message = $this->CI->load->view('template/email/email-verification.php', [
            'company_code' => $company_code,
            'token' => $token,
            'theme_color' => $this->theme_color,
            'logoUrl' => $this->logoUrl
        ], true);
        $this->CI->email->message($html_message);
        $this->CI->email->send();
    }

     /*** Sends an email on forgot company-code ***/

    public function sendCompanyCode($email, $company_code)
    {
        $this->CI->email->to($email);
        $this->CI->email->from(getenv('EMAIL_SMTP_USER'), 'SmartPM Notification');
        $this->CI->email->subject('Forgot Company Code - SmartPM');
        $html_message = $this->CI->load->view('template/email/forgot-company-code.php', [
            'company_code' => $company_code
        ], true);
        $this->CI->email->message($html_message);
        $this->CI->email->send();
    }

    public function sendNoteTagNotification($email, $task_name, $note, $link)
    {
        $this->CI->email->to($email);
        $this->CI->email->subject('You have been tagged in a Note - SmartPM');
        $html_message = $this->CI->load->view('template/email/note-tag-notification.php', [
            'logoUrl' => $this->logoUrl,
            'task_name' => $task_name,
            'note' => $note,
            'link' => $link,
            'theme_color' => $this->theme_color
        ], true);
        $this->CI->email->message($html_message);
        $this->CI->email->send();
    }

    public function sendNoteTagNotificationMob($phone, $task_name, $note, $link)
    {
        if ($this->twilioClient) {
            $this->twilioClient->messages->create(
                $phone,
                [
                    'from' => $this->twilio_number,
                    'body' => 'Smartpm.app: ' . $task_name . ' (' . $link . ') "' . $note . '"'
                ]
            );
        }
    }

    /*** Sends an email when user is tagged in task ***/

    public function sendTaskTagNotification($email, $task_id, $task_name, $note, $link)
    {
        $this->CI->email->to($email);
        $this->CI->email->subject('You have been tagged in a Task - SmartPM');
        $html_message = $this->CI->load->view('template/email/task-tag-notification.php', [
            'logoUrl' => $this->logoUrl,
            'task_id' => $task_id,
            'task_name' => $task_name,
            'note' => $note,
            'link' => $link,
            'theme_color'=> $this->theme_color,
        ], true);
        $this->CI->email->message($html_message);
        $this->CI->email->send();
    }

    public function sendTaskTagNotificationMob($phone, $task_id, $task_name, $note, $link)
    {
        if ($this->twilioClient) {
            $this->twilioClient->messages->create(
                $phone,
                [
                    'from' => $this->twilio_number,
                    'body' => 'Smartpm.app: #' . $task_id . ' ' . $task_name . ' (' . $link . ') "' . $note . '"'
                ]
            );
        }
    }

    /*** Sends an email when user is assigned in task ***/

    public function sendTaskAssignNotification($email, $task_id, $task_name)
    {
        $this->CI->email->to($email);
        $this->CI->email->subject('A Task has been assign to You - SmartPM');
        $html_message = $this->CI->load->view('template/email/task-assign-notification.php', [
            'logoUrl' => $this->logoUrl,
            'task_id' => $task_id,
            'task_name' => $task_name,
            'theme_color'=> $this->theme_color,
            
        ], true);
        $this->CI->email->message($html_message);
        $this->CI->email->send();
    }

    public function sendLeadAssignNotification($email, $lead_id, $lead_name, $link)
    {
        $this->CI->email->to($email);
        $this->CI->email->subject("You have a new Lead: {$lead_name}");
        $html_message = $this->CI->load->view('template/email/lead-assign-notification.php', [
            'logoUrl' => $this->logoUrl,
            'lead_id' => $lead_id,
            'lead_name' => $lead_name,
            'link' => $link,
            'theme_color'=> $this->theme_color,
        ], true);
        $this->CI->email->message($html_message);
        $this->CI->email->send();
    }

    public function sendLeadAssignNotificationMob($phone, $lead_id, $lead_name, $link)
    {
        if ($this->twilioClient) {
            $this->twilioClient->messages->create(
                $phone,
                [
                    'from' => $this->twilio_number,
                    'body' => "Smartpm.app: You have a new Lead: {$lead_name} - Lead # {$lead_id} ( {$link} )",
                ]
            );
        }
    }

    public function sendWelcomeUserNotification($email, $name, $logoUrl = false)
    {
        $this->CI->email->to($email);
        $this->CI->email->from(getenv('EMAIL_SMTP_USER'), 'SmartPM Notification');
        $this->CI->email->subject('Welcome to SmartPM');
        $html_message = $this->CI->load->view('template/email/welcome-user-notification.php', [
            'name' => $name,
            'logoUrl' => $this->logoUrl,
            'theme_color'=> $this->theme_color,
        ], true);
        $this->CI->email->message($html_message);
        $this->CI->email->send();
    }

    /*** To send email notification for notice ***/
    
    public function sendClientNotice($email, $company_name, $logoUrl, $notice_type_name, $notice_details, $theme_color)
    {
        $result = 0;

        if(!empty($email)) {
            
            $emaildata = [];
            $emaildata['logoUrl'] = $logoUrl;
            $emaildata['notice_type'] = $notice_type_name;
            $emaildata['notice_details'] = $notice_details;
            $emaildata['theme_color'] = $theme_color;
            $this->CI->email->to($email);
            $subject = 'Notice from '.$company_name;
            $this->CI->email->subject($subject);
           
            $html_message = $this->CI->load->view('template/email/client-notice-notification.php', [
                'emaildata' => $emaildata,

            ], true);
            $this->CI->email->message($html_message);

            if($this->CI->email->send()) {
                $result = 1;
            }
        }
        return $result;
    }

    public function sendInvoice($email, $client_name, $user_name, $attachment)
    {
        $this->CI->email->to($email);
        $this->CI->email->subject('Invoice');
        $this->CI->email->attach($attachment);
        $html_message = $this->CI->load->view('template/email/invoice-notification.php', [
            'logoUrl' => $this->logoUrl,
            'client_name' => $client_name,
            'user_name' => $user_name,
            'theme_color'=> $this->theme_color,
        ], true);
        $this->CI->email->message($html_message);
        $this->CI->email->send();
    }
}
