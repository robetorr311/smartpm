<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
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
            <div class="form-element">
                <input type="file" class="companyphotos" name="companyphotos[]" multiple />
                <div class="upload-photos-area">
                    <h1>Drag and Drop file here <br />Or<br />Click to select file</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="margin-bottom: 30px;">
            <form action="<?= base_url('company-photos' . $path . 'create-folder') ?>" method="post" class="form-inline">
                <div class="form-group">
                    <label>Create Folder:</label>
                    <input type="text" class="form-control" name="folder_name">
                </div>
                <div class="form-group">
                    <input class="btn btn-info btn-fill" type="submit" value="Create">
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">Files & Folders</h4>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-hover table-striped">
                        <thead>
                            <th width="50px"></th>
                            <th>File Name</th>
                            <th>Shared URL</th>
                            <th>Date Time Uploaded</th>
                            <th class="text-center">Delete</th>
                        </thead>
                        <tbody>
                            <?php if (!empty($ffList)) : ?>
                                <?php foreach ($ffList as $ff) : ?>
                                    <tr>
                                        <?php if ($ff->type == 1) { ?>
                                            <td><i class="fa fa-folder" aria-hidden="true"></i></td>
                                        <?php } else { ?>
                                            <td><i class="fa fa-file" aria-hidden="true"></i></td>
                                        <?php } ?>
                                        <?php if ($ff->type == 1) { ?>
                                            <td><a href="<?= base_url('company-photos/' . $ff->id) ?>"><?= $ff->name ?></a></td>
                                        <?php } else { ?>
                                            <td><?= $ff->name ?></td>
                                        <?php } ?>
                                        <?php if ($ff->public_key == '' && $ff->type == 1) { ?>
                                            <td><a href="<?= base_url('company-photos' . $path . $ff->id . '/generate-public-key') ?>" data-method="POST"><i class="fa fa-link" aria-hidden="true" style="font-size: 14px;"></i> Genrate</a></td>
                                        <?php } else if ($ff->type == 1) { ?>
                                            <td><input id="publicUrl<?= $ff->id ?>" type="text" value="<?= base_url('company-photos/public/' . $company_code . '/' . $ff->public_key) ?>" readonly> &nbsp; <i class="fa fa-files-o text-info" style="cursor: pointer;" onclick="copyToClipboard(<?= $ff->id ?>)" aria-hidden="true"></i></td>
                                        <?php } else { ?>
                                            <td>-</td>
                                        <?php } ?>
                                        <td><?= $ff->created_at ?></td>
                                        <td class="text-center"><a href="<?= base_url('company-photos' . $path . $ff->id . '/delete') ?>" data-method="POST" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
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
<script>
    $(document).ready(function() {
        var baseUrl = '<?= base_url(); ?>';
        // Drag enter
        $('.upload-photos-area').on('dragenter', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $("h1").text("Drop");
        });

        // Drag over
        $('.upload-photos-area').on('dragover', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $("h1").text("Drop");
        });

        // Drop
        $('.upload-photos-area').on('drop', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $("h1").text("Upload");
            var id = $(this).attr('id');
            var file_data = e.originalEvent.dataTransfer.files;
            var form_data = new FormData();
            var len_files = file_data.length;
            for (var i = 0; i < len_files; i++) {
                form_data.append("companyphotos[]", file_data[i]);
            }

            $.ajax({
                url: baseUrl + 'company-photos<?= $path ?>upload',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(php_script_response) {
                    var obj = JSON.parse(php_script_response)
                    if (!obj.error) {
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
        });

        $(".upload-photos-area").click(function() {
            $(".companyphotos").click();
        });

        $(".companyphotos").change(function() {
            var id = $(this).attr('id');
            var form_data = new FormData();
            len_files = $(".companyphotos").prop("files").length;
            for (var i = 0; i < len_files; i++) {
                var file_data = $(".companyphotos").prop("files")[i];
                form_data.append("companyphotos[]", file_data);
            }

            $.ajax({
                url: baseUrl + 'company-photos<?= $path ?>upload',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(php_script_response) {
                    var obj = JSON.parse(php_script_response)
                    if (!obj.error) {
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