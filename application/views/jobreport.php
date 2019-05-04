 <div class="container-fluid">
                <div class="row">
                   <div class="col-md-6">
                        <div class="card">
                             <div class="row header">
                                 <div class="col-md-6">
                                         <input class="form-control" id="myInput"  placeholder="Search Job" type="text">
                                 </div>
                                  <div class="col-md-6">
                                 <a href="javascript:window.history.go(-1);" class="btn btn-info btn-fill pull-right">Back</a>
                                    
                                 </div>
                            </div>
                            <div class="header">
                                 <?= $this->session->flashdata('message') ?>
                                <h4 class="title">Photo Report</h4>
                              
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th style="width: 55px;"></th>
                                        <th style="width: 80px;">ID</th>
                                       
                                        <th>Report Link</th>
                                    </thead>
                                    <tbody id="myTable">

                                    <?php if( !empty( $allreport ) ) : ?>
              <?php foreach( $allreport as $jobs ) : 
             // $jobid=$jobs->job_id;
              ?>  
                <tr class="tr<?php echo $jobs->id ?>">
                
                  <td><i class="del-job pe-7s-close" id="<?php echo $jobs->id; ?>"></i></td>
                  <td><?php echo $jobs->id ?></td>
                
                 
                  <td><!--<a href="http://developeradda.tech/project/roofing_latest/pdffile.php?id=33" target="_blank">View</a>-->
                  <a href="<?php echo base_url();?>report/pdffile_single.php?id2=<?php echo $jobs->job_id ?>&id1=<?php echo $jobs->id ?>" target="_blank" class="btn btn-danger btn-right btn-fill">view</a>

                </tr>


                      <?php endforeach; ?>
            <?php else : ?>
               <p class="mb-15">  No Record Found!</p>
            <?php endif; ?>
               


                                  
                                    </tbody>
                                </table>
                                <div class="footer" style="margin-bottom: 10px;">
                                    
                                    <hr>
<a href="<?php echo base_url();?>report/?id=<?php echo $jobid;?>" target="_blank" class="btn btn-danger pull-right" style="margin:5px 10px 10px 0;">Genrate New Report</a> </div>
                            </div>
                        </div>
                    </div>
					   </div>
                        </div>
  
