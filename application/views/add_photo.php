 <div class="container-fluid">
                <div class="row">
                   <div class="col-md-12">
                        <div class="card">
                           
                           
                
                            <div class="header">
                                <h4 class="title" style="float: left;">Add Photo</h4> <a href="javascript:window.history.go(-1);" class="btn btn-info btn-fill pull-right">Back</a>
<div class="clearfix"></div>
                                 <?= $this->session->flashdata('message') ?>
                                                             <?php if (validation_errors())
{   
echo '<div class="alert alert-danger fade in alert-dismissable" title="Error:"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>';
echo validation_errors();
echo '</div>';
}
?>
                            </div>
                            <div class="content">
                               <div class="image_div">
                                  
              <?php foreach( $imgs as $img ) : ?>  
              
              <div class="col-md-2" id="ph<?php echo $img->id; ?>"><i class="del-photo pe-7s-close" id="<?php echo $img->id; ?>"></i><a href="#" class="pop"><img src="<?php echo base_url('assets/job_photo'); ?>/<?php echo $img->image_name ?>" /></a></div>
              
                                   <?php endforeach; ?>
                               </div>
      <?php //echo $jobid; ?>
                            
                       </div>
			
								                                
					
                          
                        </div>
                    </div>
                    <div class="col-md-12">		   
                                    
                                 
       	<div class="form-element">
				<input type="file" class="jobphoto" name="photo[]" id="<?php echo $jobid; ?>" multiple />
				<div class="upload-area"  id="<?php echo $jobid; ?>">
					<h1>Drag and Drop file here<br/>Or<br/>Click to select file</h1>
				</div>
			</div>
            </div>
					   </div>
                        </div>
  
