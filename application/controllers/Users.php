<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
	private $title = 'Users';

	public function __construct()
	{
		parent::__construct();

		$this->load->model(['UserModel', 'AdminSettingModel', 'UserCellNotifSuffixModel']);
		$this->load->library(['form_validation', 'notify']);

		$this->user = new UserModel();
		$this->admin_setting = new AdminSettingModel();
		$this->userCellNotifSuffix = new UserCellNotifSuffixModel();
	}

	public function index()
	{
		authAccess([UserModel::$level_admin]);

		$users = $this->user->allUsers();
		$this->load->view('header', [
			'title' => $this->title
		]);
		$this->load->view('users/index', [
			'users' => $users
		]);
		$this->load->view('footer');
	}

	public function create()
	{
		authAccess([UserModel::$level_admin]);

		$levels = UserModel::getLevels();
		$notifications = UserModel::getNotifications();
		$cellNotifSuffix = $this->userCellNotifSuffix->allCellNotifSuffix();

		$this->load->view('header', [
			'title' => $this->title
		]);
		$this->load->view('users/create', [
			'levels' => $levels,
			'notifications' => $notifications,
			'cellNotifSuffix' => $cellNotifSuffix
		]);
		$this->load->view('footer');
	}

	public function store()
	{
		authAccess([UserModel::$level_admin]);

		$levelKeys = implode(',', array_keys(UserModel::getLevels()));
		$notificationKeys = implode(',', array_keys(UserModel::getNotifications()));
		$cellNotifSuffixKeys = implode(',', array_column($this->userCellNotifSuffix->allCellNotifSuffix(), 'id'));

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email_id', 'Email ID', 'trim|required|valid_email|is_unique[users.email_id]', [
			'is_unique' => 'The user with this Email ID is already exist.'
		]);
		$this->form_validation->set_rules('level', 'Level', 'trim|required|numeric|in_list[' . $levelKeys . ']');
		$this->form_validation->set_rules('office_phone', 'Office Phone', 'trim|numeric');
		$this->form_validation->set_rules('home_phone', 'Home Phone', 'trim|numeric');
		$this->form_validation->set_rules('cell_1', 'Cell 1', 'trim|numeric');
		$this->form_validation->set_rules('cell_1_provider', 'Cell 1 Provider', 'trim|numeric|in_list[' . $cellNotifSuffixKeys . ']');
		$this->form_validation->set_rules('cell_2', 'Cell 2', 'trim|numeric');
		$this->form_validation->set_rules('notifications', 'Notifications', 'trim|required|numeric|in_list[' . $notificationKeys . ']');
		$this->form_validation->set_rules('is_active', 'Status', 'trim|required|numeric|in_list[0,1]');

		if ($this->form_validation->run() == TRUE) {
			$userData = $this->input->post();
			$insert = $this->user->insert([
				'first_name' => $userData['first_name'],
				'last_name' => $userData['last_name'],
				'email_id' => $userData['email_id'],
				'password' => '',
				'level' => $userData['level'],
				'office_phone' => $userData['office_phone'],
				'home_phone' => $userData['home_phone'],
				'cell_1' => $userData['cell_1'],
				'cell_1_provider' => $userData['cell_1_provider'],
				'cell_2' => $userData['cell_2'],
				'notifications' => $userData['notifications'],
				'company_id' => $this->session->company_id,
				'is_active' => $userData['is_active']
			]);

			if ($insert) {
				$user = $this->user->getUserById($insert);
				if ($user) {
					$token = $this->user->setPasswordToken($user);
					$admin_setting = $this->admin_setting->getAdminSetting();
					$logoUrl = $admin_setting ? 'company_photo/' . $admin_setting->url : 'img/logo.png';
					$this->notify->sendWelcomeUserNotification($user->email_id, $logoUrl);
					$this->notify->createPassword($user->email_id, $token, $logoUrl);
				}
				redirect('user/' . $insert);
			} else {
				$this->session->set_flashdata('errors', '<p>Unable to Create User.</p>');
				redirect('user/create');
			}
		} else {
			$this->session->set_flashdata('errors', validation_errors());
			redirect('user/create');
		}
	}

	public function edit($id)
	{
		authAccess([UserModel::$level_admin]);

		$user = $this->user->getUserById($id);
		if ($user) {
			$levels = UserModel::getLevels();
			$notifications = UserModel::getNotifications();

			$this->load->view('header', [
				'title' => $this->title
			]);
			$this->load->view('users/edit', [
				'user' => $user,
				'levels' => $levels,
				'notifications' => $notifications
			]);
			$this->load->view('footer');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('users');
		}
	}

	public function update($id)
	{
		authAccess([UserModel::$level_admin]);

		$user = $this->user->getUserById($id);
		if ($user) {
			$levelKeys = implode(',', array_keys(UserModel::getLevels()));
			$notificationKeys = implode(',', array_keys(UserModel::getNotifications()));
			$cellNotifSuffixKeys = implode(',', array_column($this->userCellNotifSuffix->allCellNotifSuffix(), 'id'));

			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
			if ($user->email_id != $this->input->post('email_id')) {
				$this->form_validation->set_rules('email_id', 'Email ID', 'trim|required|valid_email|is_unique[users.email_id]', [
					'is_unique' => 'The user with this Email ID is already exist.'
				]);
			}
			$this->form_validation->set_rules('level', 'Level', 'trim|required|numeric|in_list[' . $levelKeys . ']');
			$this->form_validation->set_rules('office_phone', 'Office Phone', 'trim|numeric');
			$this->form_validation->set_rules('home_phone', 'Home Phone', 'trim|numeric');
			$this->form_validation->set_rules('cell_1', 'Cell 1', 'trim|numeric');
			$this->form_validation->set_rules('cell_1_provider', 'Cell 1 Provider', 'trim|numeric|in_list[' . $cellNotifSuffixKeys . ']');
			$this->form_validation->set_rules('cell_2', 'Cell 2', 'trim|numeric');
			$this->form_validation->set_rules('notifications', 'Notifications', 'trim|required|numeric|in_list[' . $notificationKeys . ']');
			$this->form_validation->set_rules('is_active', 'Status', 'trim|required|numeric|in_list[0,1]');

			if ($this->form_validation->run() == TRUE) {
				$userData = $this->input->post();
				$_userData = [
					'first_name' => $userData['first_name'],
					'last_name' => $userData['last_name'],
					'level' => $userData['level'],
					'office_phone' => $userData['office_phone'],
					'home_phone' => $userData['home_phone'],
					'cell_1' => $userData['cell_1'],
					'cell_1_provider' => $userData['cell_1_provider'],
					'cell_2' => $userData['cell_2'],
					'notifications' => $userData['notifications'],
					'is_active' => $userData['is_active']
				];
				if ($user->email_id != $userData['email_id']) {
					$_userData['email_id'] = $userData['email_id'];
				}
				$update = $this->user->update($id, $_userData);

				if (!$update) {
					$this->session->set_flashdata('errors', '<p>Unable to Update User.</p>');
				}
			} else {
				$this->session->set_flashdata('errors', validation_errors());
			}
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
		}
		redirect('user/' . $id);
	}

	public function show($id)
	{
		authAccess([UserModel::$level_admin]);

		$user = $this->user->getUserById($id);
		if ($user) {
			$levels = UserModel::getLevels();
			$notifications = UserModel::getNotifications();
			$cellNotifSuffix = $this->userCellNotifSuffix->allCellNotifSuffix();

			$this->load->view('header', [
				'title' => $this->title
			]);
			$this->load->view('users/show', [
				'user' => $user,
				'levels' => $levels,
				'notifications' => $notifications,
				'cellNotifSuffix' => $cellNotifSuffix
			]);
			$this->load->view('footer');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('users');
		}
	}

	public function delete($id)
	{
		authAccess([UserModel::$level_admin]);

		$user = $this->user->getUserById($id);
		if ($user) {
			$delete = $this->user->delete($id);
			if (!$delete) {
				$this->session->set_flashdata('errors', '<p>Unable to delete User.</p>');
			}
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
		}
		redirect('users');
	}
}
