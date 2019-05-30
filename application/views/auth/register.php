<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<title>Register - SmartPM CRM</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/auth.css') ?>">
</head>

<body>
	<div class="header">
		<img src="<?= base_url('assets/img/logo.png') ?>" style="width:200px" />
	</div>

	<?= form_open('register', ['method' => 'post']) ?>
	<h2 style="font-size: 16px;text-align: center;margin-bottom: 20px;">Create Account</h2>

	<?= $this->session->flashdata('message') ?>

	<div class="input-group">
		<label>First Name</label>
		<input type="text" name="first_name" placeholder="First Name" required>
	</div>
	<div class="input-group">
		<label>Last Name</label>
		<input type="text" name="last_name" placeholder="Last Name" required>
	</div>
	<div class="input-group">
		<label>Email ID</label>
		<input type="email" name="email_id" placeholder="Email ID" required>
	</div>
	<div class="input-group">
		<label>Password</label>
		<input type="password" name="password" placeholder="Password" required>
	</div>
	<div class="input-group">
		<label>Confirm Password</label>
		<input type="password" name="conf_password" placeholder="Confirm Password" required>
	</div>
	<div class="input-group">
		<label>Office Phone</label>
		<input type="text" name="office_phone" placeholder="Office Phone">
	</div>
	<div class="input-group">
		<label>Home Phone</label>
		<input type="text" name="home_phone" placeholder="Home Phone">
	</div>
	<div class="input-group">
		<label>Cell 1</label>
		<input type="text" name="cell_1" placeholder="Cell 1">
	</div>
	<div class="input-group">
		<label>Cell 2</label>
		<input type="text" name="cell_2" placeholder="Cell 2">
	</div>

	<br>
	
	<h2 style="font-size: 16px;text-align: center;margin-bottom: 20px;">Company Details</h2>
	
	<div class="input-group">
		<label>Name</label>
		<input type="text" name="company_name" placeholder="Name">
	</div>
	<div class="input-group">
		<label>Email ID</label>
		<input type="text" name="company_email_id" placeholder="Email ID">
	</div>
	<div class="input-group">
		<label>Alternate Email ID</label>
		<input type="text" name="company_alt_email_id" placeholder="Alternates Email ID">
	</div>
	<div class="input-group">
		<label>Address</label>
		<input type="text" name="company_address" placeholder="Address">
	</div>
	<div class="input-group">
		<label>City</label>
		<input type="text" name="company_city" placeholder="City">
	</div>
	<div class="input-group">
		<label>State</label>
		<input type="text" name="company_state" placeholder="State">
	</div>
	<div class="input-group">
		<label>Zip</label>
		<input type="text" name="company_zip" placeholder="Zip">
	</div>

	<br>

	<div class="input-group">
		<button type="submit" id="submit" class="btn">Register</button>
	</div>

	<p>
		Already have a account? <a href="<?= base_url('login') ?>">Login</a>
	</p>
	<?= form_close(); ?>
</body>

</html>