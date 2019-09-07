<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
	<div class="row page-header-buttons">
		<div class="col-md-12">
			<a href="<?= base_url('lead/' . $sub_base_path . $jobid . '/reports') ?>" class="btn btn-info btn-fill">Back</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="header">
				<h4 class="title">Genrate New Report</h4>
			</div>
		</div>
		<?= form_open('lead/' . $jobid . '/report/save', array('method' => 'post', 'id' => 'report-form')); ?>
		<div class=" col-md-2">
		</div>
		<div class=" col-md-8 img-container">
		</div>
		<div class=" col-md-2"></div>
		<div class="col-md-12">
			<div class="form-element">
				<input type="file" class="jobphoto" name="image[]" id="image" multiple="" />
				<div class="upload-area" id="uploadfile">
					<h1>Drag and Drop file here<br />Or<br />Click to select file</h1>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-element">
				<p class="gallery_photo btn btn-info" style="margin-bottom: 20px;background-color: #f44336;">Add Photo From Gallery</p>
				<input type="submit" value="Genrate PDF" class="btn btn-info btn-fill pull-right" id="gen_pdf" style="display:none;background-color: #f44336;margin-left:20px" />
				<input type="button" style="padding: 6px 30px;" value="Save" id="save" class="btn btn-info btn-fill pull-right" />

			</div>
		</div>
		<?= form_close(); ?>
		<div class="arrow-div" style="display:none">
			<table class="fontdiv marker-box">
				<tr>
					<!--<td><span class="black"></span></td>-->
					<td><i class="fa fa-long-arrow-left fa-stack-2x closeFancybox" alt="long-arrow-left" style="color:black" area-hidden="true"></i></td>
					<td><i class="fa fa-long-arrow-right fa-stack-2x closeFancybox" alt="long-arrow-right" style="color:black" area-hidden="true"></i></td>
					<td><i class="fa fa-long-arrow-up fa-stack-2x closeFancybox" alt="long-arrow-up" style="color:black" area-hidden="true"></i></td>
					<td><i class="fa fa-long-arrow-down fa-stack-2x closeFancybox" alt="long-arrow-down" style="color:black" area-hidden="true"></i></td>
					<td><img src="<?= base_url(); ?>assets/img/darrow-black.png" alt="darrow-black" style="color:black" class="closeFancybox" /></td>
					<td><img src="<?= base_url(); ?>assets/img/circle-black.png" alt="circle-black" class="closeFancybox" /></td>
					<td><img src="<?= base_url(); ?>assets/img/highlight-black.png" alt="highlight" style="color:rgba(0,0,0,0.5)" class="closeFancybox" /></td>
					<td><img src="<?= base_url(); ?>assets/img/rect-black.png" alt="rect" style="color:black" class="closeFancybox" /></td>
					<td><a style="color: black;" href="#text-box" class="various1">Aa</a></td>
				</tr>
				<tr>
					<!--<td><span class="green"></span></td>-->
					<td><i class="fa fa-long-arrow-left fa-stack-2x closeFancybox" alt="long-arrow-left" style="color:green" area-hidden="true"></i></td>
					<td><i class="fa fa-long-arrow-right fa-stack-2x closeFancybox" alt="long-arrow-right" style="color:green" area-hidden="true"></i></td>
					<td><i class="fa fa-long-arrow-up fa-stack-2x closeFancybox" alt="long-arrow-up" style="color:green" area-hidden="true"></i></td>
					<td><i class="fa fa-long-arrow-down fa-stack-2x closeFancybox" alt="long-arrow-down" style="color:green" area-hidden="true"></i></td>
					<td><img src="<?= base_url(); ?>assets/img/darrow-green.png" alt="darrow-green" style="color:green" class="closeFancybox" /></td>
					<td><img src="<?= base_url(); ?>assets/img/circle-green.png" alt="circle-green" class="closeFancybox" /></td>
					<td><img src="<?= base_url(); ?>assets/img/highlight-green.png" alt="highlight" style="color:rgba(0,255,0,0.5)" class="closeFancybox" /></td>
					<td><img src="<?= base_url(); ?>assets/img/rect-green.png" alt="rect" style="color:green" class="closeFancybox" /></td>
					<td><a style="color: green;" href="#text-box" class="various1">Aa</a></td>
				</tr>
				<tr>
					<!--<td><span class="red"></span></td>-->
					<td><i class="fa fa-long-arrow-left fa-stack-2x closeFancybox" alt="long-arrow-left" style="color:red" area-hidden="true"></i></td>
					<td><i class="fa fa-long-arrow-right fa-stack-2x closeFancybox" alt="long-arrow-right" style="color:red" area-hidden="true"></i></td>
					<td><i class="fa fa-long-arrow-up fa-stack-2x closeFancybox" alt="long-arrow-up" style="color:red" area-hidden="true"></i></td>
					<td><i class="fa fa-long-arrow-down fa-stack-2x closeFancybox" alt="long-arrow-down" style="color:red" area-hidden="true"></i></td>
					<td><img src="<?= base_url(); ?>assets/img/darrow-red.png" alt="darrow-red" style="color:red" class="closeFancybox" /></td>
					<td><img src="<?= base_url(); ?>assets/img/circle-red.png" alt="circle-red" class="closeFancybox" /></td>
					<td><img src="<?= base_url(); ?>assets/img/highlight-red.png" alt="highlight" style="color:rgba(255,0,0,0.4)" class="closeFancybox" /></td>
					<td><img src="<?= base_url(); ?>assets/img/rect-red.png" alt="rect" style="color:red" class="closeFancybox" /></td>
					<td><a style="color: red;" href="#text-box" class="various1">Aa</a></td>
				</tr>
				<tr>
					<!--<td><span class="yellow"></span></td>-->
					<td><i class="fa fa-long-arrow-left fa-stack-2x closeFancybox" alt="long-arrow-left" style="color:yellow" area-hidden="true"></i></td>
					<td><i class="fa fa-long-arrow-right fa-stack-2x closeFancybox" alt="long-arrow-right" style="color:yellow" area-hidden="true"></i></td>
					<td><i class="fa fa-long-arrow-up fa-stack-2x closeFancybox" alt="long-arrow-up" style="color:yellow" area-hidden="true"></i></td>
					<td><i class="fa fa-long-arrow-down fa-stack-2x closeFancybox" alt="long-arrow-down" style="color:yellow" area-hidden="true"></i></td>
					<td><img src="<?= base_url(); ?>assets/img/darrow-yellow.png" alt="darrow-yellow" style="color:yellow" class="closeFancybox" /></td>
					<td><img src="<?= base_url(); ?>assets/img/circle-yellow.png" alt="circle-yellow" class="closeFancybox" /></td>
					<td><img src="<?= base_url(); ?>assets/img/highlight.png" alt="highlight" style="color:rgba(255,255,0,0.5)" class="closeFancybox" /></td>
					<td><img src="<?= base_url(); ?>assets/img/rect.png" alt="rect" style="color:yellow" class="closeFancybox" /></td>
					<td><a style="color: yellow;" href="#text-box" class="various1">Aa</a></td>
				</tr>
			</table>
		</div>
		<div class="job_photo_block"><span class="close-box">X</span>
			<?php
			if ($photos != '') {
				foreach ($photos as $photo) : ?>
					<div class="image-div">
						<input type="checkbox" name="img" value="<?= $photo->image_name; ?>">
						<img src="<?= base_url(); ?>assets/job_photo/<?= $photo->image_name; ?>" />
					</div>
				<?php endforeach; ?>
				<p style="width: 100%;float: left;magin-top:40px"><input type="button" name="Upload" value="Upload" class="btn btn-info upload"></p>
			<?php
			} else {
				echo "No Images!";
			} ?>
		</div>
	</div>
