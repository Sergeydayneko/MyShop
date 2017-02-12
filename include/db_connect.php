<?php

$db_host      = 'localhost';
$db_user      = 'admin';
$db_pass      = '123456';
$db_database  = 'db_shop';

$link = new mysqli($db_host, $db_user, $db_pass, $db_database);

if (mysqli_connect_error()) {
    die('Connection error (' . mysqli_connect_errno() . ') '
        . mysqli_connect_error());
}
mysqli_set_charset($link, "UTF8");
?>