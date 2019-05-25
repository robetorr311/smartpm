<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Server extends CI_Controller {
	public function __construct(){
		parent::__construct();
		authAdminAccess();
	
		$this->load->helper(['form','security','cookie']);
		$this->load->library(['form_validation','email','user_agent','session','image_lib']);
		$this->load->model('JobsDocModel');
		$this->doc = new JobsDocModel();
		$this->datetime = date("Y-m-d H:i:s");
	}
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
    $this->image_lib->resize();
 }
	
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

	
	
	public function ajaxupload_jobdoc(){
		       
	 if(is_array($_FILES) && !empty($_FILES['doc']))  
	 {  
		  $doc=array();
		  $doc_name=array();$i=0;
	      foreach($_FILES['doc']['name'] as $key => $filename)  
	     {  	
			  	
	           $file_name = explode(".", $filename);  
	           $allowed_extension = array("pdf", "doc","docx","xls","xlsx","ppt","pptx","txt","zip");  
	           if(in_array($file_name[1], $allowed_extension))  
	           {  
	                if($file_name[1]!='zip')
	            	{
		            	$new_name = $_FILES["doc"]["name"][$key];  
		                $sourcePath = $_FILES["doc"]["tmp_name"][$key];  
		                $targetPath = "assets/job_doc/".$new_name;  
		                move_uploaded_file($sourcePath, $targetPath);  
						$doc[$i]=$_FILES["doc"]["name"][$key];
						$i++;
	        		}else{

	        			$targetPath = 'assets/job_doc/';  
               			$location = $targetPath . $filename; 
               			if(move_uploaded_file($_FILES['doc']['tmp_name'][$key], $location))  
		                {  
		                       
		                     $zip = new ZipArchive;
  	                       if($zip->open($location))  
 		                     {    $zip->extractTo($targetPath); 
		                     	  $dir = trim($zip->getNameIndex(0), '/');
								  $destinationFolder = $targetPath."$dir";
		              
		                
		                         if(!is_dir($destinationFolder)) {
								    mkdir( $targetPath."/$file_name[0]");  			  
								    $zip->extractTo( $targetPath."/$file_name[0]");
								    $zip->close();
								    $files = scandir( $targetPath."/$file_name[0]");  
		                   
				                     foreach($files as $file)  
				                     {  
				                          $tmp=explode(".", $file);
										  $file_ext = end($tmp);  
				                          $allowed_ext = array("pdf", "doc","docx","xls","xlsx","ppt","pptx","txt"); 
				                          $new_name='';
				                          if(in_array($file_ext, $allowed_ext))  
				                          {  
				                               $new_name = md5(rand()).'.' . $file_ext; 
				                             
				                               copy( $targetPath."/$file_name[0]".'/'.$file, $targetPath . $new_name);  
				                               unlink( $targetPath."/$file_name[0]".'/'.$file);  
				                          }
				                          if($new_name!=''){
				                          	$doc[$i]=$new_name;  
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
				                          $allowed_ext = array("pdf", "doc","docx","xls","xlsx","ppt","pptx","txt");  
				                          $new_name='';
				                          if(in_array($file_ext, $allowed_ext))  
				                          {  
				                               $new_name = md5(rand()).'.' . $file_ext; 
				                             
				                               copy($targetPath . $dir.'/'.$file, $targetPath . $new_name);  
				                               unlink($targetPath . $dir.'/'.$file);  
				                          }
				                          if($new_name!=''){
				                          	$doc[$i]=$new_name;  
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

			echo json_encode($doc);
	      
	      
	 }
		
	}
	
	
	
	public function ajaxsave_jobphoto(){ 
		$posts = $this->input->post();
		$data = json_decode($posts['name'], true);

		for($i=0;$i<count($data);$i++){
			$params = array();
			$params['job_id'] 		= $posts['id'];
			$params['image_name'] 		= $data[$i];
			$params['entry_date'] 		= date('Y-m-d h:i:s');
			$params['is_active'] 		= TRUE;

			$this->thumbnail($data[$i]);

			$this->db->insert('jobs_photo', $params);
			$insertId = $this->db->insert_id();
			echo '<div id="ph'.$insertId.'" class="col-md-2"><i class="del-photo pe-7s-close" id="'.$insertId.'"></i><a alt="'.$insertId.'"  href="'.base_url().'assets/job_photo/'.$data[$i].'" data-fancybox="photo" data-caption="'.$data[$i].'"><img id="img'.$insertId.'" src="'.base_url().'assets/job_photo/thumbnail/'.$data[$i].'"  /></a></div>';
		}
	}
	
	public function ajaxsave_jobdoc(){
		$posts = $this->input->post();
		$data = json_decode($posts['name'], true);
		for($i=0;$i<count($data);$i++){
			 $search = '.'.strtolower(pathinfo($data[$i], PATHINFO_EXTENSION));
             $trimmed = str_replace($search, '', $data[$i]) ;

			$params = array();
			$params['job_id'] 		= $posts['id'];
			$params['doc_name'] 		= $data[$i];
		    $params['name'] 		= $trimmed;
			$params['entry_date'] 		= date('Y-m-d h:i:s');
			$params['is_active'] 		= TRUE;
			$this->db->insert('jobs_doc', $params);
			$insertId = $this->db->insert_id();
			$total=$this->doc->getCount(['is_active'=>1,'job_id'=>$posts['id']]);
			echo '<tr id="doc'.$insertId.'"><td style="width: 30px">'.$total.'</td><td style="width: 30px"><i class="del-doc pe-7s-trash" id="'.$insertId.'"></i></td><td style="width: 30px"><a href="'.base_url().'assets/job_doc/'.$data[$i].'"  target="_blank"><i class="pe-7s-news-paper" style="font-size: 30px"></i></a></td><td><span class="'.$insertId.'"><i class="del-edit pe-7s-note"></i></span></td><td><p id="docp'.$insertId.'">'.$trimmed.'</p><input style="width: 100%;display:none" name="'.$insertId.'" type="text"  class="docname" id="doctext'.$insertId.'" /></td><td >'.$data[$i].'</td></tr>';
			

			 
		}
	}
	 
	

	public function deletephoto(){
	   
		$posts = $this->input->post();
		$this->db->query("UPDATE jobs_photo SET is_active=0 WHERE id='".$posts['id']."'");
		return true;
	}
	
	public function deletedoc(){
	   
		$posts = $this->input->post();
		$this->db->query("UPDATE jobs_doc SET is_active=0 WHERE id='".$posts['id']."'");
		return true;
	}
	
	public function deletejobreport(){
	   
		$posts = $this->input->post();
		$this->db->query("UPDATE roofing_project SET active=0 WHERE id='".$posts['id']."'");
		return true;
	}
	
	
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

	public function updatedocname(){
	   
		$posts = $this->input->post();
		$name= $posts['na'];
		//$this->db->query("UPDATE jobs_doc SET name='".$name."' WHERE id='".$posts['id']."'");

		$this->db->set('name', $name);  //Set the column name and which value to set..
		$this->db->where('id', $posts['id']); //set column_name and value in which row need to update
		$this->db->update('jobs_doc');
		return true;
		echo $name;
	}



}
