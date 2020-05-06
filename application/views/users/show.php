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
            <a href="<?= base_url('users') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <a href="#" class="btn btn-info btn-fill show-edit-toggler"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; Edit</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">User Details</h4>
                </div>
                <div class="content view">
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>UserName</label>
                                    <p><?= $user->username ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <p><?= $user->first_name ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <p><?= $user->last_name ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email ID</label>
                                    <p><?= $user->email_id ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Level</label>
                                    <p><?= UserModel::levelToStr($user->level) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Office Phone</label>
                                    <p><?= $user->office_phone ? $user->office_phone : '-' ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Home Phone</label>
                                    <p><?= $user->home_phone ? $user->home_phone : '-' ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cell 1</label>
                                    <p><?= $user->cell_1 ? $user->cell_1 : '-' ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cell 2</label>
                                    <p><?= $user->cell_2 ? $user->cell_2 : '-' ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cell 1 Provider</label>
                                    <p><?= $user->cell_1_provider_name ? $user->cell_1_provider_name : '-' ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Notifications</label>
                                    <p><?= UserModel::notificationsToStr($user->notifications) ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <p><?= UserModel::activeToStr($user->is_active) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
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
            <a href="<?= base_url('user/' . $user->id . '/delete') ?>" data-method="POST" class="btn btn-danger btn-fill show-edit-toggler pull-right"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Edit User</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <form id="user_edit" action="<?= base_url('user/' . $user->id . '/update') ?>" method="post" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="First Name" name="first_name" type="text" value="<?= $user->first_name ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Last Name" name="last_name" type="text" value="<?= $user->last_name ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email ID<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Email ID" name="email_id" type="email" value="<?= $user->email_id ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Level<span class="red-mark">*</span></label>
                                    <select name="level" class="form-control">
                                        <option value="" disabled<?= empty($user->level) ? ' selected' : '' ?>>Select Level</option>
                                        <?php foreach ($levels as $id => $level) {
                                            echo '<option value="' . $id . '"' . ($id == $user->level ? ' selected' : '') . '>' . $level . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Office Phone</label>
                                    <input class="form-control" placeholder="Office Phone" name="office_phone" type="text" value="<?= $user->office_phone ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Home Phone</label>
                                    <input class="form-control" placeholder="Home Phone" name="home_phone" type="text" value="<?= $user->home_phone ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cell 1</label>
                                    <input class="form-control" placeholder="Cell 1" name="cell_1" type="text" value="<?= $user->cell_1 ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cell 2</label>
                                    <input class="form-control" placeholder="Cell 2" name="cell_2" type="text" value="<?= $user->cell_2 ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cell 1 Provider</label>
                                    <select name="cell_1_provider" class="form-control">
                                        <option value="" disabled<?= $user->cell_1_provider == '' ? ' selected' : '' ?>>Select Cell 1 Provider</option>
                                        <?php foreach ($cellNotifSuffix as $cellProvider) {
                                            echo '<option value="' . $cellProvider->id . '"' . ($cellProvider->id == $user->cell_1_provider ? ' selected' : '') . '>' . $cellProvider->cell_provider . '</option>';
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
                                        <option value="" disabled<?= empty($user->notifications) ? ' selected' : '' ?>>Select Notifications</option>
                                        <?php foreach ($notifications as $id => $notification) {
                                            echo '<option value="' . $id . '"' . ($id == $user->notifications ? ' selected' : '') . '>' . $notification . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status<span class="red-mark">*</span></label>
                                    <select name="is_active" class="form-control">
                                        <option value="" disabled<?= empty($user->is_active) ? ' selected' : '' ?>>Select Status</option>
                                        <option value="1" <?= $user->is_active == 1 ? ' selected' : '' ?>>Active</option>
                                        <option value="0" <?= $user->is_active == 0 ? ' selected' : '' ?>>Inactive</option>
                                    </select>
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

<script src="<?= base_url('assets/js/users/edit.js') ?>"></script>