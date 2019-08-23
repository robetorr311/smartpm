<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Party extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		authAdminAccess();
		$this->load->model('PartyModel');
		$this->load->library(['pagination', 'form_validation']);

		$this->party = new PartyModel();
	}

	public function add($id, $sub_base_path = '')
	{
		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		if (isset($_POST) && count($_POST) > 0) {
			$posts = $this->input->post();
			$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('errors', validation_errors());
				redirect('lead/' . $sub_base_path . $id . '/edit');
			} else {
				$params = array();
				$params['job_id'] = $id;
				$params['fname'] = $posts['firstname'];
				$params['lname'] = $posts['lastname'];
				$params['email'] = $posts['email'];
				$params['phone'] = $posts['phone'];
				$this->party->add_record($params);
				redirect('lead/' . $sub_base_path . $id);
			}
		}
	}

	public function update($id, $sub_base_path = '')
	{
		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		if (isset($_POST) && count($_POST) > 0) {
			$posts = $this->input->post();
			$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('errors', validation_errors());
				redirect('lead/' . $sub_base_path . $id . '/edit');
			} else {
				$params = array();
				$params['fname'] = $posts['firstname'];
				$params['lname'] = $posts['lastname'];
				$params['email'] = $posts['email'];
				$params['phone'] = $posts['phone'];
				$this->party->update_record($params, ['job_id' => $id]);
				redirect('lead/' . $sub_base_path . $id);
			}
		}
	}
}
