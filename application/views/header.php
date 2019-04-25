<!doctype html>
<html lang="en">
<head> 
    <?php $array = json_decode(json_encode($this->session->userdata), true); ?>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/img/<?php echo $array['admindata']['favicon']; ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Roofing Project</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="<?php echo base_url();?>assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="<?php echo base_url();?>assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo base_url();?>assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="<?php echo base_url();?>assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

</head>
<body>

<div class="wrapper">
   
    <?php //print_r($array['admindata']) ?>
    <div class="sidebar" <?php if($this->session->userdata("color")!=''){ echo "data-color=".$this->session->userdata("color"); }else{ echo "data-color=".$array['admindata']['color']; }?> data-image="assets/img/sidebar-5.jpg">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="#" class="simple-text">
                    CRM
                 <!-- <img src="<?php echo base_url(); ?>assets/img/<?php echo $array['admindata']['url']; ?>" />-->
                </a>
            </div>

            <ul class="nav">
                 <li >
                    <a href="<?php echo base_url('index.php/dashboard');?>">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
              <li>
                    <a href="<?php echo base_url('index.php/dashboard/alljob');?>">
                        <i class="pe-7s-user"></i>
                        <p>Jobs</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('index.php/dashboard/admininfo');?>">
                        <i class="pe-7s-note2"></i>
                        <p>Setting</p>
                    </a>
                </li>
               
               
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Dashboard</a>
                </div>
                <div class="collapse navbar-collapse">
                    

                    <ul class="nav navbar-nav navbar-right">
					
                       <li>
							 <a href="">Welcome <strong><?php echo $array['admininfo']['username']; ?></strong></a>
					   </li>
                        <li>
                            
<a href="<?php echo base_url('index.php/dashboard/logout');?>" style="color: red;"><p>Log out</p></a>                         
                        </li>
						<li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
