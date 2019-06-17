<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Photos extends CI_Controller {
	public function __construct(){
		parent::__construct();
		authAdminAccess(); 
	
		$this->load->helper(['form','security','cookie']);
		$this->load->library(['form_validation','email','user_agent','session','image_lib']);
		$this->load->model(['JobsPhotoModel']);
	}
	public function index($job_id)
	{
        $params = array();
		$params['job_id'] =$job_id;
		$params['is_active'] =1;
		$count = $this->JobsPhotoModel->getCount($params);
		$imgs  = $this->JobsPhotoModel->allPhoto($params);
		$this->load->view('header',['title' => 'Add Photo']);
		$this->load->view('photo/index', ['count' => $count, 'imgs'=> $imgs, 'jobid'=>$job_id ]);
		$this->load->view('footer');
	}
	/* function for remove directory */
	function rrmdir($dir) {
		  if (is_dir($dir)) {
		    $objects = scandir($dir);
		    foreach ($objects as $object) {
		      if ($object != "." && $object != "..") {
		        if (filetype($dir."/".$object) == "dir") 
		           $this->rrmdir($dir."/".$object); 
		        else unlink   ($dir."/".$object);
		      }
		    }
		    reset($objects);
		    rmdir($dir);
		  }
	 }

	 /* function for image Thumbnail */
	 function thumbnail($src) {
		$file_path = $_SERVER['DOCUMENT_ROOT']."/assets/job_photo/" . $src;
		$target_path = $_SERVER['DOCUMENT_ROOT']."/assets/job_photo/thumbnail/".$src;
	    $this->load->library('image_lib');
	    $img_cfg['image_library'] = 'gd2';
		$img_cfg['source_image'] = $file_path;
	    $img_cfg['maintain_ratio'] = TRUE;
	    $img_cfg['create_thumb'] = TRUE;
	    $img_cfg['new_image'] = $target_path;
	    $img_cfg['thumb_marker'] ='';
	    $img_cfg['width'] = 150; 
	    $img_cfg['quality'] = 100;
	    $img_cfg['height'] = 150;
	    $this->image_lib->initialize($img_cfg);
	     if (!$this->image_lib->resize()) {
				echo "Image Not Exist";//$this->image_lib->display_errors();
			} 
	  }
	
	/* function for image upload */
	public function ajaxupload_jobphoto(){
			       
	 if(is_array($_FILES) && !empty($_FILES['photo']))  
	 {  
		  $img=array();$i=0;
	      foreach($_FILES['photo']['name'] as $key => $filename)  
	     {  	
			  	
	           $file_name = explode(".", $filename);  
	           $allowed_extension = array("jpg", "jpeg", "png", "PNG", "gif", "JPG", "zip");  
	           if(in_array($file_name[1], $allowed_extension))  
	           {  
	                if($file_name[1]!='zip')
		            {
		                $new_name = rand() . '.'. $file_name[1];  
		                $sourcePath = $_FILES["photo"]["tmp_name"][$key];  
		                $targetPath = "assets/job_photo/".$new_name;  
		                move_uploaded_file($sourcePath, $targetPath);  
						$img[$i]=$new_name;
						$i++; 
					}else{
						$targetPath = 'assets/job_photo/';  
	               		$location = $targetPath . $filename; 
	               		if(move_uploaded_file($_FILES['photo']['tmp_name'][$key], $location))  
			               {  
			                   $zip = new ZipArchive;
	  	                       if($zip->open($location))  
	 		                     {    $zip->extractTo($targetPath); 
			                     	  $dir = trim($zip->getNameIndex(0), '/');
									  $destinationFolder = $targetPath."/$dir";
			                   
			                         if(!is_dir($destinationFolder)) {
									    mkdir( $targetPath."/$file_name[0]");				  
									    $zip->extractTo( $targetPath."/$file_name[0]");
									    $zip->close();
									    $files = scandir( $targetPath."/$file_name[0]");  
			                    
					                     foreach($files as $file)  
					                     {  
					                          $tmp=explode(".", $file);
											  $file_ext = end($tmp);  
					                          $allowed_ext = array("jpg", "jpeg", "png", "PNG", "gif", "JPG"); 
					                          $new_name='';
					                          if(in_array($file_ext, $allowed_ext))  
					                          {  
					                               $new_name = md5(rand()).'.' . $file_ext; 
					                             
					                               copy( $targetPath."/$file_name[0]".'/'.$file, $targetPath . $new_name);  
					                               unlink( $targetPath."/$file_name[0]".'/'.$file);  
					                          }
					                          if($new_name!=''){
					                          	$img[$i]=$new_name;  
					                          $i++; 
					                          }
					                               
					                     }  
			                     		 unlink($location);  
			                      		 $this->rrmdir( $targetPath."/$file_name[0]");
									  }else{
									  	  
									  	  $dir = trim($zip->getNameIndex(0), '/');
			                        	  $zip->close(); 
			                        	  $files = scandir($targetPath . $dir);    
			                   
					                      foreach($files as $file)  
					                      {  
					                          $tmp=explode(".", $file);
											  $file_ext = end($tmp);  
					                          $allowed_ext = array("jpg", "jpeg", "png", "PNG", "gif", "JPG"); 
					                          $new_name='';
					                          if(in_array($file_ext, $allowed_ext))  
					                          {  
					                               $new_name = md5(rand()).'.' . $file_ext; 
					                             
					                               copy($targetPath . $dir.'/'.$file, $targetPath . $new_name);  
					                               unlink($targetPath . $dir.'/'.$file);  
					                          }
					                          if($new_name!=''){
					                          	$img[$i]=$new_name;  
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
			echo json_encode($img);  
	 	}
			
	}


	/* function for image save in db */
	public function ajaxsave_jobphoto(){ 
		$posts = $this->input->post();
		$data = json_decode($posts['name'], true);

		for($i=0;$i<count($data);$i++){
			$params = array();
			$params['job_id'] 		= $posts['id'];
			$params['image_name'] 		= $data[$i];
			$params['entry_date'] 		= date('Y-m-d h:i:s');
			$params['is_active'] 		= TRUE;
			$this->db->insert('jobs_photo', $params);
			$insertId = $this->db->insert_id();
			echo '<div id="ph'.$insertId.'" class="col-md-2"><i class="del-photo pe-7s-close" id="'.$insertId.'"></i><a alt="'.$insertId.'"  href="'.base_url().'assets/job_photo/'.$data[$i].'" data-fancybox="photo" data-caption="'.$data[$i].'"><img id="img'.$insertId.'" src="'.base_url().'assets/job_photo/'.$data[$i].'"  /></a></div>';
			$this->thumbnail($data[$i]);
		}
	}

	/* function for image rotate */
	public function imagerotate(){
		$posts = $this->input->post();
		$this->image_lib->clear();
		$config=array();
		$config['image_library']   = 'gd2';
		$config['source_image'] = $_SERVER['DOCUMENT_ROOT']."/assets/job_photo/".$posts['name'];
		$config['rotation_angle'] = '90';
		$this->image_lib->initialize($config); // reinitialize it instead of reloading
		if (!$this->image_lib->rotate()) {
			echo $this->image_lib->display_errors();
		} else {
			$this->thumbnail($posts['name']);
			echo $posts['name'];
		}
	}

	/* function for image tumbnail to All existing images  */
	public function thumbnail_all(){
			$this->db->select('image_name');
			$this->db->where(['is_active' => 1]);
			$query = $this->db->get('jobs_photo');

			
			foreach ($query->result() as $row)
			{
			    //echo $row->image_name."<br>";
			    if(is_file($_SERVER['DOCUMENT_ROOT']."/assets/job_photo/".$row->image_name)){
			    	 $this->thumbnail($row->image_name);
			    }
			  
			}
		$this->session->set_flashdata('message', '<p>Thumbnail Created Sucessfully</p>');
		redirect('/dashboard');
	}
	
	/* function for image delete */
	public function deletephoto(){
	   
		$posts = $this->input->post();
		$this->db->query("UPDATE jobs_photo SET is_active=0 WHERE id='".$posts['id']."'");
		return true;
	}

}
