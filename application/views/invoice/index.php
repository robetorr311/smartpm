<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-12">
            <?php if ($clientId) { ?>
                <a href="<?= base_url('lead/' . $sub_base_path . $clientId) ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <?php } ?>
            <a href="<?= $clientId ? base_url('lead/' . $sub_base_path . $clientId . '/invoice/create') : base_url('financial/invoice/create') ?>" class="btn btn-info btn-fill">New Invoice</a>
        </div>
    </div>
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
    <?php if ($clientId) { ?>
        <div class="row">
            <div class="col-md-8">
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
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">Invoice List</h4>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-hover table-striped">
                        <thead>
                            <th class="text-center">View</th>
                            <th>Invoice #</th>
                            <th>Date</th>
                            <th>Client Name</th>
                            <th>Total</th>
                            <th>Created By</th>
                            <th class="text-center">PDF</th>
                        </thead>
                        <tbody>
                            <?php if (!empty($invoices)) : ?>
                                <?php foreach ($invoices as $invoice) : ?>
                                    <tr>
                                        <td class="text-center"><a href="<?= $clientId ? base_url('lead/' . $sub_base_path . $clientId . '/invoice/' . $invoice->id) : base_url('financial/invoice/' . $invoice->id) ?>" class="text-info"><i class="fa fa-eye"></i></a></td>
                                        <td><?= $invoice->id ?></td>
                                        <td><?= date('M j, Y', strtotime($invoice->date)) ?></td>
                                        <td><?= $invoice->client_name ?></td>
                                        <td>$<?= number_format($invoice->total, 2) ?></td>
                                        <td><?= $invoice->created_user ?></td>
                                        <td class="text-center"><a href="<?= base_url('financial/invoice/' . $invoice->id . '/pdf') ?>" target="_blank" class="text-info"><i class="fa fa-file-pdf-o"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" class="text-center">No Record Found!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>