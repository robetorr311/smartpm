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
					$message = '<div class="error" title="Error:">Username or Password not correct. Please try again!</div>';
					$this->session->set_flashdata('message',$message);

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
			$this->form_validation->set_rules('email','Email','trim|required|is_unique[users.email]');
			if( $this->form_validation->run() == TRUE ) {
				$posts = $this->input->post();
				$posts = $this->input->post();
				$params = array();
				$params['username'] 		= $posts['username'];
				$params['password'] 		= $posts['password'];
				$params['email'] 		= $posts['email'];
				$query = $this->Common_model->add_record( 'users', $params );
			    if( $query ) {
					$message = '<div class="error" title="Error:" style="color:white;background-color: green;border: green;">Registered Successfully.Please login!</div>';
					$this->session->set_flashdata('message',$message);
					$this->load->view('login');
				} else {
					$message = '<div class="error" title="Error:" >Account not created. Please try again!</div>';
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
			$this->form_validation->set_rules('phone1','Cell Phone','trim|required');
			$this->form_validation->set_rules('phone2','Home Phone','trim');
			$this->form_validation->set_rules('email','Email','trim');
			if( $this->form_validation->run() == TRUE ) {
				
				$getjob=$this->db->query('SELECT * FROM jobs');
				$total=$getjob->num_rows();
				$total++;

				$posts = $this->input->post();
				$params['job_name'] 		= $posts['jobname'];
				$params['status'] 		='lead';
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
				$params['job_number'] 		= 'RJOB'.$total;
				$query = $this->Common_model->add_record( 'jobs', $params );

			  //$query = $this->Common_model->add_record( 'status', $params );

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
			$posts = $this->input->post();

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
					$errors = validation_errors();
					$errors = '<div class="alert alert-danger fade in alert-dismissable col-lg-12">';
					$errors .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>'.validation_errors().'</strong>';
					$errors .= '</div>';
           			$this->session->set_flashdata('message', $errors);
					redirect('dashboard/update_job/'.$posts['id']);
				
			} else {
				
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

				$this->db->where('id',$posts['id']);
				$this->db->update('jobs',$params);
				$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
				$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Record Saved Successfully!</strong>';
				$message .= '</div>';
				$this->session->set_flashdata('message',$message);
				redirect('dashboard/update_job/'.$posts['id']);

			}

		}else{

				redirect('dashboard/alllead');
		}
	}

	public function additional_party_add(){
		if( isset($_POST) && count($_POST) > 0 ) {
			$posts = $this->input->post();
		    $this->form_validation->set_rules('firstname','First Name','trim|required');
			$this->form_validation->set_rules('lastname','Last Name','trim|required');
			$this->form_validation->set_rules('email','Email','trim|required');
			$this->form_validation->set_rules('phone','Phone','trim|required');
			if( $this->form_validation->run() == FALSE ) {
					$errors = validation_errors();
					$errors = '<div class="alert alert-danger fade in alert-dismissable col-lg-12">';
					$errors .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>'.validation_errors().' for Additional Party</strong>';
					$errors .= '</div>';
           			$this->session->set_flashdata('message', $errors);
					redirect('dashboard/update_job/'.$posts['id']);
				
			} else {

				$params = array();
				$params['job_id'] 		= $posts['id'];
				$params['fname'] 		= $posts['firstname'];
				$params['lname'] 		= $posts['lastname'];
				$params['email'] 		= $posts['email'];
				$params['phone'] 		= $posts['phone'];
				

				$query = $this->Common_model->add_record( 'job_add_party', $params );
				$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
				$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Additional info Record Added Successfully!</strong>';
				$message .= '</div>';
				$this->session->set_flashdata('message',$message);
				redirect('dashboard/update_job/'.$posts['id']);
			}
		}
		
	}


	public function additional_party_update(){
		if( isset($_POST) && count($_POST) > 0 ) {
			$posts = $this->input->post();
		    $this->form_validation->set_rules('firstname','First Name','trim|required');
			$this->form_validation->set_rules('lastname','Last Name','trim|required');
			$this->form_validation->set_rules('email','Email','trim|required');
			$this->form_validation->set_rules('phone','Phone','trim|required');
			if( $this->form_validation->run() == FALSE ) {
					$errors = validation_errors();
					$errors = '<div class="alert alert-danger fade in alert-dismissable col-lg-12">';
					$errors .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>'.validation_errors().' for Additional Party</strong>';
					$errors .= '</div>';
           			$this->session->set_flashdata('message', $errors);
					redirect('dashboard/update_job/'.$posts['id']);
				
			} else {

				$params = array();
			
				$params['fname'] 		= $posts['firstname'];
				$params['lname'] 		= $posts['lastname'];
				$params['email'] 		= $posts['email'];
				$params['phone'] 		= $posts['phone'];

				$this->db->where('job_id',$posts['id']);
				$this->db->update('job_add_party',$params);
				
				$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
				$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Additional info Record Updated Successfully!</strong>';
				$message .= '</div>';
				$this->session->set_flashdata('message',$message);
				redirect('dashboard/update_job/'.$posts['id']);
			}
		}
		
	}

	

	public function save_team(){
		if( isset($_POST) && count($_POST) > 0 ) {
			$posts = $this->input->post();
		    $this->form_validation->set_rules('teamname','Team Name','trim|required');
			$this->form_validation->set_rules('remark','Remark','trim');
			if( $this->form_validation->run() == FALSE ) {
					$this->load->view('header');
					$this->load->view('add_team');
					$this->load->view('footer');
				
			} else {

				$params = array();
				$params['team_name'] 		= $posts['teamname'];
				$params['remark'] 		= $posts['remark'];
				$params['is_active'] 		= True;
				$query = $this->Common_model->add_record( 'teams', $params );
				$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
				$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Record Added Successfully!</strong>';
				$message .= '</div>';
				$this->session->set_flashdata('message',$message);
				redirect('dashboard/teams');
			}
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
	
	public function ajaxupload_jobdoc(){
		       
 if(is_array($_FILES) && !empty($_FILES['doc']))  
 {  
	  $doc=array();
	  $doc_name=array();$i=0;
      foreach($_FILES['doc']['name'] as $key => $filename)  
     {  	
		  	
           $file_name = explode(".", $filename);  
           $allowed_extension = array("jpg","pdf","jpeg","gif","png","doc","docx","xls","xlsx","ppt","pptx","txt","zip","rar","gzip");  
           if(in_array($file_name[1], $allowed_extension))  
           {  
                $new_name = $_FILES["doc"]["name"][$key];  
                $sourcePath = $_FILES["doc"]["tmp_name"][$key];  
                $targetPath = "assets/job_doc/".$new_name;  
                move_uploaded_file($sourcePath, $targetPath);  
				$doc[$i]=$_FILES["doc"]["name"][$key];
				$i++;
           } 
      }

		echo json_encode($doc);
      
      
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
	}
	
	public function ajaxsave_jobdoc(){
		$posts = $this->input->post();
		$data = json_decode($posts['name'], true);
		//print_r($data);
		
		for($i=0;$i<count($data);$i++){
			 $search = '.'.strtolower(pathinfo($data[$i], PATHINFO_EXTENSION));
             $trimmed = str_replace($search, '', $data[$i]) ;

			$params = array();
			$params['job_id'] 		= $posts['id'];
			$params['doc_name'] 		= $data[$i];
		    $params['name'] 		= $trimmed;
			$params['entry_date'] 		= date('Y-m-d h:i:s');
			$params['is_active'] 		= TRUE;
			$this->db->insert('jobs_doc', $params);
			$insertId = $this->db->insert_id();
			echo '<tr id="doc'.$insertId.'"><td style="width: 30px"></td><td style="width: 30px"><i class="del-doc pe-7s-close" id="'.$insertId.'"></i></td><td style="width: 30px"><a href="'.base_url().'assets/job_doc/'.$data[$i].'"  target="_blank">view</a></td><td><p id="docp'.$insertId.'">'.$trimmed.'</p><input style="width: 100%;display:none" name="'.$insertId.'" type="text"  class="docname" id="doctext'.$insertId.'" /><span class="'.$insertId.'">Edit</span></td><td >'.$data[$i].'</td></tr>';
			

			 
		}
	}
	 
	public function updatestatus(){
	   
		$posts = $this->input->post();
		$this->db->query("UPDATE jobs SET status='".$posts['status']."' WHERE id='".$posts['id']."'");
		return true;
	}
	

	public function deletephoto(){
	   
		$posts = $this->input->post();
		$this->db->query("UPDATE jobs_photo SET is_active=0 WHERE id='".$posts['id']."'");
		return true;
	}
	
	public function deletedoc(){
	   
		$posts = $this->input->post();
		$this->db->query("UPDATE jobs_doc SET is_active=0 WHERE id='".$posts['id']."'");
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

	public function imagerotate(){
		$posts = $this->input->post();
	  	$filename   =   $_SERVER['DOCUMENT_ROOT']."/assets/job_photo/".$posts['name'];//base_url()."assets/job_photo/".$posts['name'];
		$savename     = $filename;
		$angle=90;
		
		$original_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		if($original_extension == "jpg" or $original_extension == "jpeg"){
                    $original = imagecreatefromjpeg($filename);
                }
		if($original_extension == "gif"){
			$original = imagecreatefromgif($filename);
		}
		if($original_extension == "png"){
			$original = imagecreatefrompng($filename);
		}
		
	    // Your original file
       // $original   =   imagecreatefromjpeg($filename);
        // Rotate
        $rotated    =   imagerotate($original, $angle, 0);
        // If you have no destination, save to browser
        if($savename == false) {
                header('Content-Type: image/jpeg');
                imagejpeg($rotated);
            }
        else{
            if($original_extension == "jpg" or $original_extension=="jpeg"){
                    imagejpeg($rotated, $savename);
                }
			if($original_extension == "gif"){
				imagegif($rotated, $savename);
			}
			if($original_extension == "png"){
				imagepng($rotated, $savename);
			}
			
			// Save to a directory with a new filename
           // imagejpeg($rotated,$savename);
		}
        // Standard destroy command
        imagedestroy($rotated);

	   //echo $_SERVER['DOCUMENT_ROOT'];
	}

	public function updatedocname(){
	   
		$posts = $this->input->post();
		$name= $posts['na'];
		//$this->db->query("UPDATE jobs_doc SET name='".$name."' WHERE id='".$posts['id']."'");

		$this->db->set('name', $name);  //Set the column name and which value to set..
		$this->db->where('id', $posts['id']); //set column_name and value in which row need to update
		$this->db->update('jobs_doc');
		return true;
		echo $name;
	}



}
