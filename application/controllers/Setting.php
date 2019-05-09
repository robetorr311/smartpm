<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	    public function __construct()
	    {
	        parent::__construct();
	        authAdminAccess();
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
				move_uploaded_file($_FILES['file']['tmp_name'], 'assets/img/' . $_FILES['file']['name']);
				echo $_FILES['file']['name'];
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
		
		public function ajaxcolor(){
		   
		    $array = json_decode(json_encode($this->session->userdata), true);
			$posts = $this->input->post();
			$this->db->query("UPDATE admin_setting SET color='".$posts['color']."' WHERE user_id='".$array['admininfo']['id']."'");
			 $this->session->set_userdata("color",$posts['color']);
			echo $posts['color'];
		}

		public function status_tag(){
	    	
			$this->load->view('header',['title' => 'Status Tags']);
			$this->load->view('setting/status');
			$this->load->view('footer');
	    }


}