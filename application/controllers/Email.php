<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {
	 public function __construct()
	    {
	        parent::__construct();
	    }
 
	    public function index(){
        	
        	

        	$msg = $this->load->view('template/email', '', true);

			$this->load->library('email');			
			$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
			$this->email->set_header('Content-type', 'text/html');			
        	$this->email->from('test@gmail.com', 'Roofing');
			$this->email->to('test@gmail.com');
			$this->email->subject('Email Test');
			$this->email->message($msg);
			$this->email->send();

		}
 
}