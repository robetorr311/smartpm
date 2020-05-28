<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
	<div class="row page-header-buttons">
		<div class="col-md-12">
			<a href="<?= base_url('vendor/' . $vendor->id) ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?= $this->session->flashdata('errors') ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 max-1000-form-container">
			<div class="card">
				<div class="header">
					<h4 class="title">Vendor Details</h4>
				</div>
				<div class="content view">
					<div>
						<div class="row">
							<div class="col-md-12">
								#<?= $vendor->id ?><br />
								<?= $vendor->name ?><br />
								<?= empty($vendor->address) ? '-' : $vendor->address ?><br />
								<?= empty($vendor->city) ? '-' : $vendor->city ?>, <?= empty($vendor->state) ? '-' : $vendor->state ?> - <?= empty($vendor->zip) ? '-' : $vendor->zip ?><br />
								<?= empty($vendor->phone) ? '-' : ('C - ' . $vendor->phone) ?><br />
								<?= empty($vendor->email_id) ? '-' : $vendor->email_id ?><br />
								<?= empty($vendor->tax_id) ? '-' : ('<b>Tax ID: </b>' . $vendor->tax_id) ?><br />
								<?= empty($vendor->credit_line) ? '-' : ('<b>Credit Line: </b>' . $vendor->credit_line) ?>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="footer">
					<div class="row">
						<div class="col-md-12">
							<a href="<?= base_url('vendor/' . $vendor->id . '/docs'); ?>" class="btn btn-fill">Docs</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-element">
				<input type="file" class="vendordoc" name="doc[]" id="<?= $vendor->id; ?>" multiple />
				<div class="upload-doc-area" id="<?= $vendor->id; ?>">
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
								<td class="text-center"><a target="_blank" href="<?= base_url('assets/vendor_doc/' . $doc->doc_name); ?>"><i class="fa fa-eye text-info"></i></a></td>
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
			//len_files = $(".vendorphoto").prop("files").length;
			var len_files = file_data.length;
			for (var i = 0; i < len_files; i++) {
				//var file_data = $(".vendorphoto").prop("files")[i];
				form_data.append("doc[]", file_data[i]);
			}

			$.ajax({
				url: baseUrl + 'vendor/<?= $vendor->id ?>/doc/upload', // point to server-side PHP script     
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
							url: baseUrl + 'vendor/<?= $vendor->id ?>/doc/save', // point to server-side PHP script     
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
			$(".vendordoc").click();
		});

		$(".vendordoc").change(function() {
			var id = $(this).attr('id');
			var form_data = new FormData();
			//alert(id);          
			len_files = $(".vendordoc").prop("files").length;
			for (var i = 0; i < len_files; i++) {
				var file_data = $(".vendordoc").prop("files")[i];
				form_data.append("doc[]", file_data);
			}

			$.ajax({
				url: baseUrl + 'vendor/<?= $vendor->id ?>/doc/upload', // point to server-side PHP script     
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
							url: baseUrl + 'vendor/<?= $vendor->id ?>/doc/save', // point to server-side PHP script     
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
				url: baseUrl + 'vendor/<?= $vendor->id ?>/doc/delete',
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
				url: baseUrl + 'vendor/<?= $vendor->id ?>/doc/update',
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