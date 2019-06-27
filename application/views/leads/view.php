<?php
defined('BASEPATH') or exit('No direct script access allowed');
?> <div class="container-fluid">
                <div class="row">
           <?= $this->session->flashdata('message') ?>
                   <div class="col-md-8">
                        <div class="card">
                           
                           
                
                            <div class="header">
                                <h4 class="title" style="float: left;">Lead Detail</h4> <a href="javascript:window.history.go(-1);" class="btn btn-info btn-fill pull-right">Back</a>
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
                                $status='';
                                   foreach( $leads as $lead ) : ?>  

                               
                                <?php  $status= $lead->status; ?>
                                    <div class="row">
                                       
                                        <div class="col-md-12">
                                             <input type="hidden" name="id" class="hidden_id" value="<?php echo $lead->id ?>"/>
                                            <div class="form-group">
                                                <label style="line-height: 30px;">Job Name :</label>
                                               <p style="font-size: 25px"> <?php echo $lead->job_name ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Name :</label>
                                                <p><?php echo $lead->firstname ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Name :</label>
                                                <p><?php echo $lead->lastname ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address :</label>
                                                <p><?php echo $lead->address ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>City :</label>
                                               <p><?php echo $lead->city ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>State :</label>
                                               <p><?php echo $lead->state ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Postal Code :</label>
                                              <p><?php echo $lead->zip ?></p>
                                            </div>
                                        </div>
                                    </div>

                                 <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Cell Phone :</label>
                                               <p><?php echo $lead->phone1 ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Home Phone :</label>
                                               <p><?php echo $lead->phone2 ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Email :</label>
                                                <p><?php echo $lead->email ?></p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="clearfix"></div>
                           
                            
                       
                       <div class="footer" style="margin-bottom: 10px;">
                                    
                                    <hr>
   <a href="<?php echo base_url('photos/'.$lead->id);?>" class="btn btn-success btn-fill">Photos</a>
   <a href="<?php echo base_url('report/'.$lead->id);?>" class="btn btn-danger btn-fill">All Report</a>
   <a href="" class="btn btn-success btn-fill">Create Estimate</a>
   <a href="<?php echo base_url('docs/'.$lead->id);?>" class="btn btn-danger btn-fill">Docs</a>
   <a href="<?php echo base_url('/lead/'.$lead->id.'/notes');?>" class="btn btn-success btn-fill">Notes</a>
                                </div>
                                                                   <?php endforeach; ?>
                    </div>
                          
                        </div>
                    </div>

 <div class="col-md-4">
            <div class="card">
                <?php  foreach( $leadstatus as $status ) : ?>  
                <div class="header">
                    <h4 class="title" style="float: left;">Lead Status</h4><span class="status <?php if($status->lead!='open'){ echo 'closed';}else{ echo 'open';} ?>"><?php echo  $status->lead; ?></span> 
                    <div class="clearfix" style="padding: 10px;" ></div>  

                     <h4 class="title" style="float: left;">Contract Status</h4><span class="status <?php if($status->contract=='signed'){ echo 'open';}else{ echo 'closed';} ?>"><?php echo  $status->contract; ?></span> 
                    <div class="clearfix" style="padding: 10px;"></div>

                     <h4 class="title" style="float: left;">Job Type</h4><span class="status <?php if($status->job==''){ echo 'closed';}else{ echo 'open';} ?>">
<?= empty($status->job) ? ' None' : $status->job ?>
                      </span> 
                    <div class="clearfix" style="padding: 10px;"></div>         
                </div>
                <?php endforeach; ?>  
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
  
