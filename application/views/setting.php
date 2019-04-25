 <div class="container-fluid">
                <div class="row admin"><?= $this->session->flashdata('message') ?>
				
				 <?php if( !empty( $data ) ) : ?>
              <?php foreach( $data->result() as $datas ) : ?> 
                   <div class="col-md-6">
                        <div class="card">
                             
                            <div class="header">
                                 
                                <h4 class="title">Update Logo</h4>
                                <p class="category">Here is a subtitle for this table</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                              <div class="row logo-update">
									<div class="col-md-4">
										 <img style="width:100px" src="<?php echo base_url() ?>assets/img/<?php echo $datas->url ?>" class="logoimg"/>
 
									</div>
									<div class="col-md-6">
										<div class="form-group">
                                                <label>Update logo</label>
												<input class="form-control" type="file" name="logo" id="logo" />
                                               
                                            </div>
										
									</div>
								</div>
                            </div>
                        </div>
                    </div>
					                   <div class="col-md-6">
                        <div class="card">
                             
                            <div class="header">
                              
                                <h4 class="title">Update Favicon</h4>
                                <p class="category">Here is a subtitle for this table</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                               <div class="row favicon-update">
									<div class="col-md-4">
										<img style="width:100px" src="<?php echo base_url() ?>assets/img/<?php echo $datas->favicon ?>" class="favimg" />
									</div>
									<div class="col-md-6">
									<div class="form-group">
                                                <label>Update Favicon</label>
												<input class="form-control" type="file" name="fav"   id="fav" />
                                               
                                            </div>
										
									</div>
								</div>

                            </div>
                        </div>
                    </div>     <div class="col-md-6">
                        <div class="card">
                             
                            <div class="header">
                              
                                <h4 class="title">Admin Color</h4>
                                <p class="category">Here is a subtitle for this table</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                              <ul class="color-ul"><li class="red"></li><li class="black"></li><li class="orange"></li><li class="green"></li></ul>

                            </div>
                        </div>
                    </div> 
                    <?php endforeach; ?>
            <?php else : ?>
               <p class="mb-15">  No Record Found!</p>
            <?php endif; ?>
					   </div>
                        </div>
  
