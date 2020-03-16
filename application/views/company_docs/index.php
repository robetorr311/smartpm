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
                <input type="file" class="companydoc" name="doc[]" multiple />
                <div class="upload-doc-area">
                    <h1>Drag and Drop file here <br />Or<br />Click to select file</h1>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">Company Documents List</h4>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-hover table-striped">
                        <thead>
                            <th>ID</th>
                            <th>File Name</th>
                            <th>Created By</th>
                            <th class="text-center">Download</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Delete</th>
                        </thead>
                        <tbody>
                            <?php if (!empty($docs)) : ?>
                                <?php foreach ($docs as $doc) : ?>
                                    <tr>
                                        <td><?= $doc->id ?></td>
                                        <td><?= $doc->doc_name ?></td>
                                        <td><?= $doc->created_user_fullname ?></td>
                                        <td class="text-center"><a target="_blank" href="<?= base_url('company-doc/' . $doc->id . '/download') ?>" class="text-primary"><i class="fa fa-download"></i></a></td>
                                        <?php if (substr($doc->doc_name, -4) === ".pdf") { ?>
                                            <td class="text-center"><a target="_blank" href="<?= base_url('assets/company_doc/' . $doc->doc_name) ?>" class="text-info"><i class="fa fa-eye"></i></a></td>
                                        <?php } else { ?>
                                            <td class="text-center">-</td>
                                        <?php } ?>
                                        <td class="text-center"><a href="<?= base_url('company-doc/' . $doc->id . '/delete') ?>" data-method="POST" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
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
                url: baseUrl + 'company-docs/upload', // point to server-side PHP script     
                dataType: 'text', // what to expect back from the PHP script, if anything
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

        $(".upload-doc-area").click(function() {
            $(".companydoc").click();
        });

        $(".companydoc").change(function() {
            var id = $(this).attr('id');
            var form_data = new FormData();
            //alert(id);          
            len_files = $(".companydoc").prop("files").length;
            for (var i = 0; i < len_files; i++) {
                var file_data = $(".companydoc").prop("files")[i];
                form_data.append("doc[]", file_data);
            }

            $.ajax({
                url: baseUrl + 'company-docs/upload', // point to server-side PHP script     
                dataType: 'text', // what to expect back from the PHP script, if anything
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
</script>