<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
	<div class="row page-header-buttons">
		<div class="col-md-8">
			<?php if (isset($status) && $status == 0) { ?>
				<a href="<?= base_url('lead/create') ?>" class="btn btn-info btn-fill">New <?= isset($subtitle) ? $subtitle : 'Lead / Client' ?></a>
			<?php } ?>
		</div>
		<div class="col-md-4 text-right">
			<?php if (isset($prev_status) && isset($next_status)) : ?>
				<a <?= $prev_status ? 'href="' . base_url('leads/status/' . $prev_status) . '"' : '' ?> class="<?= $prev_status ? 'btn btn-info btn-fill' : 'btn btn-default btn-fill' ?>"><i class="fa fa-angle-double-left" aria-hidden="true"></i>&nbsp; Prev Status</a>
				<a <?= $next_status ? 'href="' . base_url('leads/status/' . $next_status) . '"' : '' ?> class="<?= $next_status ? 'btn btn-info btn-fill' : 'btn btn-default btn-fill' ?>">Next Status &nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
			<?php endif; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php
			if (!empty($this->session->flashdata('errors'))) {
				echo '<div class="alert alert-danger fade in alert-dismissable" title="Error:"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>';
				echo $this->session->flashdata('errors');
				echo '</div>';
			}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="header">
					<h4 class="title"><?= isset($subtitle) ? $subtitle : $title ?> List</h4>
				</div>
				<div class="content table-responsive table-full-width">
					<table class="table table-hover table-striped">
						<thead>
							<th class="text-center">View</th>
							<th>Job Number</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Status</th>
							<th>Type</th>
						</thead>
						<tbody>
							<?php if (!empty($leads)) : ?>
								<?php foreach ($leads as $lead) : ?>
									<tr>
										<td class="text-center"><a href="<?= base_url('lead/' . $lead->id) ?>" class="text-info"><i class="fa fa-eye"></i></a></td>
										<td><?= (1600 + $lead->id); ?></td>
										<td><?= $lead->firstname ?></td>
										<td><?= $lead->lastname ?></td>
										<td><?= LeadModel::statusToStr($lead->status) ?></td>
										<td><?= LeadModel::typeToStr($lead->type) ?></td>
									</tr>
								<?php endforeach; ?>
							<?php else : ?>
								<tr>
									<td colspan="8" class="text-center">No Record Found!</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>