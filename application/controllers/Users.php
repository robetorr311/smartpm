<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	 public function __construct()
	    {
	        parent::__construct();
	        authAdminAccess();
	        $this->load->model(['UserModel','TeamModel','UserTeamTrackModel','TaskUserTagsModel','TaskModel']);

	        $this->user = new UserModel();
	        $this->team = new TeamModel();
	        $this->task_team_track = new UserTeamTrackModel();
	        $this->task_user_tags = new TaskUserTagsModel();
	        $this->task= new TaskModel();
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
			$query['tasks'] = $this->task->getTaskByUserId($this->uri->segment(2));
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

	    
}