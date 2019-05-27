<!doctype html>
<html lang="en">
<head> 
    <?php $admin = json_decode(json_encode($this->session->userdata), true); ?>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/img/<?php echo $admin['admindata']['favicon']; ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title><?= $title ?> - SmartPM CRM</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="<?php echo base_url();?>assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="<?php echo base_url();?>assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>
    
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-tagsinput.css') ?>">

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo base_url();?>assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="<?php echo base_url();?>assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery.fancybox.min.css">
    <!-- JS FILES -->
    <!--   Core JS Files   -->
    <script src="<?php echo base_url();?>assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap.min.js" type="text/javascript"></script>
    <!--  Notifications Plugin    -->
    <script src="<?php echo base_url();?>assets/js/bootstrap-notify.js"></script>
    <!-- bootstrap tagsinput JS -->
	<script src="<?= base_url('assets/js/bootstrap-tagsinput.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/bootstrap3-typeahead.min.js') ?>"></script>
    <script src="<?php echo base_url();?>assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
    <script src="<?php echo base_url();?>assets/js/demo.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.fancybox.js"></script>
   
</head>
<body>

<div class="wrapper">
   
    <?php //print_r($array['admindata']) ?>
    <div class="sidebar" <?php if($this->session->userdata("color")!=''){ echo "data-color=".$this->session->userdata("color"); }else{ echo "data-color=".$admin['admindata']['color']; }?> data-image="assets/img/sidebar-5.jpg">
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="#" class="simple-text">
                    CRM
                </a>
            </div>
            <ul class="nav">
                <li  class="<?= !empty($dashboard) ? 'active' : '' ?>">
                    <a href="<?php echo base_url('dashboard');?>">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('leads');?>">
                        <i class="pe-7s-note2"></i>
                        <p>Leads </p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('cash_jobs');?>">
                        <i class="pe-7s-user"></i>
                        <p>Cash Jobs</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('insurance_jobs');?>">
                        <i class="pe-7s-note2"></i>
                        <p>Insurance Jobs</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('labor_jobs');?>">
                        <i class="pe-7s-note"></i>
                        <p>Labor Only Jobs</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('productions');?>">
                        <i class="pe-7s-note"></i>
                        <p>Production</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('work_complete');?>">
                        <i class="pe-7s-note"></i>
                        <p>Work Complete</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('closed');?>">
                        <i class="pe-7s-note"></i>
                        <p>Closed</p>
                    </a>
                </li>
                <li class="">
                  <a class="nav-link" data-toggle="collapse" href="#componentsCollapse">
                    <i class="pe-7s-graph"></i>
                        <p>Admin  <b class="caret"></b></p>   
                  </a>
                  <div class="collapse submenu" id="componentsCollapse">
                    <ul class="nav">
                      <li class="nav-item ">
                        <a class="nav-link" href="<?php echo base_url('setting');?>">
                          <span class="sidebar-normal"> Setting </span>
                        </a>
                      </li>
                      <li class="nav-item ">
                        <a class="nav-link" href="<?php echo base_url('setting/status');?>">
                          <span class="sidebar-normal">Status Tag</span>
                        </a>
                      </li>
                      <li class="nav-item ">
                        <a class="nav-link" href="<?php echo base_url('teams');?>">
                          <span class="sidebar-normal"> Teams</span>
                        </a>
                      </li>
                       <li class="nav-item ">
                        <a class="nav-link" href="<?php echo base_url('archive');?>">
                          <span class="sidebar-normal"> Archive</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li>
                    <a href="<?php echo base_url('tasks');?>">
                        <i class="pe-7s-note"></i>
                        <p>Tasks</p>
                    </a>
                </li>
               <!-- <li>
                    <a href="<?php echo base_url('users');?>">
                        <i class="pe-7s-note2"></i>
                        <p>Users</p>
                    </a>
                </li>-->
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
                    <a class="navbar-brand" href="#"><?= $title ?></a>
                </div>
                <div class="collapse navbar-collapse">
                    

                    <ul class="nav navbar-nav navbar-right">
					
                       <li>
							 <a href="">Welcome <strong><?php echo $admin['first_name'] . ' ' . $admin['last_name']; ?></strong></a>
					   </li>
                        <li>
                            
<a href="<?php echo base_url('logout');?>" data-method="POST" style="color: red;"><p>Log out</p></a>                         
                        </li>
						<li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
