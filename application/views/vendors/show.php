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
            <a href="<?= base_url('vendors') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <a href="#" class="btn btn-info btn-fill show-edit-toggler"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; Edit</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Vendor Details</h4>
                </div>
                <div class="content view">
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                #<?= $vendor->id ?><br />
                                <?= $vendor->name ?><br />
                                <?= empty($vendor->address) ? '-' : $vendor->address ?><br />
                                <?= empty($vendor->city) ? '-' : $vendor->city ?>, <?= empty($vendor->state) ? '-' : $vendor->state ?> - <?= empty($vendor->zip) ? '-' : $vendor->zip ?><br />
                                <?= empty($vendor->phone) ? '-' : ('C - ' . $vendor->phone) ?><br />
                                <?= empty($vendor->email_id) ? '-' : $vendor->email_id ?><br />
                                <?= empty($vendor->tax_id) ? '-' : ('<b>Tax ID: </b>' . $vendor->tax_id) ?><br />
                                <?= empty($vendor->credit_line) ? '-' : ('<b>Credit Line: </b>' . $vendor->credit_line) ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="footer">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= base_url('vendor/' . $vendor->id . '/docs'); ?>" class="btn btn-fill">Docs</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="header">
                    <h4 class="title">Vendor Contact</h4>
                </div>
                <div class="content">
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <tr>
                                <th>Name</th>
                                <th>Cell</th>
                                <th>Email ID</th>
                            </tr>
                            <?php if (!empty($vednor_contacts)) : ?>
                                <?php foreach ($vednor_contacts as $vednor_contact) : ?>
                                    <tr>
                                        <td><?= $vednor_contact->name ?></td>
                                        <td><?= empty($vednor_contact->cell) ? '-' : $vednor_contact->cell ?></td>
                                        <td><?= empty($vednor_contact->email_id) ? '-' : $vednor_contact->email_id ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="4" class="text-center">No Record Found!</td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
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
            <a href="<?= base_url('vendor/' . $vendor->id . '/delete') ?>" data-method="POST" class="btn btn-danger btn-fill show-edit-toggler pull-right"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Edit Vendor</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <form id="vendor_edit" action="<?= base_url('vendor/' . $vendor->id . '/update') ?>" method="post" novalidate>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Name" name="name" type="text" value="<?= $vendor->name ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input class="form-control" placeholder="Address" name="address" type="text" value="<?= $vendor->address ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>City</label>
                                    <input class="form-control" placeholder="City" name="city" type="text" value="<?= $vendor->city ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>State</label>
                                    <input class="form-control" placeholder="State" Name="state" type="text" value="<?= $vendor->state ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input class="form-control" placeholder="ZIP Code" name="zip" type="text" value="<?= $vendor->zip ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input class="form-control" placeholder="Phone" name="phone" type="text" value="<?= $vendor->phone ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email ID</label>
                                    <input class="form-control" placeholder="Email ID" name="email_id" type="email" value="<?= $vendor->email_id ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tax ID</label>
                                    <input class="form-control" placeholder="Tax ID" name="tax_id" type="text" value="<?= $vendor->tax_id ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Credit Line</label>
                                    <input class="form-control" placeholder="Credit Line" name="credit_line" type="text" value="<?= $vendor->credit_line ?>">
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
            <div class="card">
                <div class="header">
                    <h4 class="title">Vendor Contact</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors-contact" class="col-md-12">
                        </div>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <tr>
                                <th>Name</th>
                                <th>Cell</th>
                                <th>Email ID</th>
                                <th>Delete</th>
                            </tr>
                            <?php if (!empty($vednor_contacts)) : ?>
                                <?php foreach ($vednor_contacts as $vednor_contact) : ?>
                                    <tr>
                                        <td><?= $vednor_contact->name ?></td>
                                        <td><?= $vednor_contact->cell ?></td>
                                        <td><?= $vednor_contact->email_id ?></td>
                                        <td><a href="<?= base_url('vendor/' . $vendor->id . '/delete-contact/' . $vednor_contact->id) ?>" data-method="POST" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="4" class="text-center">No Record Found!</td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                    <?= form_open('vendor/' . $vendor->id . '/create-contact', array('id' => 'vendor_contact', 'method' => 'post')) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="Name" name="name" type="text">
                            </div>
                            <div class="form-group">
                                <label>Cell</label>
                                <input class="form-control" placeholder="Cell" name="cell" type="text">
                            </div>
                            <div class="form-group">
                                <label>Email ID</label>
                                <input class="form-control" placeholder="Email ID" name="email_id" type="text">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info btn-fill pull-right">Add Contact</button>
                            </div>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/vendors/edit.js') ?>"></script>