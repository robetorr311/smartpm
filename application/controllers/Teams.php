<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Teams extends CI_Controller
{

	private $title = 'Teams';

	public function __construct()
	{
		parent::__construct();

		authAdminAccess();

		$this->load->model(['TeamModel', 'UserModel', 'TeamUserMapModel']);
		$this->load->library(['pagination', 'form_validation']);

		$this->team = new TeamModel();
		$this->user = new UserModel();
		$this->team_user_map = new TeamUserMapModel();
	}

	public function index($start = 0)
	{
		$limit = 10;
		$pagiConfig = [
			'base_url' => base_url('teams'),
			'total_rows' => $this->team->getCount(),
			'per_page' => $limit
		];
		$this->pagination->initialize($pagiConfig);
		$teams = $this->team->allTeams($start, $limit);
		$this->load->view('header', [
			'title' => $this->title
		]);
		$this->load->view('teams/index', [
			'teams' => $teams,
			'pagiLinks' => $this->pagination->create_links()
		]);
		$this->load->view('footer');
	}

	public function create()
	{
		$users = $this->user->getUserList();
		$this->load->view('header', [
			'title' => $this->title
		]);
		$this->load->view('teams/create', [
			'users' => $users
		]);
		$this->load->view('footer');
	}

	public function store()
	{
		$this->form_validation->set_rules('name', 'Team Name', 'trim|required');
		$this->form_validation->set_rules('remark', 'Remark', 'trim');
		$this->form_validation->set_rules('team_members', 'Team Members', 'is_own_ids[users, Users]');

		if ($this->form_validation->run() == TRUE) {
			$teamData = $this->input->post();
			$insert = $this->team->insert([
				'team_name' => $teamData['name'],
				'remark' => $teamData['remark']
			]);
			if ($insert) {
				$errors = '';

				$members = $teamData['team_members'];
				if (!empty($members)) {
					$members = explode(',', $members);
					$membersInsert = $this->team_user_map->insertByUserArr($members, $insert);
					if (!$membersInsert) {
						$errors .= '<p>Unable to add Members.</p>';
					}
				}

				if (!empty($errors)) {
					$this->session->set_flashdata('errors', $errors);
				}

				redirect('team/' . $insert);
			} else {
				$this->session->set_flashdata('errors', '<p>Unable to Create Task.</p>');
				redirect('team/create');
			}
		} else {
			$this->session->set_flashdata('errors', validation_errors());
			redirect('team/create');
		}
	}

	public function show($id)
	{
		$team = $this->team->getTeamById($id);
		if ($team) {
			$members = $this->team_user_map->getUsersByTeamId($id);
			$this->load->view('header', [
				'title' => $this->title
			]);
			$this->load->view('teams/show', [
				'team' => $team,
				'members' => $members
			]);
			$this->load->view('footer');
		}
	}


	public function update()
	{
		if (isset($_POST) && count($_POST) > 0) {
			$posts = $this->input->post();
			$this->form_validation->set_rules('teamname', 'Team Name', 'trim|required');
			$this->form_validation->set_rules('remark', 'Remark', 'trim');
			if ($this->form_validation->run() == FALSE) {


				$errors = '<div class="alert alert-danger fade in alert-dismissable col-lg-12">';
				$errors .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>' . validation_errors() . ' for Additional Party</strong>';
				$errors .= '</div>';
				$this->session->set_flashdata('message', $errors);
				redirect('team/' . $posts['id'] . '/edit');
			} else {

				$params = array();
				$params['team_name'] 		= $posts['teamname'];
				$params['remark'] 		= $posts['remark'];
				$params['is_active'] 		= True;
				$this->team->update_record($params, ['id' => $posts['id']]);
				$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
				$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Record Added Successfully!</strong>';
				$message .= '</div>';
				$this->session->set_flashdata('message', $message);
				redirect('teams/');
			}
		}
	}


	public function edit()
	{
		$teams = $this->team->get_all_where(['id' => $this->uri->segment(2)]);

		$this->load->view('header', [
			'title' => $this->title
		]);
		$this->load->view('teams/edit', ['teams' => $teams, 'jobid' => $this->uri->segment(2)]);
		$this->load->view('footer');
	}


	public function delete()
	{
		$teams = $this->team->delete(['id' => $this->uri->segment(2)]);
		redirect('teams');
	}
}
