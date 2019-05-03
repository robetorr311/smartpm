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
                                <h4 class="title">Insurance Job List</h4>
                            
                            </div>
                            <div class="content table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Job Name</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                      
                                        
                                    </thead>
                                    <tbody id="myTable">

                                    <?php if( !empty( $job ) ) : ?>
              <?php foreach( $job as $jobs ) : ?>  
                <tr>
               <td style="width: 30px"><a href="<?php echo base_url('insurance_job/'.$jobs->id);?>"><i class="pe-7s-news-paper" style="font-size: 30px" /></a></td>
                  <td><?php echo $jobs->id ?></td>
                  <td><?php echo $jobs->job_name ?></td>
                  <td><?php echo $jobs->firstname ?></td>
                  <td><?php echo $jobs->lastname ?></td>
                  <td><?php echo $jobs->address ?></td>
                  <td><?php echo $jobs->email ?></td>
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
  
