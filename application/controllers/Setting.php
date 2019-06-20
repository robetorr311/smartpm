<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	    public function __construct()
	    {
	        parent::__construct();
	        authAdminAccess();


	        
	        $this->load->model('StatusTagModel');

        	$this->status = new StatusTagModel();
	    }

	    public function index(){
	    	$query['data'] = $this->db->query("SELECT * FROM admin_setting;");
			$this->load->view('header',['title' => 'Setting']);
			$this->load->view('setting/index',$query);
			$this->load->view('footer');
	    }

	    public function ajaxupload(){
			if ( 0 < $_FILES['file']['error'] ) {
				echo 'Error: ' . $_FILES['file']['error'] . '<br>';
			}
			else {
				$fileInfo = pathinfo($_FILES['file']['name']);
				$filename = $fileInfo['filename'] . '.' . $fileInfo['extension'];
				$extentFilename = 1;
				while (file_exists('assets/company_photo/' . $filename)) {
					$filename = $fileInfo['filename'] . '_' . $extentFilename . '.' . $fileInfo['extension'];
					$extentFilename++;
				}
				move_uploaded_file($_FILES['file']['tmp_name'], 'assets/company_photo/' . $filename);
				echo $filename;
			}
		}
	   
	    public function ajaxsave(){
			$posts = $this->input->post();
			if($posts['id']=='logo'){
			$this->db->query("UPDATE admin_setting SET url='".$posts['name']."'");
			}
			else{
			$this->db->query("UPDATE admin_setting SET favicon='".$posts['name']."'");
			}
			echo $posts['name'];
		}
		
		public function ajaxcolor(){
		   
		    $array = json_decode(json_encode($this->session->userdata), true);
			$posts = $this->input->post();
			$this->db->query("UPDATE admin_setting SET color='".$posts['color']."' WHERE company_id='".$array['company_id']."'");
			 $this->session->set_userdata("color",$posts['color']);
			echo $posts['color'];
		}

		public function status_tag(){
	    	

			$query['job_type'] = $this->status->getall('job_type');
			$query['job_classification'] = $this->status->getall('job_classification');
			$query['lead_status'] = $this->status->getall('lead_status');
			$query['client_status'] = $this->status->getall('client_status');
			$query['contract_status'] = $this->status->getall('contract_status');
			$this->load->view('header',['title' => 'Status Tags']);
			$this->load->view('setting/status',$query);
			$this->load->view('footer');
	    }

	    public function newtag(){
	    	$posts = $this->input->post();
	    	$params = array();
			$params['status_tag_id'] 		= $posts['id'];
			$params['value'] 		= strtolower($posts['type']);
			$params['is_active'] 		= 1;
	  		$this->status->addTag($params);
	  		redirect('setting/status');
	    }

	    public function deltag(){
	    	$this->status->delete_record(['id' => $this->uri->segment(2)]);
	    	redirect('setting/status');
	    }


}