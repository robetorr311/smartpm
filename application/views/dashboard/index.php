<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<h3>Leads</h3>
		</div>
	</div>
	<div class="row dashbord-box">
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('leads') ?>">
					<span><?= $newLeads ?></span>
					<p>New</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('leads') ?>">
					<span><?= $appointmentScheduledLeads ?></span>
					<p>Appointment<br>Scheduled</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('leads') ?>">
					<span><?= $followUpLeads ?></span>
					<p>Needs Follow Up<br>Call</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('leads') ?>">
					<span><?= $needsSiteVisitLeads ?></span>
					<p>Needs Site<br>Visit</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('leads') ?>">
					<span><?= $estimateBidLeads ?></span>
					<p>Needs<br>Estimate / Bid</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('leads') ?>">
					<span><?= $estimateSentLeads ?></span>
					<p>Estimate Sent</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('leads') ?>">
					<span><?= $readyToSignLeads ?></span>
					<p>Ready to<br>Sign / Verbal Go</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('leads') ?>">
					<span><?= $worryToLoaseLeads ?></span>
					<p>Worry to Lose</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('leads') ?>">
					<span><?= $postponedLeads ?></span>
					<p>Postponed</p>
				</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h3>Jobs</h3>
		</div>
	</div>
	<div class="row dashbord-box">
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('lead/production-jobs') ?>">
					<span><?= $productionJobs ?></span>
					<p>Production</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('lead/completed-jobs') ?>">
					<span><?= $completedJobs ?></span>
					<p>Completed</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('lead/closed-jobs') ?>">
					<span><?= $closedJobs ?></span>
					<p>Closed</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('lead/archive-jobs') ?>">
					<span><?= $archiveJobs ?></span>
					<p>Archive</p>
				</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h3>Tasks</h3>
		</div>
	</div>
	<div class="row dashbord-box">
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('tasks') ?>">
					<span><?= $createdTasks ?></span>
					<p>Created</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('tasks') ?>">
					<span><?= $workingTasks ?></span>
					<p>Working</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('tasks') ?>">
					<span><?= $stuckTasks ?></span>
					<p>Stuck</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('tasks') ?>">
					<span><?= $holdTasks ?></span>
					<p>Hold</p>
				</a>
			</div>
		</div>
		<div class="col-md-2">
			<div class="box gray-box">
				<a href="<?= base_url('tasks') ?>">
					<span><?= $completedTasks ?></span>
					<p>Completed</p>
				</a>
			</div>
		</div>
	</div>
</div>