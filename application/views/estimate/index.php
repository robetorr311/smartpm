<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-12">
            <a href="<?= $clientId ? base_url('financial/estimate/client/' . $clientId . '/create') : base_url('financial/estimate/create') ?>" class="btn btn-info btn-fill">New Estimate</a>
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
                    <h4 class="title">Estimate List</h4>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-hover table-striped">
                        <thead>
                            <th class="text-center">View</th>
                            <th>Estimate #</th>
                            <th>Date</th>
                            <th>Client Name</th>
                            <th>Total</th>
                            <th>Created By</th>
                            <th class="text-center">PDF</th>
                        </thead>
                        <tbody>
                            <?php if (!empty($estimates)) : ?>
                                <?php foreach ($estimates as $estimate) : ?>
                                    <tr>
                                        <td class="text-center"><a href="<?= $clientId ? base_url('financial/estimate/client/' . $clientId . '/' . $estimate->id) : base_url('financial/estimate/' . $estimate->id) ?>" class="text-info"><i class="fa fa-eye"></i></a></td>
                                        <td><?= $estimate->estimate_number ?></td>
                                        <td><?= date('M j, Y', strtotime($estimate->date)) ?></td>
                                        <td><?= $estimate->client_name ?></td>
                                        <td>$<?= number_format($estimate->total, 2) ?></td>
                                        <td><?= $estimate->created_user ?></td>
                                        <td class="text-center"><a href="<?= base_url('financial/estimate/' . $estimate->id . '/pdf') ?>" target="_blank" class="text-info"><i class="fa fa-file-pdf-o"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center">No Record Found!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>