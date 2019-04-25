<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Server extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model(['Login','Common_model']);
		$this->load->helper(['form','security','cookie']);
		$this->load->library(['form_validation','email','user_agent','session']);
		$this->datetime = date("Y-m-d H:i:s");
	}
	public function index()
	{
		
		if( isset($_POST) && count($_POST) > 0 ) 
		{
			$this->form_validation->set_rules('username','Username','trim|required');
			$this->form_validation->set_rules('password','Password','trim|required');
			if( $this->form_validation->run() == TRUE ) {
				$posts = $this->input->post();
				$result = $this->Login->get_user('users',['id','username'],['username'=>$posts['username'], 'password' => $posts['password']]);
				
			   
				if($result) {
					$this->session->set_userdata('isLoggedIn','true');
					$this->session->set_userdata('admininfo',$result);
					
			$array = json_decode(json_encode($this->session->userdata), true);
			$result1 = $this->Login->get_user('admin_setting',['color','url','favicon'],['user_id'=>$array['admininfo']['id']]);
			
			$this->session->set_userdata('admindata',$result1);
					redirect('dashboard');
				} else {
					$this->load->view('login');
				}
			}else
			{
			    	$this->load->view('login');
			}
		}
		else{
		    	redirect('home');
		}
		//$this->load->view('welcome_message');
	}
	
	public function register()
	{
		
		if( isset($_POST) && count($_POST) > 0 ) 
		{
			$this->form_validation->set_rules('username','Username','trim|required');
			$this->form_validation->set_rules('password','Password','trim|required');
			$this->form_validation->set_rules('email','Email','trim|required');
			$this->form_validation->set_rules('mobile','Mobile','trim|required');
			if( $this->form_validation->run() == TRUE ) {
				$posts = $this->input->post();
				$posts = $this->input->post();
				$params = array();
				$params['username'] 		= $posts['username'];
				$params['password'] 		= $posts['password'];
			//	$params['mobile'] 		= $posts['mobile'];
				$params['email'] 		= $posts['email'];
			//	$params['entry_date'] 			= date('Y-m-d h:i:s');
			//	$params['is_active'] 			= TRUE;
				$query = $this->Common_model->add_record( 'users', $params );
			    if( $query ) {
					$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
					$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Account Created Successfully! Please login</strong>';
					$message .= '</div>';
					$this->session->set_flashdata('message',$message);
					$this->load->view('login');
				} else {
					$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
					$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Account not created!</strong>';
					$message .= '</div>';
					$this->session->set_flashdata('message',$message);
				    redirect('home/register');
				}
			}else
			{
			    		$this->load->view('signup');
			}
		}
		else{
		    	redirect('home/register');
		}
		//$this->load->view('welcome_message');
	}
	

	public function save_job()
	{
		
		if( isset($_POST) && count($_POST) > 0 ) 
		{
			
			$this->form_validation->set_rules('jobname','Job Name','trim|required');
			$this->form_validation->set_rules('firstname','First Name','trim|required');
			$this->form_validation->set_rules('lastname','Last Name','trim|required');
			$this->form_validation->set_rules('address','Address','trim|required');
			$this->form_validation->set_rules('city','City','trim|required');
			$this->form_validation->set_rules('country','State','trim|required');
			$this->form_validation->set_rules('zip','Postal Code','trim|required');
			$this->form_validation->set_rules('phone1','Phone 1','trim|required');
			$this->form_validation->set_rules('phone2','Phone 2','trim');
			$this->form_validation->set_rules('email','Email','trim');
			if( $this->form_validation->run() == TRUE ) {
				$posts = $this->input->post();
				
				$params['job_name'] 		= $posts['jobname'];
				$params['firstname'] 		= $posts['firstname'];
				$params['lastname'] 		= $posts['lastname'];
				$params['address'] 		= $posts['address'];
				$params['city'] 		= $posts['city'];
				$params['state'] 		= $posts['country'];
				$params['zip'] 		= $posts['zip'];
				$params['phone1'] 		= $posts['phone1'];
				$params['phone2'] 		= $posts['phone2'];
				$params['email'] 		= $posts['email'];			
				$params['entry_date'] 			= date('Y-m-d h:i:s');
				$params['is_active'] 			= TRUE;
				$query = $this->Common_model->add_record( 'jobs', $params );
				if( $query ) {
					$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
					$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Record Saved Successfully!</strong>';
					$message .= '</div>';
					$this->session->set_flashdata('message',$message);
					redirect('dashboard/alljob');
				} else {
					$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
					$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Job Not Saved Successfully!</strong>';
					$message .= '</div>';
					$this->session->set_flashdata('message',$message);
					redirect('dashboard/addjob');
				}
			}
			else{
			
				$this->load->view('header');
				$this->load->view('add_job');
				$this->load->view('footer');
			}
		}
		
	}

	public function update_job(){
		if( isset($_POST) && count($_POST) > 0 ) {
			$this->form_validation->set_rules('jobname','Job Name','trim|required');
			$this->form_validation->set_rules('firstname','First Name','trim|required');
			$this->form_validation->set_rules('lastname','Last Name','trim|required');
			$this->form_validation->set_rules('address','Address','trim|required');
			$this->form_validation->set_rules('city','City','trim|required');
			$this->form_validation->set_rules('country','State','trim|required');
			$this->form_validation->set_rules('zip','Postal Code','trim|required');
			$this->form_validation->set_rules('phone1','Phone 1','trim|required');
			$this->form_validation->set_rules('phone2','Phone 2','trim');
			$this->form_validation->set_rules('email','Email','trim');
			if( $this->form_validation->run() == FALSE ) {
					$this->load->view('header');
					$this->load->view('add_job');
					$this->load->view('footer');
			} else {
				$posts = $this->input->post();
				$params = array();
				$params['job_name'] 		= $posts['jobname'];
				$params['firstname'] 		= $posts['firstname'];
				$params['lastname'] 		= $posts['lastname'];
				$params['address'] 		= $posts['address'];
				$params['city'] 		= $posts['city'];
				$params['state'] 		= $posts['country'];
				$params['zip'] 		= $posts['zip'];
				$params['phone1'] 		= $posts['phone1'];
				$params['phone2'] 		= $posts['phone2'];
				$params['email'] 		= $posts['email'];	

				//$query=array('content'=>$params['content']);
				$this->db->where('id',$posts['id']);
				$this->db->update('jobs',$params);
				$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
				$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Record Saved Successfully!</strong>';
				$message .= '</div>';
				$this->session->set_flashdata('message',$message);
				redirect('dashboard/alljob');
				

			}

		}else{

					$this->load->view('header');
				$this->load->view('add_job');
				$this->load->view('footer');
		}
	}
	
	public function ajaxupload(){
		
		if ( 0 < $_FILES['file']['error'] ) {
			echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		}
		else {
			move_uploaded_file($_FILES['file']['tmp_name'], 'assets/img/' . $_FILES['file']['name']);
			echo $_FILES['file']['name'];
		}
		
	}
	public function ajaxupload_jobphoto(){
		
		/*if ( 0 < $_FILES['file']['error'] ) {
			echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		}
		else {
			move_uploaded_file($_FILES['file']['tmp_name'], 'assets/job_photo/' . $_FILES['file']['name']);
			echo $_FILES['file']['name'];
		}*/
		       
 if(is_array($_FILES) && !empty($_FILES['photo']))  
 {  
	  $img=array();$i=0;
      foreach($_FILES['photo']['name'] as $key => $filename)  
     {  	
		  	
           $file_name = explode(".", $filename);  
           $allowed_extension = array("jpg", "jpeg", "png", "gif", "JPG");  
           if(in_array($file_name[1], $allowed_extension))  
           {  
                $new_name = rand() . '.'. $file_name[1];  
                $sourcePath = $_FILES["photo"]["tmp_name"][$key];  
                $targetPath = "assets/job_photo/".$new_name;  
                move_uploaded_file($sourcePath, $targetPath);  
				$img[$i]=$new_name;
				$i++;
           } 
      }

		echo json_encode($img);
      
      
 }
		
	}
	
	public function ajaxsave(){
		$posts = $this->input->post();
		if($posts['id']=='logo'){
		$this->db->query("UPDATE admin_setting SET url='".$posts['name']."' WHERE name='".$posts['id']."'");
		}
		else{
		$this->db->query("UPDATE admin_setting SET favicon='".$posts['name']."'");
		}
		echo $posts['name'];
	}
	public function ajaxsave_jobphoto(){
		$posts = $this->input->post();
		$data = json_decode($posts['name'], true);
		//print_r($data);
		
		for($i=0;$i<count($data);$i++){
			$params = array();
			$params['job_id'] 		= $posts['id'];
			$params['image_name'] 		= $data[$i];
			$params['entry_date'] 		= date('Y-m-d h:i:s');
			$params['is_active'] 		= TRUE;
			$this->db->insert('jobs_photo', $params);
			$insertId = $this->db->insert_id();
			echo '<div id="ph'.$insertId.'" class="col-md-2"><i class="del-photo pe-7s-close" id="'.$insertId.'"></i><a href="#" class="pop"><img src="'.base_url().'assets/job_photo/'.$data[$i].'" /></a></div>';
		}
		
		//$params = array();
		//$params['job_id'] 		= $posts['id'];
		//$params['image_name'] 		= $posts['name'];
		//$params['entry_date'] 		= date('Y-m-d h:i:s');
		//$params['is_active'] 		= TRUE;
		//$this->db->insert('jobs_photo', $params);
		//$insertId = $this->db->insert_id();
		//echo $insertId;
		
		//'<div id="ph'+photoid+'" class="col-md-2"><i class="del-photo pe-7s-close" id="'+photoid+'"></i><a href="#" class="pop"><img src="'+baseUrl+'assets/job_photo/'+php_script_response+'" /></a></div>'
	}
	 
	public function deletephoto(){
	   
		$posts = $this->input->post();
		$this->db->query("UPDATE jobs_photo SET is_active=0 WHERE id='".$posts['id']."'");
		return true;
	}
	
	public function deletejobreport(){
	   
		$posts = $this->input->post();
		$this->db->query("UPDATE roofing_project SET active=0 WHERE id='".$posts['id']."'");
		return true;
	}
	
	public function ajaxcolor(){
	   
	    $array = json_decode(json_encode($this->session->userdata), true);
		$posts = $this->input->post();
		$this->db->query("UPDATE admin_setting SET color='".$posts['color']."' WHERE user_id='".$array['admininfo']['id']."'");
		 $this->session->set_userdata("color",$posts['color']);
		echo $posts['color'];
	}



}
