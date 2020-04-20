<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Company_photos extends CI_Controller
{
	private $title = 'Company Photos';

	public function __construct()
	{
		parent::__construct();

		$this->load->model(['CompanyPhotosModel']);
		$this->load->library(['form_validation']);

		$this->company_photos = new CompanyPhotosModel();
	}

	public function index($id = false)
	{
		authAccess();

		$ffList = $this->company_photos->allFilesFolders($id);
		$company_code = $this->session->userdata('company_code');
		$this->load->view('header', [
			'title' => $this->title
		]);
		$this->load->view('company_photos/index', [
			'ffList' => $ffList,
			'path' => ($id ? ('/' . $id . '/') : '/'),
			'company_code' => $company_code
		]);
		$this->load->view('footer');
	}

	public function createFolder($id = false)
	{
		authAccess();

		$this->form_validation->set_rules('folder_name', 'Folder Name', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$createFolderData = $this->input->post();
			$company_code = $this->session->userdata('company_code');
			$companyDir = 'assets/company_photos/' . $company_code;

			if (!is_dir($companyDir)) {
				mkdir($companyDir);
			}

			$path = '/';
			if ($id) {
				$currentDirRecord = $this->company_photos->getById($id);
				$path = $currentDirRecord->path . $currentDirRecord->name . '/';
			}

			if (is_dir($companyDir . $path)) {
				if (!is_dir($companyDir . $path . $createFolderData['folder_name'])) {
					if (mkdir($companyDir . $path . $createFolderData['folder_name'])) {
						$this->company_photos->insert([
							'type' => 1,
							'path' => $path,
							'name' => $createFolderData['folder_name']
						]);
					} else {
						$this->session->set_flashdata('errors', '<p>Unable to create folder.</p>');
					}
				} else {
					$this->session->set_flashdata('errors', '<p>Folder already exist.</p>');
				}
			} else {
				$this->session->set_flashdata('errors', '<p>Invalid path.</p>');
			}
		}

		redirect('company-photos' . ($id ? ('/' . $id . '/') : '/'));
	}

	public function generatePublicKey($ff_id, $id = false)
	{
		authAccess();

		$path = '/';
		if ($id) {
			$currentDirRecord = $this->company_photos->getById($id);
			$path = $currentDirRecord->path . $currentDirRecord->name . '/';
		}
		$this->company_photos->savePublicKey($ff_id);
		redirect('company-photos' . ($id ? ('/' . $id . '/') : '/'));
	}

	public function upload($id = false)
	{
		authAccess();

		if (is_array($_FILES) && !empty($_FILES['companyphotos'])) {
			$doc = array();
			$i = 0;
			foreach ($_FILES['companyphotos']['size'] as $key => $size) {
				if ($size > 104857600) {
					// Error Only 100MB
					echo json_encode([
						'error' => 'Max file size limit is 100MB'
					]);
					die();
				}
			}

			$path = '/';
			if ($id) {
				$currentDirRecord = $this->company_photos->getById($id);
				$path = $currentDirRecord->path . $currentDirRecord->name . '/';
			}

			$company_code = $this->session->userdata('company_code');
			$companyDir = 'assets/company_photos/' . $company_code;

			if (!is_dir($companyDir)) {
				mkdir($companyDir);
			}

			if (is_dir($companyDir . $path)) {
				foreach ($_FILES['companyphotos']['name'] as $key => $filename) {
					$file_name = explode(".", $filename);
					$file_ext = strtolower(array_pop($file_name));
					$file_name_only = implode('.', $file_name);

					$tmp_file_name = explode(".", $_FILES["companyphotos"]["name"][$key]);
					$tmp_file_ext = array_pop($tmp_file_name);
					$tmp_file_name_only = implode('.', $file_name);
					$tmp_i = 1;

					$new_name = $tmp_file_name_only . '.' . $tmp_file_ext;
					$sourcePath = $_FILES["companyphotos"]["tmp_name"][$key];
					$targetPath = $companyDir . $path . $new_name;
					while (file_exists($targetPath)) {
						$new_name = $tmp_file_name_only . '_' . $tmp_i . '.' . $tmp_file_ext;
						$targetPath = $companyDir . $path . $new_name;
						$tmp_i++;
					}
					if (move_uploaded_file($sourcePath, $targetPath)) {
						$this->company_photos->insert([
							'type' => 0,
							'path' => $path,
							'name' => $new_name
						]);
					} else {
						echo json_encode([
							'error' => 'Unable to upload file'
						]);
						die();
					}
				}
			} else {
				echo json_encode([
					'error' => 'Invalid path'
				]);
				die();
			}
		}
		echo json_encode([
			'success' => true
		]);
		die();
	}

	public function sharedFolder($company_code, $public_key, $id = false)
	{
		$currentDirRecord = $this->company_photos->getByPublicKey($company_code, $public_key);
		$path = $currentDirRecord->path . $currentDirRecord->name . '/';

		if ($id) {
			$currentDirRecord = $this->company_photos->getByIdAndPathCompanyCode($company_code, $path, $id);
			$path = $currentDirRecord->path . $currentDirRecord->name . '/';
		}
		
		$ffList = $this->company_photos->allFilesFoldersOfCompany($company_code, $currentDirRecord->id);
		
		$this->load->view('company_photos/shared-folder', [
			'ffList' => $ffList,
			'path' => ($id ? ('/' . $id . '/') : '/'),
			'company_code' => $company_code,
			'public_key' => $public_key
		]);
	}

	public function download($company_code, $public_key, $id)
	{
		$currentDirRecord = $this->company_photos->getByPublicKey($company_code, $public_key);
		$path = $currentDirRecord->path . $currentDirRecord->name . '/';
		$file = $this->company_photos->getFileByIdAndPathCompanyCode($company_code, $path, $id);

		if ($file) {
			$filepath = "assets/company_photos/" . $company_code . $file->path . '/' . urldecode($file->name);

			if (file_exists($filepath)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
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

	public function delete($ff_id, $id = false)
	{
		authAccess();

		$path = '/';
		if ($id) {
			$currentDirRecord = $this->company_photos->getById($id);
			$path = $currentDirRecord->path . $currentDirRecord->name . '/';
		}

		$ff = $this->company_photos->getById($ff_id);
		if ($ff) {
			$company_code = $this->session->userdata('company_code');
			$companyDir = 'assets/company_photos/' . $company_code;
			if ($ff->type == 0) {
				if (!unlink($companyDir . $ff->path . $ff->name)) {
					$this->session->set_flashdata('errors', '<p>Unable to delete file.</p>');
				} else {
					$delete = $this->company_photos->delete($ff_id);
				}
			} else {
				$this->removeDirectory($companyDir . $ff->path . $ff->name);
				$delete = $this->company_photos->deleteSubPaths($ff->path . $ff->name . '/');
				$delete = $this->company_photos->delete($ff_id);
			}


			if (!$delete) {
				$this->session->set_flashdata('errors', '<p>Unable to delete document.</p>');
			}
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
		}
		redirect('company-photos' . ($id ? ('/' . $id . '/') : '/'));
	}

	/**
	 * Private Methods
	 */
	private function removeDirectory($path)
	{
		$files = glob($path . '/*');
		foreach ($files as $file) {
			is_dir($file) ? $this->removeDirectory($file) : unlink($file);
		}
		rmdir($path);
		return;
	}
}
