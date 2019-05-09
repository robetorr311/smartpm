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
                                       
                                           
                                            <div class="form-group">
                                                <label style="line-height: 30px;">User Name :</label>
                                               <p style="font-size: 25px"> <?php echo $user->fullname ?></p>
                                            </div>
                                        </div>
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

                                   

                                 

                                    <div class="clearfix"></div>
                     
                                                                   <?php endforeach; ?>
                    </div></div>
                        <div class="card">   
 <div class="row header">
                                 <div class="col-md-6">
                                       <h4 class="title" style="float: left;">Team Member</h4>
                                 </div>
                                
                            </div>
                          <div class="content table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr><th>SN</th>
                                        <th>Username</th>
                                        <th>Full Name</th>
                                        
                                    </tr></thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>test@gmail.com</td>
                                            <td>User1</td>
                                          
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                           <td>test@gmail.com</td>
                                            <td>User1</td>
                                            
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                           <td>test@gmail.com</td>
                                            <td>User1</td>
                                            
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                             <td>test@gmail.com</td>
                                            <td>User1</td>
                                           
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>test@gmail.com</td>
                                            <td>User1</td>
                                           
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>test@gmail.com</td>
                                            <td>User1</td>
                                            
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

 <div class="col-md-4">
            <div class="card">
                <div class="header">
                                    <h4 class="title" style="float:left;">User Status</h4>
<span class="status open">Active</span> 
                                    <div class="clearfix"></div>
                                         <div class="content"></div>         
                                </div>
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
                                        <th>Assigned Date</th>
                                        
                                    </tr></thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Dakota Rice</td>
                                            <td>06 May 2019</td>
                                          
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Minerva Hooper</td>
                                            <td>06 May 2019</td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
</div>
                       </div>
                        </div>
  
