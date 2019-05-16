<?php
	/*	if ( 0 < $_FILES['file']['error'] ) {
			echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		}
		else {
			move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name']);
			echo $_FILES['file']['name'];
		}
	*/

	if(is_array($_FILES) && !empty($_FILES['image']))  
	 {  
		  $img=array(); $i=0;
	      foreach($_FILES['image']['name'] as $key => $filename)  
	     {  	
			  	
	           $file_name = explode(".", $filename);  
	           $allowed_extension = array("jpg", "jpeg", "png", "gif", "JPG","zip");  
	           if(in_array($file_name[1], $allowed_extension))  
	           {  
	                if($file_name[1]!='zip')
	                {	
	                	$new_name = rand() . '.'. $file_name[1];  
		                $sourcePath = $_FILES["image"]["tmp_name"][$key];  
		                $targetPath = "uploads/".$new_name;  
		                move_uploaded_file($sourcePath, $targetPath);  
						$img[$i]=$new_name;
						$i++;
	                }else{

	                	$targetPath = 'uploads/';  
               			$location = $targetPath . $filename; 
               			if(move_uploaded_file($_FILES['image']['tmp_name'][$key], $location))  
		                {  
		                     $zip = new ZipArchive;  
		                     if($zip->open($location))  
		                     {  
		                          $zip->extractTo($targetPath);  
		                          $zip->close();  
		                     }  
		                     $files = scandir($targetPath . $file_name[0]);  
		                      
		                     foreach($files as $file)  
		                     {  
		                          $tmp=explode(".", $file);
								  $file_ext = end($tmp);  
		                          $allowed_ext = array("jpg", "jpeg", "png", "gif", "JPG"); 
		                          $new_name='';
		                          if(in_array($file_ext, $allowed_ext))  
		                          {  
		                               $new_name = md5(rand()).'.' . $file_ext; 
		                             
		                               copy($targetPath.$file_name[0].'/'.$file, $targetPath . $new_name);  
		                               unlink($targetPath.$file_name[0].'/'.$file);  
		                          }
		                          if($new_name!=''){
		                          	$img[$i]=$new_name;  
		                          $i++; 
		                          }
		                               
		                     }  
		                     unlink($location);  
		                     rmdir($targetPath . $file_name[0]);  
		                }  
	                }
	                
	           } 
	      }

			echo json_encode($img);
	      
	      
	 }
?>