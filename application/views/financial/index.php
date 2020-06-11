<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-12">
            <a href="<?= base_url('financial/record/create') ?>" class="btn btn-info btn-fill">New Financial Record</a>
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
                    <h4 class="title">Financial List</h4>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-hover table-striped">
                        <thead>
                            <th class="text-center">View</th>
                            <th>Transaction #</th>
                            <th>Party Name</th>
                            <th>Transaction Date</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Sales Representative</th>
                        </thead>
                        <tbody>
                            <?php if (!empty($financials)) : ?>
                                <?php foreach ($financials as $financial) : ?>
                                    <tr>
                                        <td class="text-center"><a href="<?= base_url('financial/record/' . $financial->id) ?>" class="text-info"><i class="fa fa-eye"></i></a></td>
                                        <td><?= (100 + $financial->id) ?></td>
                                        <td><?= $financial->party == 1 ? $financial->vendor_name : ($financial->party == 2 ? $financial->client_name : '') ?></td>
                                        <td><?= date('M j, Y', strtotime($financial->transaction_date)) ?></td>
                                        <td><?= number_format($financial->amount, 2) ?></td>
                                        <td><?= FinancialModel::typeToStr($financial->type) ?></td>
                                        <td><?= $financial->created_user_fullname ?></td>
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