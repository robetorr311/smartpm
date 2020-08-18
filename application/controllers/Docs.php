<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Docs extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->helper(['form', 'security', 'cookie']);
		$this->load->library(['session', 'image_lib']);
		$this->load->model(['JobsDocModel', 'Common_model', 'LeadModel', 'ActivityLogsModel', 'FinancialModel', 'LeadMaterialModel']);
		$this->doc = new JobsDocModel();
		$this->lead = new LeadModel();
		$this->activityLogs = new ActivityLogsModel();
		$this->financial = new FinancialModel();
		$this->lead_material = new LeadMaterialModel();
	}

	public function index($job_id, $sub_base_path = '')
	{
		authAccess();
		
		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		$lead = $this->lead->getLeadById($job_id);
		$financial_record = $this->financial->getContractDetailsByJobId($job_id);
		$params = array();
		$params['job_id'] = $job_id;
		$params['is_active'] = 1;
		$docs = $this->Common_model->get_all_where('jobs_doc', $params);
		$primary_material_info = $this->lead_material->getPrimaryMaterialInfoByLeadId($job_id);
		$financials = $this->financial->allFinancialsForReceipt($job_id);
		
		$this->load->view('header', ['title' => 'Add Doucment']);
		$this->load->view('doc/index', [
			'lead' => $lead,
			'financial_record' => $financial_record,
			'docs' => $docs,
			'jobid' => $job_id,
			'primary_material_info' => $primary_material_info,
			'financials' => $financials,
			'sub_base_path' => $sub_base_path
		]);
		$this->load->view('footer');
	}

	public function ajaxupload_jobdoc()
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
				$allowed_extension = array("pdf", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "txt", "zip");
				if (in_array($file_ext, $allowed_extension)) {
					if ($file_ext != 'zip') {
						$tmp_file_name = explode(".", $_FILES["doc"]["name"][$key]);
						$tmp_file_ext = array_pop($tmp_file_name);
						$tmp_file_name_only = implode('.', $file_name);
						$tmp_i = 1;

						$new_name = $tmp_file_name_only . '.' . $tmp_file_ext;
						$sourcePath = $_FILES["doc"]["tmp_name"][$key];
						$targetPath = "assets/job_doc/" . $new_name;
						while (file_exists($targetPath)) {
							$new_name = $tmp_file_name_only . '_' . $tmp_i . '.' . $tmp_file_ext;
							$targetPath = "assets/job_doc/" . $new_name;
							$tmp_i++;
						}
						move_uploaded_file($sourcePath, $targetPath);
						$doc[$i] = $new_name;
						$i++;
					} else {
						$targetPath = 'assets/job_doc/';
						$location = $targetPath . $filename;
						if (move_uploaded_file($_FILES['doc']['tmp_name'][$key], $location)) {
							$zip = new ZipArchive;
							if ($zip->open($location)) {
								$zip->extractTo($targetPath);
								$dir = trim($zip->getNameIndex(0), '/');
								$destinationFolder = $targetPath . $dir;

								if (!is_dir($destinationFolder)) {
									mkdir($targetPath . "/" . $file_name_only);
									$zip->extractTo($targetPath . "/" . $file_name_only);
									$zip->close();
									$files = scandir($targetPath . "/" . $file_name_only);

									foreach ($files as $file) {
										$tmp_file_name = explode(".", $file);
										$tmp_file_ext = strtolower(array_pop($tmp_file_name));
										$tmp_file_name_only = implode('.', $file_name);
										$tmp_i = 1;

										$allowed_ext = array("pdf", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "txt");
										$new_name = '';
										if (in_array($tmp_file_ext, $allowed_ext)) {
											$new_name = $tmp_file_name_only . '.' . $tmp_file_ext;
											while (file_exists($targetPath . $new_name)) {
												$new_name = $tmp_file_name_only . '_' . $tmp_i . '.' . $tmp_file_ext;
												$tmp_i++;
											}
											copy($targetPath . "/" . $file_name_only . '/' . $file, $targetPath . $new_name);
											unlink($targetPath . "/" . $file_name_only . '/' . $file);
										}
										if ($new_name != '') {
											$doc[$i] = $new_name;
											$i++;
										}
									}
									unlink($location);
									$this->rrmdir($targetPath . "/" . $file_name_only);
								} else {
									$dir = trim($zip->getNameIndex(0), '/');
									$zip->close();
									$files = scandir($targetPath . $dir);

									foreach ($files as $file) {
										$tmp_file_name = explode(".", $file);
										$tmp_file_ext = strtolower(array_pop($tmp_file_name));
										$tmp_file_name_only = implode('.', $file_name);
										$tmp_i = 1;

										$allowed_ext = array("pdf", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "txt");
										$new_name = '';
										if (in_array($tmp_file_ext, $allowed_ext)) {
											$new_name = $tmp_file_name_only . '.' . $tmp_file_ext;
											while (file_exists($targetPath . $new_name)) {
												$new_name = $tmp_file_name_only . '_' . $tmp_i . '.' . $tmp_file_ext;
												$tmp_i++;
											}
											copy($targetPath . $dir . '/' . $file, $targetPath . $new_name);
											unlink($targetPath . $dir . '/' . $file);
										}
										if ($new_name != '') {
											$doc[$i] = $new_name;
											$i++;
										}
									}
									unlink($location);
									$this->rrmdir($targetPath . $dir);
								}
							}
						}
					}
				}
			}
			echo json_encode([
				'doc' => $doc
			]);
		}
	}

	public function ajaxsave_jobdoc()
	{
		authAccess();
		
		$posts = $this->input->post();
		$data = json_decode($posts['name'], true);
		for ($i = 0; $i < count($data); $i++) {
			$search = '.' . strtolower(pathinfo($data[$i], PATHINFO_EXTENSION));
			$trimmed = str_replace($search, '', $data[$i]);
			$params = array();
			$params['job_id'] = $posts['id'];
			$params['doc_name'] = $data[$i];
			$params['name'] = $trimmed;
			$params['entry_date'] = date('Y-m-d h:i:s');
			$params['is_active'] = TRUE;
			$this->db->insert('jobs_doc', $params);
			$insertId = $this->db->insert_id();
			$al_insert = $this->activityLogs->insert([
				'module' => 0,
				'module_id' => $posts['id'],
				'type' => 3
			]);
			$total = $this->doc->getCount(['is_active' => 1, 'job_id' => $posts['id']]);
			echo '<tr id="doc' . $insertId . '"><td>' . $total . '</td><td><p id="docp' . $insertId . '">' . $trimmed . '</p><input style="width: 70%;display:none" name="' . $insertId . '" type="text" class="docname" placeholder="Enter new name" id="doctext' . $insertId . '" /></td><td>' . $data[$i] . '</td><td class="text-center"><a target="_blank" href="' . base_url('assets/job_doc/' . $data[$i]) . '"><i class="fa fa-eye text-info"></i></a></td><td class="text-center"><span class="' . $insertId . '"><i class="del-edit fa fa-pencil text-warning"></i></span></td><td class="text-center"><i class="del-doc fa fa-trash-o text-danger" id="' . $insertId . '"></i></td></tr>';
		}
	}

	public function deletedoc()
	{
		authAccess();
		
		$posts = $this->input->post();
		$this->db->query("UPDATE jobs_doc SET is_active=0 WHERE id='" . $posts['id'] . "'");
		return true;
	}

	public function updatedocname()
	{
		authAccess();
		
		$posts = $this->input->post();
		$name = $posts['na'];
		$this->db->set('name', $name);
		$this->db->where('id', $posts['id']);
		$this->db->update('jobs_doc');
		return true;
		echo $name;
	}

	function rrmdir($dir)
	{
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir . "/" . $object) == "dir")
						$this->rrmdir($dir . "/" . $object);
					else unlink($dir . "/" . $object);
				}
			}
			reset($objects);
			rmdir($dir);
		}
	}
}
