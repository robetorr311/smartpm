<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model(['Login','Common_model']);
		$this->load->helper(['form','security','cookie']);
		$this->load->library(['form_validation','email','user_agent','session']);
		$this->datetime = date("Y-m-d H:i:s");
		
		
		if(!$this->session->userdata('admininfo')) {
			$this->session->sess_destroy();
			delete_cookie('tokenCookie');
			redirect('/home');
			die;
		}
		
		$expireAfter = 10;
		 
		//Check to see if our "last action" session
		//variable has been set.
		if(isset($_SESSION['last_action'])){
			
			//Figure out how many seconds have passed
			//since the user was last active.
			$secondsInactive = time() - $_SESSION['last_action'];
			
			//Convert our minutes into seconds.
			$expireAfterSeconds = $expireAfter * 60;
			
			//Check to see if they have been inactive for too long.
			if($secondsInactive >= $expireAfterSeconds){
				//User has been inactive for too long.
				//Kill their session.
				$this->session->sess_destroy();
				echo '<script type="text/javascript">';
				echo 'alert("Session Timeout!");';
				echo 'window.location.href = "'.base_url().'";';
				echo '</script>';
				
			}
			
		}
		 
		//Assign the current timestamp as the user's
		//latest activity
		$this->session->set_userdata('last_action',time());
		
		
	}
	public function index()
	{
		$this->load->view('header');
		$this->load->view('dashboard');
		$this->load->view('footer');
	}
	public function alljob()
	{	
		$params = array();
		$params['is_active'] = 1;
		$query['job'] = $this->Common_model->get_all_where( 'jobs', $params );
		$this->load->view('header');
		$this->load->view('job',$query);
		$this->load->view('footer');
	}
	public function addjob()
	{
		$this->load->view('header');
		$this->load->view('add_job');
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
		
		$this->load->view('header');
		$this->load->view('jobreport',$query);
		$this->load->view('footer');
	}
	public function admininfo()
	{
		$query['data'] = $this->db->query("SELECT * FROM admin_setting;");
		$this->load->view('header');
		$this->load->view('setting',$query);
		$this->load->view('footer');
	}
	public function update_job($page_id = NULL)
	{
		$params = array();
		$params['id'] =$page_id;
		$query['jobs'] = $this->Common_model->get_all_where( 'jobs', $params );
		$this->load->view('header');
		$this->load->view('update_job',$query);
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
		$this->load->view('header');
		$this->load->view('add_photo', $data);
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
