<?php
defined('BASEPATH') or exit('No direct script access allowed');
?> <div class="container-fluid">
                <div class="row">
                   <div class="col-md-12">
                  
                        <div class="card">
                            <div class="header">
                                <h4 class="title" style="float: left;">Photos</h4> <a href="javascript:window.history.go(-1);" class="btn btn-info btn-fill pull-right">Back</a>
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
                  <?php foreach( $imgs as $img ) : ?>  
            <div class="col-md-2" id="ph<?php echo $img->id; ?>">   <i class="del-photo pe-7s-close" id="<?php echo $img->id; ?>"></i>
           <a  href="<?php echo base_url('assets/job_photo'); ?>/<?php echo $img->image_name ?>" alt="<?php echo $img->id; ?>" data-fancybox="photo" data-caption="<?php echo $img->image_name ?>">
                <img id="img<?php echo $img->id; ?>" src="<?php echo base_url('assets/job_photo'); ?>/<?php echo $img->image_name ?>"  />
            </a>
     </div>

                   <?php endforeach; ?>
             </div>
          </div>
                        </div>
                    </div>
                    <div class="col-md-12">      
                        <div class="form-element">
                            <input type="file" class="jobphoto" name="photo[]" id="<?php echo $jobid; ?>" multiple />
                            <div class="upload-area"  id="<?php echo $jobid; ?>">
                                <h1>Drag and Drop file here<br/>Or<br/>Click to select file</h1>
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

          $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

          // Drag enter
          $('.upload-area').on('dragenter', function (e) {
              e.stopPropagation();
              e.preventDefault();
              $("h1").text("Drop");
          });

          // Drag over
          $('.upload-area').on('dragover', function (e) {
              e.stopPropagation();
              e.preventDefault();
              $("h1").text("Drop");
          });

          // Drop
          $('.upload-area').on('drop', function (e) {
              e.stopPropagation();
              e.preventDefault();
             // alert($(this).attr('id'));
              $("h1").text("Upload");
            var id =$(this).attr('id');
                var file_data =  e.originalEvent.dataTransfer.files;
              
                 var form_data = new FormData(); 578784
                var len_files=file_data.length;
                for (var i = 0; i < len_files; i++) {
                  form_data.append("photo[]", file_data[i]);
                }

                  $.ajax({
                  url: baseUrl+'index.php/server/ajaxupload_jobphoto', // point to server-side PHP script     
                  dataType: 'text',  // what to expect back from the PHP script, if anything
                  cache: false,
                  contentType: false,
                  processData: false,
                  data: form_data,                         
                  type: 'post',
                  success: function(php_script_response){
                    var obj = JSON.parse(php_script_response)
                    if(obj.length!=0){
                          $.ajax({ 
                          type: 'POST',
                          url: baseUrl+'index.php/server/ajaxsave_jobphoto', // point to server-side PHP script     
                          data: {id: id, name:php_script_response},                         
                          success: function(photoid){
                            //alert(photoid);
                            $('.image_div').append(photoid);
                          }
                        });
                        }else{

                           alert('Something went wrong!. File type not ok');
                        }
                  }
                 });       
          });
        
  
      
          $(".upload-area").click(function(){
            $(".jobphoto").click();
          });
        
        
    
          $(".jobphoto").change(function () {
              var id= $(this).attr('id');
              var form_data = new FormData(); 
              //alert(id);          
              len_files = $(".jobphoto").prop("files").length;
              for (var i = 0; i < len_files; i++) {
                var file_data = $(".jobphoto").prop("files")[i];
                form_data.append("photo[]", file_data);
              }
          
              $.ajax({
                url: baseUrl+'index.php/server/ajaxupload_jobphoto', // point to server-side PHP script     
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(php_script_response){
                   var obj = JSON.parse(php_script_response)
                     //alert(obj.length);
                 if(obj.length!=0){
                      $.ajax({
                      type: 'POST',
                      url: baseUrl+'index.php/server/ajaxsave_jobphoto', // point to server-side PHP script     
                      data: {id: id, name:php_script_response},                         
                        success: function(photoid){
                          //alert(photoid);
                          $('.image_div').append(photoid);
                        }
                      });
                    }else{
                       alert('Something went wrong!. File type not ok');
                    }
                }   
              });
        });

          $(document).on('click', '.del-photo', function () {
          var id = $(this).attr('id');
                                    
          $.ajax({
            url: baseUrl+'index.php/server/deletephoto',
            data: {id: id},        
            type: 'post',
            success: function(php_script_response){
              $('#ph'+id).remove();
            }
           });
        });


          $('[data-fancybox="photo"]').fancybox({
              buttons : ['rotate1','zoom','slideShow','close'],
              caption : function( instance, item ) {
              var caption = $(this).data('caption') || '';
             /* if ( item.type === 'image' ) {
                var caption =  '<button name="'+caption+'" href="' + item.src + '" id="rotate"  class="btn btn-success btn-fill rotate">Rotate image</button>' ;
              }*/
          
              return caption;
              },
            /*  afterShow: function( instance, current ) {
             img_array[k]=current.opts.$orig.attr("alt");
             k++;
            //  alert(this.a);
              },*/
          });




          $(document).on('click','.fancybox-button--rotate', function(){

            var name=$('.fancybox-caption__body').html();
            var angle=90;
              $.ajax({
                url: baseUrl+'index.php/server/imagerotate',
                data: {name: name, angle: angle},        
                type: 'post',
                success: function(php_script_response)
                {  
                   // location.reload();
                    var tStamp = +new Date();
                  
                    $('body .fancybox-slide--current .fancybox-content .fancybox-image').attr('src',baseUrl+'assets/job_photo/'+php_script_response+'?t='+ tStamp);


                    src=baseUrl+'assets/job_photo/'+php_script_response;
                  
     
                    var idx = $('.image_div a[href="'+src+'"]').attr('alt');
                    $('.image_div #img'+idx).attr('src',baseUrl+'assets/job_photo/'+php_script_response+'?t='+ tStamp);
         
                }

               });
          });


         

     



    });



</script>


   
