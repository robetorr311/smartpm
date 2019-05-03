<?php
defined('BASEPATH') or exit('No direct script access allowed');?> 
<div class="container-fluid">
    <div class="row dashbord-box">
      
              <?php foreach( $data->result() as $dat ) : ?> 
                          
                           
     
       <div class="col-md-2">
        	<div class="box alert-success">
        		<a href="<?php echo base_url('leads');?>"><span><?php echo $dat->LEAD; ?></span>
        		<p>Open Leads</p>
        		</a>
        	</div>
        </div>
        <div class="col-md-2">
        	<div class="box alert-warning">
        		<a href="<?php echo base_url('cash_jobs');?>"><span><?php echo $dat->CASH; ?></span>
        		<p>Open Cash Jobs</p></a>
        	</div>
        </div>
        <div class="col-md-2">
        	<div class="box alert-danger">
        		<a href="<?php echo base_url('insurance_jobs');?>"><span><?php echo $dat->INSURANCE; ?></span>
        		<p>Open Insurance Jobs</p></a>
        	</div>
        </div>
        <div class="col-md-2">
        	<div class="box alert-info">
        		<a href="<?php echo base_url('dashboard');?>"><span><?php echo $dat->CASH; ?></span>
        		<p>Complete Jobs</p></a>
        	</div>
        </div>
        <div class="col-md-2">
        	<div class="box alert-warning">
        		<a href="<?php echo base_url('dashboard');?>"><span><?php echo $dat->CLOSED; ?></span>
        		<p>Closed Jobs</p></a>
        	</div>
        </div> <?php endforeach; ?>
	</div>
</div>