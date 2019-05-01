 <div class="container-fluid">
    <div class="row dashbord-box">
      
              <?php foreach( $data->result() as $dat ) : ?> 
                          
                           
     
       <div class="col-md-2">
        	<div class="box alert-success">
        		<a href="<?php echo base_url('index.php/dashboard/alllead');?>"><span><?php echo $dat->LEAD; ?></span>
        		<p>Open Leads</p>
        		</a>
        	</div>
        </div>
        <div class="col-md-2">
        	<div class="box alert-warning">
        		<a href="<?php echo base_url('index.php/dashboard/alljob');?>"><span><?php echo $dat->CASH; ?></span>
        		<p>Open Cash Jobs</p></a>
        	</div>
        </div>
        <div class="col-md-2">
        	<div class="box alert-danger">
        		<a href="<?php echo base_url('index.php/dashboard/allinsurance');?>"><span><?php echo $dat->INSURANCE; ?></span>
        		<p>Open Insurance Jobs</p></a>
        	</div>
        </div>
        <div class="col-md-2">
        	<div class="box alert-info">
        		<a href="<?php echo base_url('index.php/dashboard/alllead');?>"><span><?php echo $dat->CASH; ?></span>
        		<p>Complete Jobs</p></a>
        	</div>
        </div>
        <div class="col-md-2">
        	<div class="box alert-warning">
        		<a href="<?php echo base_url('index.php/dashboard/alllead');?>"><span><?php echo $dat->CLOSED; ?></span>
        		<p>Closed Jobs</p></a>
        	</div>
        </div> <?php endforeach; ?>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="card" style="margin-top:30px">
                            <div class="header">
                               <!-- <h4 class="title">Search</h4>-->
                                <input class="form-control" id="myInput"  placeholder="Search Job" type="text">
                            </div>
                          <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr><th>ID</th>
                                    	<th>Name</th>
                                    	<th>Salary</th>
                                    	<th>Country</th>
                                    	<th>City</th>
                                    </tr></thead>
                                    <tbody>
                                        <tr>
                                        	<td>1</td>
                                        	<td>Dakota Rice</td>
                                        	<td>$36,738</td>
                                        	<td>Niger</td>
                                        	<td>Oud-Turnhout</td>
                                        </tr>
                                        <tr>
                                        	<td>2</td>
                                        	<td>Minerva Hooper</td>
                                        	<td>$23,789</td>
                                        	<td>Curaçao</td>
                                        	<td>Sinaai-Waas</td>
                                        </tr>
                                        <tr>
                                        	<td>3</td>
                                        	<td>Sage Rodriguez</td>
                                        	<td>$56,142</td>
                                        	<td>Netherlands</td>
                                        	<td>Baileux</td>
                                        </tr>
                                        <tr>
                                        	<td>4</td>
                                        	<td>Philip Chaney</td>
                                        	<td>$38,735</td>
                                        	<td>Korea, South</td>
                                        	<td>Overland Park</td>
                                        </tr>
                                        <tr>
                                        	<td>5</td>
                                        	<td>Doris Greene</td>
                                        	<td>$63,542</td>
                                        	<td>Malawi</td>
                                        	<td>Feldkirchen in Kärnten</td>
                                        </tr>
                                        <tr>
                                        	<td>6</td>
                                        	<td>Mason Porter</td>
                                        	<td>$78,615</td>
                                        	<td>Chile</td>
                                        	<td>Gloucester</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>

	</div>
	</div>
  
