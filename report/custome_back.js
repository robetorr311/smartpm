$(document).ready(function() {
			
			  var timg=0;
   /*           $("input[name=image]").change(function () {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
					timg++;
                        var img = $('<img>').attr('src', e.target.result);
                        $('.img-container').append('<div class="image-box" id="box'+timg+'"><img class="img'+timg+'" src="'+e.target.result+'" /><span class="marker">Add Marker</span></div>');
                    };
                    reader.readAsDataURL(this.files[0]);
                }
			  });
			 
			*/  
			
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

        $("h1").text("Upload");

        	var file_data =  e.originalEvent.dataTransfer.files;
			var form_data = new FormData(); 
//alert(file_data[0]);					

        form_data.append('file', file_data[0]);

       // uploadData(fd);
	   
	   $.ajax({
						url: 'upload.php', // point to server-side PHP script 
						dataType: 'text',  // what to expect back from the PHP script, if anything
						cache: false,
						contentType: false,
						processData: false,
						data: form_data,                         
						type: 'post',
						success: function(php_script_response){
							//alert(php_script_response); // display response from the PHP script, if any
							timg++;
                       // var img = $('<img>').attr('src', e.target.result);
                        $('.img-container').append('<div class="image-box" id="box'+timg+'"><img class="img'+timg+'" src="uploads/'+php_script_response+'" /><span class="marker">Add Marker</span></div>');
						}
					 });
					 
					 
    });
	
	
			
			 $("#uploadfile").click(function(){
        $("#image").click();
    });
			
			  
		   $("input[name=image]").change(function () {
					var file_data = $('#image').prop('files')[0];   
					var form_data = new FormData();                  
					form_data.append('file', file_data);
					//alert(form_data);                             
					$.ajax({
						url: 'upload.php', // point to server-side PHP script     
						dataType: 'text',  // what to expect back from the PHP script, if anything
						cache: false,
						contentType: false,
						processData: false,
						data: form_data,                         
						type: 'post',
						success: function(php_script_response){
							//alert(php_script_response); // display response from the PHP script, if any
							timg++;
						//	alert();
                       // var img = $('<img>').attr('src', e.target.result);
                  $('.img-container').append('<div class="image-box" id="box'+timg+'"><img class="img'+timg+'" src="uploads/'+php_script_response+'" /><span class="marker">Add Marker</span></div>');
				 // alert();
						}
					 });
				});
		
			  
			  
			  
			  
			  
			  
			  
			 var uid; 
			 var color;
			 var el;
			 var ctx; 
			$(".fontdiv span").click( function(){
						color =$(this).attr('class');
						
						$('.fontdiv span').css('border','1px solid black');
						$(this).css('border','3px solid gray');
						$(".ptext").css('color',color);
						//$.fancybox.close();
				});
					
					
			 
			 $('.img-container').on('click', '.marker', function(){
					  uid = $(this).parent().attr("id");
					  //$('.arrow-div').toggle();
					  $(".arrow-div").fancybox({
						ajax : {
						type	: "POST",
						data	: 'mydata=test'
						}
					 }).trigger('click');
				});
				
			 $(".arrow-div img").click(function() {
					  //var pid = $(this).parent('div').attr("id");
					  var count=$('#'+uid+" > span").length;
					  var cl=$(this).attr("id");
					 
					  //var img = $('<img>').attr({src:'image/'+cl+'.png' , id:'icon'});
					  
					  if(cl=="minus"){ 
					  
							  var line=$('<div>').attr('class','line line'+count).html('<img src="image/minus.png" id="img'+count+'" /><i class="fa fa-window-close" aria-hidden="true"></i>');
							  //var img=$('<img>').attr({'src':'image/minus.png', 'id':'img'+count});
							  line.appendTo('#'+uid).draggable()//.draggable().resizable();
								$('.divd').draggable();
								$('#img'+count).resizable();
								
					  }else if(cl=="circle"){
						   var circle=$('<div>').attr('class','circle circle'+count).html('<img src="image/circle.png" id="circle'+count+'" style="wifht:50px" /><i class="fa fa-window-close" aria-hidden="true"></i>');
						  
						    circle.appendTo('#'+uid).draggable();
							$('#circle'+count).resizable();
							 var txt=$('#'+uid+" > .circle").length;
							 $('#'+uid).append('<textarea maxlength="200" placeholder="Add Note" name="'+uid+'circlenote">#Circle'+txt+'</textarea>');
							
					  }else if(cl=="darrow"){
						   var darrow=$('<div>').attr('class','darrow darrow'+count).html('<img src="image/darrow.png" id="darrow'+count+'" style="wifht:50px" /><i class="fa fa-window-close" aria-hidden="true"></i>');
						  
						    darrow.appendTo('#'+uid).draggable().rotatable();;
							$('#darrow'+count).resizable();
							 var txt=$('#'+uid+" > .darrow").length;
							 $('#'+uid).append('<textarea maxlength="200" placeholder="Add Note" name="'+uid+'linenote">#Line'+txt+'</textarea>');
							
					  }else if(cl=="rect"){
						   var circle=$('<div>').attr('class','rect rect'+count).html('<div style="background:rgba(255,255,0,.4);height:60px;width:100px"  id="rect'+count+'" ></div><i class="fa fa-window-close" aria-hidden="true"></i>');
						  
						    circle.appendTo('#'+uid).draggable();
							$('#rect'+count).resizable();
							
					  }else if(cl=="highlight"){
						  
						  var canvas_count=$('#'+uid+" > .canv").length;
						  
						   var canvas=$('<canvas>').attr({'class':'canv canv'+count, 'id':uid+'can'+canvas_count}).css({'width':$('#'+uid).width()+'px','height':$('#'+uid).height()+'px'});
						  
						    canvas.appendTo('#'+uid);
							el = document.getElementById(uid+'can'+canvas_count);
							
							ctx = el.getContext('2d');
							//alert(ctx);
					  }else {
					 
					 var img=$('<span>').attr('class','fa-stack').html('<span style="color:'+color+'" class="fa fa-'+cl+' fa-stack-2x"></span><strong class="fa-stack-1x '+cl+'">'+count+'</strong><i class="fa fa-window-close" aria-hidden="true"></i>');
					 
					 
					 
					  img.appendTo('#'+uid).draggable();//.rotatable();
					  $('#'+uid).append('<textarea maxlength="200" placeholder="Add Note" name="'+uid+'note">#'+count+'</textarea>');
					  }
					 // img.appendTo('#'+uid).draggable();//.rotatable();
					 // $('.arrow-div').toggle();
					 var txt=$('#'+uid+" > textarea").length;
					if(txt!=1){	 
					// $('#'+uid).append('<textarea placeholder="Add Note" name="'+uid+'note"></textarea>');
					}
				 $.fancybox.close(true);
				});
			
				$(document).on('click','.fa-window-close',function(){
				
					$(this).parent().css('display','none');
					
				});
			
				$("#various3").fancybox({
						ajax : {
							type	: "POST",
							data	: 'mydata=test'
						}
					});
					
							
				
				$("#submit-text").click( function(){
					//alert(uid);
					 var count=$('#'+uid+" > .para").length;
					// alert(count);
	var p=$('<div>').attr('class','para').html('<a href="#text-box-update" class="various3" id="para'+count+'" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><p style="color:'+color+'" class="para'+count+'">'+$('.ptext').val()+'</p>');
					p.appendTo('#'+uid).draggable();
					$.fancybox.close();
					$.fancybox.close();
				});
				
				
			var pid;
			
				$(document).on('click', '.various3', function(){
					var id=$(this).attr('id');
						
					pid = id;
				//	alert(pid);
					var value=$("."+id).html();
					$(".p-u-text").val(value);
					$("#text-box-update").fancybox({
					}).trigger('click');
					
			});
				
				
				$("#update").click( function(){
					//$.fancybox.close();
						$("."+pid).html($('.p-u-text').val());
						$('.update-message').html('Note updated Sucessfully');
						
				});
				
				
					
				 $(document).on('click','.closeFancybox',function(){
							$.fancybox.close();
					})
				
				$('#save').click(function(event) {

					//event.preventDefault(); //this will prevent the default submit
					var divcount=$('.img-container > div').length;
					//alert(divcount);
					var j=1;
					for(var i=1;i<=divcount;i++){
					div_content = document.querySelector("#box"+i);
					div_content1 = $("#box"+i).html();
					$('#myform').append("<input type='hidden' name='imageboxdata[]' value='"+div_content1+"' />");
			     	html2canvas(div_content).then(function(canvas) {
						data = canvas.toDataURL('image/jpeg');
						
						save_img(data, divcount, j);
						j++;
				
					});
					}

				//	$('#gen_pdf').toggle();
					// $(this).unbind('submit').submit(); // continue the submit unbind preventDefault
					});
					
					function save_img(data, divcount, j){
					//ajax method.
					//	alert(j);
						//	alert(divcount);
					$.post('save_jpg.php', {data: data}, function(res){
						//if the file saved properly, trigger a popup to the user.
						if(res != ''){
						
							if(j == divcount){
							    	$('#gen_pdf').toggle();
							}
							$('#myform').append('<input type="hidden" name="imagebox[]" value="'+res+'.jpg" />');
							
						//	yes = confirm('File saved in output folder, click ok to see it!');
						//	if(yes){
						//		location.href =document.URL+'output/'+res+'.jpg';
						//	}
						}
						else{
							alert('something wrong');
						}
					});
					}
					
										 $(document).ajaxStart(function(){
                                            $("#wait").css("display", "block");
                                          });
                                          $(document).ajaxComplete(function(){
                                            $("#wait").css("display", "none");
                                          });
										  
					
					
		/*				
				$('.image-box1').mousemove(function( e ){
					//alert();
				//	var x = event.pageX; var y = event.pageY;
					
					 var offset = $(this).offset();
  var relativeX = (e.pageX - offset.left);
  var relativeY = (e.pageY - offset.top);

  //alert("X: " + relativeX + "  Y: " + relativeY)
  
					$(this).append('<span style="position:absolute;height:20px;width:20px;background:rgba(255,255,0,.9);left:'+relativeX+'px;top:'+relativeY+'px"></span>');
				});	
				
				//var x,y;
		/*		$('#brush1').draggable({
					      drag: function(e) {
							
						    var offset = $(this).offset();
							var relativeX =$(this).css('top');// (e.pageX - offset.left);
							var relativeY =$(this).css('left');// (e.pageY - offset.top);
							//alert("X: " + relativeX + "  Y: " + relativeY)
							
						//	if(x>){
							$('.image-box').append('<span style="border-radius:20px;position:absolute;height:20px;width:20px;background:rgba(255,255,0,.9);left:'+relativeY+';top:'+relativeX+'"></span>');
							//}
							//x=relativeX;
							//y=relativeY;
				        }
				});
	  */
				$(".bg-color-box li").click( function(){
					
						var cla=$(this).attr('class');
						$('body').css('background',cla);
						
				});
				
				//canvas
				
				
				
				
		

