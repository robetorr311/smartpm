<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Server extends CI_Controller {
	public function __construct(){
		parent::__construct();
		authAdminAccess();
	
		$this->load->helper(['form','security','cookie']);
		$this->load->library(['form_validation','email','user_agent','session']);
		$this->datetime = date("Y-m-d H:i:s");
	}

	
	public function ajaxupload_jobphoto(){
		       
 if(is_array($_FILES) && !empty($_FILES['photo']))  
 {  
	  $img=array();$i=0;
      foreach($_FILES['photo']['name'] as $key => $filename)  
     {  	
		  	
           $file_name = explode(".", $filename);  
           $allowed_extension = array("jpg", "jpeg", "png", "gif", "JPG");  
           if(in_array($file_name[1], $allowed_extension))  
           {  
                $new_name = rand() . '.'. $file_name[1];  
                $sourcePath = $_FILES["photo"]["tmp_name"][$key];  
                $targetPath = "assets/job_photo/".$new_name;  
                move_uploaded_file($sourcePath, $targetPath);  
				$img[$i]=$new_name;
				$i++;
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
           $allowed_extension = array("jpg","pdf","jpeg","gif","png","doc","docx","xls","xlsx","ppt","pptx","txt","zip","rar","gzip");  
           if(in_array($file_name[1], $allowed_extension))  
           {  
                $new_name = $_FILES["doc"]["name"][$key];  
                $sourcePath = $_FILES["doc"]["tmp_name"][$key];  
                $targetPath = "assets/job_doc/".$new_name;  
                move_uploaded_file($sourcePath, $targetPath);  
				$doc[$i]=$_FILES["doc"]["name"][$key];
				$i++;
           } 
      }

		echo json_encode($doc);
      
      
 }
		
	}
	
	
	public function ajaxsave_jobphoto(){
		$posts = $this->input->post();
		$data = json_decode($posts['name'], true);
		//print_r($data);
		
		for($i=0;$i<count($data);$i++){
			$params = array();
			$params['job_id'] 		= $posts['id'];
			$params['image_name'] 		= $data[$i];
			$params['entry_date'] 		= date('Y-m-d h:i:s');
			$params['is_active'] 		= TRUE;
			$this->db->insert('jobs_photo', $params);
			$insertId = $this->db->insert_id();
			echo '<div id="ph'.$insertId.'" class="col-md-2"><i class="del-photo pe-7s-close" id="'.$insertId.'"></i><a href="#" class="pop"><img src="'.base_url().'assets/job_photo/'.$data[$i].'" /></a></div>';
		}
	}
	
	public function ajaxsave_jobdoc(){
		$posts = $this->input->post();
		$data = json_decode($posts['name'], true);
		//print_r($data);
		
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
			echo '<tr id="doc'.$insertId.'"><td style="width: 30px"></td><td style="width: 30px"><i class="del-doc pe-7s-trash" id="'.$insertId.'"></i></td><td style="width: 30px"><a href="'.base_url().'assets/job_doc/'.$data[$i].'"  target="_blank"><i class="pe-7s-news-paper" style="font-size: 30px"></i></a></td><td><span class="'.$insertId.'"><i class="del-edit pe-7s-note"></i></span></td><td><p id="docp'.$insertId.'">'.$trimmed.'</p><input style="width: 100%;display:none" name="'.$insertId.'" type="text"  class="docname" id="doctext'.$insertId.'" /></td><td >'.$data[$i].'</td></tr>';
			

			 
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
	  	$filename   =   $_SERVER['DOCUMENT_ROOT']."/assets/job_photo/".$posts['name'];//base_url()."assets/job_photo/".$posts['name'];
		$savename     = $filename;
		$angle=90;
		
		$original_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		if($original_extension == "jpg" or $original_extension == "jpeg"){
                    $original = imagecreatefromjpeg($filename);
                }
		if($original_extension == "gif"){
			$original = imagecreatefromgif($filename);
		}
		if($original_extension == "png"){
			$original = imagecreatefrompng($filename);
		}
		
	    // Your original file
       // $original   =   imagecreatefromjpeg($filename);
        // Rotate
        $rotated    =   imagerotate($original, $angle, 0);
        // If you have no destination, save to browser
        if($savename == false) {
                header('Content-Type: image/jpeg');
                imagejpeg($rotated);
            }
        else{
            if($original_extension == "jpg" or $original_extension=="jpeg"){
                    imagejpeg($rotated, $savename);
                }
			if($original_extension == "gif"){
				imagegif($rotated, $savename);
			}
			if($original_extension == "png"){
				imagepng($rotated, $savename);
			}
			
			// Save to a directory with a new filename
           // imagejpeg($rotated,$savename);
		}
        // Standard destroy command
        imagedestroy($rotated);

	   //echo $_SERVER['DOCUMENT_ROOT'];
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
