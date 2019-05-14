<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('UserModel');

		$this->user = new UserModel();
	}

	public function index()
	{
		redirect('login');
	}

	public function login()
	{
		$this->load->view('auth/index');
	}

	public function auth()
	{
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
							'type' => $user->type,
							'logged_in' => TRUE
						]);
						$result1 = $this->user->get_crm_data('admin_setting', ['color', 'url', 'favicon'], ['user_id' => $user->id]);
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
		$this->load->view('auth/register');
	}

	public function register()
	{
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('conf_password', 'Confirm Password', 'trim|required|matches[password]');
		$this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email|is_unique[users.email_id]');

		if ($this->user->mail_exists($_POST['username']) == TRUE) {
			$message = '<div class="error" title="Error:" >Email Already Registered!</div>';
			$this->session->set_flashdata('message', $message);
			$this->load->view('auth/register');
		} else {
			$_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
			$_POST['usertype'] = 'user';
			$query = $this->user->signup($_POST);
			if ($query) {

				$message = '<div class="error" title="Error:" style="color:white;background-color: green;border: green;">Registered Successfully.Please login!</div>';
				$this->session->set_flashdata('message', $message);
				redirect('account/index');
			} else {
				$message = '<div class="error" title="Error:" >Account not created. Please try again!</div>';
				$this->session->set_flashdata('message', $message);
				redirect('account/index');
			}
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}
