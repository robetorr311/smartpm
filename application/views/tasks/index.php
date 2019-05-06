<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-12">
            <a href="<?php echo base_url('tasks/create'); ?>" class="btn btn-info btn-fill pull-right">New Task</a>
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
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Level</th>
                            <th>Assigned To</th>
                            <th>Created By</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Edit</th>
                            <th class="text-center">Delete</th>
                        </thead>
                        <tbody>
                            <?php if (!empty($tasks)) : ?>
                                <?php foreach ($tasks as $task) : ?>
                                    <tr>
                                        <td><?php echo $task->id ?></td>
                                        <td><?php echo $task->name ?></td>
                                        <td><?php echo TaskModel::typetostr($task->type) ?></td>
                                        <td><?php echo TaskModel::leveltostr($task->level) ?></td>
                                        <td><?php echo $task->assigned_username ?></td>
                                        <td><?php echo $task->created_username ?></td>
                                        <td class="text-center"><a href="<?= base_url('task/' . $task->id) ?>" class="text-info"><i class="fa fa-eye"></i></a></td>
                                        <td class="text-center"><a href="<?= base_url('task/' . $task->id . '/edit') ?>" class="text-warning"><i class="fa fa-pencil"></i></a></td>
                                        <td class="text-center"><a href="<?= base_url('task/' . $task->id . '/delete') ?>" data-method="DELETE" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
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