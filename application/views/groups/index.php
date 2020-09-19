<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-12">
            <a href="<?= base_url('group/create') ?>" class="btn btn-info btn-fill">New Group</a>
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
                    <h4 class="title">Groups</h4>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-hover table-striped">
                        <thead>
                            <th class="text-center">View</th>
                            <th>ID</th>
                            <th>Group Name</th>
                            <th>Associated Items Count</th>
                        </thead>
                        <tbody>
                            <?php if (!empty($groups)) : ?>
                                <?php foreach ($groups as $group) : ?>
                                    <tr>
                                        <td class="text-center"><a href="<?= base_url('group/' . $group->id) ?>" class="text-info"><i class="fa fa-eye"></i></a></td>
                                        <td><?= $group->id ?></td>
                                        <td><?= $group->name ?></td>
                                        <td><?= $group->items_count ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="text-center">No Record Found!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>