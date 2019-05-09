<?php
defined('BASEPATH') or exit('No direct script access allowed');
?> <div class="container-fluid">
                <div class="row">
           <?= $this->session->flashdata('message') ?>
                   <div class="col-md-8">
                        <div class="card">
                            
                            <div class="content view">
                                  <?php
                                
                                   foreach( $users as $user ) : ?> 
                         
                                    <div class="row">
                                        <div class="col-md-12">
                                        <div class="form-group">
                                            <label style="line-height: 30px;">User Name :</label>
                                           <p style="font-size: 25px"> <?php echo $user->fullname ?></p>
                                           <input type="hidden" value="<?php echo $user->id ?>" class="hidden_id" />
                                        </div>  </div>
                                    </div>
                                   

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email :</label>
                                                <p><?php echo $user->username ?></p>
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone :</label>
                                                <p>999999999</p>
                                            </div>
                                        </div>
                                       </div>

                                    </div>

                                 

                                    <div class="clearfix"></div>
                     
                                                                   <?php endforeach; ?>
                    </div>
                     <div class="card">
                           
                           
                
                            <div class="header">
                                <h4 class="title" style="float: left;">Task Assigned</h4> 
                                <div class="clearfix"></div>
                              
                                                           
                            </div>
                            <div class="content">
                           <table class="table table-hover table-striped">
                                    <thead>
                                        <tr><th>SN</th>
                                        <th>Task Name</th>
                                        <th>Type</th>
                                        <th>Level</th>
                                    </tr></thead>
                                    <tbody>   <?php if( !empty( $tasks ) ) : ?>
                                         <?php $i=1;  
                                         foreach( $tasks as $task ) : ?> 
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $task->name; ?></td>
                                            <td><?= TaskModel::typetostr($task->type) ?></td>
                                            <td><?= TaskModel::leveltostr($task->level) ?></td>
                                        </tr>
                                           <?php $i++;
                                            endforeach; ?>
                                       <?php else : ?>
                  <tr>
                      <td colspan="13" class="text-center">No Record Found!</td>
                  </tr>
            <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                </div>
                       
                   

 <div class="col-md-4">
            <div class="card">
                <div class="header">
                                    <h4 class="title" style="float: left;">Assign Team</h4>
<span class="status open">Active</span> 
                                    <div class="clearfix"></div>
                                         <div class="content">
                                             <select name="team" id="add_team" class="form-control">
                                                <option>Select</option>
                                                 <?php foreach( $teams as $team ) : ?> 
                                                    <option value="<?php echo $team->id; ?>"><?php echo $team->team_name; ?> </option>
                                                 <?php endforeach; ?>
                                             </select>

                                         </div>         
                                </div>
             </div>
       
</div>
                       </div>
                        </div>
  
