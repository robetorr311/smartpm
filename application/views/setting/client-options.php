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
                    <h4 class="title">Lead Source</h4>
                </div>
                <div class="content">
                    <div id="leadSourceInsert" class="insert-form">
                        <form action="<?= base_url('setting/client-options/lead-source/store') ?>" method="post">
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
                    <div id="leadSourceEdit" class="edit-form" style="display: none;">
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
                                        <button onclick="cancelEdit('leadSource')" type="button" class="btn btn-info btn-fill">Cancel</button>
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
                                <?php if (!empty($leadSource)) : ?>
                                    <?php foreach ($leadSource as $ls) : ?>
                                        <tr>
                                            <td><?= $ls->name ?></td>
                                            <td class="text-center"><a onclick="editAction('<?= $ls->id ?>', '<?= $ls->name ?>', 'leadSource')" class="text-warning cursor-pointer" style="margin-right: 10px;"><i class="fa fa-pencil"></i></a><a href="<?= base_url('setting/client-options/lead-source/' . $ls->id . '/delete') ?>" data-method="POST" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
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
    function editAction(id, name, idPrefix) {
        $('#' + idPrefix + 'Insert').hide();
        $('#' + idPrefix + 'Edit').show();
        $('#' + idPrefix + 'Edit form').attr('action', '<?= base_url('setting/client-options/lead-source') ?>/' + id + '/update');
        $('#' + idPrefix + 'Edit form input[name="name"]').val(name);
        $('#' + idPrefix + 'Edit form input[name="name"]').focus();
    }

    function cancelEdit(idPrefix) {
        $('#' + idPrefix + 'Edit').hide();
        $('#' + idPrefix + 'Insert').show();

    }
</script>