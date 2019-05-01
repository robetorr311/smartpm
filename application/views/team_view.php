 <div class="container-fluid">
                <div class="row">
                   <div class="col-md-8">
                        <div class="card">
                             <div class="row header">
                                
                                  <div class="col-md-6">
                            <?php foreach( $teams as $team ) : ?>  
                             <p> Team Name:<span style="font-size: 24px;color: brown;"> <?php echo $team->team_name; ?></span></p>
                              <p>  Remark: <?php echo $team->remark; ?></p>
                            <?php endforeach; ?>
                                 </div>
                            </div>
                            <div class="header">
                                 <?= $this->session->flashdata('message') ?>
                                <h4 class="title">Users</h4>
                                
                            </div>
                            <div class="content table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Team Name</th>
                                        <th>Remark</th>
                                       
                                        
                                       
                                      
                                        
                                    </thead>
                                    <tbody id="myTable">

                                  
             
        


                     


                                  
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
					   </div>
                        </div>
  
