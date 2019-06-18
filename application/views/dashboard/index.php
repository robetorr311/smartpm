<?php
defined('BASEPATH') or exit('No direct script access allowed');?> 
<div class="container-fluid">
    <div class="row dashbord-box">
      
              <?php foreach( $data as $dat ) : ?> 
                          
                           
     
       <div class="col-md-2">
        	<div class="box alert-success">
        		<a href="<?php echo base_url('leads');?>"><span><?php if($dat->OPEN!=''){echo $dat->OPEN;}else{ echo '0';} ?></span>
        		<p>Unsigned<br> Leads</p>
        		</a>
        	</div>
        </div>
        <div class="col-md-2">
        	<div class="box alert-warning">
        		<a href="<?php echo base_url('cash-jobs');?>"><span><?php if($dat->CASH!=''){echo $dat->CASH;}else{ echo '0';} ?></span>
        		<p>Open Cash Jobs</p></a>
        	</div>
        </div>
        <div class="col-md-2">
        	<div class="box alert-danger">
        		<a href="<?php echo base_url('insurance-jobs');?>"><span><?php if($dat->INSURANCE!=''){echo $dat->INSURANCE;}else{ echo '0';} ?></span>
        		<p>Open Insurance Jobs</p></a>
        	</div>
        </div>
        <div class="col-md-2">
        	<div class="box alert-info">
        		<a href="<?php echo base_url('work-completed');?>"><span><?php if($dat->COMPLETE!=''){echo $dat->COMPLETE;}else{ echo '0';} ?></span>
        		<p>Complete<br> Jobs</p></a>
        	</div>
        </div>
        <div class="col-md-2">
        	<div class="box alert-warning">
        		<a href="<?php echo base_url('lead/closed');?>"><span><?php if($dat->CLOSED!=''){echo $dat->CLOSED;}else{ echo '0';} ?></span>
        		<p>Closed <br>Jobs</p></a>
        	</div>
        </div> <?php endforeach; ?>
	</div>
</div>