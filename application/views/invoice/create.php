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
        <div class="col-md-12 max-1000-form-container">
            <a href="<?= $clientId ? base_url('lead/' . $sub_base_path . $clientId . '/invoices') : base_url('financial/invoices') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Create Invoice</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <form id="invoice_create" action="<?= $clientId ? base_url('lead/' . $sub_base_path . $clientId . '/invoice/store') : base_url('financial/invoice/store') ?>" method="post" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Client<span class="red-mark">*</span></label>
                                    <select id="client_id" name="client_id" class="form-control">
                                        <option value="" disabled selected>Select Client</option>
                                        <?php foreach ($clients as $client) {
                                            echo '<option value="' . $client->id . '">' . $client->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Date" name="date" type="date" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>Item<span class="red-mark">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <label>Amount<span class="red-mark">*</span></label>
                                </div>
                            </div>
                            <div data-index="0" class="row duplicate-container items-container">
                                <div class="col-md-8">
                                    <input class="form-control" placeholder="Item" name="items[0][name]" type="text">
                                </div>
                                <div class="col-md-3 col-xs-8">
                                    <input class="form-control" placeholder="Amount" name="items[0][amount]" type="number">
                                </div>
                                <div class="col-md-1 col-xs-4 duplicate-buttons">
                                    <span id="add"><i class="fa fa-plus-square-o text-success" aria-hidden="true"></i></span>
                                    <span id="remove" class="pull-right"><i class="fa fa-minus-square-o text-danger" aria-hidden="true"></i></span>
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

<script src="<?= base_url('assets/js/invoices/create.js') ?>"></script>
<?php if ($clientId) { ?>
    <script>
        $('form#invoice_create #client_id').val(<?= $clientId ?>);
        $('form#invoice_create #client_id').change();
    </script>
<?php } ?>