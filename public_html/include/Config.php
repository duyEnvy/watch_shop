<?php
$server_username = "***";
$server_password = "***";
$server_host = "***";
$database = '**';

$conn = mysqli_connect($server_host,$server_username,$server_password,$database) or die("không thể kết nối tới database");
mysqli_query($conn,"SET NAMES 'UTF8'");
?>