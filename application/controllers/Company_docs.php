<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Company_docs extends CI_Controller
{
	private $title = 'Company Documents';

	public function __construct()
	{
		parent::__construct();

		$this->load->model(['CompanyDocsModel']);
		$this->load->library(['form_validation']);

		$this->company_docs = new CompanyDocsModel();
	}

	public function index()
	{
		authAccess();

		$docs = $this->company_docs->allCompanyDocs();
		$this->load->view('header', [
			'title' => $this->title
		]);
		$this->load->view('company_docs/index', [
			'docs' => $docs
		]);
		$this->load->view('footer');
	}

	public function upload()
	{
		authAccess();

		if (is_array($_FILES) && !empty($_FILES['doc'])) {
			$doc = array();
			$i = 0;
			foreach ($_FILES['doc']['size'] as $key => $size) {
				if ($size > 104857600) {
					// Error Only 100MB
					echo json_encode([
						'error' => 'Max file size limit is 100MB'
					]);
					die();
				}
			}
			foreach ($_FILES['doc']['name'] as $key => $filename) {
				$file_name = explode(".", $filename);
				$file_ext = strtolower(array_pop($file_name));
				$file_name_only = implode('.', $file_name);
				if (!file_exists('assets/company_doc')) {
					mkdir('assets/company_doc', 0777, true);
				}
				// if ($file_ext != 'zip') {
				$tmp_file_name = explode(".", $_FILES["doc"]["name"][$key]);
				$tmp_file_ext = array_pop($tmp_file_name);
				$tmp_file_name_only = implode('.', $file_name);
				$tmp_i = 1;

				$new_name = $tmp_file_name_only . '.' . $tmp_file_ext;
				$sourcePath = $_FILES["doc"]["tmp_name"][$key];
				$targetPath = "assets/company_doc/" . $new_name;
				while (file_exists($targetPath)) {
					$new_name = $tmp_file_name_only . '_' . $tmp_i . '.' . $tmp_file_ext;
					$targetPath = "assets/company_doc/" . $new_name;
					$tmp_i++;
				}
				move_uploaded_file($sourcePath, $targetPath);
				$doc[$i] = $new_name;
				$i++;
				// } else {
				// 	$targetPath = 'assets/job_doc/';
				// 	$location = $targetPath . $filename;
				// 	if (move_uploaded_file($_FILES['doc']['tmp_name'][$key], $location)) {
				// 		$zip = new ZipArchive;
				// 		if ($zip->open($location)) {
				// 			$zip->extractTo($targetPath);
				// 			$dir = trim($zip->getNameIndex(0), '/');
				// 			$destinationFolder = $targetPath . $dir;

				// 			if (!is_dir($destinationFolder)) {
				// 				mkdir($targetPath . "/" . $file_name_only);
				// 				$zip->extractTo($targetPath . "/" . $file_name_only);
				// 				$zip->close();
				// 				$files = scandir($targetPath . "/" . $file_name_only);

				// 				foreach ($files as $file) {
				// 					$tmp_file_name = explode(".", $file);
				// 					$tmp_file_ext = strtolower(array_pop($tmp_file_name));
				// 					$tmp_file_name_only = implode('.', $file_name);
				// 					$tmp_i = 1;

				// 					$allowed_ext = array("pdf", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "txt");
				// 					$new_name = '';
				// 					if (in_array($tmp_file_ext, $allowed_ext)) {
				// 						$new_name = $tmp_file_name_only . '.' . $tmp_file_ext;
				// 						while (file_exists($targetPath . $new_name)) {
				// 							$new_name = $tmp_file_name_only . '_' . $tmp_i . '.' . $tmp_file_ext;
				// 							$tmp_i++;
				// 						}
				// 						copy($targetPath . "/" . $file_name_only . '/' . $file, $targetPath . $new_name);
				// 						unlink($targetPath . "/" . $file_name_only . '/' . $file);
				// 					}
				// 					if ($new_name != '') {
				// 						$doc[$i] = $new_name;
				// 						$i++;
				// 					}
				// 				}
				// 				unlink($location);
				// 				$this->rrmdir($targetPath . "/" . $file_name_only);
				// 			} else {
				// 				$dir = trim($zip->getNameIndex(0), '/');
				// 				$zip->close();
				// 				$files = scandir($targetPath . $dir);

				// 				foreach ($files as $file) {
				// 					$tmp_file_name = explode(".", $file);
				// 					$tmp_file_ext = strtolower(array_pop($tmp_file_name));
				// 					$tmp_file_name_only = implode('.', $file_name);
				// 					$tmp_i = 1;

				// 					$allowed_ext = array("pdf", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "txt");
				// 					$new_name = '';
				// 					if (in_array($tmp_file_ext, $allowed_ext)) {
				// 						$new_name = $tmp_file_name_only . '.' . $tmp_file_ext;
				// 						while (file_exists($targetPath . $new_name)) {
				// 							$new_name = $tmp_file_name_only . '_' . $tmp_i . '.' . $tmp_file_ext;
				// 							$tmp_i++;
				// 						}
				// 						copy($targetPath . $dir . '/' . $file, $targetPath . $new_name);
				// 						unlink($targetPath . $dir . '/' . $file);
				// 					}
				// 					if ($new_name != '') {
				// 						$doc[$i] = $new_name;
				// 						$i++;
				// 					}
				// 				}
				// 				unlink($location);
				// 				$this->rrmdir($targetPath . $dir);
				// 			}
				// 		}
				// 	}
				// }
			}
			// Save to Database
			$data = [];
			for ($i = 0; $i < count($doc); $i++) {
				$data[] = [
					'doc_name' => $doc[$i]
				];
			}
			$inserts = $this->company_docs->insertArr($data);
			if (!$inserts) {
				echo json_encode([
					'error' => 'Unable to create entry on database'
				]);
			} else {
				echo json_encode([
					'success' => true
				]);
			}
		}
	}

	public function download($id)
	{
		authAccess();

		$doc = $this->company_docs->getCompanyDocById($id);
		if ($doc) {
			$file = urldecode($doc->doc_name);
			$filepath = "assets/company_doc/" . $file;

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

	public function delete($id)
	{
		authAccess();

		$doc = $this->company_docs->getCompanyDocById($id);
		if ($doc) {
			// $file = urldecode($doc->doc_name);
			// $filepath = "assets/company_doc/" . $file;
			// if (file_exists($filepath)) {
			// 	unlink($filepath);
			// }

			$delete = $this->company_docs->delete($id);
			if (!$delete) {
				$this->session->set_flashdata('errors', '<p>Unable to delete document.</p>');
			}
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
		}
		redirect('company-docs');
	}
}
