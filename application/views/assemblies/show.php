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
            <a href="<?= base_url('assemblies') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <a href="#" class="btn btn-info btn-fill show-edit-toggler"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; Edit</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Assembly Detail</h4>
                </div>
                <div class="content view">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <p><?= $assembly->name ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <tr>
                                <th>Items<div class="assemblies-description-display">Description</div></th>
                            </tr>
                            <?php
                            foreach ($assemblies_description as $assemblies_desc) {
                                echo '<tr><td>' . $assemblies_desc->item_name . '<div class="assemblies-description-display">' . $assemblies_desc->description . '</div></td></tr>';
                            }
                            ?>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- edit sesction -->
<div id="edit-section" class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-12 max-1000-form-container">
            <a href="#" class="btn btn-info btn-fill show-edit-toggler"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <a href="<?= base_url('assembly/' . $assembly->id . '/delete') ?>" data-method="POST" class="btn btn-danger btn-fill show-edit-toggler pull-right"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Edit Assembly</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <?= form_open('assembly/' . $assembly->id . '/update', array('id' => 'assembly_edit', 'method' => 'post', 'novalidate' => true)) ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="Name" name="name" value="<?= $assembly->name ?>" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Items<span class="red-mark">*</span></label>
                                    </div>
                                </div>
                                <?php
                                $index = 1;
                                foreach ($assemblies_description as $assemblies_desc) {
                                ?>
                                    <div data-index="<?= $index ?>" class="row duplicate-container description-container">
                                        <div class="col-md-11 col-xs-8">
                                            <select name="items[<?= $index ?>][item_id]" class="form-control">
                                                <option value="" disabled>Select Item</option>
                                                <?php foreach ($items as $item) {
                                                    echo '<option value="' . $item->id . '"' . ($assemblies_desc->item == $item->id ? ' selected' : '') . '>' . $item->name . '</option>';
                                                } ?>
                                            </select>
                                            <textarea class="form-control item-description" name="items[<?= $index ?>][description]" placeholder="Description"><?= $assemblies_desc->description ?></textarea>
                                            <input type="hidden" name="items[<?= $index ?>][id]" value="<?= $assemblies_desc->id ?>" />
                                        </div>
                                        <div class="col-md-1 col-xs-4 duplicate-buttons">
                                            <span id="add"><i class="fa fa-plus-square-o text-success" aria-hidden="true"></i></span>
                                            <span id="remove" class="pull-right"><i class="fa fa-minus-square-o text-danger" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                <?php
                                    $index++;
                                }
                                ?>
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
                    <?= form_close() ?>


                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/assemblies/edit.js') ?>"></script>

<!-- end section -->