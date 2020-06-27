<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-12">
            <a href="<?= base_url('item/create') ?>" class="btn btn-info btn-fill">New Item</a>
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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">Items</h4>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-hover table-striped">
                        <thead>
                            <th class="text-center">View</th>
                            <th>ID</th>
                            <th>Display Name </th>
                            <th>Line/ Style/ Type</th>
                            <th>Internal Part #</th>
                            <th>Quantity Units</th>
                            <th>Unit Price</th>
                        </thead>
                        <tbody>
                            <?php if (!empty($items)) : ?>
                                <?php foreach ($items as $item) : ?>
                                    <tr>
                                        <td class="text-center"><a href="<?= base_url('item/' . $item->id) ?>" class="text-info"><i class="fa fa-eye"></i></a></td>
                                        <td><?= $item->id ?></td>
                                        <td><?= $item->name ?></td>
                                        <td><?= $item->line_style_type ?></td>
                                        <td><?= $item->internal_part_no ?></td>
                                        <td><?= $item->quantity_units ?></td>
                                        <td><?= is_null($item->unit_price) ? '' : '$' . number_format($item->unit_price, 2) ?></td>
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