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
        <div class="col-md-12">
            <a href="<?= base_url('financial/records') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12 max-1000-form-container">
            <div class="card">
                <div class="header">
                    <!-- <h4 class="title">ROOFING ESTIMATE</h4> -->
                    <div class="pull-left"> <img style="width:100px" src="<?php echo base_url() ?>assets/img/imageedit_2_8414475587.png>" class="logoimg" /></div><div class="pull-right">Estimate #:1682</div>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <div><center> <h4 class="title">ROOFING ESTIMATE</h4></center></div>
                    <div class="col-md-12">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-3"><h5>Chris Jones</h5>
                    17 Mayfair St<br>
                    S Burlington, VT
                    </div>
                    <div class="col-lg-3"></div>
                    <div class="col-lg-3">
                        <br>
                        Date: 04/14/2020
                        <br>
                        Done By: Brian H.
                    </div>
                    </div>
                    <div class="col-md-12">
                    <div class="col-lg-3"></div>
                    <h5>MAIN HOUSE ONLY*</h5>
                    <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="center"></th>
                                <th>Description</th>
                                <th class="center"></th>
                                <th class="right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="left"></td>
                                <td class="left strong">Remove existing roof and haul off debris</td>
                                <td class="right"></td>
                                <td class="right"></td>
                            </tr>
                            <tr>
                                <td class="left"></td>
                                <td class="left">Install new asphalt shingles – color specified by customer</td>
                                <td class="right"></td>
                                <td class="right"></td>
                            </tr>
                            <tr>
                                <td class="left"></td>
                                <td class="left">Install ice and water protectant barrier – perimeter & valleys</td>
                                <td class="right"></td>
                                <td class="right"></td>
                            </tr>
                            <tr>
                                <td class="left"></td>
                                <td class="left">Install New Drip Edge Metal</td>
                                <td class="right"></td>
                                <td class="right"></td>
                            </tr>
                            <tr>
                                <td class="left"></td>
                                <td class="left">Install New Drip Edge Metal</td>
                                <td class="right"></td>
                                <td class="right"></td>
                            </tr>
                            <tr>
                                <td class="left"></td>
                                <td class="left">Shingle Spec: IKO “Dynasty” or Owens Corning “Duration”</td>
                                <td class="right"></td>
                                <td class="right"></td>
                            </tr>
                            <tr>
                                <td class="left"></td>
                                <td class="right"></td>
                                <td class="right">Subtotal - Garage</td>
                                <td class="right">$3,626.00</td>
                            </tr>
                            <tr>
                                <td class="left"></td>
                                <td class="right"></td>
                                <td class="right">Subtotal – Main House</td>
                                <td class="right">$11,914.00</td>
                            </tr>
                            <tr>
                                <td class="left"></td>
                                <td class="right">3-year labor “no-leak” warranty (Included) Total $15,540.00
                                Shingles include “Lifetime” manufacturer’s warranty
                                130 mph wind uplift warranty</td>
                                <td class="right"><strong>Total</strong></td>
                                <td class="right"><strong>$15,540.00</strong></td>
                            </tr>
                        </tbody>
                    </table>
               </div>
            </div>
            <div class="pull-left">
            <address>
           <strong>Thank you for your business!</strong>
            <br>Brian H.
            <br>info@champlainroofing.com<br>
            802.417.9113
            </div>
            </div>

            
            <div class="row">
            
                            <div class="col-md-12">
                           <center>C h a m p l a i n R o o f i n g , L L C | 145 Pine Haven Shores Rd #1191, Shelburne, VT 05482 <br>
                i n f o @ c h a m p l a i n r o o f i n g . c o m | 8 0 2 . 4 1 7 . 9 1 1 3</center> 
                                <div class="form-group"><br>
                                <a target="_blank" class="btn btn-info btn-fill cetnter " href="<?= base_url('financial/downloadestimate') ?>">Export to PDF</a>
                                    
                                </div>
                            </div>
                        </div>
            </div>
            
            </div>
<script src="<?= base_url('assets/js/financial/create.js') ?>"></script>