<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-12">
            <a href="<?= base_url('financial/items/create') ?>" class="btn btn-info btn-fill">Add New Item</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">Items</h4>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-hover table-striped" id="jobtable">
                        <thead>
                            <th>ID</th>
                            <th>Display Name</th>
                            <th>Line/ Style/ Type</th>
                            <th>Internal Part #</th>
                            <th>Quantity Units</th>
                            <th>Unit Price</th>
                            <th>Description</th>
                        </thead>
                        <tbody>
                            <?php if (!empty($items)) : ?>
                                <?php foreach ($items as $item) : ?>
                                    <tr>
                                        <td><?= $item->id ?></td>
                                        <td><?= $item->item_name ?></td>
                                        <td><?= $item->item_type ?></td>
                                        <td><?= $item->internal_part ?></td>
                                        <td><?= $item->quantity_units ?></td>
                                        <td><?= $item->unit_price ?></td>
                                        <td><?= $item->item_description ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No Record Found!</td>
                                    </tr>
                                <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>