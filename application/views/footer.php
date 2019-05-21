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

<div id="wait" ><img src='<?php echo base_url();?>assets/img/demo_wait.gif' width="64" height="64" /><br>Loading..</div>


</body>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="<?php echo base_url();?>assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="<?php echo base_url();?>assets/js/demo.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.fancybox.js"></script>
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
          $(document).ajaxStart(function(){
                $("#wait").css("display", "block");
              });
              $(document).ajaxComplete(function(){
                $("#wait").css("display", "none");
              });
		
  });
</script>

</html>
