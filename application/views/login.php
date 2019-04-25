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
  <?php echo form_open('server/index',array('id'=>"loginform",'autocomplete'=>"off"));?>
 <h2 style="font-size: 16px;text-align: center;margin-bottom: 20px;">Sign in to continue</h2>
  <p style="color: green;">
  <?= $this->session->flashdata('message') ?></p>

<?php if(validation_errors())
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
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p>
  Not yet a member? <a href="<?php echo base_url('index.php/home/register'); ?>">Sign up</a>
  	</p>
  <?php echo form_close(); ?>      
</body>
</html>