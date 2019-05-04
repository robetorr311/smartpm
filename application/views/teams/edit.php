<?php
defined('BASEPATH') or exit('No direct script access allowed');
?> <div class="container-fluid">
                <div class="row">  <div class="col-md-12">        
  <?= $this->session->flashdata('message') ?>
                                                            </div>
                   <div class="col-md-8">
                        <div class="card">
                           
                           
                
                            <div class="header">
                                <h4 class="title" style="float: left;">Add team</h4> <a href="javascript:window.history.go(-1);" class="btn btn-info btn-fill pull-right">Back</a>

                               

                            </div>

                            <div class="content">
                                     <?php if( !empty( $teams ) ) : ?>
              <?php foreach( $teams as $team ) : ?>                
                                <?php echo form_open('team/'.$team->id.'/update',array('method'=>'post'));?>
                                    <div class="row">
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Team Name(Region Name)</label>
                                                <input  name="id" value="<?php echo $team->id ?>" type="hidden">
                                                <input class="form-control" placeholder="Job Name" name="teamname" value="<?php echo $team->team_name ?>" type="text">
                                            </div>
                                        </div>
                                    </div>

                                

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Remark</label>
                                                <textarea class="form-control" placeholder="Address" name="remark" ><?php echo $team->remark ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                   

                                


                                    <button type="submit" class="btn btn-info btn-fill pull-right">Update</button>
                                    <div class="clearfix"></div>
                                <?php echo form_close(); ?>    
                                <?php endforeach; ?>
            <?php else : ?>
               <p class="mb-15">  Something Wrong!</p>
            <?php endif; ?>  
                            </div>
                       
                          
                        </div>
                    </div>
					   </div>
                        </div>
  
