<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teams extends CI_Controller {
	 public function __construct()
	    {
	        parent::__construct();
	        authAdminAccess();
	        $this->load->model('TeamModel');
       		$this->load->library(['pagination', 'form_validation']);

        	$this->team = new TeamModel();
	    }

	    public function index(){
			$limit = 10;
	    	$pagiConfig = [
            'base_url' => base_url('teams'),
            'total_rows' => $this->team->getCount(),
            'per_page' => $limit
        	];
        	$this->pagination->initialize($pagiConfig);
			$teams = $this->team->get_all_where(['is_active'=>1]);
			$this->load->view('header',['title' => 'Teams']);
			$this->load->view('teams/index',['teams' => $teams,'pagiLinks' => $this->pagination->create_links()]);
			$this->load->view('footer');
	    }

	    public function new()
		{	
			$this->load->view('header',['title' => 'Add NewTeams']);
			$this->load->view('teams/new');
			$this->load->view('footer');
		}

		 public function view(){
		 	$data = $this->team->get_all_where(['id' => $this->uri->segment(2)]);
			$this->load->view('header',['title' => 'Team Detail']);
			$this->load->view('teams/view',['datas' => $data]);
			$this->load->view('footer');
	    }

	    public function store(){
		if( isset($_POST) && count($_POST) > 0 ) {
			$posts = $this->input->post();
		    $this->form_validation->set_rules('teamname','Team Name','trim|required');
			$this->form_validation->set_rules('remark','Remark','trim');
			if( $this->form_validation->run() == FALSE ) {
					

					$errors = '<div class="alert alert-danger fade in alert-dismissable col-lg-12">';
					$errors .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>'.validation_errors().' for Additional Party</strong>';
					$errors .= '</div>';
           			$this->session->set_flashdata('message', $errors);
					redirect('team/new');
				
			} else {

				$params = array();
				$params['team_name'] 		= $posts['teamname'];
				$params['remark'] 		= $posts['remark'];
				$params['is_active'] 		= True;
				$query = $this->team->add_record($params);
				$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
				$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Record Added Successfully!</strong>';
				$message .= '</div>';
				$this->session->set_flashdata('message',$message);
				redirect('teams/');
			}
		}
		
	}


	public function update(){
		if( isset($_POST) && count($_POST) > 0 ) {
			$posts = $this->input->post();
		    $this->form_validation->set_rules('teamname','Team Name','trim|required');
			$this->form_validation->set_rules('remark','Remark','trim');
			if( $this->form_validation->run() == FALSE ) {
					

					$errors = '<div class="alert alert-danger fade in alert-dismissable col-lg-12">';
					$errors .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>'.validation_errors().' for Additional Party</strong>';
					$errors .= '</div>';
           			$this->session->set_flashdata('message', $errors);
					redirect('team/'.$posts['id'].'/edit');
				
			} else {

				$params = array();
				$params['team_name'] 		= $posts['teamname'];
				$params['remark'] 		= $posts['remark'];
				$params['is_active'] 		= True;
				$this->team->update_record($params,['id' =>$posts['id']]);
				$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
				$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Record Added Successfully!</strong>';
				$message .= '</div>';
				$this->session->set_flashdata('message',$message);
				redirect('teams/');
			}
		}
	}


	 public function edit(){
			$teams = $this->team->get_all_where(['id' => $this->uri->segment(2)]);
			
			$this->load->view('header',['title' => 'Team Update']);
			$this->load->view('teams/edit',['teams' => $teams,'jobid' => $this->uri->segment(2)]);
			$this->load->view('footer');
	    }


	   public function delete(){
			$teams = $this->team->delete(['id' => $this->uri->segment(2)]);
			redirect('teams');
	    }
}