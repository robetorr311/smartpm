<?php
session_start();
include('connection.php');
$baseUrl="https://smartpm.app";
if($_GET['id']!=''){	
?>
<html>
	<head>
		<title>Roofing Project</title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/png" href="<?php echo $baseUrl; ?>/assets/img/<?php echo $favicon; ?>"/>
		<link  rel="stylesheet" type="text/css" href="jquery-ui.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">	
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body style="background: #12A5A5;text-align: center;">
		<div class="logo">
			<img src="<?php echo $baseUrl; ?>/assets/img/<?php echo $logo; ?>" />
		</div>
		<form id="myform"  method="post" action="savedata.php">
			<!--<div class="form-element in">
			<input type="text" name="firstname" placeholder="First Name" required>
			</div>
			<div class="form-element in">
			<input type="text" name="lastname" placeholder="Last Name" required>
			</div>
			<div class="form-element in">
			<input type="text" name="address" placeholder="Address" required>
			</div>
			<div class="form-element in">
			<input type="text" name="phone" placeholder="Phone" required>
			</div> -->
			<div class="img-container">
			
			</div>
			<input type="hidden" name="id" placeholder="" value="<?php echo $_GET['id']; ?>">
			<div class="form-element">
				<input type="file" name="image" id="image" />
				<div class="upload-area"  id="uploadfile">
					<h1>Drag and Drop file here<br/>Or<br/>Click to select file</h1>
				</div>
			</div>
			<div class="form-element">
			<input type="button" value="Save" id="save" style="width:200px;float:left;"/><input type="submit" value="Genrate PDF" id="gen_pdf" style="width:200px;float:left;display:none"  />
			</div>
		</form>
		
		<div class="arrow-div" style="display:none">
		    <table class="fontdiv marker-box">
			<tr >
				<!--<td><span class="black"></span></td>-->
				<td><i class="fa fa-long-arrow-left fa-stack-2x closeFancybox" alt="long-arrow-left"   style="color:black" area-hidden="true" ></i></td>
				<td><i class="fa fa-long-arrow-right fa-stack-2x closeFancybox" alt="long-arrow-right" style="color:black" area-hidden="true" ></i></td>
				<td><i class="fa fa-long-arrow-up fa-stack-2x closeFancybox" alt="long-arrow-up" style="color:black" area-hidden="true" ></i></td>
				<td><i class="fa fa-long-arrow-down fa-stack-2x closeFancybox" alt="long-arrow-down" style="color:black" area-hidden="true" ></i></td>
				<td><img src="image/darrow-black.png" alt="darrow-black" style="color:black" class="closeFancybox"/></td>
				<td><img src="image/circle-black.png" alt="circle-black" class="closeFancybox"/></td>
				<td><img src="image/highlight-black.png" alt="highlight" style="color:rgba(0,0,0,0.5)" class="closeFancybox"/></td>
				<td><img src="image/rect-black.png" alt="rect" style="color:black" class="closeFancybox"/></td>
				<td><a style="color: black;"   href="#text-box" class="various1">Aa</a></td>
			</tr>
			<tr>
				<!--<td><span class="green"></span></td>-->
			<td><i class="fa fa-long-arrow-left fa-stack-2x closeFancybox" alt="long-arrow-left" style="color:green" area-hidden="true" ></i></td>
				<td><i class="fa fa-long-arrow-right fa-stack-2x closeFancybox" alt="long-arrow-right" style="color:green" area-hidden="true" ></i></td>
				<td><i class="fa fa-long-arrow-up fa-stack-2x closeFancybox" alt="long-arrow-up" style="color:green" area-hidden="true" ></i></td>
				<td><i class="fa fa-long-arrow-down fa-stack-2x closeFancybox"  alt="long-arrow-down"  style="color:green" area-hidden="true" ></i></td>
				<td><img src="image/darrow-green.png" alt="darrow-green" style="color:green"  class="closeFancybox"/></td>
				<td><img src="image/circle-green.png" alt="circle-green" class="closeFancybox"/></td>
				<td><img src="image/highlight-green.png" alt="highlight" style="color:rgba(0,255,0,0.5)" class="closeFancybox"/></td>
				<td><img src="image/rect-green.png" alt="rect" style="color:green" class="closeFancybox"/></td>
				<td><a style="color: green;"   href="#text-box" class="various1">Aa</a></td>
			</tr>
			<tr>
				<!--<td><span class="red"></span></td>-->
				<td><i class="fa fa-long-arrow-left fa-stack-2x closeFancybox" alt="long-arrow-left" style="color:red" area-hidden="true" ></i></td>
				<td><i class="fa fa-long-arrow-right fa-stack-2x closeFancybox" alt="long-arrow-right" style="color:red" area-hidden="true" ></i></td>
				<td><i class="fa fa-long-arrow-up fa-stack-2x closeFancybox" alt="long-arrow-up" style="color:red" area-hidden="true" ></i></td>
				<td><i class="fa fa-long-arrow-down fa-stack-2x closeFancybox"  alt="long-arrow-down"  style="color:red" area-hidden="true" ></i></td>
				<td><img src="image/darrow-red.png" alt="darrow-red" style="color:red" class="closeFancybox"/></td>
				<td><img src="image/circle-red.png" alt="circle-red" class="closeFancybox"/></td>
				<td><img src="image/highlight-red.png" alt="highlight" style="color:rgba(255,0,0,0.4)" class="closeFancybox"/></td>
				<td><img src="image/rect-red.png" alt="rect" style="color:red" class="closeFancybox"/></td>
					<td><a style="color: red;"  href="#text-box" class="various1">Aa</a></td>
			</tr>
			<tr>
				<!--<td><span class="yellow"></span></td>-->
				<td><i class="fa fa-long-arrow-left fa-stack-2x closeFancybox" alt="long-arrow-left" style="color:yellow" area-hidden="true" ></i></td>
				<td><i class="fa fa-long-arrow-right fa-stack-2x closeFancybox" alt="long-arrow-right" style="color:yellow" area-hidden="true" ></i></td>
				<td><i class="fa fa-long-arrow-up fa-stack-2x closeFancybox" alt="long-arrow-up" style="color:yellow" area-hidden="true" ></i></td>
				<td><i class="fa fa-long-arrow-down fa-stack-2x closeFancybox" alt="long-arrow-down" style="color:yellow" area-hidden="true" ></i></td>
				<td><img src="image/darrow-yellow.png" alt="darrow-yellow" style="color:yellow" class="closeFancybox"/></td>
				<td><img src="image/circle-yellow.png" alt="circle-yellow" class="closeFancybox"/></td>
				<td><img src="image/highlight.png" alt="highlight" style="color:rgba(255,255,0,0.5)" class="closeFancybox"/></td>
				<td><img src="image/rect.png" alt="rect" style="color:yellow" class="closeFancybox"/></td>
					<td><a style="color: yellow;"   href="#text-box" class="various1">Aa</a></td>
			</tr>
		</table>
		<!--<p class="fontdiv" style="float: left;width: 100%;"><label style="float: left;width: 100%;font-weight: bold;margin-bottom: 8px;">Choose Color:</label>
				<span class="red"></span>
				<span class="yellow"></span>
				<span class="white"></span>
				<span class="green"></span>
			</p>
			<label class="popup-label">Choose Text  /Arrow:</label>
			<img src="image/left.png" id="long-arrow-left" class="closeFancybox"  />
			<img src="image/right.png" id="long-arrow-right" class="closeFancybox"/>
			<img src="image/top.png" id="long-arrow-up" class="closeFancybox"/>
			<img src="image/bottom.png" id="long-arrow-down" class="closeFancybox"/>
			<img src="image/line.png" id="minus" class="closeFancybox"/>
			<img src="image/darrow.png" id="darrow" class="closeFancybox"/>
			<img src="image/circle.png" id="circle" class="closeFancybox"/>
			<img src="image/circle-white.png" id="circle-white" class="closeFancybox"/>
			<img src="image/circle-green.png" id="circle-green" class="closeFancybox"/>
			<img src="image/circle-red.png" id="circle-red" class="closeFancybox"/>
			
			<img src="image/highlight.png" id="highlight" class="closeFancybox"/>
			<img src="image/rect.png" id="rect" class="closeFancybox"/>
			<a style="border: 1px solid gray;float: left;text-decoration: navajowhite;padding: 2px 4px;color: black;margin-right:10px"  href="#text-box" id="various3">Aa</a>-->
	<!--		<button type="button" id="marker">Marker</button>
<button type="button" id="highlight">Highlight</button>
<button type="button" id="clear">Clear</button>-->
		</div>
		<div id="text-box" style="display:none">
				<!--	<p class="fontdiv">
	<label class="popup-label">Choose Text Color:</label>
				<span class="red"></span>
				<span class="yellow"></span>
				<span class="white"></span>
				<span class="green"></span>
			</p>-->
			<input style="width: 100%;margin-bottom: 10px;height: 30px;" type="text" class="ptext"  placeholder="Enter Note" />
			<input style="background: green;color: white;border: navajowhite;padding: 7px 30px;" type="button" value="Submit" id="submit-text"/>
		</div>
		<div id="text-box-update" style="display:none">
			<input type="text" class="p-u-text"  placeholder="Enter Note" />
			<input type="button" value="Update" id="update"/>
			<p class="update-message"></p>
		</div>

	<div id="wait" ><img src='demo_wait.gif' width="64" height="64" /><br>Loading..</div>
	
	
	<div class="bg-color-box">
	<p ><img style="width: 35px;" src="image/settings-icon.png" /></p>
	<ul style="list-style: none;margin: 0;padding: 0;">
			<li class="white"></li>
			<li class="black"></li>
			<li class="red"></li>
			<li class="yellow"></li>
		</ul>	
	</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet"/>
		<link href="jquery.fancybox.css" rel="stylesheet"/>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="jquery.fancybox.js"></script>
		<script src="https://cdn.jsdelivr.net/gh/godswearhats/jquery-ui-rotatable@1.1/jquery.ui.rotatable.min.js"></script>
		<script src="html2canvas.js"></script>
		<script src="custome.js"></script>
		
</script>
	</body>
</html>
<?php } else { echo "something went wrong"; }?>