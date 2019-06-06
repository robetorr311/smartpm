<?php
defined('BASEPATH') or exit('No direct script access allowed');?>
<div class="container-fluid">
    <div class="row admin"><?= $this->session->flashdata('message') ?>			
			  <?php if( !empty( $data ) ) : ?>
              <?php foreach( $data->result() as $datas ) : ?> 
                   <div class=""><div class="col-md-6" >
                        <div class="card" style="min-height:200px"> 
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
					<div class="col-md-6" >
                        <div class="card" style="min-height:200px">  
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
                    </div>     </div>   
                    <div class="col-md-6" >
                        <div class="card" style="min-height:200px">
                            <div class="header">
                                <h4 class="title">Admin Color</h4>
                                <p class="category">Here is a subtitle for this table</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                              <ul class="color-ul">
                                  <li class="red"></li>
                                  <li class="black"></li>
                                  <li class="orange"></li>
                                  <li class="green"></li>
                              </ul>
                            </div>
                        </div>
                    </div> 
            <?php endforeach; ?>
            <?php else : ?>
               <p class="mb-15">  No Record Found!</p>
            <?php endif; ?>
	</div> 
</div>
<script>
    $(document).ready(function(){
        var baseUrl = '<?= base_url(); ?>';
        $(".admin input[type=file]").change(function () {
          var id= $(this).attr('id');
          //alert(id);          
          var file_data = $('#'+id).prop('files')[0];   
          var form_data = new FormData();               
          form_data.append('file', file_data);
          $.ajax({
            url: baseUrl+'setting/ajaxupload', // point to server-side PHP script     
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(php_script_response){
              //alert(php_script_response); 
              $.ajax({
                type: 'POST',
                url: baseUrl+'setting/ajaxsave', // point to server-side PHP script     
                data: {id: id, name:php_script_response},                         
                success: function(php_script_response){
                  $('.'+id+'img').attr('src',baseUrl+'assets/img/'+php_script_response ); // 
              
                }
              });
            }
           });
        });
        
        
      
        
    
  
        
      
       $(".color-ul li").click(function () {
          var color = $(this).attr('class');
                                    
          $.ajax({
            url: baseUrl+'setting/ajaxcolor',
            data: {color: color},        
            type: 'post',
            success: function(php_script_response){
              $('.sidebar').attr('data-color',php_script_response);
            }
           });
        });
        
    });
</script>
  
