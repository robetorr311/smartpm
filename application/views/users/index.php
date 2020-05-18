<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
	<div class="row page-header-buttons">
		<div class="col-md-12">
			<a href="<?= base_url('user/create') ?>" class="btn btn-info btn-fill">New User</a>
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
					<h4 class="title">Users</h4>
				</div>
				<div class="content table-responsive table-full-width">
					<table class="table table-hover table-striped">
						<thead>
							<th class="text-center">View</th>
							<th>ID</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>UserName</th>
							<th>Email ID</th>
							<th>Level</th>
							<th>Status</th>
						</thead>
						<tbody>
							<?php if (!empty($users)) : ?>
								<?php foreach ($users as $user) : ?>
									<tr>
										<td class="text-center"><a href="<?= base_url('user/' . $user->id) ?>" class="text-info"><i class="fa fa-eye"></i></a></td>
										<td><?= $user->id ?></td>
										<td><?= $user->first_name ?></td>
										<td><?= $user->last_name ?></td>
										<td><?= $user->username ?></td>
										<td><?= $user->email_id ?></td>
										<td><?= UserModel::levelToStr($user->level) ?></td>
										<td><?= UserModel::activeToStr($user->is_active) ?></td>
									</tr>
								<?php endforeach; ?>
							<?php else : ?>
								<tr>
									<td colspan="10" class="text-center">No Record Found!</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>