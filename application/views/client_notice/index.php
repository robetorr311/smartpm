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

    <div class="row page-header-buttons">
        <div class="col-md-12">
            <a href="<?= base_url('lead/' . $sub_base_path . $lead->id) ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
        </div>
    </div>
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
                            <a href="<?= base_url('financial/estimates/client/' . $lead->id); ?>" class="btn btn-fill" target="_blank">Estimates</a>
                            <a href="<?= base_url('lead/' . $sub_base_path . $lead->id . '/client-notices'); ?>" class="btn btn-fill">Client Notice</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="header">
                    <h4 class="title">Send Notice</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="<?= base_url('lead/' . $sub_base_path . $lead->id . '/client-notice/store') ?>" method="post">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Type<span class="red-mark">*</span></label>
                                            <select name="type" class="form-control">
                                                <option value="" disabled selected>Select Type</option>
                                                <?php foreach ($noticeTypes as $noticeType) {
                                                    echo '<option value="' . $noticeType->id . '">' . $noticeType->name . '</option>';
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Date<span class="red-mark">*</span></label>
                                            <input class="form-control" placeholder="Date" Name="date" type="date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Expected Date</label>
                                            <input class="form-control" placeholder="Expected Date" Name="expected_date" type="date">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea class="form-control note-input" name="note" placeholder="Note (You can use Ctrl + Enter for Submit)" rows="10" ctrl-enter-submit></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info btn-fill pull-right">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card lead-notes-card">
                <div class="header">
                    <h4 class="title">Client Notices</h4>
                </div>
                <?php
                if ($notices) {
                    foreach ($notices as $notice) {
                ?>
                        <hr />
                        <div class="content view">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Type</label>
                                    <p><?= $notice->type_name ?></p>
                                </div>
                                <div class="col-md-4">
                                    <label>Date</label>
                                    <p><?= date('M j, Y', strtotime($notice->date)) ?></p>
                                </div>
                                <div class="col-md-4">
                                    <label>Expected Date</label>
                                    <p><?= is_null($notice->expected_date) ? '-' : date('M j, Y', strtotime($notice->expected_date)) ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Note</label>
                                    <p><?= empty($notice->note) ? '-' : nl2br($notice->note) ?></p>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                    echo "<p></p>";
                } else {
                    echo '<div class="content view"><p>-</p></div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>