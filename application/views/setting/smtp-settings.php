<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <h4 class="title">SMTP Settings</h4>
                </div>
                <div class="content">
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
                    <form action="<?= base_url('setting/smtp-settings/update') ?>" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>SMTP Crypto<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="SMTP Crypto" name="smtp_crypto" type="text" value="<?= $smtpSettings->smtp_crypto ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>SMTP Host<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="SMTP Host" name="smtp_host" type="text" value="<?= $smtpSettings->smtp_host ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>SMTP Port<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="SMTP Port" name="smtp_port" type="text" value="<?= $smtpSettings->smtp_port ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>SMTP User<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="SMTP User" name="smtp_user" type="text" value="<?= $smtpSettings->smtp_user ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>SMTP Password<span class="red-mark">*</span></label>
                                    <input class="form-control" placeholder="SMTP Password" name="smtp_pass" type="text" value="<?= $smtpSettings->smtp_pass ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info btn-fill pull-right">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>