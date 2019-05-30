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
		$this->form_validation->set_rules('manager', 'Manager', 'trim|required');
		$this->form_validation->set_rules('team_leader', 'Team Leader', 'trim|required');
		$this->form_validation->set_rules('team_members', 'Team Members', 'is_own_ids[users, Users]');

		if ($this->form_validation->run() == TRUE) {
			$teamData = $this->input->post();
			$insert = $this->team->insert([
				'team_name' => $teamData['name'],
				'remark' => $teamData['remark'],
				'manager' => $teamData['manager'],
				'team_leader' => $teamData['team_leader']
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

	public function edit($id)
	{
		$team = $this->team->getTeamById($id);
		if ($team) {
			$members = $this->team_user_map->getUsersByTeamId($id);
			$users = $this->user->getUserList();

			$this->load->view('header', [
				'title' => $this->title
			]);
			$this->load->view('teams/edit', [
				'team' => $team,
				'members' => $members,
				'users' => $users
			]);
			$this->load->view('footer');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('teams');
		}
	}

	public function update($id)
	{
		$team = $this->team->getTeamById($id);
		if ($team) {
			$this->form_validation->set_rules('name', 'Team Name', 'trim|required');
			$this->form_validation->set_rules('remark', 'Remark', 'trim');
			$this->form_validation->set_rules('manager', 'Manager', 'trim|required');
			$this->form_validation->set_rules('team_leader', 'Team Leader', 'trim|required');
			$this->form_validation->set_rules('team_members', 'Team Members', 'is_own_ids[users, Users]');
			if ($this->form_validation->run() == TRUE) {
				$teamData = $this->input->post();
				$update = $this->team->update($id, [
					'team_name' => $teamData['name'],
					'remark' => $teamData['remark'],
					'manager' => $teamData['manager'],
					'team_leader' => $teamData['team_leader']
				]);
				if ($update) {
					$errors = '';

					$old_members = $this->team_user_map->getUsersByTeamId($id);
					$old_members = ($old_members) ? array_column($old_members, 'id') : [];
					$members = $teamData['team_members'];
					$members = (!empty($members)) ? explode(',', $members) : [];
					$members_insert = array_diff($members, $old_members);
					if (count($members_insert)) {
						$membersInsert = $this->team_user_map->insertByUserArr($members_insert, $id);
						if (!$membersInsert) {
							$errors .= '<p>Unable to add new Members.</p>';
						}
					}
					$members_remove = array_diff($old_members, $members);
					if (count($members_remove)) {
						$membersRemove = $this->team_user_map->deleteByUserArr($members_remove, $id);
						if (!$membersRemove) {
							$errors .= '<p>Unable to remove added Members.</p>';
						}
					}

					if (!empty($errors)) {
						$this->session->set_flashdata('errors', $errors);
					}

					redirect('team/' . $id);
				}
			} else {
				$this->session->set_flashdata('errors', validation_errors());
				redirect('team/' . $id . '/edit');
			}
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('teams');
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
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('teams');
		}
	}

	public function delete($id)
	{
		$team = $this->team->getTeamById($id);
		if ($team) {
			$this->team_user_map->deleteRelated($id);
			$delete = $this->team->delete($id);
			if (!$delete) {
				$this->session->set_flashdata('errors', '<p>Unable to delete Team.</p>');
			}
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
		}
		redirect('teams');
	}
}
