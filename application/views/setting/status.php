<?php
defined('BASEPATH') or exit('No direct script access allowed');?>
<div class="container-fluid status-box">
	<div class="row">

        <div class="col-md-3">
            <div class="card">
				  <div class="header">
				  	  <h4>Job Type</h4>
				  </div>
				  <div class="content">
				  	  <table class="table table-hover table-striped">
                            <thead>
                                 <tr><th>Existing Tag</th><th></th></tr>
                            </thead>
                            <tbody> 
								<?php foreach( $job_type as $data ) : ?>  
								<tr><td><?php echo $data->status_value  ?></td><td><a href="<?php echo base_url('setting/'.$data->status_id.'/delete') ?>"><i class="del-doc pe-7s-trash" id=""></i></a></td></tr>
								<?php endforeach; ?>
                            
                            </tbody>     
                        </table> 
                     
  						<div class="addmore" style="display: none">
  					  <?php echo form_open('setting/newtag',array('method'=>'post'));?>
  					  <input type="hidden" value="1" name="id">
                        <input type="text" name="type" class="form-control" />
                        <input type="submit"  name="" value="Save" />
      					  <?php echo form_close(); ?>   </div>       


      					    <button  class="add_more_tag" name="" value="Save"><i class="pe-7s-plus" style="font-size: 20px" /></i></button>
				  </div>
            </div>
        </div>


        <div class="col-md-3">
            <div class="card">
					<div class="header">
				  	  <h4>Job Classification</h4>
				  </div>
				  <div class="content">
				  	  <table class="table table-hover table-striped">
                            <thead>
                                 <th>Existing Tag</th>
                                 <th></th>
                            </thead>
                           <tbody> <?php if( !empty( $job_classification ) ) : ?>
								<?php foreach( $job_classification as $data ) : ?>  
								<tr><td><?php echo $data->status_value  ?></td><td><a href="<?php echo base_url('setting/'.$data->status_id.'/delete') ?>"><i class="del-doc pe-7s-trash" id=""></i></a></td></tr>
								<?php endforeach; ?>
                            	 <?php else : ?>
                  <tr>
                      <td colspan="13" class="text-center">No Record Found!</td>
                  </tr>
            <?php endif; ?>
                            </tbody>      
                        </table> 
                       <button  class="add_more_tag" name="" value="Save"><i class="pe-7s-plus"  /></i></button>
 <div class="addmore" style="display: none">
  					  <?php echo form_open('setting/newtag',array('method'=>'post'));?>
  					  <input type="hidden" value="2" name="id">
                       <input type="text" name="type" class="form-control" />
                        <input type="submit"  name="" value="Save" />
      					  <?php echo form_close(); ?>   </div>         
				  </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
					<div class="header">
				  	  <h4>Lead Status</h4>
				  </div>
				  <div class="content">
				  	  <table class="table table-hover table-striped">
                            <thead>
                                 <th>Existing Tag</th><th></th>
                            </thead>
                            <tbody> <?php if( !empty( $lead_status ) ) : ?>
								<?php foreach( $lead_status as $data ) : ?>  
								<tr><td><?php echo $data->status_value  ?></td>
									<td><a href="<?php echo base_url('setting/'.$data->status_id.'/delete') ?>"><i class="del-doc pe-7s-trash" id=""></i></a></td></tr>
								<?php endforeach; ?>
                            	 <?php else : ?>
                  <tr>
                      <td colspan="13" class="text-center">No Record Found!</td>
                  </tr>
            <?php endif; ?>
                            </tbody>    
                        </table>


  <button  class="add_more_tag" name="" value="Save"><i class="pe-7s-plus" style="font-size: 20px" /></i></button>
 <div class="addmore" style="display: none">
  					  <?php echo form_open('setting/newtag',array('method'=>'post'));?>
  					    <input type="hidden" value="3" name="id">
                        <input type="text" name="type" class="form-control" />
                        <input type="submit"  name="" value="Save" />
      					  <?php echo form_close(); ?>   </div>                         
				  </div>
            </div>
        </div>
         <div class="col-md-3">
            <div class="card">
					<div class="header">
				  	  <h4>Contract Status</h4>
				  </div>
				  <div class="content">
				  	  <table class="table table-hover table-striped">
                            <thead>
                                 <th>Existing Tag</th><th></th>
                            </thead>
                           <tbody> <?php if( !empty( $contract_status ) ) : ?>
								<?php foreach( $contract_status as $data ) : ?>  
								<tr><td><?php echo $data->status_value  ?></td><td><a href="<?php echo base_url('setting/'.$data->status_id.'/delete') ?>"><i class="del-doc pe-7s-trash" id=""></i></a></td></tr>
								<?php endforeach; ?>
                            	 <?php else : ?>
                  <tr>
                      <td colspan="13" class="text-center">No Record Found!</td>
                  </tr>
            <?php endif; ?>
                            </tbody>    
                        </table> 
                        <button  class="add_more_tag" name="" value="Save"><i class="pe-7s-plus" style="font-size: 20px" /></i></button>
  <div class="addmore" style="display: none">
  					  <?php echo form_open('setting/newtag',array('method'=>'post'));?>
  					    <input type="hidden" value="5" name="id">
                        <input type="text" name="type" class="form-control" />
                        <input type="submit"  name="" value="Save" />
      					  <?php echo form_close(); ?>   </div>          
				  </div>
            </div>
        </div>
    </div>
</div>
  
