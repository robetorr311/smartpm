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
        <!-- <div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h4 class="title">Types</h4>
                </div>
                <div class="content">
                    <div id="typeInsert" class="insert-form">
                        <form action="<?= base_url('setting/financial-options/type/store') ?>" method="post">
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
                    <div id="typeEdit" class="edit-form" style="display: none;">
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
                                        <button onclick="cancelEdit('type')" type="button" class="btn btn-info btn-fill">Cancel</button>
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
                                <th width="100" class="text-center">Delete</th>
                            </thead>
                            <tbody>
                                <?php if (!empty($types)) : ?>
                                    <?php foreach ($types as $type) : ?>
                                        <tr>
                                            <td><?= $type->name ?></td>
                                            <td class="text-center"><a onclick="editAction('<?= $type->id ?>', '<?= $type->name ?>', 'type', 'type')" class="text-warning cursor-pointer" style="margin-right: 10px;"><i class="fa fa-pencil"></i></a><a href="<?= base_url('setting/financial-options/type/' . $type->id . '/delete') ?>" data-method="POST" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
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
        </div> -->
        <div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h4 class="title">Subtypes</h4>
                </div>
                <div class="content">
                    <div id="subtypeInsert" class="insert-form">
                        <form action="<?= base_url('setting/financial-options/subtype/store') ?>" method="post">
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
                    <div id="subtypeEdit" class="edit-form" style="display: none;">
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
                                        <button onclick="cancelEdit('subtype')" type="button" class="btn btn-info btn-fill">Cancel</button>
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
                                <th width="100" class="text-center">Delete</th>
                            </thead>
                            <tbody>
                                <?php if (!empty($subtypes)) : ?>
                                    <?php foreach ($subtypes as $subtype) : ?>
                                        <tr>
                                            <td><?= $subtype->name ?></td>
                                            <td class="text-center"><a onclick="editAction('<?= $subtype->id ?>', '<?= $subtype->name ?>', 'subtype', 'subtype')" class="text-warning cursor-pointer" style="margin-right: 10px;"><i class="fa fa-pencil"></i></a><a href="<?= base_url('setting/financial-options/subtype/' . $subtype->id . '/delete') ?>" data-method="POST" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
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
        <div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h4 class="title">Accounting Codes</h4>
                </div>
                <div class="content">
                    <div id="accCodeInsert" class="insert-form">
                        <form action="<?= base_url('setting/financial-options/accCode/store') ?>" method="post">
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
                    <div id="accCodeEdit" class="edit-form" style="display: none;">
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
                                        <button onclick="cancelEdit('accCode')" type="button" class="btn btn-info btn-fill">Cancel</button>
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
                                <th width="100" class="text-center">Delete</th>
                            </thead>
                            <tbody>
                                <?php if (!empty($accCodes)) : ?>
                                    <?php foreach ($accCodes as $accCode) : ?>
                                        <tr>
                                            <td><?= $accCode->name ?></td>
                                            <td class="text-center"><a onclick="editAction('<?= $accCode->id ?>', '<?= $accCode->name ?>', 'accCode', 'accCode')" class="text-warning cursor-pointer" style="margin-right: 10px;"><i class="fa fa-pencil"></i></a><a href="<?= base_url('setting/financial-options/accCode/' . $accCode->id . '/delete') ?>" data-method="POST" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
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
        <div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h4 class="title">Methods of Payment</h4>
                </div>
                <div class="content">
                    <div id="methodInsert" class="insert-form">
                        <form action="<?= base_url('setting/financial-options/method/store') ?>" method="post">
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
                    <div id="methodEdit" class="edit-form" style="display: none;">
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
                                        <button onclick="cancelEdit('method')" type="button" class="btn btn-info btn-fill">Cancel</button>
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
                                <th width="100" class="text-center">Delete</th>
                            </thead>
                            <tbody>
                                <?php if (!empty($methods)) : ?>
                                    <?php foreach ($methods as $method) : ?>
                                        <tr>
                                            <td><?= $method->name ?></td>
                                            <td class="text-center"><a onclick="editAction('<?= $method->id ?>', '<?= $method->name ?>', 'method', 'method')" class="text-warning cursor-pointer" style="margin-right: 10px;"><i class="fa fa-pencil"></i></a><a href="<?= base_url('setting/financial-options/method/' . $method->id . '/delete') ?>" data-method="POST" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
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
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h4 class="title">Bank Accounts</h4>
                </div>
                <div class="content">
                    <div id="bankAccInsert" class="insert-form">
                        <form action="<?= base_url('setting/financial-options/bankAcc/store') ?>" method="post">
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
                    <div id="bankAccEdit" class="edit-form" style="display: none;">
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
                                        <button onclick="cancelEdit('bankAcc')" type="button" class="btn btn-info btn-fill">Cancel</button>
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
                                <th width="100" class="text-center">Delete</th>
                            </thead>
                            <tbody>
                                <?php if (!empty($bankAccs)) : ?>
                                    <?php foreach ($bankAccs as $bankAcc) : ?>
                                        <tr>
                                            <td><?= $bankAcc->name ?></td>
                                            <td class="text-center"><a onclick="editAction('<?= $bankAcc->id ?>', '<?= $bankAcc->name ?>', 'bankAcc', 'bankAcc')" class="text-warning cursor-pointer" style="margin-right: 10px;"><i class="fa fa-pencil"></i></a><a href="<?= base_url('setting/financial-options/bankAcc/' . $bankAcc->id . '/delete') ?>" data-method="POST" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
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
        <div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h4 class="title">States</h4>
                </div>
                <div class="content">
                    <div id="stateInsert" class="insert-form">
                        <form action="<?= base_url('setting/financial-options/state/store') ?>" method="post">
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
                    <div id="stateEdit" class="edit-form" style="display: none;">
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
                                        <button onclick="cancelEdit('state')" type="button" class="btn btn-info btn-fill">Cancel</button>
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
                                <th width="100" class="text-center">Delete</th>
                            </thead>
                            <tbody>
                                <?php if (!empty($states)) : ?>
                                    <?php foreach ($states as $state) : ?>
                                        <tr>
                                            <td><?= $state->name ?></td>
                                            <td class="text-center"><a onclick="editAction('<?= $state->id ?>', '<?= $state->name ?>', 'state', 'state')" class="text-warning cursor-pointer" style="margin-right: 10px;"><i class="fa fa-pencil"></i></a><a href="<?= base_url('setting/financial-options/state/' . $state->id . '/delete') ?>" data-method="POST" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
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
        $('#' + idPrefix + 'Edit form').attr('action', '<?= base_url('setting/financial-options') ?>/' + optionName + '/' + id + '/update');
        $('#' + idPrefix + 'Edit form input[name="name"]').val(name);
        $('#' + idPrefix + 'Edit form input[name="name"]').focus();
    }

    function cancelEdit(idPrefix) {
        $('#' + idPrefix + 'Edit').hide();
        $('#' + idPrefix + 'Insert').show();

    }
</script>