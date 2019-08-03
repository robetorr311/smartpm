<?php
defined('BASEPATH') or exit('No direct script access allowed');
?> <div class="container-fluid">
                <div class="row">
                   <div class="col-md-12">
                        <div class="card">
                             <div class="row header">
                                 <div class="col-md-6">
                                         <input class="form-control" id="myInput"  placeholder="Search Lead" type="text">
                                 </div>
                                  <div class="col-md-6">
                              
                                
                                 </div>
                            </div>
                            <div class="header">      
                                 <?= $this->session->flashdata('errors') ?>
                             
                            </div>
                            <div class="content table-responsive" style="overflow-x: scroll;width: 100%;">
                                <table class="table table-hover table-striped">
                                    <thead>
                                       <!-- <th></th> -->
                                        <th>View</th>
                                       
                                        <th>Job Number</th>
                                        <th>Lead Name</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Contract</th>
                                        
                                       
                                     <!--   <th>Status</th>-->
                                      
                                        
                                    </thead>
                                    <tbody id="myTable">

                                    <?php if( !empty( $leads ) ) : ?>
              <?php $i=1; foreach( $leads as $lead ) : ?>  
            <?php  $date=  date("Y-m-d h:i:s",strtotime('-30 days')); 
            if(strtotime($lead->date) < strtotime($date) AND strtotime($lead->date)!=0){
            ?>

                <tr> <!--<td style="width: 30px"><i class="del-doc pe-7s-trash" id=""></i></td>-->
                <td style="width: 30px"><a href="<?php echo base_url('lead/'.$lead->id);?>"><i class="pe-7s-look" style="font-size: 30px" /></a></td>
              
              
                  <td><?php echo $lead->job_number; ?></td>
                  <td><?php echo $lead->job_name ?></td>
                  <td><?php echo $lead->firstname ?></td>
                  <td><?php echo $lead->lastname ?></td>
                  <td><?php echo $lead->address ?></td>
                
                   <td><?php echo $lead->lead_status ?></td>
                  <td><?php echo $lead->contract_status ?></td>
                 
              
                 </tr>
                  <?php $i++; } endforeach; ?>
            <?php else : ?>
                  <tr>
                      <td colspan="13" class="text-center">No Record Found!</td>
                  </tr>
            <?php endif; ?>
               


                                  
                                    </tbody>
                                </table>
<div class="pagination">
                          <?= $pagiLinks ?>
                    </div>
                            </div> 
                        </div>
                    </div>
					   </div>
                        </div>
<script>
  $(document).ready(function(){
      $(".del-job").click(function () {
          var id = $(this).attr('id');
                                    
          $.ajax({
            url: baseUrl+'index.php/server/deletejobreport',
            data: {id: id},        
            type: 'post',
            success: function(php_script_response){
              $('.tr'+id).remove();
            }
           });
        });
  });
</script>
