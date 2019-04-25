</div>

                   

        <footer class="footer">
            <div class="container-fluid">
               
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> Roofing
                </p>
            </div>
        </footer>

    </div>
</div>
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview" style="width: 100%;">
      </div>
    </div>
  </div>
</div>
<div id="wait" ><img src='<?php echo base_url();?>assets/img/demo_wait.gif' width="64" height="64" /><br>Loading..</div>


</body>

    <!--   Core JS Files   -->
    <script src="<?php echo base_url();?>assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap.min.js" type="text/javascript"></script>
    <!--  Notifications Plugin    -->
    <script src="<?php echo base_url();?>assets/js/bootstrap-notify.js"></script>
    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="<?php echo base_url();?>assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="<?php echo base_url();?>assets/js/demo.js"></script>

	<script type="text/javascript">
    	$(document).ready(function(){
var baseUrl = '<?= base_url(); ?>';
    		 $("#myInput").on("keyup", function() {
			    var value = $(this).val().toLowerCase();
			    $("#myTable tr").filter(function() {
			      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			    });
			  });
			
		$(".admin input[type=file]").change(function () {
					var id= $(this).attr('id');
					//alert(id);					
					var file_data = $('#'+id).prop('files')[0];   
					var form_data = new FormData();      					
					form_data.append('file', file_data);
					//form_data.append('file', file_data);
					//alert(form_data);                             
					$.ajax({
						url: baseUrl+'index.php/server/ajaxupload', // point to server-side PHP script     
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
								url: baseUrl+'index.php/server/ajaxsave', // point to server-side PHP script     
								data: {id: id, name:php_script_response},                         
								success: function(php_script_response){
									$('.'+id+'img').attr('src',baseUrl+'assets/img/'+php_script_response ); // 
								alert();
								}
							});
						}
					 });
				});
				
				
							    $("html").on("dragover", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $("h1").text("Drag here");
    });

    $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

    // Drag enter
    $('.upload-area').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("h1").text("Drop");
    });

    // Drag over
    $('.upload-area').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("h1").text("Drop");
    });

    // Drop
    $('.upload-area').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();
       // alert($(this).attr('id'));
        $("h1").text("Upload");
			var id =$(this).attr('id');
        	var file_data =  e.originalEvent.dataTransfer.files;
				
					 var form_data = new FormData(); 
					//alert(id);					
					//len_files = $(".jobphoto").prop("files").length;
					var len_files=file_data.length;
					for (var i = 0; i < len_files; i++) {
						//var file_data = $(".jobphoto").prop("files")[i];
						form_data.append("photo[]", file_data[i]);
						//var construc = '<img width="200px" height="200px" src="' +  window.URL.createObjectURL(file_data) + '" alt="'  +  file_data.name  + '" />';
						//$('.preview').append(construc); 
					}

       	//var file_data = $('#'+id).prop('files')[0];   
				//	var form_data = new FormData();      					
				//	form_data.append('file', file_data);
					//form_data.append('file', file_data);
					//alert(form_data);                             
				$.ajax({
						url: baseUrl+'index.php/server/ajaxupload_jobphoto', // point to server-side PHP script     
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
								url: baseUrl+'index.php/server/ajaxsave_jobphoto', // point to server-side PHP script     
								data: {id: id, name:php_script_response},                         
								success: function(photoid){
									//alert(photoid);
									$('.image_div').append(photoid);
									//$('.image_div').append('<div id="ph'+photoid+'" class="col-md-2"><i class="del-photo pe-7s-close" id="'+photoid+'"></i><a href="#" class="pop"><img src="'+baseUrl+'assets/job_photo/'+php_script_response+'" /></a></div>'); // 
								}
							});
						}
					 });

	   
	   
					 
					 
    });
	
	
			
			 $(".upload-area").click(function(){
        $(".jobphoto").click();
    });
				
				
    
        		$(".jobphoto").change(function () {
					var id= $(this).attr('id');
					 var form_data = new FormData(); 
					//alert(id);					
					len_files = $(".jobphoto").prop("files").length;
					for (var i = 0; i < len_files; i++) {
						var file_data = $(".jobphoto").prop("files")[i];
						form_data.append("photo[]", file_data);
						//var construc = '<img width="200px" height="200px" src="' +  window.URL.createObjectURL(file_data) + '" alt="'  +  file_data.name  + '" />';
						//$('.preview').append(construc); 
					}
					
					
				//alert();
		
				//	form_data.append('file', file_data);
					//form_data.append('file', file_data);
					//alert(form_data);                             
					$.ajax({
						url: baseUrl+'index.php/server/ajaxupload_jobphoto', // point to server-side PHP script     
						dataType: 'text',  // what to expect back from the PHP script, if anything
						cache: false,
						contentType: false,
						processData: false,
						data: form_data,                         
						type: 'post',
						success: function(php_script_response){
							alert(php_script_response); 
							$.ajax({
								type: 'POST',
								url: baseUrl+'index.php/server/ajaxsave_jobphoto', // point to server-side PHP script     
								data: {id: id, name:php_script_response},                         
								success: function(photoid){
									//alert(photoid);
									$('.image_div').append(photoid);
									//$('.image_div').append('<div id="ph'+photoid+'" class="col-md-2"><i class="del-photo pe-7s-close" id="'+photoid+'"></i><a href="#" class="pop"><img src="'+baseUrl+'assets/job_photo/'+php_script_response+'" /></a></div>'); // 
								}
							});
						}
					 });
				});
				
				
				$(".color-ul li").click(function () {
					var color = $(this).attr('class');
				                            
					$.ajax({
						url: baseUrl+'index.php/server/ajaxcolor',
						data: {color: color},        
						type: 'post',
						success: function(php_script_response){
							$('.sidebar').attr('data-color',php_script_response);
						}
					 });
				});
				
				$(document).on('click', '.del-photo', function () {
					var id = $(this).attr('id');
				                            
					$.ajax({
						url: baseUrl+'index.php/server/deletephoto',
						data: {id: id},        
						type: 'post',
						success: function(php_script_response){
							$('#ph'+id).remove();
						}
					 });
				});
				
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
<script>
  $(function() {
          $(document).on('click', '.pop', function() {
              $('.imagepreview').attr('src', $(this).find('img').attr('src'));
              $('#imagemodal').modal('show');   
          });    
          
          $(document).ajaxStart(function(){
                                            $("#wait").css("display", "block");
                                          });
                                          $(document).ajaxComplete(function(){
                                            $("#wait").css("display", "none");
                                          });
  });
</script>

</html>
