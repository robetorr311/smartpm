<?php
defined('BASEPATH') or exit('No direct script access allowed');
?> <div class="container-fluid">
                <div class="row">
                   <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title" style="float: left;">Docs</h4> <a href="javascript:window.history.go(-1);" class="btn btn-info btn-fill pull-right">Back</a>
                                <div class="clearfix"></div>
                                <?= $this->session->flashdata('message') ?>
                                <?php if (validation_errors())
                                {   
                                  echo '<div class="alert alert-danger fade in alert-dismissable" title="Error:"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>';
                                  echo validation_errors();
                                  echo '</div>';
                                }
                                ?>
                            </div> 
                            <div class="content">
                               <div class="image_div">
                               <table class="table table-hover table-striped doc_list">
                                    <tr>
                                        <th>SN</th>
                                        <th>Delete</th>
                                        <th>View</th>
                                        <th>Update Name</th>
                                        <th>Name</th>
                                        <th>Filename</th>
                                    </tr>   
                                  <?php $i=0; foreach( $docs as $doc ) : ?>  
                                     <?php $i++; ?>
                                <tr  id="doc<?php echo $doc->id; ?>">
                                      <td style="width: 30px"><?php  echo $i; ?></td>
                                      <td style="width: 30px"><i class="del-doc pe-7s-trash" id="<?php echo $doc->id; ?>"></i></td>
                                      <td style="width: 30px"><a target="_blank" href="<?php echo base_url('assets/job_doc'); ?>/<?php echo $doc->doc_name ?>" class="" ><i class="pe-7s-news-paper" style="font-size: 30px" /></a></td>
                                      <td><span class="<?php echo $doc->id ?>"><i class="del-edit pe-7s-note" /></span></td>
                                      <td><p id="docp<?php echo $doc->id ?>"><?php  echo $doc->name ?></p><input style="width: 70%;display:none" name="<?php echo $doc->id ?>" type="text"  class="docname" placeholder="Enter new name" id="doctext<?php echo $doc->id ?>" /></td>
                                      <td><?php echo $doc->doc_name ?></td>
                                  </tr>
                                   <?php endforeach; ?>
                               </table>
                               </div>
                          </div>
      
                                                
          
                          
                        </div>
                    </div>
                    <div class="col-md-12">             
                        <div class="form-element">
                        <input type="file" class="jobdoc" name="doc[]" id="<?php echo $jobid; ?>" multiple />
                        <div class="upload-doc-area"  id="<?php echo $jobid; ?>">
                          <h1>Drag and Drop file here <br/>Or<br/>Click to select file</h1>
                        </div>
                      </div>
                  </div>
            </div>
    </div>

<script>
  $(document).ready(function(){
    var baseUrl = '<?= base_url(); ?>';
          // Drag enter
    $('.upload-doc-area').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("h1").text("Drop");
    });

    // Drag over
    $('.upload-doc-area').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("h1").text("Drop");
    });

    // Drop
    $('.upload-doc-area').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();
       // alert($(this).attr('id'));
        $("h1").text("Upload");
      var id =$(this).attr('id');
          var file_data =  e.originalEvent.dataTransfer.files;
        
           var form_data = new FormData(); 
          //alert(id);          
          //len_files = $(".jobphoto").prop("files").length;
          var len_files=file_data.length;    
          for (var i = 0; i < len_files; i++) {
            //var file_data = $(".jobphoto").prop("files")[i];
            form_data.append("doc[]", file_data[i]);
          }

        $.ajax({
            url: baseUrl+'server/doc_upload', // point to server-side PHP script     
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(php_script_response){
              //alert(php_script_response); 
              $.ajax({
                type: 'POST',
                url: baseUrl+'index.php/server/ajaxsave_jobdoc', // point to server-side PHP script     
                data: {id: id, name:php_script_response},                         
                success: function(photoid){
                  //alert(photoid);
                  $('.image_div table').append(photoid);
                }
              });

            var obj = JSON.parse(php_script_response)
              if(obj.length!=0){
                   $.ajax({
                            type: 'POST',
                            url: baseUrl+'server/doc_save', // point to server-side PHP script     
                            data: {id: id, name:php_script_response},                         
                            success: function(photoid){
                              //alert(photoid);
                              $('.image_div table').append(photoid);
                            }
                          });
               }else{

                       alert('Something went wrong!. File type not ok');
               }
            }
           });
    });
  
  
      
       $(".upload-doc-area").click(function(){
        $(".jobdoc").click();
    });
        
        
    
            $(".jobdoc").change(function () {
          var id= $(this).attr('id');
           var form_data = new FormData(); 
          //alert(id);          
          len_files = $(".jobdoc").prop("files").length;
          for (var i = 0; i < len_files; i++) {
            var file_data = $(".jobdoc").prop("files")[i];
            form_data.append("doc[]", file_data);
          }
          
          $.ajax({
            url: baseUrl+'server/doc_upload', // point to server-side PHP script     
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(php_script_response){
              //alert(php_script_response); 
              $.ajax({
                type: 'POST',
                url: baseUrl+'index.php/server/ajaxsave_jobdoc', // point to server-side PHP script     
                data: {id: id, name:php_script_response},                         
                success: function(photoid){
                  //alert(photoid);
                  $('.image_div table').append(photoid);
                }
              });
              var obj = JSON.parse(php_script_response)
              if(obj.length!=0){ 
                      $.ajax({
                        type: 'POST',
                        url: baseUrl+'server/doc_save', // point to server-side PHP script     
                        data: {id: id, name:php_script_response},                         
                        success: function(photoid){
                          //alert(photoid);
                          $('.image_div table').append(photoid);
                        }
                      });
                }else{

                           alert('Something went wrong!. File type not ok');
                        }
            }
           });
        });

            $(document).on('click', '.del-doc', function () {
          var id = $(this).attr('id');
                                    
          $.ajax({
            url: baseUrl+'server/doc_delete',
            data: {id: id},        
            type: 'post',
            success: function(php_script_response){
              $('#doc'+id).remove();
            }
           });
        });

             $(document).on('change', '.docname',  function () {
          var data = $(this).val();
          var id = $(this).attr('name');
          $.ajax({
            url: baseUrl+'server/doc_update',
            data: {na: data, id: id},        
            type: 'post',
            success: function(php_script_response){

            $('#doctext'+id).toggle();
            $('#docp'+id).toggle();
            $('#docp'+id).html(data);
            }
           });
        });

             $(document).on('click', '.doc_list span',  function () {
          var id = $(this).attr('class');
          $('#doctext'+id).toggle();
          $('#docp'+id).toggle();
        });

  });
</script>

  
