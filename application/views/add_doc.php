 <div class="container-fluid">
                <div class="row">
                   <div class="col-md-12">
                        <div class="card">
                           
                           
                
                            <div class="header">
                                <h4 class="title" style="float: left;">Docs</h4> <a href="javascript:window.history.go(-1);" class="btn btn-info btn-fill pull-right">Back</a>
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
							<input type="hidden" />
                               <div class="image_div">
                               <table class="table table-hover table-striped doc_list">   
              <?php $i=0; foreach( $docs as $doc ) : ?>  
              <?php $i++; 
                     ?>
              <tr  id="doc<?php echo $doc->id; ?>">
                <td style="width: 30px"><?php  echo $i; ?></td>
                <td style="width: 30px"><i class="del-doc pe-7s-trash" id="<?php echo $doc->id; ?>"></i></td>
                <td style="width: 30px"><a target="_blank" href="<?php echo base_url('assets/job_doc'); ?>/<?php echo $doc->doc_name ?>" class="" ><i class="pe-7s-news-paper" style="font-size: 30px" /></a></td>
                <td><span class="<?php echo $doc->id ?>"><i class="del-edit pe-7s-note" /></span></td>
                <td><p id="docp<?php echo $doc->id ?>"><?php  echo $doc->name ?></p><input style="width: 100%;display:none" name="<?php echo $doc->id ?>" type="text"  class="docname" id="doctext<?php echo $doc->id ?>" /></td>
                <td><?php echo $doc->doc_name ?></td></tr>
              
                                   <?php endforeach; ?>
                               </table></div>
      <?php //echo $jobid; ?>
                            
                       </div>
			
								                                
					
                          
                        </div>
                    </div>
                    <div class="col-md-12">		   
                                    
                                 
       	<div class="form-element">
				<input type="file" class="jobdoc" name="doc[]" id="<?php echo $jobid; ?>" multiple />
				<div class="upload-doc-area"  id="<?php echo $jobid; ?>">
					<h1>Drag and Drop file here <br/>Or<br/>Click to select file</h1>
				</div>
			</div>
            </div>
					   </div>
                        </div>
  
