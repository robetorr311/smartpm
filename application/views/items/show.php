<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="container-fluid">
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
        <div class="col-md-12">
            <a href="<?= base_url('items') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <a href="#" class="btn btn-info btn-fill show-edit-toggler"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; Edit</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="header">
                    <h4 class="title">Items Detail</h4>
                </div>
                <div class="content view">
                    <div class="row">
                        <div class="col-md-12">
                        <?php if (!empty($item)) : ?>
                        <?php $id=1; foreach ($item as $item) : ?>
                        <p><b>Item Name:</b> <?php echo $item->item_name; ?></p> 
                        <p><b>Item Type: </b> <?php echo $item->item_type; ?></p>
                        <p><b>Internal Parts:</b> <?php echo $item->internal_part; ?></p>
                        <p><b>Quantity: </b><?php echo $item->quantity_units; ?></p>
                        <p><b>Unit Price: </b><?php echo '$ '.$item->unit_price;  ?></p>
                        <p><b>Description: </b><?php echo $item->item_description; ?></p>
                        <?php $id++; endforeach; ?>
                                <?php else : ?>
                                        <td colspan="8" class="text-center">No Record Found!</td>
                                <?php endif; ?>
                        
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
        
    </div>
</div>
<!-- edit sesction -->
<div id="edit-section" class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-12">
      
            <a href="#" class="btn btn-info btn-fill show-edit-toggler"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <a href="<?= base_url('items/' .$item->id . '/delete') ?>" data-method="POST" class="btn btn-danger btn-fill show-edit-toggler"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Edit Item</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <?= form_open('items/' . $item->id . '/update', array('id' => 'item_edit', 'method' => 'post', 'novalidate' => true)) ?>
                   
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Display Name<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="Item Display Name" name="item_name" value="<?php  echo $item->item_name;  ?>" type="text" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Line/ Style / Type<span class="red-mark"></span></label>
                                    <input class="form-control" placeholder="Item Line/ Style / Type" name="item_type" type="text" value="<?php  echo $item->item_type;  ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Internal Part <span class="red-mark"></span></label>
                                    <input class="form-control" placeholder="Internal Part" name="internal_part" type="text" value="<?php  echo $item->internal_part;  ?>">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quantity Units<span class="red-mark"></span></label>
                                    <input class="form-control" placeholder="Quantity Units" name="quantity_units" type="text" step="any" value="<?php  echo $item->quantity_units;  ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Unit Price<span class="red-mark"></span></label>
                                    <input class="form-control" placeholder="Unit Price" name="unit_price" type="number" step="any" value="<?php  echo  $item->unit_price;  ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description<span class="red-mark"></span></label>
                                    <textarea id="note-input" class="form-control" name="item_description" placeholder="Item Description" rows="10" ><?php  echo $item->item_description;  ?></textarea>
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

<script src="<?= base_url('assets/js/items/edit.js') ?>"></script>

<!-- end section -->