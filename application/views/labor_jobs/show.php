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
                    <h4 class="title" style="float: left;">Job Details</h4>
                    <a href="<?= base_url('lead/labor-jobs') ?>" class="btn btn-info btn-fill pull-right">Back</a>
                    <div class="clearfix"></div>
                </div>
                <div class="content view">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name</label>
                                <p><?= $job->firstname ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name</label>
                                <p><?= $job->lastname ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Address</label>
                                <p><?= $job->address ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>City</label>
                                <p><?= $job->city ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>State</label>
                                <p><?= $job->state ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Postal Code</label>
                                <p><?= $job->zip ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Phone 1</label>
                                <p><?= $job->phone1 ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Phone 2</label>
                                <p><?= $job->phone2 ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <p><?= $job->email ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="footer">
                    <a href="<?= base_url('lead/labor-job/' . $job->id . '/photos') ?>" class="btn btn-success btn-fill">Photos</a>
                    <a href="<?= base_url('lead/labor-job/' . $job->id . '/reports') ?>" class="btn btn-danger btn-fill">All Report</a>
                    <a href="" class="btn btn-success btn-fill">Create Estimate</a>
                    <a href="<?= base_url('lead/labor-job/' . $job->id . '/docs') ?>" class="btn btn-danger btn-fill">Docs</a>
                    <a href="<?= base_url('lead/labor-job/' . $job->id . '/notes') ?>" class="btn btn-success btn-fill">Notes</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h4 class="title" style="float: left;">Team Detail</h4>
                    <?php if (!empty($teams_detail)) : ?>
                    <?php foreach ($teams_detail as $data) : ?>
                    <div style="float: right;text-align: right;">
                        <p><?= $data->name ?></p>
                        <p><?= $data->assign_date ?></p>
                        <a href="<?= base_url('lead/labor-job/' . $jobid . '/remove-team') ?>" data-method="POST">Remove</a>
                    </div>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <p style="float: right;color: red;margin-bottom: 20px;"> No Team Assigned!</p>
                    <div class="content team-block">
                        <?= form_open('lead/labor-job/' . $jobid . '/add-team', array('method' => 'post')) ?>
                        <select name="team_id" class="form-control team_assign">
                            <option value="">Select Team</option>
                            <?php foreach ($teams as $team) : ?>
                            <option value="<?= $team->id ?>"><?= $team->team_name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input class="btn btn-success btn-fill" type="submit" value="Add Team">
                        <?= form_close() ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card">
                    <div class="header">
                        <h4 class="title" style="float: left;">Status</h4>
                        <span class="status">
                            <?= LeadModel::statusToStr($job->status) ?>
                        </span>
                        <div class="clearfix" style="padding: 10px;"></div>
                        <h4 class="title" style="float: left;">Job Type</h4>
                        <span class="status">
                            <?= LeadModel::typeToStr($job->type) ?>
                        </span>
                        <div class="clearfix" style="padding: 10px;"></div>
                    </div>
            </div>
            <div class="card">
                <div class="header">
                    <h4 class="title" style="float: left;">Additional Party Detail</h4>
                    <div class="clearfix"></div>
                </div>
                <div class="content">
                    <?php if (!empty($add_info)) : ?>
                    <?php foreach ($add_info as $info) : ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>First Name</label>
                                <p><?= $info->fname ?></p>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <p><?= $info->lname ?></p>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <p><?= $info->phone ?></p>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <p><?= $info->email ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <div class="row">
                        <div class="col-md-12">
                            No record!
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="<?= base_url('lead/labor-job/' . $job->id . '/move-next-stage') ?>" class="btn btn-info btn-fill full-width  lead-move-btn" data-method="POST">Move to Production&nbsp;<i class="pe-7s-angle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>