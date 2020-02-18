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
<div class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-12">
            <a href="<?= base_url('teams') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Create Team</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <form id="team_create" action="<?= base_url('team/store') ?>" method="post" novalidate>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name (Team Region Name)<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Team Name" name="name" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <textarea class="form-control" name="remark" placeholder="Remark" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Manager<span class="red-mark">*</span></label>
                                    <select name="manager" class="form-control">
                                        <option value="" disabled selected>Select Manager</option>
                                        <?php foreach ($users as $user) {
                                            echo '<option value="' . $user->id . '">' . $user->name . ' (@' . $user->username . ')' . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Team Leader<span class="red-mark">*</span></label>
                                    <select name="team_leader" class="form-control">
                                        <option value="" disabled selected>Select Team Leader</option>
                                        <?php foreach ($users as $user) {
                                            echo '<option value="' . $user->id . '">' . $user->name . ' (@' . $user->username . ')' . '</option>';
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
                                    <button type="submit" class="btn btn-info btn-fill pull-right">Create</button>
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
    });
</script>

<script src="<?= base_url('assets/js/teams/create.js') ?>"></script>