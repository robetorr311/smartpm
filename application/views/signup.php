<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/register.css">
</head>
<body>
  <div class="header">
      <img src="<?php echo base_url(); ?>assets/img/logo.png"  style="width:200px"/>
  
  </div>
	 
  <?php echo form_open('server/register',array('id'=>"registerform",'autocomplete'=>"off"));?>
  <h2 style="font-size: 16px;text-align: center;margin-bottom: 20px;">Create Account</h2>
  <p style="color: green;">
  <?= $this->session->flashdata('message') ?></p>

                                                              <?php if (validation_errors())
{   
echo '<div class="error" title="Error:">';
echo validation_errors();
echo '</div>';
}
?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<label>Mobile</label>
  		<input type="text" name="mobile">
  	</div>
  		<div class="input-group">
  		<label>Email</label>
  		<input type="email" name="email">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Register</button>
  	</div>
  	<p>
  Already have a account? <a href="<?php echo base_url(); ?>">Login</a>
  	</p>
  <?php echo form_close(); ?>      
</body>
</html>