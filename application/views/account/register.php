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
	 
  <?php echo form_open('account/save');?>
  <h2 style="font-size: 16px;text-align: center;margin-bottom: 20px;">Create Account</h2>

  <?= $this->session->flashdata('message') ?>

                                                       
  	<div class="input-group">
  		<label>Username</label>
  		<input type="email" name="username" placeholder="abc@gmail.com" required="">
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password" required="">
  	</div>
  		<div class="input-group">
  		<label>Full Name</label>
  		<input type="text" name="fullname" required="">
  	</div>
  	<div class="input-group">
  		<button type="submit" id="submit" class="btn" >Register</button>
  	</div>
  	<p>
  Already have a account? <a href="<?php echo base_url(); ?>">Login</a>
  	</p>
  <?php echo form_close(); ?>  
   <script src="<?php echo base_url();?>assets/js/md5.js"></script>    
</body>
</html>