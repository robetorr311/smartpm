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
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet" />

    <!--  Light Bootstrap Table core CSS    -->
    <link href="<?php echo base_url(); ?>assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet" />
    <!-- bootstrap tagsinput CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-tagsinput.css') ?>">
    <!-- At.js CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/jquery.atwho.css') ?>">

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo base_url(); ?>assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="<?php echo base_url(); ?>assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

    <!-- JS FILES -->
    <!--   Core JS Files   -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
    <!--  Notifications Plugin    -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-notify.js"></script>
    <!-- bootstrap tagsinput JS -->
    <script src="<?= base_url('assets/js/bootstrap-tagsinput.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap3-typeahead.min.js') ?>"></script>
    <!-- At.js JS -->
    <script src="<?= base_url('assets/js/jquery.caret.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.atwho.js') ?>"></script>
</head>

<body>

    <div class="wrapper">

        <?php 
        ?>
        <div class="sidebar" <?php if ($this->session->userdata("color") != '') {
                                    echo "data-color=" . $this->session->userdata("color");
                                } else {
                                    echo "data-color=" . $admin['admindata']['color'];
                                } ?> data-image="assets/img/sidebar-5.jpg">

            <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="#" class="simple-text">
                        CRM

                    </a>
                </div>

                <ul class="nav">
                    <li>
                        <a href="<?php echo base_url('dashboard'); ?>">
                            <i class="pe-7s-graph"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('leads'); ?>">
                            <i class="pe-7s-note2"></i>
                            <p>Leads </p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('cash_jobs'); ?>">
                            <i class="pe-7s-user"></i>
                            <p>Cash Jobs</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('tasks'); ?>">
                            <i class="pe-7s-note"></i>
                            <p>Tasks</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('insurance_jobs'); ?>">
                            <i class="pe-7s-note2"></i>
                            <p>Insurance Jobs</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('teams'); ?>">
                            <i class="pe-7s-note2"></i>
                            <p>Teams</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('users'); ?>">
                            <i class="pe-7s-note2"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('setting'); ?>">
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
                        <a class="navbar-brand" href="#"><?= $title ?></a>
                    </div>
                    <div class="collapse navbar-collapse">


                        <ul class="nav navbar-nav navbar-right">

                            <li>
                                <a href="">Welcome <strong><?php echo $admin['admininfo']['fullname']; ?></strong></a>
                            </li>
                            <li>

                                <a href="<?php echo base_url('logout'); ?>" style="color: red;">
                                    <p>Log out</p>
                                </a>
                            </li>
                            <li class="separator hidden-lg"></li>
                        </ul>
                    </div>
                </div>
            </nav>


            <div class="content">