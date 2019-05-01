 <div class="container-fluid">
                <div class="row">
                   <div class="col-md-12">
                        <div class="card">
                             <div class="row header">
                                 <div class="col-md-6">
                                         <input class="form-control" id="myInput"  placeholder="Search Job" type="text">
                                 </div>
                                  <div class="col-md-6">
                                    <a href="<?php echo base_url('index.php/dashboard/addjob');?>" class="btn btn-info btn-fill pull-right">Add New Job</a>
                                 </div>
                            </div>
                            <div class="header">
                                 <?= $this->session->flashdata('message') ?>
                                <h4 class="title">Job List</h4>
                                <p class="category">Here is a subtitle for this table</p>
                            </div>
                            <div class="content table-responsive" style="overflow-x: scroll;width: 100%;">
                                <table class="table table-hover table-striped">
                                    <thead>
                                       <!-- <th></th> -->
                                        <th></th>
                                        <th></th>

                                        <th>Job ID</th>
                                        <th>Job Name</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Zip</th>
                                        <th>Cell Phone</th>
                                        <th>Home Phone</th>
                                        <th>Email</th>
                                     <!--   <th>Status</th>-->
                                      
                                        
                                    </thead>
                                    <tbody id="myTable">

                                    <?php if( !empty( $job ) ) : ?>
              <?php foreach( $job as $jobs ) : ?>  
                <tr> <!--<td style="width: 30px"><i class="del-doc pe-7s-trash" id=""></i></td>-->
                <td style="width: 30px"><a href="<?php echo base_url();?>index.php/dashboard/view_job/<?php echo $jobs->id ?>"><i class="pe-7s-news-paper" style="font-size: 30px" /></a></td>
              <td><a href="<?php echo base_url();?>index.php/dashboard/update_job/<?php echo $jobs->id ?>"><span class=""><i class="del-edit pe-7s-note" style="font-size: 30px;" /></span></a></td>
              
                  <td><?php echo $jobs->job_number ?></td>
                  <td><?php echo $jobs->job_name ?></td>
                  <td><?php echo $jobs->firstname ?></td>
                  <td><?php echo $jobs->lastname ?></td>
                  <td><?php echo $jobs->address ?></td>
                  <td><?php echo $jobs->city ?></td>
                  <td><?php echo $jobs->state ?></td>
                  <td><?php echo $jobs->zip ?></td>
                  <td><?php echo $jobs->phone1 ?></td>
                  <td><?php echo $jobs->phone2 ?></td>
                  <td><?php echo $jobs->email ?></td>
                 <!-- <td><select class="form-control">
                        <option value="lead">Lead</option>
                        <option value="lead">Cash job</option>
                        <option value="lead">Insurance job</option>
                        <option value="lead">Closed</option>
                    </select>-->
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
  
