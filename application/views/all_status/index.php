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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">All Status Leads / Clients List</h4>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-hover table-striped">
                        <thead>
                            <th>Job Number</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Edit</th>
                            <th class="text-center">Delete</th>
                        </thead>
                        <tbody>
                            <?php if (!empty($jobs)) : ?>
                                <?php foreach ($jobs as $job) : ?>
                                    <?php
                                            $sub_base_path = '';
                                            if ($job->signed_stage == 1 && ($job->status == 7 || $job->status == 8 || $job->status == 9)) {
                                                $sub_base_path = 'production-job/';
                                            } else if ($job->signed_stage == 2 && ($job->status == 7 || $job->status == 8 || $job->status == 9)) {
                                                $sub_base_path = 'completed-job/';
                                            } else if ($job->status == 7) {
                                                $sub_base_path = 'insurance-job/';
                                            } else if ($job->status == 8) {
                                                $sub_base_path = 'cash-job/';
                                            } else if ($job->status == 9) {
                                                $sub_base_path = 'labor-job/';
                                            } else {
                                                $sub_base_path = '';
                                            }
                                            ?>
                                    <tr>
                                        <td><?= ('RJOB' . $job->id); ?></td>
                                        <td><?= $job->firstname ?></td>
                                        <td><?= $job->lastname ?></td>
                                        <td><?= LeadModel::statusToStr($job->status) ?></td>
                                        <td><?= LeadModel::typeToStr($job->type) ?></td>
                                        <td class="text-center"><a href="<?= base_url('lead/' . $sub_base_path . $job->id) ?>" class="text-info"><i class="fa fa-eye"></i></a></td>
                                        <td class="text-center"><a href="<?= base_url('lead/' . $sub_base_path . $job->id . '/edit') ?>" class="text-warning"><i class="fa fa-pencil"></i></a></td>
                                        <td class="text-center"><a href="<?= base_url('lead/' . $sub_base_path . $job->id . '/delete') ?>" data-method="POST" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="9" class="text-center">No Record Found!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <?= $pagiLinks ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>