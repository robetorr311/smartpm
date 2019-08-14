<?php
defined('BASEPATH') or exit('No direct script access allowed');
?> <div class="container-fluid">
                <div class="row">
           <?= $this->session->flashdata('errors') ?>
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
                            <div class="content view">
                                  <?php
                              
                                   foreach( $jobs as $job ) : ?>  

                                
                              
                                    <div class="row">
                                        <input type="hidden" name="id" class="hidden_id" value="<?php echo $job->id ?>">
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


                                 
                                    <div class="clearfix"></div>
                              
                            
                       
                 <div class="footer" style="margin-bottom: 10px;">
                                    
                                    <hr>
   <a href="<?php echo base_url('photos/'.$job->id);?>" class="btn btn-success btn-fill">Photos</a>
    <a href="<?php echo base_url('report/'.$job->id);?>" class="btn btn-danger btn-fill">All Report</a>
   <a href="" class="btn btn-success btn-fill">Create Estimate</a>
   <a href="<?php echo base_url('docs/'.$job->id);?>" class="btn btn-danger btn-fill">Docs</a>
                                </div>
                                                                   <?php endforeach; ?>
                    </div>
                          
                        </div>
                    </div>

 <div class="col-md-4"> 
     <div class="card">
        <div class="header"> 
             <h4 class="title" style="float: left;">Current Status:</h4>
              <div style="float: right;text-align: right;"><p>Complete</p></div>
                <div class="clearfix"></div>

             
              <?php if ($status) {  foreach ($status as $st) {
                  if($st->closeout =="no"){
               ?>
              <a href="<?php echo base_url('work-complete/'.$jobid.'/mark-complete')?>" class="btn btn-danger pull-right" style="margin:20px 0;">Mark Closed</a>
              <?php }else{ ?>
               <a href="<?php echo base_url('work-complete/'.$jobid.'/mark-incomplete')?>" class="btn btn-sucess pull-right" style="margin:20px 0;">Mark incomplete</a>
                <?php }}} ?>
        </div>
    </div>
     <div class="card">
        <div class="header"> 
            <h4 class="title" style="float: left;">Team Detail:</h4>
                <?php if( !empty( $teams_detail ) ) : ?>
                <?php foreach( $teams_detail as $data ) : ?>  
                             <div style="float: right;text-align: right;"><p><?php echo $data->name ?></p>
                            <p><?php echo $data->assign_date ?></p>
                           
                         </div>
                <?php endforeach; ?>
                <?php else : ?>
                   <p style="float: right;color: red;margin-bottom: 20px;"> No Team Assigned!</p>
                     
                <?php endif; ?>
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
                                                <input type="hidden"  name="id" value="<?php echo $jobid; ?>">
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
                                   

                                    <div class="row">
                                         
                                        <div class="col-md-12">
                                           No record!
                                        </div>
                                    </div>

                               

                                <?php endif; ?>
                            </div>
                        </div>
</div>
                       </div>
                        </div>
  
