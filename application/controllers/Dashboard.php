<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		authAdminAccess();
		$this->load->model(['Login','Common_model']);
	}
	public function index()
	{
		
		$query['data'] = $this->db->query("select SUM(if(status='cash',1,NULL)) as CASH, SUM(if(status='insurance',1,NULL)) as INSURANCE, SUM(if(status='lead',1,NULL)) as LEAD , SUM(if(status='closed',1,NULL)) as CLOSED from jobs");
		$this->load->view('header',['title' => 'Dashboard']);
		$this->load->view('dashboard/index',$query);
		$this->load->view('footer'); 
	}


	public function alljobreport($job_id = NULL)
	{	
	$query = array(
         'jobid' => $job_id
         ); 
		$params = array();
		$params['active'] = 1;
		$params['job_id'] = $job_id;
		$query['allreport'] = $this->Common_model->get_all_where( 'roofing_project', $params );
		
		$this->load->view('header',['title' => 'Job Report']);
		$this->load->view('jobreport',$query);
		$this->load->view('footer');
	}



	public function addphoto($job_id = NULL)
	{	
	    $data = array(
         'jobid' => $job_id
         );
        $params = array();
		$params['job_id'] =$job_id;
		$params['is_active'] =1;
		$data['imgs'] = $this->Common_model->get_all_where( 'jobs_photo', $params );
		$this->load->view('header',['title' => 'Add Photo']);
		$this->load->view('add_photo', $data);
		$this->load->view('footer');
	}
	
	public function adddoc($job_id = NULL)
	{	
	    $data = array(
         'jobid' => $job_id
         );
        $params = array();
		$params['job_id'] =$job_id;
		$params['is_active'] =1;
		$data['docs'] = $this->Common_model->get_all_where( 'jobs_doc', $params );
		$this->load->view('header',['title' => 'Add Doucment']);
		$this->load->view('add_doc', $data);
		$this->load->view('footer');
	}
	public function logout(){
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
