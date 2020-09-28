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
            <a href="<?= base_url('item-groups') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <a href="#" class="btn btn-info btn-fill show-edit-toggler"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; Edit</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="content view">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Item Group Name</label>
                                <p><?= $itemGroup->name ?></p>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-12">
                            <label>Items</label>
                            <?php
                            if (!empty($groupItems)) {
                                echo '<p>';
                                foreach ($groupItems as $groupItem) {
                                    echo '<span class="info-tag">' . $groupItem->name .'</span>';
                                }
                                echo '</p>';
                            } else {
                                echo '<p>No Items are mapped.</p>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit Section -->
<div id="edit-section" class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-12 max-1000-form-container">
            <a href="#" class="btn btn-info btn-fill show-edit-toggler"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <a href="<?= base_url('item-group/' . $itemGroup->id . '/delete') ?>" data-method="POST" class="btn btn-danger btn-fill show-edit-toggler pull-right"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Edit Group</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <?= form_open('item-group/' . $itemGroup->id . '/update', array('id' => 'group_edit', 'method' => 'post', 'novalidate' => true)) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Item Group Name<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="Item Group Name" name="name" value="<?= $itemGroup->name ?>" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Items</label>
                                <input class="form-control" placeholder="Add Items" name="items" id="items" type="text">
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

<script>
$(document).ready(function() {
    $('input#items').tagsinput({
            itemValue: 'id',
            itemText: function(item) {
                console.log(item);
                 return item.name;
            },
            typeahead: {
                source: <?= json_encode($items) ?>,
                afterSelect: function() {
                    this.$element[0].value = '';
                }
            }
        });
    <?php
    if ($groupItems) {
        foreach ($groupItems as $groupItem) {
            echo "$('input#items').tagsinput('add', " . json_encode($groupItem) . ");";
        }
    }
    ?>
});
</script>