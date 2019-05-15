$(document).ready(function() {
			
	var timg=0; 		
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

    $("#uploadfile").click(function(){
        $("#image").click();
    });


    // Drop
    $('.upload-area').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();

        $("h1").text("Upload");
        var id =$(this).attr('id');
    	var file_data =  e.originalEvent.dataTransfer.files;
		var form_data = new FormData(); 
		var len_files=file_data.length;
		for (var i = 0; i < len_files; i++) {
			form_data.append("image[]", file_data[i]);
		}
        form_data.append('file', file_data[0]);
	    $.ajax({
				url: 'upload.php', 
				dataType: 'text',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',
				success: function(php_script_response){
					var str=$.parseJSON(php_script_response);
					var i;
					for(i=0;i<str.length;i++){
						$('.img-container').append('<div class="image-box" id="box'+timg+'"><img class="img'+timg+'" src="uploads/'+str[i]+'" /><span class="marker">Add Marker</span><i class="fa fa-window-close"  style="display:block"></i></div>');
						timg++;
					}
				}
		});
					 
					 
    });
	
	
	 $("#image").change(function () {
		var id= "image";
		var form_data = new FormData();                   
		len_files = $("#image").prop("files").length;
		for (var i = 0; i < len_files; i++) {
			var file_data = $("#image").prop("files")[i];
			form_data.append("image[]", file_data);
		}                           
		  $.ajax({
				url: 'upload.php', 
				dataType: 'text',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',
				success: function(php_script_response){
					//alert(php_script_response);
					var str=$.parseJSON(php_script_response);
					var i;
					for(i=0;i<str.length;i++){
						$('.img-container').append('<div class="image-box" id="box'+timg+'"><img class="img'+timg+'" src="uploads/'+str[i]+'" /><span class="marker">Add Marker</span><i class="fa fa-window-close"  style="display:block"></i></div>');
						timg++;
					}
				}
		});
	});
			  
			  
	var uid; 
	var color;
	var el;
	var ctx; 
	var count;
	var isDrawing;
	var _highlight = false;
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
				
	
		
		
	$('td i').click(function(){
				//alert($(this).attr('alt'));
				var arrow=$(this).attr('alt');
				color=$(this).css('color');
				var arrow_count=$('#'+uid+" > span").length;
				var circle_count=$('#'+uid+" > .circle").length;
				var darrow_count=$('#'+uid+" > .darrow").length;
				var rect_count=$('#'+uid+" > .rect").length;
				var count = arrow_count + circle_count + darrow_count + rect_count;
										  
				var img=$('<span>').attr('class','fa-stack').html('<span style="color:'+color+'" class="fa fa-'+arrow+' fa-stack-2x"></span><strong class="fa-stack-1x '+arrow+'">#'+count+'</strong><i class="fa fa-window-close" id="textarea-'+count+'" aria-hidden="true"></i>');
					 	 
				img.appendTo('#'+uid).draggable();//.rotatable();
				$('#'+uid).append('<div class="textarea-box textarea-'+count+'"><span>Note '+count+'</span><textarea maxlength="200"  name="'+uid+'note"></textarea></div>');					
			});
	$('td img').click(function(){
		//alert($(this).attr('alt'));
		var item=$(this).attr('alt');
		color=$(this).css('color');
		var res = item.substr(0, 6); 
		//alert(res);
		var arrow_count=$('#'+uid+" > span").length;
		var circle_count=$('#'+uid+" > .circle").length;
		var darrow_count=$('#'+uid+" > .darrow").length;
		var rect_count=$('#'+uid+" > .rect").length;
		var count = arrow_count + circle_count + darrow_count + rect_count;
								  
		if(res=='darrow')
		{
			//var darrow=$('<div>').attr('class','darrow darrow'+count).html('<span>#'+count+'</span><img src="image/'+item+'.png" id="darrow'+count+'" style="wifht:50px" /><i class="fa fa-window-close" id="textarea-'+count+'" aria-hidden="true"></i>');
			var darrow=$('<div>').attr('class','darrow darrow'+count).html('<span>#'+count+'</span><div id="darrow'+count+'" class="drag connector_box" style="background:'+color+';"><span></span></div><i class="fa fa-window-close" id="textarea-'+count+'" aria-hidden="true"></i>');
		$('#'+uid).append('<style>#darrow'+count+':before{border-right-color:'+color+'}#darrow'+count+':after{border-left-color:'+color+'}<style>');	  
			darrow.appendTo('#'+uid).draggable().rotatable();;
			$('#darrow'+count).resizable({
handles: 'e, w'
});
			$('#'+uid).append('<div class="textarea-box textarea-'+count+'"><span>Note '+count+'</span><textarea maxlength="200" rows="3"   name="'+uid+'note"></textarea></div>');
		}
		else if(res=='circle'){
			var circle=$('<div>').attr('class','circle circle'+count).html('<span>#'+count+'</span><img src="image/'+item+'.png" id="circle'+count+'"  /><i class="fa fa-window-close" id="textarea-'+count+'" aria-hidden="true"></i>');
				  
			circle.appendTo('#'+uid).draggable();
			$('#circle'+count).resizable();
			 $('#'+uid).append('<div class="textarea-box textarea-'+count+'"><span>Note '+count+'</span><textarea maxlength="200" rows="3"  name="'+uid+'note"></textarea></div>');
		}else if(res=="highli"){
			//	  alert(color);
				  var canvas_count=$('#'+uid+" > .canv").length;
				  
				   var canvas=$('<canvas>').attr({'class':'canv canv'+count, 'id':uid+'can'+canvas_count}).css({'width':$('#'+uid).width()+'px','height':$('#'+uid).height()+'px'});
				  
				    canvas.appendTo('#'+uid);
					el = document.getElementById(uid+'can'+canvas_count);
					
					ctx = el.getContext('2d');
					_highlight = true;
					ctx.strokeStyle = color;
					//alert(ctx);
				$('#'+uid).append('<div class="textarea-box textarea-'+count+'"><span>Highlight Note</span><textarea maxlength="200"  name="'+uid+'note"></textarea></div>');
		}else{
			 var rect=$('<div>').attr('class','rect rect'+count).html('<span>#'+count+'</span><div style="background:'+color+';opacity:0.4; height:60px; width:100px"  id="rect'+count+'" ></div><i class="fa fa-window-close" id="textarea-'+count+'" aria-hidden="true"></i>');
				  
				    rect.appendTo('#'+uid).draggable();
					$('#rect'+count).resizable();
					 $('#'+uid).append('<div class="textarea-box textarea-'+count+'"><span>Note '+count+'</span><textarea maxlength="200"  name="'+uid+'note"></textarea></div>');
		}
							
	});
			
			
	$(document).on('click','.fa-window-close',function(){
		if($(this).attr('id')=='boxclose'){
		    timg--;
		}
		$(this).parent().remove();
		$("."+$(this).attr('id')).remove();
	});
			
    $('.various1').click(function(){
       	color=$(this).css('color'); 
    });

	$(".various1").fancybox({
			ajax : {
				type	: "POST",
				data	: 'mydata=test'
			}
	});
					
							
				
	$("#submit-text").click( function(){
		//alert(uid);
		 var counttext=$('#'+uid+" > .para").length;
		// alert(count);
		var p=$('<div>').attr('class','para').html('<a href="#text-box-update" class="various3" id="para'+counttext+'" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><p style="color:'+color+'" class="para'+counttext+'">'+$('.ptext').val()+'</p>');
		p.appendTo('#'+uid).draggable();
		$.fancybox.close();
		$.fancybox.close();
	});
				
	var pid;
			
	$(document).on('click', '.various3', function(){
			var id=$(this).attr('id');
			pid = id;
			var value=$("."+id).html();
			$(".p-u-text").val(value);
			$("#text-box-update").fancybox({
			}).trigger('click');
			
	});
				
				
	$("#update").click( function(){
			$("."+pid).html($('.p-u-text').val());
			$('.update-message').html('Note updated Sucessfully');
			
	});
							
	$(document).on('click','.closeFancybox',function(){
				$.fancybox.close();
	})
				
	$('#save').click(function(event) {
		$("#wait").css("display", "block");
		var divcount=$('.img-container > div').length;
		//alert(divcount);
		var j=1;
		for(var i=0;i<divcount;i++){
		div_content = document.querySelector("#box"+i);
		div_content1 = $("#box"+i).html();
		$('#myform').append("<input type='hidden' name='imageboxdata[]' value='"+div_content1+"' />");
     	html2canvas(div_content).then(function(canvas) {
			data = canvas.toDataURL('image/jpeg');
			save_img(data, divcount, j);
			j++;
	
		});
		}
	});
					
	function save_img(data, divcount, j){
	$.post('save_jpg.php', {data: data}, function(res){
		
		if(res != ''){
		
			if(j == divcount){
			    	$('#gen_pdf').toggle();
			    	$("#wait").css("display", "none");
			}
			$('#myform').append('<input type="hidden" name="imagebox[]" value="'+res+'.jpg" />');
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
										  

	$(".bg-color-box li").click( function(){
		
			var cla=$(this).attr('class');
			$('body').css('background',cla);
			
	});
				
				

//var el = document.getElementById('can2');
//var ctx = el.getContext('2d');
//var isDrawing;
//var _highlight = false;


function marker(){
  ctx.lineWidth = 4;
	ctx.strokeStyle = 'rgba(0,0,0,1)';
}

function highlight(){
  ctx.lineWidth = 15;
 // ctx.strokeStyle = 'rgba(255,255,0,0.4)';
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


document.getElementById("highlight").addEventListener("click", function(){
  _highlight = true;
});
*/
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