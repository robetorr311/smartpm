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
                    <h4 class="title" style="float: left;">Lead Detail</h4>
                    <a href="<?= base_url('leads') ?>" class="btn btn-info btn-fill pull-right">Back</a>
                    <div class="clearfix"></div>
                </div>
                <div class="content view">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id" class="hidden_id" value="<?= $lead->id ?>" />
                            <div class="form-group">
                                <label style="line-height: 30px;">Job Name :</label>
                                <p style="font-size: 25px"> <?= $lead->job_name ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name :</label>
                                <p><?= $lead->firstname ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name :</label>
                                <p><?= $lead->lastname ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Address :</label>
                                <p><?= $lead->address ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>City :</label>
                                <p><?= $lead->city ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>State :</label>
                                <p><?= $lead->state ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Postal Code :</label>
                                <p><?= $lead->zip ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cell Phone :</label>
                                <p><?= $lead->phone1 ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Home Phone :</label>
                                <p><?= $lead->phone2 ? $lead->phone2 : '-' ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email :</label>
                                <p><?= $lead->email ? $lead->email : '-' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= base_url('lead/' . $lead->id . '/photos'); ?>" class="btn btn-success btn-fill">Photos</a>
                            <a href="<?= base_url('lead/' . $lead->id . '/reports'); ?>" class="btn btn-danger btn-fill">All Report</a>
                            <a href="#" class="btn btn-success btn-fill">Create Estimate</a>
                            <a href="<?= base_url('lead/' . $lead->id . '/docs'); ?>" class="btn btn-danger btn-fill">Docs</a>
                            <a href="<?= base_url('lead/' . $lead->id . '/notes'); ?>" class="btn btn-success btn-fill">Notes</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                    <div class="header">
                        <h4 class="title" style="float: left;">Lead Status</h4>
                        <span class="status">
                            <?= LeadModel::statusToStr($lead->status); ?>
                        </span>
                        <div class="clearfix" style="padding: 10px;"></div>
                        <h4 class="title" style="float: left;">Job Type</h4>
                        <span class="status">
                            <?= LeadModel::typeToStr($lead->type) ?>
                        </span>
                        <div class="clearfix" style="padding: 10px;"></div>
                    </div>
            </div>
            <div class="card">
                <div class="header">
                    <h4 class="title">Additional Party Detail</h4>
                </div>
                <div class="content view">
                    <?php if (!empty($add_info)) : ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?= $jobid; ?>">
                                    <label>First Name</label>
                                    <p><?= $add_info->fname ?></p>
                                </div>

                                <div class="form-group">
                                    <label>Last Name</label>
                                    <p><?= $add_info->lname ?></p>
                                </div>

                                <div class="form-group">
                                    <label>Phone</label>
                                    <p><?= $add_info->phone ?></p>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <p><?= $add_info->email ?></p>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="row">
                            <div class="col-md-12">
                                No record!
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>