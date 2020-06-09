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
            <a href="<?= base_url('financial/records') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Create Financial Record</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <form id="financial_create" action="<?= base_url('financial/record/store') ?>" method="post" novalidate>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Party<span class="red-mark">*</span></label>
                                    &nbsp; <label><input type="radio" name="party" id="party_vendor" value="1" checked> Vendor</label> &nbsp;
                                    <label><input type="radio" name="party" id="party_client" value="2"> Client</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="vendor_id_row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Party Name<span class="red-mark">*</span></label>
                                    <select id="vendor_id" name="vendor_id" class="form-control">
                                        <option value="" disabled selected>Select Vendor</option>
                                        <?php foreach ($vendors as $vendor) {
                                            echo '<option value="' . $vendor->id . '">' . $vendor->name . '</option>';
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
                                        <option value="" disabled selected>Select Client</option>
                                        <?php foreach ($clients as $client) {
                                            echo '<option value="' . $client->id . '">' . $client->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Transaction Date<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Transaction Date" name="transaction_date" type="date" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Job<span class="red-mark">*</span></label>
                                    <select id="job_id" name="job_id" class="form-control">
                                        <option value="" disabled selected>Select Job</option>
                                        <?php foreach ($jobs as $job) {
                                            echo '<option value="' . $job->id . '">' . (1600 + $job->id) . ' - ' . $job->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Amount<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Amount" name="amount" type="number" step="any">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Type<span class="red-mark">*</span></label>
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
                                    <label>Sub Type<span class="red-mark">*</span></label>
                                    <select name="subtype" class="form-control">
                                        <option value="" disabled selected>Select Sub Type</option>
                                        <?php foreach ($subTypes as $subType) {
                                            echo '<option value="' . $subType->id . '">' . $subType->name . '</option>';
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
                                        <option value="" disabled selected>Select Accounting Code</option>
                                        <?php foreach ($accountingCodes as $accountingCode) {
                                            echo '<option value="' . $accountingCode->id . '">' . $accountingCode->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Method<span class="red-mark">*</span></label>
                                    <select name="method" class="form-control">
                                        <option value="" disabled selected>Select Method</option>
                                        <?php foreach ($methods as $method) {
                                            echo '<option value="' . $method->id . '">' . $method->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Bank Account<span class="red-mark">*</span></label>
                                    <select name="bank_account" class="form-control">
                                        <option value="" disabled selected>Select Bank Account</option>
                                        <?php foreach ($bankAccounts as $bankAccount) {
                                            echo '<option value="' . $bankAccount->id . '">' . $bankAccount->name . '</option>';
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
                                        <option value="" disabled selected>Select State</option>
                                        <?php foreach ($states as $state) {
                                            echo '<option value="' . $state->id . '">' . $state->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea id="note-input" class="form-control" name="notes" placeholder="Notes" rows="10"></textarea>
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

<script src="<?= base_url('assets/js/financial/create.js') ?>"></script>