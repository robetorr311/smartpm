<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Photos extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->helper(['form', 'security', 'cookie']);
		$this->load->library(['form_validation', 'email', 'user_agent', 'session', 'image_lib']);
		$this->load->model(['JobsPhotoModel', 'LeadModel', 'ActivityLogsModel', 'FinancialModel', 'LeadMaterialModel']);
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
		$count = $this->JobsPhotoModel->getCount($params);
		$imgs  = $this->JobsPhotoModel->allPhoto($params);
		$primary_material_info = $this->lead_material->getPrimaryMaterialInfoByLeadId($job_id);
		$financials = $this->financial->allFinancialsForReceipt($job_id);

		$this->load->view('header', ['title' => 'Add Photo']);
		$this->load->view('photo/index', [
			'lead' => $lead,
			'financial_record' => $financial_record,
			'count' => $count,
			'imgs' => $imgs,
			'jobid' => $job_id,
			'financials' => $financials,
			'primary_material_info' => $primary_material_info,
			'sub_base_path' => $sub_base_path
		]);
		$this->load->view('footer');
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

	function thumbnail($src)
	{
		$file_path = $_SERVER['DOCUMENT_ROOT'] . "/assets/job_photo/" . $src;
		$target_path = $_SERVER['DOCUMENT_ROOT'] . "/assets/job_photo/thumbnail/" . $src;
		$this->load->library('image_lib');
		$img_cfg['image_library'] = 'gd2';
		$img_cfg['source_image'] = $file_path;
		$img_cfg['maintain_ratio'] = TRUE;
		$img_cfg['create_thumb'] = TRUE;
		$img_cfg['new_image'] = $target_path;
		$img_cfg['thumb_marker'] = '';
		$img_cfg['width'] = 150;
		$img_cfg['quality'] = 100;
		$img_cfg['height'] = 150;
		$this->image_lib->initialize($img_cfg);
		if (!$this->image_lib->resize()) {
			echo "Image Not Exist";
		}
	}

	function newImageRotation($image)
	{
		$exif = exif_read_data($_SERVER['DOCUMENT_ROOT'] . "/assets/job_photo/" . $image);
		if (!empty($exif['Orientation'])) {
			$this->image_lib->clear();
			$config = array();
			$config['image_library']   = 'gd2';
			$config['source_image'] = $_SERVER['DOCUMENT_ROOT'] . "/assets/job_photo/" . $image;
			switch ($exif['Orientation']) {
				case 8:
					$config['rotation_angle'] = '90';
					break;
				case 3:
					$config['rotation_angle'] = '180';
					break;
				case 6:
					$config['rotation_angle'] = '270';
					break;
				default:
					return;
			}
			$this->image_lib->initialize($config);
			if (!$this->image_lib->rotate()) {
				echo $this->image_lib->display_errors();
			}
		}
	}

	public function ajaxupload_jobphoto()
	{
		authAccess();

		if (is_array($_FILES) && !empty($_FILES['photo'])) {
			$img = array();
			$i = 0;
			foreach ($_FILES['photo']['size'] as $key => $size) {
				if ($size > 104857600) {
					// Error Only 100MB
					echo json_encode([
						'error' => 'Max file size limit is 100MB'
					]);
					die();
				}
			}
			foreach ($_FILES['photo']['name'] as $key => $filename) {
				$file_name = explode(".", $filename);
				$file_ext = array_pop($file_name);
				$file_name_only = implode('.', $file_name);
				$allowed_extension = array("jpg", "jpeg", "png", "PNG", "gif", "JPG", "zip");
				if (in_array($file_ext, $allowed_extension)) {
					if ($file_ext != 'zip') {
						$tmp_file_name = explode(".", $_FILES["photo"]["name"][$key]);
						$tmp_file_ext = array_pop($tmp_file_name);
						$tmp_file_name_only = implode('.', $file_name);
						$tmp_i = 1;

						$new_name = $tmp_file_name_only . '.' . $tmp_file_ext;
						$sourcePath = $_FILES["photo"]["tmp_name"][$key];
						$targetPath = "assets/job_photo/" . $new_name;
						while (file_exists($targetPath)) {
							$new_name = $tmp_file_name_only . '_' . $tmp_i . '.' . $tmp_file_ext;
							$targetPath = "assets/job_photo/" . $new_name;
							$tmp_i++;
						}
						move_uploaded_file($sourcePath, $targetPath);
						$this->newImageRotation($new_name);
						$img[$i] = $new_name;
						$i++;
					} else {
						$targetPath = 'assets/job_photo/';
						$location = $targetPath . $filename;
						if (move_uploaded_file($_FILES['photo']['tmp_name'][$key], $location)) {
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
										$tmp_file_ext = array_pop($tmp_file_name);
										$tmp_file_name_only = implode('.', $file_name);
										$tmp_i = 1;

										$allowed_ext = array("jpg", "jpeg", "png", "PNG", "gif", "JPG");
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
											$this->newImageRotation($new_name);
											$img[$i] = $new_name;
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
										$tmp_file_ext = array_pop($tmp_file_name);
										$tmp_file_name_only = implode('.', $file_name);
										$tmp_i = 1;

										$allowed_ext = array("jpg", "jpeg", "png", "PNG", "gif", "JPG");
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
											$this->newImageRotation($new_name);
											$img[$i] = $new_name;
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
				'img' => $img
			]);
		}
	}

	public function ajaxsave_jobphoto()
	{
		authAccess();

		$posts = $this->input->post();
		$data = json_decode($posts['name'], true);

		for ($i = 0; $i < count($data); $i++) {
			$params = array();
			$params['job_id'] 		= $posts['id'];
			$params['image_name'] 		= $data[$i];
			$params['entry_date'] 		= date('Y-m-d h:i:s');
			$params['is_active'] 		= TRUE;
			$this->db->insert('jobs_photo', $params);
			$insertId = $this->db->insert_id();
			echo '<div id="ph' . $insertId . '" class="col-md-2"><i class="del-photo pe-7s-close" id="' . $insertId . '"></i><a alt="' . $insertId . '"  href="' . base_url() . 'assets/job_photo/' . $data[$i] . '" data-fancybox="photo" data-caption="' . $data[$i] . '"><img id="img' . $insertId . '" src="' . base_url() . 'assets/job_photo/' . $data[$i] . '"  /></a></div>';
			$this->thumbnail($data[$i]);
		}
		$al_insert = $this->activityLogs->insert([
			'module' => 0,
			'module_id' => $posts['id'],
			'type' => 2
		]);
	}

	public function imagerotate()
	{
		authAccess();

		$posts = $this->input->post();
		$this->image_lib->clear();
		$config = array();
		$config['image_library']   = 'gd2';
		$config['source_image'] = $_SERVER['DOCUMENT_ROOT'] . "/assets/job_photo/" . $posts['name'];
		$config['rotation_angle'] = '90';
		$this->image_lib->initialize($config); // reinitialize it instead of reloading
		if (!$this->image_lib->rotate()) {
			echo $this->image_lib->display_errors();
		} else {
			$this->thumbnail($posts['name']);
			echo $posts['name'];
		}
	}

	public function thumbnail_all()
	{
		authAccess();

		$this->db->select('image_name');
		$this->db->where(['is_active' => 1]);
		$query = $this->db->get('jobs_photo');


		foreach ($query->result() as $row) {
			//echo $row->image_name."<br>";
			if (is_file($_SERVER['DOCUMENT_ROOT'] . "/assets/job_photo/" . $row->image_name)) {
				$this->thumbnail($row->image_name);
			}
		}
		$this->session->set_flashdata('errors', '<p>Thumbnail Created Sucessfully</p>');
		redirect('/dashboard');
	}

	public function deletephoto($job_id, $photo_id)
	{
		authAccess();

		$this->db->query("UPDATE jobs_photo SET is_active=0 WHERE id='" . $photo_id . "' AND job_id='" . $job_id . "'");
		$al_insert = $this->activityLogs->insert([
			'module' => 0,
			'module_id' => $job_id,
			'type' => 5
		]);
		return true;
	}
}
