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
	   <div class="modal-footer">
       <button type="button" class="btn btn-success btn-fill rotate"  id="rotate">Rotate</button>
      </div>
    </div>
  </div>
</div>
<div id="wait" ><img src='<?php echo base_url();?>assets/img/demo_wait.gif' width="64" height="64" /><br>Loading..</div>


</body>

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
								var len_files=file_data.length;
								for (var i = 0; i < len_files; i++) {
									form_data.append("photo[]", file_data[i]);
								}

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
					}
					
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
								}
							});
						}
					 });
				});
				
				
	// Code for Doc upload

		// Drag enter
    $('.upload-doc-area').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("h1").text("Drop");
    });

    // Drag over
    $('.upload-doc-area').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("h1").text("Drop");
    });

    // Drop
    $('.upload-doc-area').on('drop', function (e) {
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
						form_data.append("doc[]", file_data[i]);
					}

				$.ajax({
						url: baseUrl+'index.php/server/ajaxupload_jobdoc', // point to server-side PHP script     
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
								url: baseUrl+'index.php/server/ajaxsave_jobdoc', // point to server-side PHP script     
								data: {id: id, name:php_script_response},                         
								success: function(photoid){
									//alert(photoid);
									$('.image_div table').append(photoid);
								}
							});
						}
					 });
    });
	
	
			
			 $(".upload-doc-area").click(function(){
        $(".jobdoc").click();
    });
				
				
    
        		$(".jobdoc").change(function () {
					var id= $(this).attr('id');
					 var form_data = new FormData(); 
					//alert(id);					
					len_files = $(".jobdoc").prop("files").length;
					for (var i = 0; i < len_files; i++) {
						var file_data = $(".jobdoc").prop("files")[i];
						form_data.append("doc[]", file_data);
					}
					
					$.ajax({
						url: baseUrl+'index.php/server/ajaxupload_jobdoc', // point to server-side PHP script     
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
								url: baseUrl+'index.php/server/ajaxsave_jobdoc', // point to server-side PHP script     
								data: {id: id, name:php_script_response},                         
								success: function(photoid){
									//alert(photoid);
									$('.image_div table').append(photoid);
								}
							});
						}
					 });
				});

	// code end for Doc Upload
				
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
				
				$(document).on('click', '.del-doc', function () {
					var id = $(this).attr('id');
				                            
					$.ajax({
						url: baseUrl+'index.php/server/deletedoc',
						data: {id: id},        
						type: 'post',
						success: function(php_script_response){
							$('#doc'+id).remove();
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


				
$(document).on('click', '.doc_list span',  function () {
					var id = $(this).attr('class');
					$('#doctext'+id).toggle();
					$('#docp'+id).toggle();
				});

			
 $(document).on('change', '.docname',  function () {
					var data = $(this).val();
					var id = $(this).attr('name');
					$.ajax({
						url: baseUrl+'index.php/server/updatedocname',
						data: {na: data, id: id},        
						type: 'post',
						success: function(php_script_response){

						$('#doctext'+id).toggle();
						$('#docp'+id).toggle();
						$('#docp'+id).html(data);
						}
					 });
				});	
				
			
			$('#leadstatus').change(function(){
				
				$('.status').html($(this).val());
				if($(this).val()=='closed'){
					$('.status').addClass('closed');
				}else{
					$('.status').removeClass('closed');
					$('.status').addClass('open');
				}
				var value=$(this).val();
				var id=$('.hidden_id').val();
				$.ajax({
						url: baseUrl+'lead/updatestatus',
						data: {status: value, id: id},        
						type: 'post',
						success: function(php_script_response){
							
						
						}
					 });
				});

    	});
	</script>
	<script>
	 	$(document).ready(function(){
	  	var imgclass;
	  	 var baseUrl = '<?= base_url(); ?>';
	          $(document).on('click', '.pop', function() {
	              $('.imagepreview').attr('src', $(this).find('img').attr('src'));
				  $('#imagemodal').modal('show');  
				  $('#rotate').attr('name',$(this).attr('alt'));
				  imgclass = $(this).attr('href');
				 // $('.imagepreview').css({'transform': 'rotate(0deg)'});			  
	          });    
	          
          $(document).ajaxStart(function(){
                $("#wait").css("display", "block");
              });
              $(document).ajaxComplete(function(){
                $("#wait").css("display", "none");
              });
			  
			$('#rotate').click(function(){
			var angle = ($('.imagepreview').data('angle') - 90) || -90;
			    $('.imagepreview').css({'transform': 'rotate(' + angle + 'deg)'});
			    var name=$(this).attr('name');
			    $.ajax({
						url: baseUrl+'index.php/server/imagerotate',
						data: {name: name},        
						type: 'post',
						success: function(php_script_response){
							
					 imgclass=imgclass.replace(/#/g, "");
					 $('.imagepreview').data('angle', angle);
					 $('.image_div .img'+imgclass).css({'transform': 'rotate(' + angle + 'deg)'});
							
					
						}
					 });
			});
  });
</script>

</html>
