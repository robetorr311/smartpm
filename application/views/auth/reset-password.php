<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<title>Login - SmartPM CRM</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/auth.css') ?>">
</head>

<body>
	<div class="header">
		<img src="<?= base_url('assets/img/logo.png') ?>" style="width:200px" />
	</div>

	<?= form_open('set-token-verified-password/' . $token, ['method' => 'post']) ?>
	<h2 style="font-size: 16px;text-align: center;margin-bottom: 20px;">Reset Password</h2>

	<?= $this->session->flashdata('message') ?>

	<div class="input-group">
		<label>Company Code</label>
		<input type="text" name="company_code" placeholder="Company Code">
	</div>

	<div class="input-group">
		<label>Password</label>
		<input type="password" name="password" placeholder="Password">
	</div>

	<div class="input-group">
		<label>Confirm Password</label>
		<input type="password" name="confirm_password" placeholder="Confirm Password">
	</div>

	<div class="input-group">
		<button type="submit" id="submit" class="btn" name="login_user" onclick="setCompanyCode()">Submit</button>

		<p style="float: right; margin-top: 7px;">
			<a href="<?= base_url('login') ?>">Looking for login?</a>
		</p>
	</div>

	<p>
		Not yet a member? <a href="<?= base_url('signup'); ?>">Sign up</a>
	</p>
	<?= form_close(); ?>

	<script>
		if (localStorage.company_code) {
			document.getElementsByName('company_code')[0].value = localStorage.company_code;
		}

		function setCompanyCode() {
			localStorage.company_code = document.getElementsByName('company_code')[0].value;
		}
	</script>
</body>

</html>