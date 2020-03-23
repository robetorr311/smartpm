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
        <div class="col-md-6">
            <div class="card">
                <div class="header">
                    <h4 class="title">Cell Notification Suffix</h4>
                </div>
                <div class="content">
                    <div id="userCellNotifSuffixInsert" class="insert-form">
                        <form action="<?= base_url('setting/user-options/cell-notif-suffix/store') ?>" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Cell Provider<span class="red-mark">*</span></label>
                                        <input class="form-control" placeholder="Cell Provider" name="cell_provider" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Suffix<span class="red-mark">*</span></label>
                                        <input class="form-control" placeholder="Suffix" name="suffix" type="text">
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
                    <div id="userCellNotifSuffixEdit" class="edit-form" style="display: none;">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Cell Provider<span class="red-mark">*</span></label>
                                        <input class="form-control" placeholder="Cell Provider" name="cell_provider" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Suffix<span class="red-mark">*</span></label>
                                        <input class="form-control" placeholder="Suffix" name="suffix" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-right">
                                        <button onclick="cancelEdit('userCellNotifSuffix')" type="button" class="btn btn-info btn-fill">Cancel</button>
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
                                <th>Cell Provider</th>
                                <th>Suffix</th>
                                <th width="100" class="text-center">Actions</th>
                            </thead>
                            <tbody>
                                <?php if (!empty($userCellNotifSuffixs)) : ?>
                                    <?php foreach ($userCellNotifSuffixs as $userCellNotifSuffix) : ?>
                                        <tr>
                                            <td><?= $userCellNotifSuffix->cell_provider ?></td>
                                            <td><?= $userCellNotifSuffix->suffix ?></td>
                                            <td class="text-center"><a onclick="editAction('<?= $userCellNotifSuffix->id ?>', '<?= $userCellNotifSuffix->cell_provider ?>', '<?= $userCellNotifSuffix->suffix ?>', 'userCellNotifSuffix', 'cell-notif-suffix')" class="text-warning cursor-pointer" style="margin-right: 10px;"><i class="fa fa-pencil"></i></a><a href="<?= base_url('setting/user-options/cell-notif-suffix/' . $userCellNotifSuffix->id . '/delete') ?>" data-method="POST" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
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
    function editAction(id, cell_provider, suffix, idPrefix, optionName) {
        $('#' + idPrefix + 'Insert').hide();
        $('#' + idPrefix + 'Edit').show();
        $('#' + idPrefix + 'Edit form').attr('action', '<?= base_url('setting/user-options') ?>/' + optionName + '/' + id + '/update');
        $('#' + idPrefix + 'Edit form input[name="cell_provider"]').val(cell_provider);
        $('#' + idPrefix + 'Edit form input[name="suffix"]').val(suffix);
        $('#' + idPrefix + 'Edit form input[name="cell_provider"]').focus();
    }

    function cancelEdit(idPrefix) {
        $('#' + idPrefix + 'Edit').hide();
        $('#' + idPrefix + 'Insert').show();

    }
</script>