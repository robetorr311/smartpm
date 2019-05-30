<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Edit User</h4>
                </div>
                <div class="content">
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
                    <form action="<?= base_url('user/' . $user->id . '/update') ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input class="form-control" placeholder="First Name" name="first_name" type="text" value="<?= $user->first_name ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input class="form-control" placeholder="Last Name" name="last_name" type="text" value="<?= $user->last_name ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email ID</label>
                                    <input class="form-control" placeholder="Email ID" name="email_id" type="email" value="<?= $user->email_id ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Level</label>
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
                                    <label>Notifications</label>
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
                                    <label>Status</label>
                                    <select name="is_active" class="form-control">
                                        <option value="" disabled<?= empty($user->is_active) ? ' selected' : '' ?>>Select Status</option>
                                        <option value="1"<?= $user->is_active == 1 ? ' selected' : '' ?>>Active</option>
                                        <option value="0"<?= $user->is_active == 0 ? ' selected' : '' ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="<?= base_url('users') ?>" class="btn btn-info btn-fill">Back</a>
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