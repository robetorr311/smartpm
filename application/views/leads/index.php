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
                                    <a href="<?php echo base_url('lead/new');?>" class="btn btn-info btn-fill pull-right">Add New Job</a>
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

                                    <?php if( !empty( $leads ) ) : ?>
              <?php foreach( $leads as $lead ) : ?>  
                <tr> <!--<td style="width: 30px"><i class="del-doc pe-7s-trash" id=""></i></td>-->
                <td style="width: 30px"><a href="<?php echo base_url('lead/'.$lead->id);?>"><i class="pe-7s-news-paper" style="font-size: 30px" /></a></td>
              <td><a href="<?php echo base_url('lead/'.$lead->id.'/edit');?>"><span class=""><i class="del-edit pe-7s-note" style="font-size: 30px;" /></span></a></td>
              
                  <td><?php echo $lead->job_number ?></td>
                  <td><?php echo $lead->job_name ?></td>
                  <td><?php echo $lead->firstname ?></td>
                  <td><?php echo $lead->lastname ?></td>
                  <td><?php echo $lead->address ?></td>
                  <td><?php echo $lead->city ?></td>
                  <td><?php echo $lead->state ?></td>
                  <td><?php echo $lead->zip ?></td>
                  <td><?php echo $lead->phone1 ?></td>
                  <td><?php echo $lead->phone2 ?></td>
                  <td><?php echo $lead->email ?></td>
                 </tr>
                  <?php endforeach; ?>
            <?php else : ?>
                  <tr>
                      <td colspan="13" class="text-center">No Record Found!</td>
                  </tr>
            <?php endif; ?>
               


                                  
                                    </tbody>
                                </table>
<div class="pagination">
                        <?= $pagiLinks ?>
                    </div>
                            </div> 
                        </div>
                    </div>
					   </div>
                        </div>
  
