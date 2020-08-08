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
            <a href="<?= $clientId ? base_url('financial/estimates/client/' . $clientId) : base_url('financial/estimates') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <a href="#" class="btn btn-info btn-fill show-edit-toggler"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; Edit</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Estimate Detail</h4>
                </div>
                <div class="content view">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Client Name</label>
                                <p><?= $estimate->client_name ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <p><?= date('M j, Y', strtotime($estimate->date)) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Title</label>
                                <p><?= $estimate->title ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <tr>
                                <th>Item<div class="estimate-description-display">Description</div></th>
                                <th width="100" class="text-right">Qty</th>
                                <th>Unit</th>
                                <th width="150" class="text-right">Price</th>
                                <th width="150" class="text-right">Total</th>
                            </tr>
                            <?php
                            $desc_total = 0;
                            foreach ($estimate_desc_groups as $group) {
                            ?>
                                <tr>
                                    <th style="background-color: #eee; color: #333 !important;" colspan="5"><?= $group->sub_title ?></th>
                                </tr>
                                <?php
                                $group_total = 0;
                                if (isset($descs[$group->id])) {
                                    foreach ($descs[$group->id] as $desc) {
                                ?>
                                        <tr>
                                            <td><?= $desc->item_name ?><div class="estimate-description-display"><?= $desc->description ?></div></td>
                                            <td class="text-right"><?= number_format($desc->amount, 2) ?></td>
                                            <td><?= $desc->item_quantity_units ?></td>
                                            <td class="text-right">$<?= number_format($desc->item_unit_price, 2) ?></td>
                                            <td class="text-right">$<?= number_format((($desc->amount == 0) ? 0 : (floatval($desc->amount) * floatval($desc->item_unit_price))), 2) ?></td>
                                        </tr>
                                <?php
                                        $group_total += (($desc->amount == 0) ? 0 : (floatval($desc->amount) * floatval($desc->item_unit_price)));
                                    }
                                }
                                $desc_total += $group_total;
                                ?>
                                <tr>
                                    <th style="background-color: #eee; color: #333 !important;" class="text-right" colspan="4">Sub Total - <?= $group->sub_title ?>:</th>
                                    <th style="background-color: #eee; color: #333 !important;" class="text-right">$<?= number_format($group_total, 2) ?></th>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <th class="text-right" colspan="4">Total:</th>
                                <th class="text-right">$<?= number_format($desc_total, 2) ?></th>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Note</label>
                                <p><?= empty($estimate->note) ? '-' : nl2br($estimate->note) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="footer">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= $clientId ? base_url('financial/estimate/client/' . $clientId . '/' . $estimate->id . '/pdf') : base_url('financial/estimate/' . $estimate->id . '/pdf'); ?>" target="_blank" class="btn btn-fill">PDF</a>
                            <a href="<?= $clientId ? base_url('financial/estimate/client/' . $clientId . '/' . $estimate->id . '/save-pdf') : base_url('financial/estimate/' . $estimate->id . '/save-pdf'); ?>" data-method="POST" class="btn btn-fill">Save PDF</a>
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
            <a href="<?= $clientId ? base_url('financial/estimate/client/' . $clientId . '/' . $estimate->id . '/delete') : base_url('financial/estimate/' . $estimate->id . '/delete') ?>" data-method="POST" class="btn btn-danger btn-fill show-edit-toggler pull-right"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Edit Estimate</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <form id="estimate_edit" action="<?= $clientId ? base_url('financial/estimate/client/' . $clientId . '/' . $estimate->id . '/update') : base_url('financial/estimate/' . $estimate->id . '/update') ?>" method="post" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Client Name<span class="red-mark">*</span></label>
                                    <select id="client_id" name="client_id" class="form-control" disabled>
                                        <option value="" disabled<?= $estimate->client_id == '' ? ' selected' : '' ?>>Select Client</option>
                                        <?php foreach ($clients as $client) {
                                            echo '<option value="' . $client->id . '"' . ($estimate->client_id == $client->id ? ' selected' : '') . '>' . $client->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Date" name="date" type="date" value="<?= $estimate->date ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Title" name="title" type="text" value="<?= $estimate->title ?>">
                                </div>
                            </div>
                        </div>
                        <?php
                        $parent_index = 0;
                        foreach ($estimate_desc_groups as $group) {
                        ?>
                            <div data-index="<?= $parent_index ?>" class="duplicate-container group-container">
                                <hr />
                                <div class="row">
                                    <div class="col-md-12" style="background-color: #ddd;">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Sub Title<span class="red-mark">*</span></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-11 col-xs-8">
                                                    <input name="desc_group[<?= $parent_index ?>][id]" type="hidden" value="<?= $group->id ?>">
                                                    <input class="form-control" placeholder="Sub Title" name="desc_group[<?= $parent_index ?>][sub_title]" type="text" value="<?= $group->sub_title ?>">
                                                </div>
                                                <div class="col-md-1 col-xs-4 duplicate-buttons group-duplicate-buttons">
                                                    <span id="add"><i class="fa fa-plus-square-o text-success" aria-hidden="true"></i></span>
                                                    <span id="remove" class="pull-right"><i class="fa fa-minus-square-o text-danger" aria-hidden="true"></i></span>
                                                </div>
                                            </div>
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
                                                    <label>Quantity</label>
                                                </div>
                                            </div>
                                            <?php
                                            if (isset($descs[$group->id])) {
                                                $index = 0;
                                                foreach ($descs[$group->id] as $desc) {
                                            ?>
                                                    <div data-index="<?= $index ?>" class="row duplicate-container description-container">
                                                        <div class="col-md-8">
                                                            <input name="desc_group[<?= $parent_index ?>][<?= $index ?>][id]" type="hidden" value="<?= $desc->id ?>">
                                                            <select name="desc_group[<?= $parent_index ?>][<?= $index ?>][item]" class="form-control">
                                                                <option value="" disabled<?= (empty($desc->item) ? ' selected' : '') ?>>Select Item</option>
                                                                <?php foreach ($items as $item) {
                                                                    echo '<option value="' . $item->id . '"' . ($desc->item == $item->id ? ' selected' : '') . '>' . $item->name . '</option>';
                                                                } ?>
                                                            </select>
                                                            <textarea class="form-control item-description" name="desc_group[<?= $parent_index ?>][<?= $index ?>][description]" placeholder="Description"><?= $desc->description ?></textarea>
                                                        </div>
                                                        <div class="col-md-3 col-xs-8">
                                                            <input class="form-control" placeholder="Quantity" name="desc_group[<?= $parent_index ?>][<?= $index ?>][amount]" type="number" value="<?= $desc->amount ?>">
                                                        </div>
                                                        <div class="col-md-1 col-xs-4 duplicate-buttons">
                                                            <span id="add"><i class="fa fa-plus-square-o text-success" aria-hidden="true"></i></span>
                                                            <span id="remove" class="pull-right"><i class="fa fa-minus-square-o text-danger" aria-hidden="true"></i></span>
                                                        </div>
                                                    </div>
                                            <?php
                                                    $index++;
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            $parent_index++;
                        }
                        ?>
                        <hr />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Note</label>
                                    <textarea class="form-control" name="note" placeholder="Note" rows="10"><?= $estimate->note ?></textarea>
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

<script src="<?= base_url('assets/js/estimates/edit.js') ?>"></script>