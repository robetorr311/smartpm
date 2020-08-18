<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PublicFolder extends CI_Controller
{
	private $title = 'Public Folder';

	public function __construct()
	{
		parent::__construct();

		$this->load->library(['form_validation']);
		$this->load->model(['PublicFolderModel', 'LeadModel', 'FinancialModel', 'LeadMaterialModel']);
		$this->lead = new LeadModel();
		$this->publicFolder = new PublicFolderModel();
		$this->financial = new FinancialModel();
		$this->lead_material = new LeadMaterialModel();
	}

	public function index($job_id, $sub_base_path = '')
	{
		authAccess();

		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		$lead = $this->lead->getLeadById($job_id);
		$financial_record = $this->financial->getContractDetailsByJobId($job_id);
		$files = $this->publicFolder->allPublicFilesByJobId($job_id);
		$primary_material_info = $this->lead_material->getPrimaryMaterialInfoByLeadId($job_id);
		$financials = $this->financial->allFinancialsForReceipt($job_id);

		$this->load->view('header', [
			'title' => $this->title
		]);
		$this->load->view('public-folder/index', [
			'lead' => $lead,
			'financial_record' => $financial_record,
			'files' => $files,
			'jobid' => $job_id,
			'company_code' => $this->session->userdata('company_code'),
			'primary_material_info' => $primary_material_info,
			'financials' => $financials,
			'sub_base_path' => $sub_base_path
		]);
		$this->load->view('footer');
	}

	public function upload($job_id, $sub_base_path = '')
	{
		authAccess();

		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;


		if (is_array($_FILES) && !empty($_FILES['jobpublicfolderfile'])) {
			$img = array();
			$i = 0;
			foreach ($_FILES['jobpublicfolderfile']['size'] as $key => $size) {
				if ($size > 104857600) {
					// Error Only 100MB
					echo json_encode([
						'error' => 'Max file size limit is 100MB'
					]);
					die();
				}
			}
			foreach ($_FILES['jobpublicfolderfile']['name'] as $key => $filename) {
				$file_name = explode(".", $filename);
				$file_ext = array_pop($file_name);
				$file_name_only = implode('.', $file_name);
				$tmp_file_name = explode(".", $_FILES["jobpublicfolderfile"]["name"][$key]);
				$tmp_file_ext = array_pop($tmp_file_name);
				$tmp_file_name_only = implode('.', $file_name);
				$tmp_i = 1;

				$new_name = $tmp_file_name_only . '.' . $tmp_file_ext;
				$sourcePath = $_FILES["jobpublicfolderfile"]["tmp_name"][$key];
				$targetPath = "assets/job_public_folder/" . $new_name;
				while (file_exists($targetPath)) {
					$new_name = $tmp_file_name_only . '_' . $tmp_i . '.' . $tmp_file_ext;
					$targetPath = "assets/job_public_folder/" . $new_name;
					$tmp_i++;
				}
				move_uploaded_file($sourcePath, $targetPath);
				$insert = $this->publicFolder->insert([
					'job_id' => $job_id,
					'file_name' => $filename,
					'saved_file_name' => $new_name
				]);
			}
			echo json_encode([
				'success' => true
			]);
		}
	}

	public function deleteFile($job_id, $file_id, $sub_base_path = '')
	{
		authAccess();

		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		$this->publicFolder->delete($file_id);
		redirect('lead/' . $sub_base_path . $job_id . '/public-folder');
	}

	public function file($company_code, $public_key)
	{
		$file = $this->publicFolder->getFileByPublicKey($company_code, $public_key);
		if ($file) {
			$this->load->view('public-folder/file', [
				'file' => $file,
				'company_code' => $company_code,
				'public_key' => $public_key
			]);
		} else {
			show_404();
		}
	}

	public function download($company_code, $public_key)
	{
		$file = $this->publicFolder->getFileByPublicKey($company_code, $public_key);
		if ($file) {
			$_file = urldecode($file->saved_file_name);
			$filepath = "assets/job_public_folder/" . $_file;

			if (file_exists($filepath)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="' . $file->file_name . '"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($filepath));
				flush();
				readfile($filepath);
				die();
			}
		}
		show_404();
	}
}
