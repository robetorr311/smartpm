<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
	<div class="row page-header-buttons">
		<div class="col-md-12">
			<a href="<?= base_url('lead/' . $sub_base_path . $jobid) ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?= $this->session->flashdata('errors') ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="header">
					<h4 class="title">Leads / Clients Detail</h4>
				</div>
				<div class="content view">
					<div class="row client-details">
						<div class="col-lg-4 client-details-column">
							<h6><u>Client Details</u></h6>
							Job Number <?= (1600 + $lead->id); ?><br />
							<?= $lead->firstname ?> <?= $lead->lastname ?><br />
							<?= $lead->address ?><br />
							<?= empty($lead->address_2) ? '' : ($lead->address_2 . '<br />') ?>
							<?= $lead->city ?>, <?= $lead->state ?> <?= $lead->zip ?><br />
							C - <?= formatPhoneNumber($lead->phone1) ?><br />
							<?= $lead->email ?>
						</div>
						<div class="col-lg-4 client-details-column">
							<h6><u>Financial Details</u></h6>
							<table style="width: 100%;">
								<?php
								$balance = 0;
								foreach ($financials as $financial) {
									$balance += $financial->amount;
								?>
									<tr>
										<td><?= FinancialModel::typeToStr($financial->type) ?></td>
										<td class="text-right"><b><?= (floatval($financial->amount) < 0 ? '- $' . number_format(abs($financial->amount), 2) : '$' . number_format($financial->amount, 2)) ?></b></td>
									</tr>
								<?php
								}
								?>
								<tr>
									<td>Balance Due</td>
									<td class="text-right" style="border-top: solid 1px #000;"><b><?= (floatval($balance) < 0 ? '- $' . number_format(abs($balance), 2) : '$' . number_format($balance, 2)) ?></b></td>
								</tr>
							</table>
						</div>
						<div class="col-lg-4 client-details-column">
							<h6><u>Job Details</u></h6>
                            <table style="width: 100%;">
                                <?php if (!empty($financial_record->contract_date)) { ?>
                                    <tr>
                                        <td>Contract Date:</td>
                                        <td><?= date('M j, Y', strtotime($financial_record->contract_date)) ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($lead->completed_date)) { ?>
                                    <tr>
                                        <td>Completion Date:</td>
                                        <td><?= date('M j, Y', strtotime($lead->completed_date)) ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($primary_material_info)) { ?>
                                    <?php if (!empty($primary_material_info->color)) { ?>
                                        <tr>
                                            <td>Shingle Color:</td>
                                            <td><?= $primary_material_info->color ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (!empty($primary_material_info->installer_name)) { ?>
                                        <tr>
                                            <td>Installer:</td>
                                            <td><?= $primary_material_info->installer_name ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (!empty($primary_material_info->supplier)) { ?>
                                        <tr>
                                            <td>Material Supplier:</td>
                                            <td><?= $primary_material_info->supplier ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </table>
						</div>
					</div>
				</div>
				<div class="footer">
					<div class="row">
						<div class="col-md-12">
							<a href="<?= base_url('lead/' . $sub_base_path . $lead->id . '/photos'); ?>" class="btn btn-fill">Photos</a>
							<a href="<?= base_url('lead/' . $sub_base_path . $lead->id . '/reports'); ?>" class="btn btn-fill">Photo Report</a>
							<a href="<?= base_url('lead/' . $sub_base_path . $lead->id . '/docs'); ?>" class="btn btn-fill">Docs</a>
							<a href="<?= base_url('lead/' . $sub_base_path . $lead->id . '/notes'); ?>" class="btn btn-fill">Notes</a>
							<a href="<?= base_url('lead/' . $sub_base_path . $lead->id . '/public-folder'); ?>" class="btn btn-fill">Public Folder</a>
                            <a href="<?= base_url('financial/estimates/client/' . $lead->id); ?>" class="btn btn-fill" target="_blank">Estimates</a>
                            <a href="<?= base_url('lead/' . $sub_base_path . $lead->id . '/client-notices'); ?>" class="btn btn-fill">Client Notice</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-element">
				<input type="file" class="jobdoc" name="doc[]" id="<?= $jobid; ?>" multiple />
				<div class="upload-doc-area" id="<?= $jobid; ?>">
					<h1>Drag and Drop file here <br />Or<br />Click to select file</h1>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="card">
				<div class="header">
					<h4 class="title">Docs</h4>
				</div>

				<div class="content table-responsive table-full-width doc_div">
					<table class="table table-hover table-striped doc_list">
						<tr>
							<th>SN</th>
							<th>Name</th>
							<th>Filename</th>
							<th class="text-center">View</th>
							<th class="text-center">Modify</th>
							<th class="text-center">Delete</th>
						</tr>
						<?php $i = 0;
						foreach ($docs as $doc) : ?>
							<?php $i++; ?>
							<tr id="doc<?= $doc->id; ?>">
								<td><?= $i; ?></td>
								<td>
									<p id="docp<?= $doc->id ?>"><?= $doc->name ?></p><input style="width: 70%;display:none" name="<?= $doc->id ?>" type="text" class="docname" placeholder="Enter new name" id="doctext<?= $doc->id ?>" />
								</td>
								<td><?= $doc->doc_name ?></td>
								<td class="text-center"><a target="_blank" href="<?= base_url('assets/job_doc/' . $doc->doc_name); ?>"><i class="fa fa-eye text-info"></i></a></td>
								<td class="text-center"><span class="<?= $doc->id ?>"><i class="del-edit fa fa-pencil text-warning"></i></span></td>
								<td class="text-center"><i class="del-doc fa fa-trash-o text-danger" id="<?= $doc->id; ?>"></i></td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		var baseUrl = '<?= base_url(); ?>';
		// Drag enter
		$('.upload-doc-area').on('dragenter', function(e) {
			e.stopPropagation();
			e.preventDefault();
			$("h1").text("Drop");
		});

		// Drag over
		$('.upload-doc-area').on('dragover', function(e) {
			e.stopPropagation();
			e.preventDefault();
			$("h1").text("Drop");
		});

		// Drop
		$('.upload-doc-area').on('drop', function(e) {
			e.stopPropagation();
			e.preventDefault();
			// alert($(this).attr('id'));
			$("h1").text("Upload");
			var id = $(this).attr('id');
			var file_data = e.originalEvent.dataTransfer.files;
			var form_data = new FormData();
			//alert(id);          
			//len_files = $(".jobphoto").prop("files").length;
			var len_files = file_data.length;
			for (var i = 0; i < len_files; i++) {
				//var file_data = $(".jobphoto").prop("files")[i];
				form_data.append("doc[]", file_data[i]);
			}

			$.ajax({
				url: baseUrl + 'lead/<?= $sub_base_path ?><?= $jobid ?>/doc/upload', // point to server-side PHP script     
				dataType: 'text', // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function(php_script_response) {
					var obj = JSON.parse(php_script_response)
					if (obj.doc && obj.doc.length != 0) {
						$.ajax({
							type: 'POST',
							url: baseUrl + 'lead/<?= $sub_base_path ?><?= $jobid ?>/doc/save', // point to server-side PHP script     
							data: {
								id: id,
								name: JSON.stringify(obj.doc)
							},
							success: function(photoid) {
								//alert(photoid);
								$('.doc_div table').append(photoid);
							}
						});
					} else if (obj.error) {
						alert(obj.error);
					} else {
						alert('Something went wrong!. File type not ok');
					}
				},
				error: function(jqXHR) {
					if (jqXHR.status == 413) {
						alert('Large File, Max file size limit is 100MB.');
					} else {
						alert('Something went wrong!. File type not ok');
					}
				}
			});
		});

		$(".upload-doc-area").click(function() {
			$(".jobdoc").click();
		});

		$(".jobdoc").change(function() {
			var id = $(this).attr('id');
			var form_data = new FormData();
			//alert(id);          
			len_files = $(".jobdoc").prop("files").length;
			for (var i = 0; i < len_files; i++) {
				var file_data = $(".jobdoc").prop("files")[i];
				form_data.append("doc[]", file_data);
			}

			$.ajax({
				url: baseUrl + 'lead/<?= $sub_base_path ?><?= $jobid ?>/doc/upload', // point to server-side PHP script     
				dataType: 'text', // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function(php_script_response) {
					var obj = JSON.parse(php_script_response)
					if (obj.doc && obj.doc.length != 0) {
						$.ajax({
							type: 'POST',
							url: baseUrl + 'lead/<?= $sub_base_path ?><?= $jobid ?>/doc/save', // point to server-side PHP script     
							data: {
								id: id,
								name: JSON.stringify(obj.doc)
							},
							success: function(photoid) {
								//alert(photoid);
								$('.doc_div table').append(photoid);
							}
						});
					} else if (obj.error) {
						alert(obj.error);
					} else {
						alert('Something went wrong!. File type not ok');
					}
				},
				error: function(jqXHR) {
					if (jqXHR.status == 413) {
						alert('Large File, Max file size limit is 100MB.');
					} else {
						alert('Something went wrong!. File type not ok');
					}
				}
			});
		});

		$(document).on('click', '.del-doc', function() {
			var id = $(this).attr('id');
			$.ajax({
				url: baseUrl + 'lead/<?= $sub_base_path ?><?= $jobid ?>/doc/delete',
				data: {
					id: id
				},
				type: 'post',
				success: function(php_script_response) {
					$('#doc' + id).remove();
				}
			});
		});

		$(document).on('change', '.docname', function() {
			var data = $(this).val();
			var id = $(this).attr('name');
			$.ajax({
				url: baseUrl + 'lead/<?= $sub_base_path ?><?= $jobid ?>/doc/update',
				data: {
					na: data,
					id: id
				},
				type: 'post',
				success: function(php_script_response) {
					$('#doctext' + id).toggle();
					$('#docp' + id).toggle();
					$('#docp' + id).html(data);
				}
			});
		});

		$(document).on('click', '.doc_list span', function() {
			var id = $(this).attr('class');
			$('#doctext' + id).toggle();
			$('#docp' + id).toggle();
		});
	});
</script>