<?php


session_start();
include_once 'controllers/restaurant.php';
$user = new dashboard();
unset($_SESSION['uid']);
unset($_SESSION['role']);
$user->user_logout();
header("location:../index.php");


?>