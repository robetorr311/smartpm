<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	 public function __construct()
	    {
	        parent::__construct();
	        authAdminAccess();
	        $this->load->model(['UserModel','TeamModel','UserTeamTrackModel','TaskUserTagsModel']);

	        $this->user = new UserModel();
	        $this->team = new TeamModel();
	        $this->task_team_track = new UserTeamTrackModel();
	        $this->task_user_tags = new TaskUserTagsModel();
	    }

	    public function index(){
	    	$params = array();
			$params['usertype'] ='user';
			$query['users'] = $this->user->get_all_where($params);
			$this->load->view('header',['title' => 'Users List']);
			$this->load->view('users/index',$query);
			$this->load->view('footer');
	    }

	     public function view(){
	    	$params = array();
			$params['id'] =$this->uri->segment(2);
			$query['users'] = $this->user->get_all_where($params);
			$query['teams'] = $this->team->get_all_where(['is_active'=>1]);
			$query['tasks'] = $this->db->query("SELECT  a.name, b.job_id, c.note FROM tasks a  INNER JOIN task_job_tags b ON a.id = b.task_id INNER JOIN task_notes c ON a.id = c.task_id WHERE   a.assigned_to =".$this->uri->segment(2));

			$this->load->view('header',['title' => 'Users Detail']);
			$this->load->view('users/view',$query);
			$this->load->view('footer');
	    }
	    public function adduser(){
	    		$posts = $this->input->post();
				$this->task_team_track->update_record(['is_active'=>false,'end_date'=>date('Y-m-d h:i:s')],['userid' =>$posts['userid'],'is_active'=>1]);
				$params = array();
				$params['userid'] =$posts['userid'];
				$params['teamid'] =$posts['teamid'];
				$params['entry_date'] = date('Y-m-d h:i:s');
				$params['is_active'] =true;
				$this->task_team_track->add_record($params);
	    }

	    public function gettask(){
	    	
	    	

	    	 


	        
	    }
}