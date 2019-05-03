<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Create Task</h4>
                </div>
                <div class="content">
                    <div class="col-md-12">
                        <?php
                        if (!empty($this->session->flashdata('errors'))) {
                            echo '<div class="alert alert-danger fade in alert-dismissable" title="Error:"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>';
                            echo $this->session->flashdata('errors');
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <form action="<?= base_url('task/store') ?>" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Task Name</label>
                                    <input class="form-control" placeholder="Task Name" name="name" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="type" class="form-control">
                                        <option value="" disabled selected>Select Type</option>
                                        <?php foreach ($types as $id => $type) {
                                            echo '<option value="' . $id . '">' . $type . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Importance Level</label>
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
                                    <label>Assigned To</label>
                                    <select name="assigned_to" class="form-control">
                                        <option value="" disabled selected>Select Assigned To</option>
                                        <option value="1">Option 1</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Note</label>
                                <textarea class="form-control" name="note" placeholder="Note" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tag Clients</label>
                                    <input class="form-control" placeholder="Tag Clients (@job_#)" name="tag_clients" id="tag_clients" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tag Users</label>
                                    <input class="form-control" placeholder="Tag Users (@username)" name="tag_users" id="tag_users" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Predecessor Tasks</label>
                                    <input class="form-control" placeholder="Predecessor Tasks (@task_#)" name="predecessor_tasks" id="predecessor_tasks" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?= base_url('tasks') ?>" class="btn btn-info btn-fill">Back</a>
                                <button type="submit" class="btn btn-info btn-fill pull-right">Create</button>
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
    });
</script>