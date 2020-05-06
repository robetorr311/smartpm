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
</div>
<div id="show-section" class="container-fluid show-edit-visible">
    <div class="row page-header-buttons">
        <div class="col-md-12">
            <a href="<?= base_url('teams') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <a href="#" class="btn btn-info btn-fill show-edit-toggler"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; Edit</a>
        </div>
    </div>
    <div class="row">
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
<!-- Edit Section -->
<div id="edit-section" class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-12 max-1000-form-container">
            <a href="#" class="btn btn-info btn-fill show-edit-toggler"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <a href="<?= base_url('team/' . $team->id . '/delete') ?>" data-method="POST" class="btn btn-danger btn-fill show-edit-toggler pull-right"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Edit Team</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <form id="team_edit" action="<?= base_url('team/' . $team->id . '/update') ?>" method="post" novalidate>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name (Team Region Name)<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Team Name" name="name" type="text" value="<?= $team->team_name ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <textarea class="form-control" name="remark" placeholder="Remark" rows="10"><?= $team->remark ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Manager<span class="red-mark">*</span></label>
                                    <select name="manager" class="form-control">
                                        <option value="" disabled<?= empty($team->manager) ? ' selected' : '' ?>>Select Manager</option>
                                        <?php foreach ($users as $user) {
                                            echo '<option value="' . $user->id . '"' . ($user->id == $team->manager ? ' selected' : '') . '>' . $user->name . ' (@' . $user->username . ')</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Team Leader<span class="red-mark">*</span></label>
                                    <select name="team_leader" class="form-control">
                                        <option value="" disabled<?= empty($team->team_leader) ? ' selected' : '' ?>>Select Team Leader</option>
                                        <?php foreach ($users as $user) {
                                            echo '<option value="' . $user->id . '"' . ($user->id == $team->team_leader ? ' selected' : '') . '>' . $user->name . ' (@' . $user->username . ')</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Team Members</label>
                                    <input class="form-control" placeholder="Team Members" name="team_members" id="team_members" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info btn-fill pull-right">Update</button>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('input#team_members').tagsinput({
            itemValue: 'id',
            itemText: function(item) {
                return item.name + ' (@' + item.username + ')';
            },
            typeahead: {
                source: <?= json_encode($users) ?>,
                afterSelect: function() {
                    this.$element[0].value = '';
                }
            }
        });
        <?php
        if ($members) {
            foreach ($members as $member) {
                echo "$('input#team_members').tagsinput('add', " . json_encode($member) . ");";
            }
        }
        ?>
    });
</script>

<script src="<?= base_url('assets/js/teams/edit.js') ?>"></script>