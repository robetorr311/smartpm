<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-12">
            <a href="<?= base_url('task/create') ?>" class="btn btn-info btn-fill">New Task</a>
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
                    <h4 class="title">Tasks</h4>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-hover table-striped">
                        <thead>
                            <th class="text-center">View</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Created By</th>
                        </thead>
                        <tbody>
                            <?php if (!empty($tasks)) : ?>
                                <?php foreach ($tasks as $task) : ?>
                                    <tr>
                                        <td class="text-center"><a href="<?= base_url('task/' . $task->id) ?>" class="text-info"><i class="fa fa-eye"></i></a></td>
                                        <td><?= $task->id ?></td>
                                        <td><?= $task->name ?></td>
                                        <td><?= $task->type_name ?></td>
                                        <td><?= TaskModel::levelToStr($task->level) ?></td>
                                        <td><?= TaskModel::statusToStr($task->status) ?></td>
                                        <td><?= $task->assigned_user_fullname ?></td>
                                        <td><?= $task->created_user_fullname ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="10" class="text-center">No Record Found!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>