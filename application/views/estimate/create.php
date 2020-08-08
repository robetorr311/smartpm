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
<div class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-12 max-1000-form-container">
            <a href="<?= $clientId ? base_url('financial/estimates/client/' . $clientId) : base_url('financial/estimates') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
        </div>
    </div>
    <div class="row page-header-buttons">
        <div class="col-md-12 max-1000-form-container">
            <label><input type="radio" name="create_type" id="create_type_scratch" value="Create From Scratch" checked> Create From Scratch</label><br />
            <label><input type="radio" name="create_type" id="create_type_assemblies" value="Load From Assemblies"> Load From Assemblies</label><br />
            <div class="row">
                <div class="col-md-6">
                    <select name="create_type_assemblies_select" id="create_type_assemblies_select" disabled>
                        <option value="" disabled selected>Select Assembly</option>
                        <?php
                        foreach ($assemblies as $assembly) {
                            echo '<option value="' . $assembly->id . '">' . $assembly->name . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col md 6">
                    <button id="load_assembly" class="btn btn-info btn-fill" disabled>Load</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Create Estimate</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <form id="estimate_create" action="<?= $clientId ? base_url('financial/estimate/client/' . $clientId . '/store') : base_url('financial/estimate/store') ?>" method="post" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Client Name<span class="red-mark">*</span></label>
                                    <select id="client_id" name="client_id" class="form-control">
                                        <option value="" disabled selected>Select Client</option>
                                        <?php foreach ($clients as $client) {
                                            echo '<option value="' . $client->id . '">' . $client->name . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Date" name="date" type="date" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Title" name="title" type="text">
                                </div>
                            </div>
                        </div>
                        <div data-index="0" class="duplicate-container group-container">
                            <hr />
                            <div class="row">
                                <div class="col-md-12" style="background-color: #ddd;">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Sub Title<span class="red-mark">*</span></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-11 col-xs-8">
                                                <input class="form-control" placeholder="Sub Title" name="desc_group[0][sub_title]" type="text">
                                            </div>
                                            <div class="col-md-1 col-xs-4 duplicate-buttons group-duplicate-buttons">
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
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>Item<span class="red-mark">*</span></label>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Quantity</label>
                                            </div>
                                        </div>
                                        <div data-index="0" class="row duplicate-container description-container">
                                            <div class="col-md-8">
                                                <select name="desc_group[0][0][item]" class="form-control">
                                                    <option value="" disabled selected>Select Item</option>
                                                    <?php foreach ($items as $item) {
                                                        echo '<option value="' . $item->id . '">' . $item->name . '</option>';
                                                    } ?>
                                                </select>
                                                <textarea class="form-control item-description" name="desc_group[0][0][description]" placeholder="Description"></textarea>
                                            </div>
                                            <div class="col-md-3 col-xs-8">
                                                <input class="form-control" placeholder="Quantity" name="desc_group[0][0][amount]" type="number">
                                            </div>
                                            <div class="col-md-1 col-xs-4 duplicate-buttons">
                                                <span id="add"><i class="fa fa-plus-square-o text-success" aria-hidden="true"></i></span>
                                                <span id="remove" class="pull-right"><i class="fa fa-minus-square-o text-danger" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Note</label>
                                    <textarea class="form-control" name="note" placeholder="Note" rows="10"></textarea>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/estimates/create.js') ?>"></script>
<?php if ($clientId) { ?>
    <script>
        $('form#estimate_create #client_id').val(<?= $clientId ?>);
        $('form#estimate_create #client_id').change();
    </script>
<?php } ?>