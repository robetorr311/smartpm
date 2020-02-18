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
            <a href="<?= base_url('tasks') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Create Task</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <form id="task_create" action="<?= base_url('task/store') ?>" method="post" novalidate>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Task Name<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Task Name" name="name" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Type<span class="red-mark">*</span></label>
                                    <select name="type" class="form-control">
                                        <option value="" disabled selected>Select Type</option>
                                        <?php foreach ($types as $type) {
                                            echo '<option value="' . $type->id . '">' . $type->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Importance Level<span class="red-mark">*</span></label>
                                    <select name="level" class="form-control">
                                        <option value="" disabled selected>Select Importance Level</option>
                                        <?php foreach ($levels as $id => $level) {
                                            echo '<option value="' . $id . '">' . $level . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Assigned To<span class="red-mark">*</span></label>
                                    <select name="assigned_to" class="form-control">
                                        <option value="" disabled selected>Select Assigned To</option>
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
                                    <label>Note</label>
                                    <textarea id="note-input" class="form-control" name="note" placeholder="Note" rows="10"></textarea>
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

<script src="<?= base_url('assets/js/tasks/create.js') ?>"></script>