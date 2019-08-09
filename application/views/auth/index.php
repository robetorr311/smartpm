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

	<?= form_open('auth', ['method' => 'post']) ?>
	<h2 style="font-size: 16px;text-align: center;margin-bottom: 20px;">Sign in to continue</h2>

	<?= $this->session->flashdata('errors') ?>

	<div class="input-group">
		<label>Company Code<span class="red-mark">*</span></label>
		<input type="text" name="company_code" placeholder="Company Code">
	</div>
	<div class="input-group">
		<label>Email ID<span class="red-mark">*</span></label>
		<input type="email" name="email" placeholder="Email ID">
	</div>
	<div class="input-group">
		<label>Password<span class="red-mark">*</span></label>
		<input type="password" name="password" placeholder="Password">
	</div>

	<div class="input-group">
		<button type="submit" id="submit" class="btn" name="login_user" onclick="setCompanyCode()">Login</button>

		<p class="forgot-links">
			<a href="<?= base_url('forgot-password') ?>">forogot password</a><br />
			<a href="<?= base_url('forgot-company-code') ?>">forogot company code</a>
		</p>
	</div>

	<div style="width: 100%; margin-top: 20px;">
		<p>
			Not yet a member? <a href="<?= base_url('signup'); ?>">Sign up</a>
		</p>
	</div>
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