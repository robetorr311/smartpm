<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
	public function __construct()
	{
	    parent::__construct();
        
    }

	public function index()
	{
		$this->session->sess_destroy();
		foreach($_SESSION as $keys => $values) {
		  unset($_SESSION[$keys]);
		}
		foreach($_COOKIE as $key=>$value) {
		  setcookie($key,"",1);
		}
		
		delete_cookie('tokenCookie');
		delete_cookie('csrf_cookie_name');
		$cookie_name = 'tokenCookie';
		unset($_COOKIE[$cookie_name]);
		setcookie($cookie_name, FALSE, time()-10, '/');
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
		redirect('/','refresh');
	}

}
