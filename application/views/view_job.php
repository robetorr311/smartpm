 <div class="container-fluid">
                <div class="row">
           <?= $this->session->flashdata('message') ?>
                   <div class="col-md-8">
                        <div class="card">
                           
                           
                
                            <div class="header">
                                <h4 class="title" style="float: left;">View</h4> <a href="javascript:window.history.go(-1);" class="btn btn-info btn-fill pull-right">Back</a>
<div class="clearfix"></div>
                                
                                                             <?php if(validation_errors())
{   
echo '<div class="alert alert-danger fade in alert-dismissable" title="Error:"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>';
echo validation_errors();
echo '</div>';
}
?>
                            </div>
                            <div class="content">
                                  <?php
                                $status='';
                                   foreach( $jobs as $job ) : ?>  

                                <?php echo form_open('server/update_job',array('id'=>"jobform",'autocomplete'=>"off"));?>
                                <?php  $status= $job->status; ?>
                                    <div class="row">
                                        <input type="hidden" name="id" class="hidden_id" value="<?php echo $job->id ?>"></input>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Job Name</label>
                                               <p> <?php echo $job->job_name ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <p><?php echo $job->firstname ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <p><?php echo $job->lastname ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <p><?php echo $job->address ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>City</label>
                                               <p><?php echo $job->city ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>State</label>
                                               <p><?php echo $job->state ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Postal Code</label>
                                              <p><?php echo $job->zip ?></p>
                                            </div>
                                        </div>
                                    </div>

                                 <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Phone 1</label>
                                               <p><?php echo $job->phone1 ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Phone 2</label>
                                               <p><?php echo $job->phone2 ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <p><?php echo $job->email ?></p>
                                            </div>
                                        </div>
                                    </div>


                                    <button type="submit" class="btn btn-info btn-fill pull-right">Save</button>
                                    <div class="clearfix"></div>
                                <?php echo form_close(); ?>
      
                            
                       
					   <div class="footer" style="margin-bottom: 10px;">
                                    
                                    <hr>
                                    <a href="<?php echo base_url('index.php/dashboard/addphoto/'.$job->id);?>" class="btn btn-success btn-fill">Photo</a>
									
  <!-- <a href="http://developeradda.tech/project/roofing-crm/report/?id=<?php echo $job->id ?>" target="_blank" class="btn btn-danger btn-fill">Photo Report</a>-->
   <a href="<?php echo base_url();?>index.php/dashboard/alljobreport/<?php echo $job->id ?>" class="btn btn-danger btn-fill">All Report</a>
   <a href="" class="btn btn-success btn-fill">Create Estimate</a>
   <a href="<?php echo base_url('index.php/dashboard/adddoc/'.$job->id);?>" class="btn btn-danger btn-fill">Docs</a>
                                </div>
								                                   <?php endforeach; ?>
					</div>
                          
                        </div>
                    </div>

 <div class="col-md-4">
            <div class="card">
                <div class="header">
                                    <h4 class="title" style="float: left;">Job Status</h4><span class="status <?php if($status=='closed'){ echo 'closed';}else{ echo 'open';} ?>"><?php echo $status; ?></span> 
                                    <div class="clearfix"></div>
                                         <div class="content"></div>         
                                </div>
             </div>
        <div class="card">
                           
                           
                
                            <div class="header">
                                <h4 class="title" style="float: left;">Additional Party Detail</h4> 
                                <div class="clearfix"></div>
                              
                                                           
                            </div>
                            <div class="content">
                            <?php if( !empty( $add_info ) ) : ?>
                            <?php foreach( $add_info as $info ) : ?>  
                                <?php echo form_open('server/additional_party_update',array('id'=>"jobform",'autocomplete'=>"off"));?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="hidden"  name="id" value="<?php echo $jobid; ?>"></input>
                                                <label>First Name</label>
                                               <p><?php echo $info->fname ?></p>
                                            </div>
                                       
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <p><?php echo $info->lname ?></p>
                                            </div>
                                       
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <p><?php echo $info->phone ?></p>
                                            </div>
                                       
                                            <div class="form-group">
                                                <label>Email</label>
                                                <p><?php echo $info->email ?></p>
                                            </div>
                                             <button type="submit" class="btn btn-info btn-fill pull-right">Save</button>
                                        </div>
                                    </div>

                                 <?php echo form_close(); ?>
                                 <?php endforeach; ?>
                                <?php else : ?>
                                   <?php echo form_open('server/additional_party_add',array('id'=>"jobform",'autocomplete'=>"off"));?>

                                    <div class="row">
                                         <input type="hidden" name="id" value="<?php echo $jobid; ?>"></input>
                                        <div class="col-md-12">
                                           No record!
                                        </div>
                                    </div>

                                 <?php echo form_close(); ?>

                                <?php endif; ?>
                            </div>
                        </div>
</div>
					   </div>
                        </div>
  
