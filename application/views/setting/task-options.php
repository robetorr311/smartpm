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
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h4 class="title">Types</h4>
                </div>
                <div class="content">
                    <div id="taskTypeInsert" class="insert-form">
                        <form action="<?= base_url('setting/task-options/type/store') ?>" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name<span class="red-mark">*</span></label>
                                        <input class="form-control" placeholder="Name" name="name" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-info btn-fill">Create</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="taskTypeEdit" class="edit-form" style="display: none;">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name<span class="red-mark">*</span></label>
                                        <input class="form-control" placeholder="Name" name="name" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-right">
                                        <button onclick="cancelEdit('taskType')" type="button" class="btn btn-info btn-fill">Cancel</button>
                                        <button type="submit" class="btn btn-info btn-fill">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr />
                    <div class="table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>Name</th>
                                <th width="100" class="text-center">Actions</th>
                            </thead>
                            <tbody>
                                <?php if (!empty($taskTypes)) : ?>
                                    <?php foreach ($taskTypes as $taskType) : ?>
                                        <tr>
                                            <td><?= $taskType->name ?></td>
                                            <td class="text-center"><a onclick="editAction('<?= $taskType->id ?>', '<?= $taskType->name ?>', 'taskType', 'type')" class="text-warning cursor-pointer" style="margin-right: 10px;"><i class="fa fa-pencil"></i></a><a href="<?= base_url('setting/task-options/type/' . $taskType->id . '/delete') ?>" data-method="POST" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="10" class="text-center">No Record Found!</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function editAction(id, name, idPrefix, optionName) {
        $('#' + idPrefix + 'Insert').hide();
        $('#' + idPrefix + 'Edit').show();
        $('#' + idPrefix + 'Edit form').attr('action', '<?= base_url('setting/task-options') ?>/' + optionName + '/' + id + '/update');
        $('#' + idPrefix + 'Edit form input[name="name"]').val(name);
        $('#' + idPrefix + 'Edit form input[name="name"]').focus();
    }

    function cancelEdit(idPrefix) {
        $('#' + idPrefix + 'Edit').hide();
        $('#' + idPrefix + 'Insert').show();

    }
</script>