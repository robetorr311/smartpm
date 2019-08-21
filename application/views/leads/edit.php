<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (!empty($this->session->flashdata('errors'))) {
                echo '<div class="alert alert-danger fade in alert-dismissable" title="Error:"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>';
                echo $this->session->flashdata('errors');
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="header">
                    <h4 class="title" style="float: left;">Update Lead</h4>
                    <a href="<?= base_url('leads') ?>" class="btn btn-info btn-fill pull-right">Back</a>
                    <div class="clearfix"></div>
                </div>
                <div class="content">
                    <?= form_open('lead/' . $lead->id . '/update', array('method' => 'post')) ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group"> <input type="hidden" name="id" class="hidden_id" value="<?= $lead->id ?>" />
                                <label>Lead Name<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="Lead Name" name="jobname" value="<?= $lead->job_name ?>" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name<span class="red-mark">*</span></label>
                                <input class="form-control" name="firstname" value="<?= $lead->firstname ?>" placeholder="" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="Last Name" name="lastname" value="<?= $lead->lastname ?>" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Address<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="Address" name="address" value="<?= $lead->address ?>" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>City<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="City" value="<?= $lead->city ?>" name="city" type="text">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>State<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="State" Name="state" value="<?= $lead->state ?>" type="text">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Postal Code<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="ZIP Code" value="<?= $lead->zip ?>" name="zip" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cell Phone<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="Phone 1" name="phone1" value="<?= $lead->phone1 ?>" type="text">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Home Phone</label>
                                <input class="form-control" placeholder="Phone 2" name="phone2" value="<?= $lead->phone2 ?>" type="text">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" name="email" placeholder="Email" value="<?= $lead->email ?>" type="email">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-info btn-fill pull-right">Save</button>
                    <div class="clearfix"></div>
                    <?= form_close() ?>
                </div>

            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <?= form_open('lead/' . $jobid . '/updatestatus', array('method' => 'post')) ?>
                <div class="header">
                    <h4 class="title" style="float: left;">Status</h4>
                    <span class="status">
                        <?= LeadModel::statusToStr($lead->status) ?>
                    </span>
                    <div class="clearfix"></div>
                    <div class="content">
                        <select class="form-control" id="lead" name="status">
                            <?php foreach ($lead_status_tags as $s_id => $s_tags) : ?>
                            <option value="<?= $s_id ?>" <?= ($s_id == $lead->status) ? 'selected' : '' ?>><?= $s_tags ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="header">
                    <h4 class="title" style="float: left;">Job Type</h4>
                    <span class="status">
                        <?= LeadModel::typeToStr($lead->type) ?>
                    </span>
                    <div class="clearfix"></div>
                    <div class="content">
                        <select class="form-control lead-status" id="job" name="type">
                            <?php foreach ($job_type_tags as $j_id => $job) : ?>
                            <option value="<?= $j_id ?>" <?= ($j_id == $lead->type) ? 'selected' : '' ?>><?= $job ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info btn-fill pull-right">Update</button>
                    <div class="clearfix" style="padding: 10px;"></div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="card">
                <div class="header">
                    <h4 class="title">Additional Party(If any)</h4>
                </div>
                <div class="content">
                    <?php if (!empty($add_info)) : ?>
                    <?= form_open('lead/' . $jobid . '/party/update', array('method' => 'post')) ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>First Name</label>
                                <input class="form-control" name="firstname" value="<?= $add_info->fname ?>" placeholder="First Name" type="text">
                            </div>

                            <div class="form-group">
                                <label>Last Name</label>
                                <input class="form-control" placeholder="Last Name" name="lastname" value="<?= $add_info->lname ?>" type="text">
                            </div>

                            <div class="form-group">
                                <label>Phone</label>
                                <input class="form-control" placeholder="Phone" name="phone" value="<?= $add_info->phone ?>" type="text">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" placeholder="Email" name="email" value="<?= $add_info->email ?>" type="text">
                            </div>
                            <button type="submit" class="btn btn-info btn-fill pull-right">Update</button>
                        </div>
                    </div>

                    <?= form_close() ?>
                    <?php else : ?>
                    <?= form_open('lead/' . $jobid . '/party/add', array('method' => 'post')) ?>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>First Name</label>
                                <input class="form-control" name="firstname" value="" placeholder="First Name" type="text">
                            </div>

                            <div class="form-group">
                                <label>Last Name</label>
                                <input class="form-control" placeholder="Last Name" name="lastname" value="" type="text">
                            </div>

                            <div class="form-group">
                                <label>Phone</label>
                                <input class="form-control" placeholder="Phone" name="phone" value="" type="text">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" placeholder="Email" name="email" value="" type="text">
                            </div>
                            <button type="submit" class="btn btn-info btn-fill pull-right">Save</button>
                        </div>
                    </div>

                    <?= form_close() ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>