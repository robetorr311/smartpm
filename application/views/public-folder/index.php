<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
  <div class="row page-header-buttons">
    <div class="col-md-12">
      <a href="<?= base_url('lead/' . $sub_base_path . $jobid) ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
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
      <?php
      if (!empty($this->session->flashdata('errors'))) {
        echo '<div class="alert alert-danger fade in alert-dismissable" title="Error:"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>';
        echo $this->session->flashdata('errors');
        echo '</div>';
      }
      ?>
    </div>

    <div class="col-md-12">
      <div class="form-element">
        <input type="file" class="jobpublicfolderfile" name="jobpublicfolderfile[]" id="<?= $jobid; ?>" multiple />
        <div class="upload-area" id="<?= $jobid; ?>">
          <h1>Drag and Drop file here<br />Or<br />Click to select file</h1>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="header">
            <h4 class="title">Files</h4>
          </div>
          <div class="content table-responsive table-full-width">
            <table class="table table-hover table-striped">
              <thead>
                <th>ID</th>
                <th>File Name</th>
                <th>Shared URL</th>
                <th>Date Time Uploaded</th>
                <th class="text-center">Delete</th>
              </thead>
              <tbody>
                <?php if (!empty($files)) : ?>
                  <?php foreach ($files as $file) : ?>
                    <tr>
                      <td><?= $file->id ?></td>
                      <td><?= $file->file_name ?></td>
                      <td><input id="publicUrl<?= $file->id ?>" type="text" value="<?= base_url('public-folder/' . $company_code . '/' . $file->public_key) ?>" readonly> &nbsp; <i class="fa fa-files-o text-info" style="cursor: pointer;" onclick="copyToClipboard(<?= $file->id ?>)" aria-hidden="true"></i></td>
                      <td><?= $file->created_at ?></td>
                      <td class="text-center"><a href="<?= base_url('lead/' . $sub_base_path . $jobid . '/public-folder/' . $file->id . '/delete') ?>" data-method="POST" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else : ?>
                  <tr>
                    <td colspan="5" class="text-center">No Record Found!</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    var baseUrl = '<?= base_url(); ?>';
    $("html").on("dragover", function(e) {
      e.preventDefault();
      e.stopPropagation();
      $("h1").text("Drag here");
    });
    $("html").on("drop", function(e) {
      e.preventDefault();
      e.stopPropagation();
    });
    // Drag enter
    $('.upload-area').on('dragenter', function(e) {
      e.stopPropagation();
      e.preventDefault();
      $("h1").text("Drop");
    });
    // Drag over
    $('.upload-area').on('dragover', function(e) {
      e.stopPropagation();
      e.preventDefault();
      $("h1").text("Drop");
    });
    // Drop
    $('.upload-area').on('drop', function(e) {
      e.stopPropagation();
      e.preventDefault();
      $("h1").text("Upload");
      var id = $(this).attr('id');
      var file_data = e.originalEvent.dataTransfer.files;

      var len_files = file_data.length;
      for (var i = 0; i < len_files; i++) {
        var form_data = new FormData();
        form_data.append("jobpublicfolderfile[]", file_data[i]);
        $.ajax({
          url: baseUrl + 'lead/<?= $sub_base_path ?><?= $jobid ?>/public-folder/upload',
          dataType: 'text',
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'post',
          success: function(php_script_response) {
            var obj = JSON.parse(php_script_response)
            if (obj.success && obj.success == true) {
              location.reload();
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
      }
    });

    $(".upload-area").click(function() {
      $(".jobpublicfolderfile").click();
    });

    $(".jobpublicfolderfile").change(function() {
      var id = $(this).attr('id');
      len_files = $(".jobpublicfolderfile").prop("files").length;
      for (var i = 0; i < len_files; i++) {
        var form_data = new FormData();
        var file_data = $(".jobpublicfolderfile").prop("files")[i];
        form_data.append("jobpublicfolderfile[]", file_data);

        $.ajax({
          url: baseUrl + 'lead/<?= $sub_base_path ?><?= $jobid ?>/public-folder/upload',
          dataType: 'text',
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'post',
          success: function(php_script_response) {
            var obj = JSON.parse(php_script_response)
            if (obj.success && obj.success == true) {
              location.reload();
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
      }
    });
  });

  function copyToClipboard(id) {
    var copyText = document.getElementById("publicUrl" + id);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    alert("Copied!");
  }
</script>