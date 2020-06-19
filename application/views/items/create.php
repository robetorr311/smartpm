<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        <?php
            if (!empty($this->session->flashdata('errors'))) {

                echo '<div class="alert alert-danger fade in alert-dismissable" title="Error:"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>';
                echo "".$this->session->flashdata('errors');
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-12">
            <a href="<?= base_url('/items') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Create Item</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                        
                  
                    <?= form_open('items/store', array('id' => 'item_create', 'method' => 'post', 'novalidate' => true)) ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Item Name<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Item Name" name="item_name" type="text" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Line/ Style / Type<span class="red-mark"></span></label>
                                    <input class="form-control" placeholder="Item Line/ Style / Type" name="item_line" type="text" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Internal Part <span class="red-mark"></span></label>
                                    <input class="form-control" placeholder="Internal Part" name="internal_parts" min="1" type="number" >
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quantity Units<span class="red-mark"></span></label>
                                    <input class="form-control" placeholder="Quantity Units" name="quantity_units" type="text" step="any" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div    class="form-group">
                                    <label>Unit Price<span class="red-mark"></span></label>
                                    <input class="form-control" placeholder="Unit Price" name="unit_price" type="number" min="1" step="any" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description<span class="red-mark"></span></label>
                                    <textarea id="note-input" class="form-control" name="item_desc" placeholder="Item Description" rows="10" ></textarea>
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
<script src="<?= base_url('assets/js/items/create.js') ?>"></script>