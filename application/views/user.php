<?php
defined('BASEPATH') or exit('No direct script access allowed');
?> <div class="container-fluid">
                <div class="row">
                   <div class="col-md-12">
                        <div class="card">
                             <div class="row header">
                                 <div class="col-md-6">
                                         <input class="form-control" id="myInput"  placeholder="Search Job" type="text">
                                 </div>
                                  <div class="col-md-6">
                                
                                 </div>
                            </div>
                            <div class="header">
                                 <?= $this->session->flashdata('message') ?>
                                <h4 class="title">User List</h4>
                               
                            </div>
                            <div class="content table-responsive table-full-width user" >
                                <table class="table table-hover table-striped">
                                    <thead style="background: gray;">
                                        
                                        <th>User ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Team</th>
                                      
                                        
                                    </thead>
                                    <tbody id="myTable">

                                    <?php if( !empty( $job ) ) : ?>
              <?php foreach( $job as $jobs ) : ?>  
                <tr>
               
                  <td><?php echo $jobs->id ?></td>
                  <td><?php echo $jobs->firstname ?></td>
                  <td><?php echo $jobs->lastname ?></td>
                  <td><?php echo $jobs->address ?></td>
                  <td><?php echo $jobs->email ?></td>
                  <td><select class="form-control">
                        <option value="lead">Select Team</option>
                        <option value="lead">Team 1</option>
                        <option value="lead">Team 2</option>
                        <option value="lead">Team 3</option>
                    </select>
                 </td>
                 </tr>


                      <?php endforeach; ?>
            <?php else : ?>
               <p class="mb-15">  No Record Found!</p>
            <?php endif; ?>
               


                                  
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
					   </div>
                        </div>
  
