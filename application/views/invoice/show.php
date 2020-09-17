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
        <div class="col-md-12 max-1000-form-container">
            <a href="<?= $clientId ? base_url('lead/' . $sub_base_path . $clientId . '/invoices') : base_url('financial/invoices') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <a href="#" class="btn btn-info btn-fill show-edit-toggler"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; Edit</a>
        </div>
    </div>
    <?php if ($clientId) { ?>
        <div class="row">
            <div class="col-md-12 max-1000-form-container">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Leads / Clients Detail</h4>
                    </div>
                    <div class="content view">
                        <div class="row client-details">
                            <div class="col-lg-4 client-details-column">
                                <h6><u>Client Details</u></h6>
                                Job Number <?= (1600 + $lead->id); ?><br />
                                <?= $lead->firstname ?> <?= $lead->lastname ?><br />
                                <?= $lead->address ?><br />
                                <?= empty($lead->address_2) ? '' : ($lead->address_2 . '<br />') ?>
                                <?= $lead->city ?>, <?= $lead->state ?> <?= $lead->zip ?><br />
                                C - <?= formatPhoneNumber($lead->phone1) ?><br />
                                <?= $lead->email ?>
                            </div>
                            <div class="col-lg-4 client-details-column">
                                <h6><u>Financial Details</u></h6>
                                <table style="width: 100%;">
                                    <?php
                                    $balance = 0;
                                    if (!empty($contract_price_financials)) {
                                        foreach ($contract_price_financials as $financial) {
                                            $balance += $financial->amount;
                                    ?>
                                            <tr>
                                                <td><?= FinancialModel::typeToStr($financial->type) ?></td>
                                                <td class="text-right"><b><?= (floatval($financial->amount) < 0 ? '- $' . number_format(abs($financial->amount), 2) : '$' . number_format($financial->amount, 2)) ?></b></td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td><?= FinancialModel::typeToStr(5) ?></td>
                                            <td class="text-right"><b>$0.00</b></td>
                                        </tr>
                                    <?php
                                    }
                                    foreach ($financials as $financial) {
                                        $balance += $financial->amount;
                                    ?>
                                        <tr>
                                            <td><?= FinancialModel::typeToStr($financial->type) ?></td>
                                            <td class="text-right"><b><?= (floatval($financial->amount) < 0 ? '- $' . number_format(abs($financial->amount), 2) : '$' . number_format($financial->amount, 2)) ?></b></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <td>Balance Due</td>
                                        <td class="text-right" style="border-top: solid 1px #000;"><b><?= (floatval($balance) < 0 ? '- $' . number_format(abs($balance), 2) : '$' . number_format($balance, 2)) ?></b></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-lg-4 client-details-column">
                                <h6><u>Job Details</u></h6>
                                <table style="width: 100%;">
                                    <?php if (!empty($financial_record->contract_date)) { ?>
                                        <tr>
                                            <td>Contract Date:</td>
                                            <td><?= date('M j, Y', strtotime($financial_record->contract_date)) ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (!empty($lead->completed_date)) { ?>
                                        <tr>
                                            <td>Completion Date:</td>
                                            <td><?= date('M j, Y', strtotime($lead->completed_date)) ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (!empty($primary_material_info)) { ?>
                                        <?php if (!empty($primary_material_info->color)) { ?>
                                            <tr>
                                                <td>Shingle Color:</td>
                                                <td><?= $primary_material_info->color ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if (!empty($primary_material_info->installer_name)) { ?>
                                            <tr>
                                                <td>Installer:</td>
                                                <td><?= $primary_material_info->installer_name ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if (!empty($primary_material_info->supplier)) { ?>
                                            <tr>
                                                <td>Material Supplier:</td>
                                                <td><?= $primary_material_info->supplier ?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?= base_url('lead/' . $sub_base_path . $lead->id . '/photos'); ?>" class="btn btn-fill">Photos</a>
                                <a href="<?= base_url('lead/' . $sub_base_path . $lead->id . '/reports'); ?>" class="btn btn-fill">Photo Report</a>
                                <a href="<?= base_url('lead/' . $sub_base_path . $lead->id . '/docs'); ?>" class="btn btn-fill">Docs</a>
                                <a href="<?= base_url('lead/' . $sub_base_path . $lead->id . '/notes'); ?>" class="btn btn-fill">Notes</a>
                                <a href="<?= base_url('lead/' . $sub_base_path . $lead->id . '/public-folder'); ?>" class="btn btn-fill">Public Folder</a>
                                <a href="<?= base_url('lead/' . $sub_base_path . $lead->id . '/estimates'); ?>" class="btn btn-fill">Estimates</a>
                                <a href="<?= base_url('lead/' . $sub_base_path . $lead->id . '/invoices'); ?>" class="btn btn-fill">Invoices</a>
                                <a href="<?= base_url('lead/' . $sub_base_path . $lead->id . '/client-notices'); ?>" class="btn btn-fill">Client Notice</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Invoice Detail</h4>
                </div>
                <div class="content view">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Client Name</label>
                                <p><?= $invoice->client_name ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <p><?= date('M j, Y', strtotime($invoice->date)) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <tr>
                                <th>Item</th>
                                <th width="150" class="text-right">Amount</th>
                            </tr>
                            <?php
                            $desc_total = 0;
                            foreach ($invoice_items as $invoice_item) {
                                $group_total = 0;
                            ?>
                                <tr>
                                    <td><?= $invoice_item->name ?></td>
                                    <td class="text-right">$<?= number_format($invoice_item->amount, 2) ?></td>
                                </tr>
                            <?php
                                $desc_total += $invoice_item->amount;
                            }
                            ?>
                            <tr>
                                <th class="text-right">Total:</th>
                                <th class="text-right">$<?= number_format($desc_total, 2) ?></th>
                            </tr>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="footer">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= $clientId ? base_url('lead/' . $sub_base_path . $clientId . '/invoice/' . $invoice->id . '/pdf') : base_url('financial/invoice/' . $invoice->id . '/pdf'); ?>" target="_blank" class="btn btn-fill">View PDF</a>
                            <a href="<?= $clientId ? base_url('lead/' . $sub_base_path . $clientId . '/invoice/' . $invoice->id . '/save-pdf') : base_url('financial/invoice/' . $invoice->id . '/save-pdf'); ?>" data-method="POST" class="btn btn-fill">Save PDF</a>
                            <a href="<?= $clientId ? base_url('lead/' . $sub_base_path . $clientId . '/invoice/' . $invoice->id . '/send-pdf') : base_url('financial/invoice/' . $invoice->id . '/send-pdf'); ?>" data-method="POST" class="btn btn-fill">Send PDF</a>
                        </div>
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
            <a href="<?= $clientId ? base_url('lead/' . $sub_base_path . $clientId . '/invoice/' . $invoice->id . '/delete') : base_url('financial/invoice/' . $invoice->id . '/delete') ?>" data-method="POST" class="btn btn-danger btn-fill show-edit-toggler pull-right"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Edit Invoice</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <form id="invoice_edit" action="<?= $clientId ? base_url('lead/' . $sub_base_path . $clientId . '/invoice/' . $invoice->id . '/update') : base_url('financial/invoice/' . $invoice->id . '/update') ?>" method="post" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Client Name<span class="red-mark">*</span></label>
                                    <select id="client_id" name="client_id" class="form-control" disabled>
                                        <option value="" disabled<?= $invoice->client_id == '' ? ' selected' : '' ?>>Select Client</option>
                                        <?php foreach ($clients as $client) {
                                            echo '<option value="' . $client->id . '"' . ($invoice->client_id == $client->id ? ' selected' : '') . '>' . $client->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Date" name="date" type="date" value="<?= $invoice->date ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label>Item<span class="red-mark">*</span></label>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Amount<span class="red-mark">*</span></label>
                                        </div>
                                    </div>
                                    <?php
                                    $index = 0;
                                    foreach ($invoice_items as $invoice_item) {
                                    ?>
                                        <div data-index="<?= $index ?>" class="row duplicate-container items-container">
                                            <div class="col-md-8">
                                                <input name="items[<?= $index ?>][id]" type="hidden" value="<?= $invoice_item->id ?>">
                                                <input class="form-control" placeholder="Item" name="items[<?= $index ?>][name]" type="text" value="<?= $invoice_item->name ?>">
                                            </div>
                                            <div class="col-md-3 col-xs-8">
                                                <input class="form-control" placeholder="Amount" name="items[<?= $index ?>][amount]" type="number" value="<?= $invoice_item->amount ?>">
                                            </div>
                                            <div class="col-md-1 col-xs-4 duplicate-buttons">
                                                <span id="add"><i class="fa fa-plus-square-o text-success" aria-hidden="true"></i></span>
                                                <span id="remove" class="pull-right"><i class="fa fa-minus-square-o text-danger" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                    <?php
                                        $index++;
                                    }
                                    ?>
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

<script src="<?= base_url('assets/js/invoices/edit.js') ?>"></script>