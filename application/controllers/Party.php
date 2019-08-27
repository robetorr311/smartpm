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
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('errors', validation_errors());
			redirect('lead/' . $sub_base_path . $id . '/edit');
		} else {
			$posts = $this->input->post();
			$insert = $this->party->insert([
				'job_id' => $id,
				'fname' => $posts['firstname'],
				'lname' => $posts['lastname'],
				'email' => $posts['email'],
				'phone' => $posts['phone']
			]);
			redirect('lead/' . $sub_base_path . $id);
		}
	}

	public function update($id, $sub_base_path = '')
	{
		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('errors', validation_errors());
			redirect('lead/' . $sub_base_path . $id . '/edit');
		} else {
			$posts = $this->input->post();
			$update = $this->party->updateByLeadId($id, [
				'fname' => $posts['firstname'],
				'lname' => $posts['lastname'],
				'email' => $posts['email'],
				'phone' => $posts['phone']
			]);
			redirect('lead/' . $sub_base_path . $id);
		}
	}
}
