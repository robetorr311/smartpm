<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $file->file_name ?> - SmartPM CRM</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <div style="padding: 70px 0;" class="text-center">
    <img alt="logo" src="https://smartpm.app/assets/img/logo.png" width="150" style="margin-bottom: 50px;">
    <h1><?= $file->file_name ?></h1>
  </div>
  <div style="padding-top: 50px;" class="text-center">
    <i style="font-size: 300px;" class="fa fa-cloud-download text-secondary" aria-hidden="true"></i>
    <br>
    <a href="<?= base_url('public-folder/download/' . $company_code . '/' . $public_key) ?>" class="btn btn-primary btn-lg text-white" data-method="POST">Download</a>
  </div>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script>
    $('a[data-method="POST"]').click(function(e) {
      e.preventDefault();
      var method = $(this).data('method');
      var url = $(this).attr('href');
      var parent = $(this).parent();
      var id = Date.now();
      parent.append('<form id="' + id + '" action="' + url + '" method="POST" style="display:none;"></form>');
      parent.find('form#' + id).submit();
    });
  </script>
</body>

</html>