<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(['RoofingProjectModel', 'JobsPhotoModel', 'LeadModel']);
		$this->load->library(['pagination']);
		$this->roofing = new RoofingProjectModel();
		$this->photos = new JobsPhotoModel();
		$this->lead = new LeadModel();
	}

	public function index($id, $sub_base_path = '')
	{
		authAccess();
		
		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		$allreport = $this->roofing->allProject(['job_id' => $id, 'active' => 1]);
		$this->load->view('header', ['title' => 'All Reports']);
		$this->load->view('report/index', [
			'allreport' => $allreport,
			'jobid' => $id,
			'sub_base_path' => $sub_base_path
		]);
		$this->load->view('footer');
	}

	public function create($id, $sub_base_path = '')
	{
		authAccess();
		
		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		$photos = $this->photos->allPhoto(['job_id' => $id, 'is_active' => 1]);
		$this->load->view('header', ['title' => 'Genrate Report']);
		$this->load->view('report/create', [
			'jobid' => $id,
			'photos' => $photos,
			'sub_base_path' => $sub_base_path
		]);
		$this->load->view('footer');
	}

	public function upload()
	{
		authAccess();
		
		if (is_array($_FILES) && !empty($_FILES['image'])) {
			$img = array();
			$i = 0;
			foreach ($_FILES['image']['size'] as $key => $size) {
				if ($size > 10737418240) {
					// Error Only 100MB
					echo json_encode([
						'error' => 'Max file size limit is 100MB'
					]);
					die();
				}
			}
			foreach ($_FILES['image']['name'] as $key => $filename) {
				$file_name = explode(".", $filename);
				$file_ext = array_pop($file_name);
				$file_name_only = implode('.', $file_name);
				$allowed_extension = array("jpg", "jpeg", "png", "gif", "JPG", "PNG", "zip");
				if (in_array($file_ext, $allowed_extension)) {
					if ($file_ext != 'zip') {
						$tmp_file_name = explode(".", $_FILES["image"]["name"][$key]);
						$tmp_file_ext = array_pop($tmp_file_name);
						$tmp_file_name_only = implode('.', $file_name);
						$tmp_i = 1;

						$new_name = $tmp_file_name_only . '.' . $tmp_file_ext;
						$sourcePath = $_FILES["image"]["tmp_name"][$key];
						$targetPath = "assets/job_photo/" . $new_name;
						while (file_exists($targetPath)) {
							$new_name = $tmp_file_name_only . '_' . $tmp_i . '.' . $tmp_file_ext;
							$targetPath = "assets/job_photo/" . $new_name;
							$tmp_i++;
						}
						move_uploaded_file($sourcePath, $targetPath);
						$img[$i] = $new_name;
						$i++;
					} else {
						$targetPath = 'assets/job_photo/';
						$location = $targetPath . $filename;
						if (move_uploaded_file($_FILES['image']['tmp_name'][$key], $location)) {
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

	public function delete($job_id, $report_id)
	{
		authAccess();
		
		$this->db->query("UPDATE roofing_project SET active=0 WHERE id='" . $report_id . "' AND job_id='" . $job_id .  "'");
		return true;
	}

	function rrmdir($dir)
	{
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir . "/" . $object) == "dir")
						rrmdir($dir . "/" . $object);
					else unlink($dir . "/" . $object);
				}
			}
			reset($objects);
			rmdir($dir);
		}
	}

	public function save_img()
	{
		authAccess();
		
		$now = new DateTime();
		$now->format('Y-m-d H:i:s');
		$posts = $this->input->post();
		$random = round(microtime(true) * 1000);
		$savefile = @file_put_contents("assets/report_photo/" . $random . ".jpg", base64_decode(explode(",", $posts['data'])[1]));
		echo $random;
	}

	public function save($id, $sub_base_path = '')
	{
		authAccess();
		
		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		if (isset($_POST) && count($_POST) > 0) {
			$posts = $this->input->post();
			$params = array();
			$params['job_id'] 		= $id;
			$params['imageboxdata'] 	= json_encode($posts['imageboxdata']);
			$params['imagebox'] 		= json_encode($posts['imagebox']);
			$params['entry_date'] 		= date('Y-m-d h:i:s');
			$params['active'] 		= TRUE;

			$result = $this->roofing->insert($params);
			if ($result != '') {

				$this->pdf($result, $id);
			} else {
				redirect('lead/' . $sub_base_path . $id . '/reports');
			}
		} else {
			redirect('lead/' . $sub_base_path . $id . '/reports');
		}
	}

	public function pdf($id, $jobid, $sub_base_path = '')
	{
		authAccess();
		
		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		$condition = array('id' => $id, "active" => true);
		$data = $this->roofing->get_all_where($condition);

		$qRes = ($this->db->query("SELECT * FROM admin_setting;"))->result();

		$job = $this->lead->getLeadById($jobid);
		$name = ('RJOB' . $job->id);
		$address = $job->address;
		$phone = $job->phone1;

		$this->load->library("Pdf");
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetFont('times', 'BI', 14, '', false);
		if (!empty($data)) {
			foreach ($data as $dat) {
				$a = json_decode($dat->imagebox, TRUE);
			}

			//print_r($a);

			//die;
			for ($i = 0; $i < count($a); $i++) {
				$x = 10;
				$y = 35;
				$w = 190;
				$h = 0;
				$pdf->AddPage();
				$html = '<table><tr><td  style="width: 120px;"><img src="' . base_url('assets/company_photo/' . ($qRes[0] ? $qRes[0]->url : 'logo.png')) . '" alt="test alt attribute" width="100" height="70" border="0" /></td><td>&nbsp;<br><b>Name : ' . $name . '</b>  <br><b>Adrress : ' . $address . '</b>  <br><b>Phone : ' . $phone . '</b>  <br></td></tr></table>';

				$pdf->writeHTML($html, true, false, true, false, '');
				$pdf->Image(base_url('assets/report_photo/') . $a[$i], $x, $y, $w, $h, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);
			}


			ob_clean();
			$pdf->Output('report.pdf', 'I');
		} else {
			redirect('lead/' . $sub_base_path . $jobid . '/reports');
		}
	}
}
