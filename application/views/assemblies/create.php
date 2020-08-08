<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (!empty($this->session->flashdata('errors'))) {

                echo '<div class="alert alert-danger fade in alert-dismissable" title="Error:"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>';
                echo "" . $this->session->flashdata('errors');
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-12">
            <a href="<?= base_url('assemblies') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Create Assembly</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <?= form_open('assembly/store', array('id' => 'assembly_create', 'method' => 'post', 'novalidate' => true)) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="Name" name="name" type="text">
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
                                <div  data-index="0" class="row duplicate-container description-container">
                                    <div class="col-md-11 col-xs-8">
                                        <select name="items[0][item_id]" class="form-control">
                                            <option value="" disabled selected>Select Item</option>
                                            <?php foreach ($items as $item) {
                                                echo '<option value="' . $item->id . '">' . $item->name . '</option>';
                                            } ?>
                                        </select>
                                        <textarea class="form-control item-description" name="items[0][description]" placeholder="Description"></textarea>
                                    </div>
                                    <div class="col-md-1 col-xs-4 duplicate-buttons">
                                        <span id="add"><i class="fa fa-plus-square-o text-success" aria-hidden="true"></i></span>
                                        <span id="remove" class="pull-right"><i class="fa fa-minus-square-o text-danger" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                                <div  data-index="1" class="row duplicate-container description-container">
                                    <div class="col-md-11 col-xs-8">
                                        <select name="items[1][item_id]" class="form-control">
                                            <option value="" disabled selected>Select Item</option>
                                            <?php foreach ($items as $item) {
                                                echo '<option value="' . $item->id . '">' . $item->name . '</option>';
                                            } ?>
                                        </select>
                                        <textarea class="form-control item-description" name="items[1][description]" placeholder="Description"></textarea>
                                    </div>
                                    <div class="col-md-1 col-xs-4 duplicate-buttons">
                                        <span id="add"><i class="fa fa-plus-square-o text-success" aria-hidden="true"></i></span>
                                        <span id="remove" class="pull-right"><i class="fa fa-minus-square-o text-danger" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-info btn-fill pull-right">Create</button>
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
<script src="<?= base_url('assets/js/assemblies/create.js') ?>"></script>