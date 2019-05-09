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
        <div class="col-lg-9">
            <div class="card task-notes-card">
                <div class="header">
                    <h4 class="title">Task Notes</h4>
                </div>
                <div class="content view">
                    <?php
                    if ($notes) {
                        foreach ($notes as $note) {
                            echo '<div class="row note-item">';
                            echo '<div class="col-md-12">';
                            echo '<label>' . $note->created_username . '</label>';
                            echo '<a href="' . base_url('task/' . $task->id . '/note/' . $note->id . '/delete') . '" data-method="POST" class="text-danger pull-right"><i class="fa fa-trash-o"></i></a></a>';
                            echo '<p>' . $note->note . '</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>-</p>';
                    }
                    ?>
                </div>
            </div>
            <div class="card add-note-card">
                <div class="header">
                    <h4 class="title">Add Note</h4>
                </div>
                <div class="content view">
                    <div class="row add-note-form">
                        <div class="col-md-12">
                            <form action="<?= base_url('task/' . $task->id . '/add-note') ?>" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Your Note</label>
                                            <textarea class="form-control" name="note" placeholder="Your Note" rows="10" ctrl-enter-submit></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <a href="<?= base_url('tasks') ?>" class="btn btn-info btn-fill">Back</a>
                                            <button type="submit" class="btn btn-info btn-fill pull-right">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="header">
                    <h4 class="title">Task Details</h4>
                </div>
                <div class="content view">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Task Name</label>
                            <p><?= $task->name ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Type</label>
                            <p><?= TaskModel::typetostr($task->type) ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Importance Level</label>
                            <p><?= TaskModel::leveltostr($task->level) ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Assigned To</label>
                            <p><?= $task->assigned_username ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Tag Clients</label>
                            <?php
                            if ($jobs) {
                                echo '<p>';
                                foreach ($jobs as $job) {
                                    echo '<span class="info-tag">' . $job->name . '</span>';
                                }
                                echo '</p>';
                            } else {
                                echo '<p>-</p>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Tag Users</label>
                            <?php
                            if ($users) {
                                echo '<p>';
                                foreach ($users as $user) {
                                    echo '<span class="info-tag">' . $user->username . '</span>';
                                }
                                echo '</p>';
                            } else {
                                echo '<p>-</p>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Predecessor Tasks</label>
                            <?php
                            if ($predec_tasks) {
                                echo '<p>';
                                foreach ($predec_tasks as $predec_task) {
                                    echo '<span class="info-tag">' . $predec_task->name . '</span>';
                                }
                                echo '</p>';
                            } else {
                                echo '<p>-</p>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Status</label>
                            <p><?= TaskModel::statustostr($task->status) ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Created By</label>
                            <p><?= $task->created_username ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Created At</label>
                            <p><?= $task->created_at ?></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>