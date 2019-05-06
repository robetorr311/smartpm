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
                            <div class="content table-responsive user" >
                          
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr><th>SN</th>
                                        <th>Username</th>
                                        <th>Full Name</th>
                                        <th>Team</th>
                                        
                                    </tr></thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>test@gmail.com</td>
                                            <td>User1</td>
                                            <td><select class="form-control"><option>select</option>
                                            <option>Team 1</option>
                                          <option>Team 2</option>
                                        <option>Team 3</option></select>
                                          </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                           <td>test@gmail.com</td>
                                            <td>User1</td>
                                             <td><select class="form-control"><option>select</option>
                                            <option>Team 1</option>
                                          <option>Team 2</option>
                                        <option>Team 3</option></select>
                                          </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                           <td>test@gmail.com</td>
                                            <td>User1</td>
                                             <td><select class="form-control"><option>select</option>
                                            <option>Team 1</option>
                                          <option>Team 2</option>
                                        <option>Team 3</option></select>
                                          </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                             <td>test@gmail.com</td>
                                            <td>User1</td>
                                            <td><select class="form-control"><option>select</option>
                                            <option>Team 1</option>
                                          <option>Team 2</option>
                                        <option>Team 3</option></select>
                                          </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>test@gmail.com</td>
                                            <td>User1</td>
                                            <td><select class="form-control"><option>select</option>
                                            <option>Team 1</option>
                                          <option>Team 2</option>
                                        <option>Team 3</option></select>
                                          </td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>test@gmail.com</td>
                                            <td>User1</td>
                                             <td><select class="form-control"><option>select</option>
                                            <option>Team 1</option>
                                          <option>Team 2</option>
                                        <option>Team 3</option></select>
                                          </td>
                                        </tr>
                                    </tbody>
                                </table>


                                

                            </div>
                        </div>
                    </div>
					   </div>
                        </div>
  
