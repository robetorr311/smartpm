<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/register.css">
</head>
<body>
  <div class="header">
      <img src="<?php echo base_url(); ?>assets/img/logo.png"  style="width:200px"/>
  
  </div>
  <?php echo form_open('account/login',array('method'=>'post'));?>
 <h2 style="font-size: 16px;text-align: center;margin-bottom: 20px;">Sign in to continue</h2>
  <?= $this->session->flashdata('message') ?>

  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username"  required="">
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password" required="">
  	</div>
  	<div class="input-group">
  		<button type="submit" id="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p>
  Not yet a member? <a href="<?php echo base_url('account/signup'); ?>">Sign up</a>
  	</p>
  <?php echo form_close(); ?>      

  <script src="<?php echo base_url();?>assets/js/md5.js"></script>

</body>
</html>