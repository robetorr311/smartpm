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
            <a href="<?= base_url('tasks') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <a href="#" class="btn btn-info btn-fill show-edit-toggler"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; Edit</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
        </div>
    </div>
    <div class="row">
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
                            echo '<a href="#" data-noteid="' . $note->id . '" class="edit-note text-info pull-right"><i class="fa fa-pencil"></i></a></a>';
                            echo '<p>' . $note->note . '</p>';
                            echo '<small class="date-created">' . $note->created_at . '</small>';
                            echo '</div>';
                            echo '<div id="note-item-edit-' . $note->id . '" class="note-item-edit col-md-12">';
                            echo '<form action="' . base_url('task/' . $task->id . '/note/' . $note->id . '/update') . '" method="post">';
                            echo '<div class="row">';
                            echo '<div class="col-md-12">';
                            echo '<div class="form-group">';
                            echo '<label>Your Note<span class="red-mark">*</span></label>';
                            echo '<textarea class="form-control note-input" name="note" placeholder="Your Note (You can use Ctrl + Enter for Submit)" rows="10" ctrl-enter-submit>' . str_replace('<br />', '', $note->note) . '</textarea>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="row">';
                            echo '<div class="col-md-12">';
                            echo '<div class="form-group">';
                            echo '<a href="#" data-noteid="' . $note->id . '" class="note-item-edit-cancel btn btn-info btn-fill">Cancel</a>';
                            echo '<button type="submit" class="btn btn-info btn-fill pull-right">Update</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</form>';
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
                            <form id="task_note" action="<?= base_url('task/' . $task->id . '/add-note') ?>" method="post">
                                <div class="row">
                                    <div id="validation-errors-note" class="col-md-12">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Your Note<span class="red-mark">*</span></label>
                                            <textarea class="form-control note-input" name="note" placeholder="Your Note (You can use Ctrl + Enter for Submit)" rows="10" ctrl-enter-submit></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
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
                            <p><?= $task->type_name ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Importance Level</label>
                            <p><?= TaskModel::levelToStr($task->level) ?></p>
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
                            <p><?= TaskModel::statusToStr($task->status) ?></p>
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
                                <a href="<?= base_url('task/' . $task->id . '/complete') ?>" data-method="POST" class="btn btn-info btn-fill col-xs-12">Mark As Complete</a>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="clearfix"></div>
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
            <a href="<?= base_url('task/' . $task->id . '/delete') ?>" data-method="POST" class="btn btn-danger btn-fill show-edit-toggler pull-right"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Edit Task</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors-edit" class="col-md-12">
                        </div>
                    </div>
                    <form id="task_edit" action="<?= base_url('task/' . $task->id . '/update') ?>" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Task Name<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Task Name" name="name" type="text" value="<?= $task->name ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Type<span class="red-mark">*</span></label>
                                    <select name="type" class="form-control">
                                        <option value="" disabled>Select Type</option>
                                        <?php foreach ($types as $type) {
                                            echo '<option value="' . $type->id . '"' . ($type->id == $task->type ? ' selected' : '') . '>' . $type->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Importance Level<span class="red-mark">*</span></label>
                                    <select name="level" class="form-control">
                                        <option value="" disabled<?= empty($task->level) ? ' selected' : '' ?>>Select Importance Level</option>
                                        <?php foreach ($levels as $id => $level) {
                                            echo '<option value="' . $id . '"' . ($id == $task->level ? ' selected' : '') . '>' . $level . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Assigned To<span class="red-mark">*</span></label>
                                    <select name="assigned_to" class="form-control">
                                        <option value="" disabled<?= empty($task->created_by) ? ' selected' : '' ?>>Select Assigned To</option>
                                        <?php foreach ($users as $user) {
                                            echo '<option value="' . $user->id . '"' . ($user->id == $task->created_by ? ' selected' : '') . '>' . $user->name . ' (@' . $user->username . ')' . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status<span class="red-mark">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="" disabled<?= empty($task->status) ? ' selected' : '' ?>>Select Status</option>
                                        <?php foreach ($status as $key => $value) {
                                            echo '<option value="' . $key . '"' . ($key == $task->status ? ' selected' : '') . '>' . $value . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tag Clients</label>
                                    <input class="form-control" placeholder="Tag Clients" name="tag_clients" id="tag_clients" type="text" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tag Users</label>
                                    <input class="form-control" placeholder="Tag Users" name="tag_users" id="tag_users" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Predecessor Tasks</label>
                                    <input class="form-control" placeholder="Predecessor Tasks" name="predecessor_tasks" id="predecessor_tasks" type="text">
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
        $('.note-item-edit-cancel, .edit-note').click(function(e) {
            e.preventDefault();
            var noteId = $(this).data('noteid');
            $('#note-item-edit-' + noteId).toggleClass('visible');
        });
        $('.note-input').atwho({
            at: '@',
            data: <?= json_encode($users) ?>,
            headerTpl: '<div class="atwho-header">User List:</div>',
            displayTpl: '<li>${name} (@${username})</li>',
            insertTpl: '${atwho-at}${username}',
            searchKey: 'username',
            limit: 100
        });
        $('input#tag_clients').tagsinput({
            itemValue: 'id',
            itemText: 'value',
            typeahead: {
                source: [{
                        id: 1,
                        value: 'Amsterdam'
                    },
                    {
                        id: 2,
                        value: 'Washington'
                    },
                    {
                        id: 3,
                        value: 'Sydney'
                    },
                    {
                        id: 4,
                        value: 'Beijing'
                    },
                    {
                        id: 5,
                        value: 'Cairo'
                    }
                ],
                afterSelect: function() {
                    this.$element[0].value = '';
                },
                displayKey: 'value'
            }
        });
        $('input#tag_users').tagsinput({
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
        if ($tag_users) {
            foreach ($tag_users as $tag_user) {
                echo "$('input#tag_users').tagsinput('add', " . json_encode($tag_user) . ");";
            }
        }
        ?>
        $('input#predecessor_tasks').tagsinput({
            itemValue: 'id',
            itemText: 'name',
            typeahead: {
                source: <?= json_encode($tasks) ?>,
                afterSelect: function() {
                    this.$element[0].value = '';
                }
            }
        });
        <?php
        if ($predec_tasks) {
            foreach ($predec_tasks as $predec_task) {
                echo "$('input#predecessor_tasks').tagsinput('add', " . json_encode($predec_task) . ");";
            }
        }
        ?>
    });
</script>

<script src="<?= base_url('assets/js/tasks/edit.js') ?>"></script>