</div>
<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/gh/godswearhats/jquery-ui-rotatable@1.1/jquery.ui.rotatable.min.js"></script>
<script src="<?= base_url(); ?>assets/js/html2canvas.js"></script>
<script>
	$(document).ready(function() {
		var baseUrl = '<?= base_url(); ?>';
		var timg = 0;
		var imgbox = [];
		$("html").on("dragover", function(e) {
			e.preventDefault();
			e.stopPropagation();
			$("h1").text("Drag here");
		});

		$("html").on("drop", function(e) {
			e.preventDefault();
			e.stopPropagation();
		});

		// Drag enter
		$('.upload-area').on('dragenter', function(e) {
			e.stopPropagation();
			e.preventDefault();
			$("h1").text("Drop");
		});

		// Drag over
		$('.upload-area').on('dragover', function(e) {
			e.stopPropagation();
			e.preventDefault();
			$("h1").text("Drop");
		});

		$("#uploadfile").click(function() {
			$("#image").click();
		});


		// Drop
		$('.upload-area').on('drop', function(e) {
			e.stopPropagation();
			e.preventDefault();

			$("h1").text("Upload");
			var id = $(this).attr('id');
			var file_data = e.originalEvent.dataTransfer.files;
			var form_data = new FormData();
			var len_files = file_data.length;
			for (var i = 0; i < len_files; i++) {
				form_data.append("image[]", file_data[i]);
			}
			form_data.append('file', file_data[0]);
			$.ajax({
				url: baseUrl + 'lead/<?= $jobid ?>/report/upload',
				dataType: 'text',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function(php_script_response) {
					var str = $.parseJSON(php_script_response);
					var i;
					if (str.img && str.img.length != 0) {
						str = str.img;
						for (i = 0; i < str.length; i++) {
							imgbox.push('#box' + timg);
							$('.img-container').append('<div class="image-box" id="box' + timg + '"><img class="img' + timg + '" src="' + baseUrl + 'assets/job_photo/' + str[i] + '" /><span class="marker">Add Marker</span><i class="fa fa-repeat rotate" id="img' + timg + '" title="' + str[i] + '" ></i><i class="fa fa-times" id="boxclose"  style="display:block"></i></div>');
							timg++;
						}
					} else if (str.error) {
						alert(str.error);
					} else {
						alert('Something went wrong!. File type not ok');
					}
				},
				error: function(jqXHR) {
					if (jqXHR.status == 413) {
						alert('Large File, Max file size limit is 100MB.');
					} else {
						alert('Something went wrong!. File type not ok');
					}
				}
			});
		});


		$("#image").change(function() {
			if (this.files[0].size > 51720000) {
				alert("File Size must be less than or equal to 50MB!");
				this.value = "";
			} else {
				var id = "image";
				var form_data = new FormData();
				len_files = $("#image").prop("files").length;
				for (var i = 0; i < len_files; i++) {
					var file_data = $("#image").prop("files")[i];
					form_data.append("image[]", file_data);
				}
				$.ajax({
					url: baseUrl + 'lead/<?= $jobid ?>/report/upload',
					dataType: 'text',
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,
					type: 'post',
					success: function(php_script_response) {
						var str = $.parseJSON(php_script_response);
						var i;
						if (str.img && str.img.length != 0) {
							str = str.img;
							for (i = 0; i < str.length; i++) {
								imgbox.push('#box' + timg);
								$('.img-container').append('<div class="image-box" id="box' + timg + '"><img class="img' + timg + '" src="' + baseUrl + 'assets/job_photo/' + str[i] + '" /><span class="marker">Add Marker</span><i class="fa fa-repeat rotate" id="img' + timg + '" title="' + str[i] + '"  style="display:block;width: 30px;float: left;position: absolute;top: 0;right: 92px;padding: 3px;color: white;background: black;"></i><i class="fa fa-times" id="boxclose"  style="display:block"></i></div>');
								timg++;
							}
						} else if (str.error) {
							alert(str.error);
						} else {
							alert('Something went wrong!. File type not ok');
						}
					},
					error: function(jqXHR) {
						if (jqXHR.status == 413) {
							alert('Large File, Max file size limit is 100MB.');
						} else {
							alert('Something went wrong!. File type not ok');
						}
					}
				});
			}
		});

		$(".gallery_photo").click(function() {
			$('.job_photo_block').show();
		});

		$(".close-box").click(function() {
			$('.job_photo_block').toggle();
		});

		$(".upload").click(function() {
			var img = [];
			$('.job_photo_block').hide();
			$.each($("input[name='img']:checked"), function() {
				img.push($(this).val());
				imgbox.push('#box' + timg);
				$('.img-container').append('<div class="image-box" id="box' + timg + '"><img class="img' + timg + '" src="' + baseUrl + 'assets/job_photo/' + $(this).val() + '" /><span class="marker">Add Marker</span><i class="fa fa-repeat rotate" id="img' + timg + '" title="' + $(this).val() + '" ></i><i class="fa fa-times" id="boxclose"  style="display:block"></i></div>');
				timg++;
			});
			if (img.length == '') {
				alert('No image is Selected!');
			}
			$('input[name="img"]').prop('checked', false);
		});

		var uid;
		var color;
		var el;
		var ctx;
		var count;
		var isDrawing;
		var _highlight = false;
		$(".fontdiv span").click(function() {
			color = $(this).attr('class');
			$('.fontdiv span').css('border', '1px solid black');
			$(this).css('border', '3px solid gray');
			$(".ptext").css('color', color);
			//$.fancybox.close();
		});

		$('.img-container').on('click', '.marker', function() {
			uid = $(this).parent().attr("id");
			//$('.arrow-div').toggle();
			$(".arrow-div").fancybox({
				ajax: {
					type: "POST",
					data: 'mydata=test'
				}
			}).trigger('click');
		});

		$('td i').click(function() {
			//alert($(this).attr('alt'));
			var arrow = $(this).attr('alt');
			color = $(this).css('color');
			var arrow_count = $('#' + uid + " > span").length;
			var circle_count = $('#' + uid + " > .circle").length;
			var darrow_count = $('#' + uid + " > .darrow").length;
			var rect_count = $('#' + uid + " > .rect").length;
			var count = arrow_count + circle_count + darrow_count + rect_count;

			var img = $('<span>').attr('class', 'fa-stack').html('<span style="color:' + color + '" class="fa fa-' + arrow + ' fa-stack-2x"></span><strong class="fa-stack-1x ' + arrow + '">#' + count + '</strong><i class="fa fa-times" id="textarea-' + count + '" aria-hidden="true"></i>');

			img.appendTo('#' + uid).draggable(); //.rotatable();
			$('#' + uid).append('<div class="textarea-box textarea-' + count + '"><span>Note ' + count + '</span><textarea maxlength="200"  name="' + uid + 'note"></textarea></div>');
		});

		$('td img').click(function() {
			//alert($(this).attr('alt'));
			var item = $(this).attr('alt');
			color = $(this).css('color');
			var res = item.substr(0, 6);
			//alert(res);
			var arrow_count = $('#' + uid + " > span").length;
			var circle_count = $('#' + uid + " > .circle").length;
			var darrow_count = $('#' + uid + " > .darrow").length;
			var rect_count = $('#' + uid + " > .rect").length;
			var count = arrow_count + circle_count + darrow_count + rect_count;

			if (res == 'darrow') {
				//var darrow=$('<div>').attr('class','darrow darrow'+count).html('<span>#'+count+'</span><img src="image/'+item+'.png" id="darrow'+count+'" style="wifht:50px" /><i class="fa fa-window-close" id="textarea-'+count+'" aria-hidden="true"></i>');
				var darrow = $('<div>').attr('class', 'darrow darrow' + count).html('<span>#' + count + '</span><div id="darrow' + count + '" class="drag connector_box" style="background:' + color + ';"><span></span></div><i class="fa fa-times" id="textarea-' + count + '" aria-hidden="true"></i>');
				$('#' + uid).append('<style>#darrow' + count + ':before{border-right-color:' + color + '}#darrow' + count + ':after{border-left-color:' + color + '}<style>');
				darrow.appendTo('#' + uid).draggable().rotatable();;
				$('#darrow' + count).resizable({
					handles: 'e, w'
				});
				$('#' + uid).append('<div class="textarea-box textarea-' + count + '"><span>Note ' + count + '</span><textarea maxlength="200" rows="3"   name="' + uid + 'note"></textarea></div>');
			} else if (res == 'circle') {
				var circle = $('<div>').attr('class', 'circle circle' + count).html('<span>#' + count + '</span><img src="<?= base_url(); ?>assets/img/' + item + '.png" id="circle' + count + '"  /><i class="fa fa-times" id="textarea-' + count + '" aria-hidden="true"></i>');

				circle.appendTo('#' + uid).draggable();
				$('#circle' + count).resizable();
				$('#' + uid).append('<div class="textarea-box textarea-' + count + '"><span>Note ' + count + '</span><textarea maxlength="200" rows="3"  name="' + uid + 'note"></textarea></div>');
			} else if (res == "highli") {
				//	  alert(color);
				var canvas_count = $('#' + uid + " > .canv").length;

				var canvas = $('<canvas>').attr({
					'class': 'canv canv' + count,
					'id': uid + 'can' + canvas_count
				}).css({
					'width': $('#' + uid).width() + 'px',
					'height': $('#' + uid).height() + 'px'
				});

				canvas.appendTo('#' + uid);
				el = document.getElementById(uid + 'can' + canvas_count);

				ctx = el.getContext('2d');
				_highlight = true;
				ctx.strokeStyle = color;
				//alert(ctx);
				$('#' + uid).append('<div class="textarea-box textarea-' + count + '"><span>Highlight Note</span><textarea maxlength="200"  name="' + uid + 'note"></textarea></div>');
			} else {
				var rect = $('<div>').attr('class', 'rect rect' + count).html('<span>#' + count + '</span><div style="background:' + color + ';opacity:0.4; height:60px; width:100px"  id="rect' + count + '" ></div><i class="fa times" id="textarea-' + count + '" aria-hidden="true"></i>');

				rect.appendTo('#' + uid).draggable();
				$('#rect' + count).resizable();
				$('#' + uid).append('<div class="textarea-box textarea-' + count + '"><span>Note ' + count + '</span><textarea maxlength="200"  name="' + uid + 'note"></textarea></div>');
			}
		});

		$(document).on('click', '.fa-times', function() {
			if ($(this).attr('id') == 'boxclose') {
				var id = $(this).parent().attr('id');
				var index = imgbox.indexOf('#' + id);
				if (index > -1) {
					imgbox.splice(index, 1);
				}
			}
			$(this).parent().remove();
			$("." + $(this).attr('id')).remove();
		});

		$('.various1').click(function() {
			color = $(this).css('color');
		});

		$(".various1").fancybox({
			ajax: {
				type: "POST",
				data: 'mydata=test'
			}
		});

		$("#submit-text").click(function() {
			//alert(uid);
			var counttext = $('#' + uid + " > .para").length;
			// alert(count);
			var p = $('<div>').attr('class', 'para').html('<a href="#text-box-update" class="various3" id="para' + counttext + '" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><p style="color:' + color + '" class="para' + counttext + '">' + $('.ptext').val() + '</p>');
			p.appendTo('#' + uid).draggable();
			$.fancybox.close();
			$.fancybox.close();
		});

		var pid;

		$(document).on('click', '.various3', function() {
			var id = $(this).attr('id');
			pid = id;
			var value = $("." + id).html();
			$(".p-u-text").val(value);
			$("#text-box-update").fancybox({}).trigger('click');
		});


		$("#update").click(function() {
			$("." + pid).html($('.p-u-text').val());
			$('.update-message').html('Note updated Sucessfully');
		});

		$(document).on('click', '.closeFancybox', function() {
			$.fancybox.close();
		})

		$('#save').click(function(event) {
			var divcount = imgbox.length;
			var j = 1;
			var k = 0;
			if (divcount > 0) {
				$("#wait").css("display", "block");
				$(this).attr('disabled', true);
				for (var i = 0; i < divcount; i++) {
					div_content = document.querySelector(imgbox[i]);
					div_content1 = $(imgbox[i]).html();
					$('#report-form').append("<input type='hidden' name='imageboxdata[]' value='" + div_content1 + "' />");
					html2canvas(div_content).then(function(canvas) {
						data = canvas.toDataURL('image/jpeg');
						saveimg(data, divcount, j);
						j++;
					});
				}
			} else {
				alert('Please add Images before genrating a Report File');
			}
		});

		function save_img(data, divcount, j) {
			$.post('save_jpg.php', {
				data: data
			}, function(res) {
				if (res != '') {
					if (j == divcount) {
						$('#gen_pdf').toggle();
						$("#wait").css("display", "none");
					}
					$('#myform').append('<input type="hidden" name="imagebox[]" value="' + res + '.jpg" />');
				} else {
					alert('something wrong');
				}
			});
		}

		function saveimg(data, divcount, j) {
			$.ajax({
				url: baseUrl + 'lead/<?= $jobid ?>/report/save-img',
				data: {
					data,
					data
				},
				type: 'post',
				success: function(res) {
					if (res != '') {
						if (j == divcount) {
							$('#gen_pdf').toggle();
							$("#wait").css("display", "none");
						}
						$('#report-form').append('<input type="hidden" name="imagebox[]" value="' + res + '.jpg" />');
					} else {
						alert('something wrong');
					}
				}
			});
		}

		$(document).ajaxStart(function() {
			$("#wait").css("display", "block");
		});

		$(document).ajaxComplete(function() {
			$("#wait").css("display", "none");
		});

		$(".bg-color-box li").click(function() {
			var cla = $(this).attr('class');
			$('body').css('background', cla);

		});

		function marker() {
			ctx.lineWidth = 4;
			ctx.strokeStyle = 'rgba(0,0,0,1)';
		}

		function highlight() {
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

		$(document).on('mousedown', '.canv', function(e) {
			isDrawing = true;
			var pos = getMousePos(el, e);
			if (_highlight) {
				highlight();
				ctx.lineJoin = ctx.lineCap = 'round';

				ctx.moveTo(pos.x, pos.y);
			} else {
				marker();
				ctx.lineJoin = ctx.lineCap = 'round';
				ctx.moveTo(pos.x, pos.y);
			}
		});

		$(document).on('mousemove', '.canv', function(e) {
			var pos = getMousePos(el, e);
			if (isDrawing) {
				if (_highlight) {
					highlight();
					ctx.lineTo(pos.x, pos.y);
					ctx.stroke();
				} else {
					marker();
					ctx.lineTo(pos.x, pos.y);
					ctx.stroke();
				}

			}
		});

		$(document).on('mouseup', '.canv', function() {
			isDrawing = false;
		});

		function getMousePos(el, e) {
			var rect = el.getBoundingClientRect();
			return {
				x: (e.clientX - rect.left) / (rect.right - rect.left) * el.width,
				y: (e.clientY - rect.top) / (rect.bottom - rect.top) * el.height
			};
		}

		$(document).on('click', '.rotate', function() {
			var name = $(this).attr('title');
			var cl = $(this).attr('id');
			$.ajax({
				url: baseUrl + 'lead/<?= $jobid ?>/photo/rotate',
				data: {
					name: name
				},
				type: 'post',
				success: function(php_script_response) {
					var tStamp = +new Date();
					$('.' + cl).attr('src', baseUrl + 'assets/job_photo/' + php_script_response + '?t=' + tStamp);
				}
			});
		});
	});
</script>