<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
	<div class="row dashbord-box">
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('leads') ?>">
					<span><?= $leads ?></span>
					<p>Unsigned<br> Leads</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('lead/cash-jobs') ?>">
					<span><?= $cashJobs ?></span>
					<p>Open Cash Jobs</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('lead/insurance-jobs') ?>">
					<span><?= $insuranceJobs ?></span>
					<p>Open Insurance Jobs</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('work-completed') ?>">
					<span><?= 0 ?></span>
					<p>Complete<br> Jobs</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('lead/closed') ?>">
					<span><?= 0 ?></span>
					<p>Closed <br>Jobs</p>
				</a>
			</div>
		</div>
	</div>
</div>