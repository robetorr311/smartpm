<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SmartPM CRM</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <div style="padding-top: 55px;" class="text-center">
    <img alt="logo" src="https://smartpm.app/assets/img/logo.png" width="150" style="margin-bottom: 50px;">
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header" style="background-color: white;">
            <h5 style="margin-bottom: 0;">Files & Folders</h5>
          </div>
          <div class="content table-responsive table-full-width">
            <table class="table table-hover table-striped">
              <thead>
                <th style="background-color: gray; color: white;" width="50px"></th>
                <th style="background-color: gray; color: white;">File Name</th>
                <th style="background-color: gray; color: white;">Date Time Uploaded</th>
                <th style="background-color: gray; color: white;" class="text-center">Download</th>
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
                        <td><a href="<?= base_url('company-photos/public/' . $company_code . '/' . $public_key . '/' . $ff->id) ?>"><?= $ff->name ?></a></td>
                      <?php } else { ?>
                        <td><?= $ff->name ?></td>
                      <?php } ?>
                      <td><?= $ff->created_at ?></td>
                      <?php if ($ff->type == 1) { ?>
                        <td class="text-center">-</td>
                      <?php } else { ?>
                        <td class="text-center"><a href="<?= base_url('company-photos/public/download/' . $company_code . '/' . $public_key . '/' . $ff->id) ?>" data-method="POST"><i class="fa fa-cloud-download"></i></a></td>
                      <?php } ?>
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