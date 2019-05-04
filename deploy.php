<?php

if ($_POST['payload']) {
    echo shell_exec('cd /var/www/html/ && git reset --hard HEAD && git pull');
    echo 'success';
} else {
    echo 'fail';
}
