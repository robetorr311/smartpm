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
            <a href="<?= base_url('users') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Create User</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <form id="user_create" action="<?= base_url('user/store') ?>" method="post" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="First Name" name="first_name" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Last Name" name="last_name" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email ID<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Email ID" name="email_id" type="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Level<span class="red-mark">*</span></label>
                                    <select name="level" class="form-control">
                                        <option value="" disabled selected>Select Level</option>
                                        <?php foreach ($levels as $id => $level) {
                                            echo '<option value="' . $id . '">' . $level . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Office Phone</label>
                                    <input class="form-control" placeholder="Office Phone" name="office_phone" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Home Phone</label>
                                    <input class="form-control" placeholder="Home Phone" name="home_phone" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cell 1</label>
                                    <input class="form-control" placeholder="Cell 1" name="cell_1" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cell 2</label>
                                    <input class="form-control" placeholder="Cell 2" name="cell_2" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cell 1 Provider</label>
                                    <select name="cell_1_provider" class="form-control">
                                        <option value="" disabled selected>Select Cell 1 Provider</option>
                                        <?php foreach ($cellNotifSuffix as $cellProvider) {
                                            echo '<option value="' . $cellProvider->id . '">' . $cellProvider->cell_provider . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Notifications<span class="red-mark">*</span></label>
                                    <select name="notifications" class="form-control">
                                        <option value="" disabled selected>Select Notifications</option>
                                        <?php foreach ($notifications as $id => $notification) {
                                            echo '<option value="' . $id . '">' . $notification . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status<span class="red-mark">*</span></label>
                                    <select name="is_active" class="form-control">
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
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

<script src="<?= base_url('assets/js/users/create.js') ?>"></script>