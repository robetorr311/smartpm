<?php
defined('BASEPATH') or exit('No direct script access allowed');
?> <div class="container-fluid">
                <div class="row"> <div class="col-md-12">
       <?= $this->session->flashdata('message') ?>
       
        </div>
                   <div class="col-md-8">
                        <div class="card">
                           
                           
                
                            <div class="header">
                                <h4 class="title" style="float: left;">Add Job</h4> <a href="javascript:window.history.go(-1);" class="btn btn-info btn-fill pull-right">Back</a>

                               

                            </div>

                            <div class="content">
       
                                <?php echo form_open('lead/store',array('method'=>'post'));?>
                                    <div class="row">
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Job Name</label>
                                                <input class="form-control" placeholder="Job Name" name="jobname" value="<?= set_value('jobname') ?>" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input class="form-control" name="firstname" value="<?= set_value('firstname') ?>" placeholder="" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input class="form-control" placeholder="Last Name" name="lastname" value="<?= set_value('lastname') ?>" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Street Address</label>
                                                <input class="form-control" placeholder="Address" name="address" value="<?= set_value('address') ?>" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input class="form-control" placeholder="City" value="<?= set_value('city') ?>" name="city" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>State</label>
                                                <input class="form-control" placeholder="Country" Name="country" value="<?= set_value('country') ?>" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Postal Code</label>
                                                <input class="form-control" placeholder="ZIP Code" value="<?= set_value('zip') ?>" name="zip" type="text">
                                            </div>
                                        </div>
                                    </div>

                                 <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Cell Phone</label>
                                                <input class="form-control" placeholder="Phone 1" name="phone1" value="<?= set_value('phone1') ?>" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Home Phone</label>
                                                <input class="form-control" placeholder="Phone 2" name="phone2" value="<?= set_value('phone2') ?>" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" name="email" placeholder="Email" value="<?= set_value('email') ?>" type="email">
                                            </div>
                                        </div>
                                    </div>


                                    <button type="submit" class="btn btn-info btn-fill pull-right">Save</button>
                                    <div class="clearfix"></div>
                                <?php echo form_close(); ?>      
                            </div>
                       
                          
                        </div>
                    </div>
					   </div>
                        </div>
  
