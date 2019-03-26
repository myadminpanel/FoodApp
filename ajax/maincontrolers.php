<?php
session_start();
include_once '../controllers/authantication.php';
$user = new Admin();
if (isset($_REQUEST['Submit'])) {
    extract($_REQUEST);
    $login = $user->check_login($username, $password);
    if ($login)
    {
       echo "True";
    }
    else
    {
       echo "False";
    }
}
?>