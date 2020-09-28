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
            <a href="<?= base_url('item-groups') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">Create Item Group</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <?= form_open('item-group/store', ['id' => 'item_group_create', 'method' => 'post', 'novalidate' => true]) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Item Group Name<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="Item Group Name" name="name" type="text">
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
<script>
    $(document).ready(function() {
        $('input#items').tagsinput({
            itemValue: 'id',
            itemText: 'name',
            typeahead: {
                source: <?= json_encode($items) ?>,
                afterSelect: function() {
                    this.$element[0].value = '';
                }
            }
        });
    });
</script>