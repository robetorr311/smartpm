<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(['UserModel', 'CompanyModel', 'AdminSettingModel']);

		$this->user = new UserModel();
		$this->company = new CompanyModel();
		$this->admin_setting = new AdminSettingModel();
	}

	public function index()
	{
		if ($this->session->logged_in) {
			redirect('dashboard');
			die();
		}

		redirect('login');
	}

	public function login()
	{
		if ($this->session->logged_in) {
			redirect();
			die();
		}

		$this->load->view('auth/index');
	}

	public function auth()
	{
		if ($this->session->logged_in) {
			redirect();
			die();
		}

		$this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$authData = $this->input->post();
			if ($user = $this->user->authenticate($authData['email'], $authData['password'])) {
				if (empty($user->verification_token)) {
					if ($user->is_active == 1) {
						$this->session->set_userdata([
							'first_name' => $user->first_name,
							'last_name' => $user->last_name,
							'username' => $user->username,
							'id' => $user->id,
							'email_id' => $user->email_id,
							'level' => $user->level,
							'company_id' => $user->company_id,
							'logged_in' => TRUE
						]);
						$result1 = $this->user->get_crm_data('admin_setting', ['color', 'url', 'favicon'], ['company_id' => $user->company_id]);
						$this->session->set_userdata('admindata', $result1);
						redirect('dashboard');
					} else {
						$message = '<div class="error"><p>Your account is not activated.</p></div>';
						$this->session->set_flashdata('message', $message);
						redirect('login');
					}
				} else {
					$message = '<div class="error"><p>Verify your Email ID before login.</p></div>';
					$this->session->set_flashdata('message', $message);
					redirect('login');
				}
			} else {
				$message = '<div class="error"><p>Email ID or Password Invalid.</p></div>';
				$this->session->set_flashdata('message', $message);
				redirect('login');
			}
		} else {
			$message = '<div class="error">' . validation_errors() . '</div>';
			$this->session->set_flashdata('message', $message);
			redirect('login');
		}
	}

	public function signup()
	{
		if ($this->session->logged_in) {
			redirect();
			die();
		}

		$this->load->view('auth/register');
	}

	public function register()
	{
		if ($this->session->logged_in) {
			redirect();
			die();
		}

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('conf_password', 'Confirm Password', 'trim|required|matches[password]');
		$this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email|is_unique[users.email_id]');
		$this->form_validation->set_rules('company_email', 'Company Email ID', 'trim|valid_email');
		$this->form_validation->set_rules('company_alt_email', 'Company Alt Email ID', 'trim|valid_email');

		$userData = $this->input->post();
		$companyInsert = $this->company->insert([
			'name' => $userData['company_name'],
			'email_id' => $userData['company_email_id'],
			'alt_email_id' => $userData['company_alt_email_id'],
			'address' => $userData['company_address'],
			'city' => $userData['company_city'],
			'state' => $userData['company_state'],
			'zip' => $userData['company_zip']
		]);

		if ($companyInsert) {
			$message = '';
			$admin_setting = $this->admin_setting->insert([
				'company_id' => $companyInsert
			]);
			if (!$admin_setting) {
				$message .= '<div class="error" title="Error:" >Setting options not created. Please inform Admin!</div>';
			}
			$signup = $this->user->signup([
				'first_name' => $userData['first_name'],
				'last_name' => $userData['last_name'],
				'password' => $userData['password'],
				'email_id' => $userData['email_id'],
				'office_phone' => $userData['office_phone'],
				'home_phone' => $userData['home_phone'],
				'cell_1' => $userData['cell_1'],
				'cell_2' => $userData['cell_2'],
				'company_id' => $companyInsert
			]);
			if ($signup) {
				$message .= '<div class="error" title="Error:" style="color:white;background-color: green;border: green;">Registered Successfully.Please login!</div>';
				$this->session->set_flashdata('message', $message);
				redirect('login');
			} else {
				$message .= '<div class="error" title="Error:" >User not created. Please try again!</div>';
				$this->session->set_flashdata('message', $message);
				redirect('signup');
			}
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}
