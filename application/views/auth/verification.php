<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <title>Login - SmartPM CRM</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/auth.css') ?>">
</head>

<body>
    <div class="header">
        <img src="<?= base_url('assets/img/logo.png') ?>" style="width:200px" />
    </div>

    <?= form_open() ?>
    <?= $message ?>
    <?= form_close(); ?>
</body>

</html>