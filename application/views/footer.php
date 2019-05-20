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


				


			
	
/*  Lead Status Update */				 
			$('#lead').change(function(){
				var value=$(this).val();
				var id=$('.hidden_id').val();
				var status=$(this).attr('id');
				var contract_status=$('#contract').val();
				if(value=='open'){
					$('#contract').removeAttr('disabled');
					$('#job').removeAttr('disabled');
					$.ajax({
						url: baseUrl+'lead/updatestatus',
						data: {value: value, id: id, status:status},        
						type: 'post',
						success: function(php_script_response){
							$('.'+status).html(value);
							}
					});
				}else if(value!=open && contract_status!='signed'){
					$('#contract').prop('disabled', 'disabled');	
					$('#job').prop('disabled', 'disabled');
					$.ajax({
						url: baseUrl+'lead/updatestatus',
						data: {value: value, id: id, status:status},        
						type: 'post',
						success: function(php_script_response){
							$('.'+status).html(value);
							}
					});
				}else{
					alert('Contract Already Signed. First Unsigned Contract than update lead Status!');
				}
			});

			$('.lead-status').change(function(){
				var value=$(this).val();
				var id=$('.hidden_id').val();
				var status=$(this).attr('id');

				var lead_status=$('#lead').val();
				var contract_status=$('#contract').val();
			
					if(lead_status=='open'){
						$.ajax({
								url: baseUrl+'lead/updatestatus',
								data: {value: value, id: id, status:status},        
								type: 'post',
								success: function(php_script_response){
								
									$('.'+status).html(value);
							
								}
							 });
					}else{

						alert('Job Status Must be Open Before Sign a Contract!');
					}
				
				});

/*  add user to team */

			$('#add_team').change(function(){
				
				var teamid=$(this).val();
				var id=$('.hidden_id').val();
				$.ajax({
						url: baseUrl+'user/adduser',
						data: {teamid: teamid, userid: id},        
						type: 'post',
						success: function(php_script_response){
						

							
						}
					 });
				});


			$('.add_more_tag').click(function(){

				$(this).siblings('.addmore').toggle();

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
