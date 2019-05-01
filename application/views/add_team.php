 <div class="container-fluid">
                <div class="row">
                   <div class="col-md-8">
                        <div class="card">
                           
                           
                
                            <div class="header">
                                <h4 class="title" style="float: left;">Add team</h4> <a href="javascript:window.history.go(-1);" class="btn btn-info btn-fill pull-right">Back</a>

                               

                            </div>

                            <div class="content">
                                                     <div class="col-md-12">         <p style="color: green;">
  <?php $this->session->flashdata('message') ?>
                                                             <?php if(validation_errors())
{   
echo '<div class="alert alert-danger fade in alert-dismissable" title="Error:"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>';
echo validation_errors();
echo '</div>';
}
?></div>
                                <?php echo form_open('server/save_team',array('id'=>"teamjobform",'autocomplete'=>"off"));?>
                                    <div class="row">
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Team Name(Region Name)</label>
                                                <input class="form-control" placeholder="Job Name" name="teamname" value="" type="text">
                                            </div>
                                        </div>
                                    </div>

                                

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Remark</label>
                                                <textarea class="form-control" placeholder="Address" name="remark" ></textarea>
                                            </div>
                                        </div>
                                    </div>

                                   

                                


                                    <button type="submit" class="btn btn-info btn-fill pull-right">Save</button>
                                    <div class="clearfix"></div>
                                <?php echo form_close(); ?>      
                            </div>
                       
                          
                        </div>
                    </div>
					   </div>
                        </div>
  
