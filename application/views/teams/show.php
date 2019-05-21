<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
    <div class="row">
        <?= $this->session->flashdata('message') ?>
        <div class="col-md-8">
            <div class="card">
                <div class="content view">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="line-height: 30px;">Team Name :</label>
                                <p style="font-size: 25px"> <?= $team->team_name ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Manager</label>
                                <p><?= $team->manager_fullname ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Team Leader</label>
                                <p><?= $team->team_leader_fullname ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Reamrk :</label>
                                <p><?= nl2br($team->remark) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card">
                <div class="row header">
                    <div class="col-md-6">
                        <h4 class="title" style="float: left;">Team Members</h4>
                    </div>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Full Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($members)) : ?>
                                <?php foreach ($members as $member) : ?>
                                    <tr>
                                        <td><?= $member->id ?></td>
                                        <td><?= $member->username ?></td>
                                        <td><?= $member->name ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="text-center">No Record Found!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h4 class="title" style="float: left;">Task Assigned <small>(Unconfirmed Section)</small></h4>
                    <div class="clearfix"></div>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Task Name</th>
                                <th>Assigned Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Temporary Data</td>
                                <td>06 May 2019</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Temporary Data</td>
                                <td>06 May 2019</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>