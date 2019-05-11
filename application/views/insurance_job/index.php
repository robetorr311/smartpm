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

                                    <?php if( !empty( $jobs ) ) : ?>
              <?php foreach( $jobs as $job ) : ?>  
                <tr>
               <td style="width: 30px"><a href="<?php echo base_url('insurance_job/'.$job->id);?>"><i class="pe-7s-news-paper" style="font-size: 30px" /></a></td>
                  <td><?php echo $job->id ?></td>
                  <td><?php echo $job->job_name ?></td>
                  <td><?php echo $job->firstname ?></td>
                  <td><?php echo $job->lastname ?></td>
                  <td><?php echo $job->address ?></td>
                  <td><?php echo $job->email ?></td>
                </tr>


                      <?php endforeach; ?>
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
					   </div>
                        </div>
  