//var el = document.getElementById('can2');
//var ctx = el.getContext('2d');
var isDrawing;
var _highlight = false;


function marker(){
  ctx.lineWidth = 4;
	ctx.strokeStyle = 'rgba(0,0,0,1)';
}

function highlight(){
  ctx.lineWidth = 15;
  ctx.strokeStyle = 'rgba(255,255,0,0.4)';
  ctx.globalCompositeOperation = 'destination-atop';
}

/*
document.getElementById("marker").addEventListener("click", function(){
  _highlight = false;
});

document.getElementById("clear").addEventListener("click", function(){
  ctx.clearRect(0, 0, el.width, el.height);
  ctx.restore();
  ctx.beginPath();
});

*/
document.getElementById("highlight").addEventListener("click", function(){
  _highlight = true;
});

$(document).on('mousedown','.canv',function(e) {
	
  isDrawing = true;
  var pos = getMousePos(el, e);
  if(_highlight){
		highlight();
  	ctx.lineJoin = ctx.lineCap = 'round';
	 
	  ctx.moveTo(pos.x, pos.y);  
  }else{
    marker();
    ctx.lineJoin = ctx.lineCap = 'round';
	  ctx.moveTo(pos.x, pos.y);
  }
});
$(document).on('mousemove','.canv',function(e) {
	var pos = getMousePos(el, e);
  if (isDrawing) {
    if(_highlight){
      highlight();
	  
    	ctx.lineTo(pos.x, pos.y);
  	  ctx.stroke();  
    }else{
      marker();
      ctx.lineTo(pos.x, pos.y);
	    ctx.stroke();
    }
    
  }
});
$(document).on('mouseup','.canv',function() {
  isDrawing = false;
});


function getMousePos(el, e) {
      var rect = el.getBoundingClientRect();
    return {
        x: (e.clientX - rect.left) / (rect.right - rect.left) * el.width,
        y: (e.clientY - rect.top) / (rect.bottom - rect.top) * el.height
    };
}

});