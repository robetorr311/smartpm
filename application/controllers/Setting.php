<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(['StatusTagModel', 'AdminSettingModel']);
		$this->status = new StatusTagModel();
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

	public function status_tag()
	{
		authAccess();
		
		$query['job_type'] = $this->status->getall('job_type');
		$query['job_classification'] = $this->status->getall('job_classification');
		$query['lead_status'] = $this->status->getall('lead_status');
		$query['client_status'] = $this->status->getall('client_status');
		$query['contract_status'] = $this->status->getall('contract_status');
		$this->load->view('header', ['title' => 'Status Tags']);
		$this->load->view('setting/status', $query);
		$this->load->view('footer');
	}

	public function newtag()
	{
		authAccess();
		
		$posts = $this->input->post();
		$params = array();
		$params['status_tag_id'] 		= $posts['id'];
		$params['value'] 		= strtolower($posts['type']);
		$params['is_active'] 		= 1;
		$this->status->addTag($params);
		redirect('setting/status');
	}

	public function deltag()
	{
		authAccess();
		
		$this->status->delete_record(['id' => $this->uri->segment(2)]);
		redirect('setting/status');
	}
}
