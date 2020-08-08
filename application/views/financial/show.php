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
            <a href="<?= base_url('financial/records') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <a href="#" class="btn btn-info btn-fill show-edit-toggler"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; Edit</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="content view">
                    <?php if ($financial->party == 1) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Party Name</label>
                                    <p><?= $financial->vendor_name ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } else if ($financial->party == 2) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Party Name</label>
                                    <p><?= $financial->client_name ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="line-height: 30px;">Transaction Date</label>
                                <p><?= date('M j, Y', strtotime($financial->transaction_date)) ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Transaction #</label>
                                <p><?= (100 + $financial->id) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Job</label>
                                <p><?= $financial->job_fullname ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Amount</label>
                                <p><?= number_format($financial->amount, 2) ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Type</label>
                                <p><?= FinancialModel::typeToStr($financial->type) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sub Type</label>
                                <p><?= $financial->subtype_name ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Accounting Code</label>
                                <p><?= $financial->accounting_code_name ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Method</label>
                                <p><?= $financial->method_name ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bank Account</label>
                                <p><?= $financial->bank_account_name ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>State</label>
                                <p><?= $financial->state_name ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Week</label>
                                <p><?= $financial->week ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sales Representative</label>
                                <p><?= $financial->created_user_fullname ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Notes</label>
                                <p><?= (!empty($financial->notes) ? nl2br($financial->notes) : '-') ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php if ($financial->type == 2) { ?>
                    <div class="footer">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?= base_url('financial/record/' . $financial->id . '/receipt'); ?>" target="_blank" class="btn btn-fill">Receipt</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- Edit Section -->
<div id="edit-section" class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-12 max-1000-form-container">
            <a href="#" class="btn btn-info btn-fill show-edit-toggler"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <a href="<?= base_url('financial/record/' . $financial->id . '/delete') ?>" data-method="POST" class="btn btn-danger btn-fill show-edit-toggler pull-right"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Edit Financial Record</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <form id="financial_edit" action="<?= base_url('financial/record/' . $financial->id . '/update') ?>" method="post" novalidate>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Party<span class="red-mark">*</span></label>
                                    &nbsp; <label><input type="radio" name="party" id="party_vendor" value="1" <?= ($financial->party == 1 ? ' checked' : '') ?>> Vendor</label> &nbsp;
                                    <label><input type="radio" name="party" id="party_client" value="2" <?= ($financial->party == 2 ? ' checked' : '') ?>> Client</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="vendor_id_row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Party Name<span class="red-mark">*</span></label>
                                    <select id="vendor_id" name="vendor_id" class="form-control">
                                        <option value="" disabled<?= (empty($financial->vendor_id) ? ' selected' : '') ?>>Select Vendor</option>
                                        <?php foreach ($vendors as $vendor) {
                                            echo '<option value="' . $vendor->id . '"' . ($financial->vendor_id == $vendor->id ? ' selected' : '') . '>' . $vendor->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="client_id_row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Party Name<span class="red-mark">*</span></label>
                                    <select id="client_id" name="client_id" class="form-control">
                                        <option value="" disabled<?= (empty($financial->client_id) ? ' selected' : '') ?>>Select Client</option>
                                        <?php foreach ($clients as $client) {
                                            echo '<option value="' . $client->id . '"' . ($financial->client_id == $client->id ? ' selected' : '') . '>' . $client->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Transaction Date<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Transaction Date" name="transaction_date" type="date" value="<?= $financial->transaction_date ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Job<span class="red-mark">*</span></label>
                                    <select id="job_id" name="job_id" class="form-control">
                                        <option value="" disabled<?= (empty($financial->job_id) ? ' selected' : '') ?>>Select Job</option>
                                        <?php foreach ($jobs as $job) {
                                            echo '<option value="' . $job->id . '"' . ($financial->job_id == $job->id ? ' selected' : '') . '>' . (1600 + $job->id) . ' - ' . $job->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Amount<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Amount" name="amount" type="number" step="any" value="<?= $financial->amount ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Type<span class="red-mark">*</span></label>
                                    <select name="type" class="form-control">
                                        <option value="" disabled<?= (empty($financial->type) ? ' selected' : '') ?>>Select Type</option>
                                        <?php foreach ($types as $id => $type) {
                                            echo '<option value="' . $id . '"' . ($financial->type == $id ? ' selected' : '') . '>' . $type . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sub Type<span class="red-mark">*</span></label>
                                    <select name="subtype" class="form-control">
                                        <option value="" disabled<?= (empty($financial->subtype) ? ' selected' : '') ?>>Select Sub Type</option>
                                        <?php foreach ($subTypes as $subType) {
                                            echo '<option value="' . $subType->id . '"' . ($financial->subtype == $subType->id ? ' selected' : '') . '>' . $subType->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Accounting Code<span class="red-mark">*</span></label>
                                    <select name="accounting_code" class="form-control">
                                        <option value="" disabled<?= (empty($financial->accounting_code) ? ' selected' : '') ?>>Select Accounting Code</option>
                                        <?php foreach ($accountingCodes as $accountingCode) {
                                            echo '<option value="' . $accountingCode->id . '"' . ($financial->accounting_code == $accountingCode->id ? ' selected' : '') . '>' . $accountingCode->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Method<span class="red-mark">*</span></label>
                                    <select name="method" class="form-control">
                                        <option value="" disabled<?= (empty($financial->method) ? ' selected' : '') ?>>Select Method</option>
                                        <?php foreach ($methods as $method) {
                                            echo '<option value="' . $method->id . '"' . ($financial->method == $method->id ? ' selected' : '') . '>' . $method->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Bank Account<span class="red-mark">*</span></label>
                                    <select name="bank_account" class="form-control">
                                        <option value="" disabled<?= (empty($financial->bank_account) ? ' selected' : '') ?>>Select Bank Account</option>
                                        <?php foreach ($bankAccounts as $bankAccount) {
                                            echo '<option value="' . $bankAccount->id . '"' . ($financial->bank_account == $bankAccount->id ? ' selected' : '') . '>' . $bankAccount->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State<span class="red-mark">*</span></label>
                                    <select name="state" class="form-control">
                                        <option value="" disabled<?= (empty($financial->state) ? ' selected' : '') ?>>Select State</option>
                                        <?php foreach ($states as $state) {
                                            echo '<option value="' . $state->id . '"' . ($financial->state == $state->id ? ' selected' : '') . '>' . $state->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea id="note-input" class="form-control" name="notes" placeholder="Notes" rows="10"><?= $financial->notes ?></textarea>
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

<script src="<?= base_url('assets/js/financial/edit.js') ?>"></script>