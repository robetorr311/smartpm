<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		authAdminAccess();
		$this->load->model(['Common_model']);
	}
	public function index()
	{
		
		$data = $this->db->query("select SUM(if(lead='open',1,NULL)) as OPEN, SUM(if(job='labor only' AND lead='open',1,NULL)) as LABOR, SUM(if(job='insurance' AND lead='open',1,NULL)) as INSURANCE, SUM(if(job='cash' AND lead='open',1,NULL)) as CASH , SUM(if(closeout='yes',1,NULL)) as CLOSED from jobs_status");
		$this->load->view('header',['title' => 'Dashboard']);
		$this->load->view('dashboard/index',['data' => $data]);
		$this->load->view('footer'); 
	}


	public function alljobreport($job_id = NULL)
	{	$job_id = $this->uri->segment(2);
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


 
	public function addphoto()
	{	
		$job_id = $this->uri->segment(2);
	    $data = array(
         'jobid' => $job_id
         );
        $params = array();
		$params['job_id'] =$job_id;
		$params['is_active'] =1;
		$data['count']=$this->Common_model->getCount( 'jobs_photo', $params );
		$data['imgs'] = $this->Common_model->get_all_where( 'jobs_photo', $params );
		$this->load->view('header',['title' => 'Add Photo']);
		$this->load->view('add_photo', $data);
		$this->load->view('footer');
	}
	
	public function adddoc($job_id = NULL)
	{	$job_id = $this->uri->segment(2);
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
	

}
