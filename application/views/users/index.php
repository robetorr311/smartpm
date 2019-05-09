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
                               
                               
                            </div>
                            <div class="content table-responsive user" >
                          
                                <table class="table table-hover table-striped " id="myTable">
                                    <thead>
                                        <tr>
                                        <th></th>
                                        <th></th>
                                        <th>SN</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Team</th>
                                        </tr>
                                    </thead>
                                    <tbody>  <?php if( !empty( $users ) ) : ?>
              <?php foreach( $users as $user ) : ?>                
                                        <tr>
                                           <td style="width: 30px"><a href="<?php echo base_url('user/'.$user->id.'/delete');?>"><i class="del-doc pe-7s-trash" id=""></i></a></td>
                <td style="width: 30px"><a href="<?php echo base_url('user/'.$user->id);?>"><i class="pe-7s-news-paper" style="font-size: 30px" /></a></td>
               
                                           <td>1</td>
                                          <td><?php echo $user->fullname ?></td>
                                         <td><?php echo $user->username ?></td>
                                          <td>999 999 9999 </td>
                                          <td>
                                            <select class="form-control">
                                              <option>select</option>
                                              <option>Team 1</option>
                                              <option>Team 2</option>
                                              <option>Team 3</option>
                                            </select>
                                          </td>
                                        </tr>
                                            <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center">No Record Found!</td>
                                </tr>
                            <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					   </div>
                        </div>
  
