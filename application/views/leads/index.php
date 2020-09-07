<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!-- Datatble CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/datatable/datatables.min.css')?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/datatable/custom-datatable.css')?>">
 <!-- Datatble JS -->
<script type="text/javascript" charset="utf8" src="<?php echo base_url('assets/js/datatable/datatables.min.js')?>"></script>


<div class="container-fluid">
	<div class="row page-header-buttons">
		<div class="col-md-8">
			<?php if (isset($status) && $status == 0) { ?>
				<a href="<?= base_url('lead/create') ?>" class="btn btn-info btn-fill"><?php echo isset($subtitle) ? 'Quick Create' : 'New Lead / Client' ?></a>
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
					<table id="lead-list" class="display" width="100%">
					<thead>
						<tr>
							<!-- <th>View</th> -->
							<!-- <th>Job Number</th> -->
							<th>First Name</th>
							<th>Last Name</th>
							<th>Status</th>
							<th>Type</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table> 
				</div>
			</div>
		</div>
	</div>
</div>

<script>

$(document).ready( function () {
	
	
	var status_id = "<?php echo !empty($status) ? $status: '';?>" ;
   // Datatable for lead-list
	var dataTable = $('#lead-list').DataTable({  
           "processing":false,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url() . 'leads/list/'; ?>",
				data: {status_id: status_id },  
                type:"POST"  
           },  
           "columns":[  
              
                    { data: "firstname" },
					{ data: "lastname" },
					{ data: "status", sorting: false },
					{ data: "type", sorting: false },
					{ data: "DT_RowId", sorting: false,
						render : function(DT_RowId) {
							var url = "<?php echo base_url('lead/') ?>"+ DT_RowId;
							return '<a href="'+url+'" data-toggle ="tooltip" data-placement="top" class="text-info view-icon" title="View"><i class="fa fa-eye"></i></a>';
						}
					}	 
                
           ],  
      }); 

	  // Search Tooltip
	  $('#lead-list_filter input').attr('data-toggle', 'tooltip')
                             .attr('data-placement', 'top')
                             .attr('title', 'Search by First Name or Last Name')
                             .tooltip(); 
	
} );

</script>