<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(['AdminSettingModel']);
		$this->adminSetting = new AdminSettingModel();
	}

	public function index()
	{
		authAccess();
		
		$settings = $this->adminSetting->getAdminSetting();
		$this->load->view('header', ['title' => 'Setting']);
		$this->load->view('setting/index', ['settings' => $settings]);
		$this->load->view('footer');
	}

	public function companyDetails()
	{
		authAccess();
		$settings = $this->input->post();
		$this->db->query("UPDATE admin_setting SET company_name='" . $settings['company_name'] . "', company_phone='" . $settings['company_phone'] . "', company_address='" . $settings['company_address'] . "', company_website='" . $settings['company_website'] . "', company_email='" . $settings['company_email'] . "'");
		redirect('setting');
	}

	public function ajaxupload()
	{
		authAccess();
		
		if (0 < $_FILES['file']['error']) {
			echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		} else {
			$fileInfo = pathinfo($_FILES['file']['name']);
			$filename = $fileInfo['filename'] . '.' . $fileInfo['extension'];
			$extentFilename = 1;
			while (file_exists('assets/company_photo/' . $filename)) {
				$filename = $fileInfo['filename'] . '_' . $extentFilename . '.' . $fileInfo['extension'];
				$extentFilename++;
			}
			move_uploaded_file($_FILES['file']['tmp_name'], 'assets/company_photo/' . $filename);
			echo $filename;
		}
	}

	public function ajaxsave()
	{
		authAccess();
		
		$posts = $this->input->post();
		if ($posts['id'] == 'logo') {
			$this->db->query("UPDATE admin_setting SET url='" . $posts['name'] . "'");
		} else {
			$this->db->query("UPDATE admin_setting SET favicon='" . $posts['name'] . "'");
		}
		echo $posts['name'];
	}

	public function ajaxcolor()
	{
		authAccess();
		
		$array = json_decode(json_encode($this->session->userdata), true);
		$posts = $this->input->post();
		$this->db->query("UPDATE admin_setting SET color='" . $posts['color'] . "' WHERE company_id='" . $array['company_id'] . "'");
		$this->session->set_userdata("color", $posts['color']);
		echo $posts['color'];
	}
}
