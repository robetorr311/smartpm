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
                            echo '<label>' . $note->created_user_fullname . '</label>';
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
                                            <label>Your Note<span class="red-mark">*</span></label>
                                            <textarea id="note-input" class="form-control" name="note" placeholder="Your Note (You can use Ctrl + Enter for Submit)" rows="10" ctrl-enter-submit></textarea>
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
                            <p><?= $task->assigned_user_fullname ?></p>
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
                            if ($tag_users) {
                                echo '<p>';
                                foreach ($tag_users as $tag_user) {
                                    echo '<span class="info-tag">' . $tag_user->name . ' (@' . $tag_user->username . ')' . '</span>';
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
                                    echo '<a href="' . base_url('task/' . $predec_task->id) . '"><span class="info-tag">' . $predec_task->name . '</span></a>';
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
                            <p><?= $task->created_user_fullname ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Created At</label>
                            <p><?= $task->created_at ?></p>
                        </div>
                    </div>
                    <?php if ($task->status != 4) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= base_url('task/' . $task->id .'/complete' ) ?>" data-method="POST" class="btn btn-info btn-fill col-xs-12">Mark As Complete</a>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#note-input').atwho({
            at: '@',
            data: <?= json_encode($users) ?>,
            headerTpl: '<div class="atwho-header">User List:</div>',
            displayTpl: '<li>${name} (@${username})</li>',
            insertTpl: '${atwho-at}${username}',
            searchKey: 'username',
            limit: 100
        });
    });
</script>