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
        <div class="col-md-6">
            <div class="card">
                <div class="header">
                    <h4 class="title">Box Names</h4>
                </div>
                <div class="content">
                    <form action="<?= base_url('setting/dashboard-options/update') ?>" method="post">
                        <div class="table-responsive table-full-width">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th width="35%">Name</th>
                                    <th width="65%">Label</th>
                                </thead>
                                <tbody>
                                    <?php if (!empty($boxNames)) : ?>
                                        <?php foreach ($boxNames as $boxName) : ?>
                                            <tr>
                                                <td><?= $boxName->name ?></td>
                                                <td><input class="form-control" placeholder="<?= $boxName->name ?>" name="name_<?= $boxName->id ?>" value="<?= $boxName->label ?>" type="text"></td>
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
                        <div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-info btn-fill">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>