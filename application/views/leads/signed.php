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
                                 <?= $this->session->flashdata('message') ?>
                             
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
                                        <th>Contract</th>
                                         <th>Job Type</th>
                                        <th>Status</th>
                                        <th>Closed</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        
                                        
                                       
                                     <!--   <th>Status</th>-->
                                      
                                        
                                    </thead>
                                    <tbody id="myTable">

                                    <?php if( !empty( $leads ) ) : ?>
              <?php $i=1; foreach( $leads as $lead ) : ?>  
                <tr> <!--<td style="width: 30px"><i class="del-doc pe-7s-trash" id=""></i></td>-->
                <td style="width: 30px"><a href="<?php echo base_url('lead/'.$lead->id);?>"><i class="pe-7s-look" style="font-size: 30px" /></a></td>
             
              
                  <td><?php echo $lead->job_number; ?></td>
                  <td><?php echo $lead->job_name ?></td>
                  <td><?php echo $lead->firstname ?></td>
                  <td><?php echo $lead->lastname ?></td>
                  <td><?php echo $lead->address ?></td>
                  <td><?php echo $lead->contract ?></td>
                  <td><?php echo $lead->job ?></td>
                    <td><?php echo $lead->production ?></td>
                    <td><?php echo $lead->closeout ?></td>
                     <td><?php echo $lead->start_at ?></td>
                  
                  <td><?php echo $lead->close_at ?></td>
                 
              
                 </tr>
                  <?php $i++; endforeach; ?>
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
