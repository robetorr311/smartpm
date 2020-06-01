<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Edit Financial Record</h4>
                </div>
                <div class="content">
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
                    <form action="<?= base_url('financial/record/' . $financial->id . '/update') ?>" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Party Name<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Party Name" name="vendor" type="text" value="<?= $financial->vendor ?>">
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
                                    <select name="job_id" class="form-control">
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
                                        <?php foreach ($types as $type) {
                                            echo '<option value="' . $type->id . '"' . ($financial->type == $type->id ? ' selected' : '') . '>' . $type->name . '</option>';
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
                                    <a href="<?= base_url('financial/records') ?>" class="btn btn-info btn-fill">Back</a>
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