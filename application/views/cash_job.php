 <div class="container-fluid">
                <div class="row">
                   <div class="col-md-12">
                        <div class="card">
                             <div class="row header">
                                 <div class="col-md-6">
                                         <input class="form-control" id="myInput"  placeholder="Search Job" type="text">
                                 </div>
                                  <div class="col-md-6">
                                   <!-- <a href="<?php echo base_url('index.php/dashboard/addjob');?>" class="btn btn-info btn-fill pull-right">Add New Job</a>-->
                                 </div>
                            </div>
                            <div class="header">
                                 <?= $this->session->flashdata('message') ?>
                                <h4 class="title">Cash Job List</h4>
                                
                            </div>
                            <div class="content table-responsive table-full-width">
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
               <td><a href="<?php echo base_url();?>index.php/dashboard/update_job/<?php echo $jobs->id ?>"><img src="<?php echo base_url('assets/img/document_edit.png');?>" style="width: 35px;"/></a></td>
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
  
