<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Party extends CI_Controller {
	 public function __construct()
	    {
	        parent::__construct();
	        authAdminAccess();
	        $this->load->model('PartyModel');
       		$this->load->library(['pagination', 'form_validation']);

        	$this->party = new PartyModel();
	    }
 
	    public function index($id){
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
					redirect('lead/'.$id.'/edit');
				
			} else {

				$params = array();
				$params['job_id'] 		= $id;
				$params['fname'] 		= $posts['firstname'];
				$params['lname'] 		= $posts['lastname'];
				$params['email'] 		= $posts['email'];
				$params['phone'] 		= $posts['phone'];
				

				$this->party->add_record($params);
				$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
				$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Additional info Record Added Successfully!</strong>';
				$message .= '</div>';
				$this->session->set_flashdata('message',$message);
				redirect('lead/'.$id.'/edit');
			}
		}
		
	}


	public function update($id){
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
					redirect('lead/'.$id.'/edit');
				
			} else {

				$params = array();
			
				$params['fname'] 		= $posts['firstname'];
				$params['lname'] 		= $posts['lastname'];
				$params['email'] 		= $posts['email'];
				$params['phone'] 		= $posts['phone'];

				//$this->db->where('job_id',$id);
				//$this->db->update('job_add_party',$params);
				$this->party->update_record($params,['job_id' => $id]);
				$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
				$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Additional info Record Updated Successfully!</strong>';
				$message .= '</div>';
				$this->session->set_flashdata('message',$message);
				redirect('lead/'.$id.'/edit');
			}
		}
		
	}

	     
}