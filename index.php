<?php
include('application/db_config.php');
session_start();
if (isset($_POST['login'])) 
{
    $username = $_POST['email'];
    $password = $_POST['password'];

    $qry = mysqli_query($conn,"SELECT id,email, password,role,username FROM fooddelivery_adminlogin WHERE email='".$username."' AND password='".$password."'
        UNION 
        SELECT id,email, password,role,username FROM fooddelivery_res_owner WHERE email='".$username."' AND password='".$password."'");

    $result = mysqli_fetch_array($qry);

    if($result['role']=='1')
    {
        session_start();
        $_SESSION['username'] = $result['username'];
        $_SESSION['uid'] = $result['id'];
        $_SESSION['role'] = $result['role'];
        echo "<script>window.location='dashboard.php'</script>";
    }
                
    if($result['role']=='2')
    {
        session_start();
        $_SESSION['username'] = $result['username'];
        $_SESSION['uid'] = $result['id'];
        $_SESSION['role'] = $result['role'];
        echo "<script>window.location='restaurant_owner/dashboard.php'</script>";
    }else {
        $fail = "Invalid Username and password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>JajaBar | Login</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="Online food ordering is a process of ordering food from a local restaurant or food cooperative through a web page or app. Much like ordering consumer goods online, many of these allow customers to keep accounts with them in order to make frequent ordering convenient. A customer will search for a favorite restaurant, usually filtered via type of cuisine and choose from available items, and choose delivery or pick-up. Payment can be amongst others either by credit card or cash, with the restaurant returning a percentage to the online food company." />
    <meta content="" name="" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="assets/css/jquery-ui.min.css" rel="stylesheet" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <link href="assets/css/style.min.css" rel="stylesheet" />
    <link href="assets/css/style-responsive.min.css" rel="stylesheet" />
    <link href="assets/css/default.css" rel="stylesheet" id="theme" />
</head>
<body class="pace-top">
<div id="page-container" class="fade">
    <div class="login bg-black animated fadeInDown">
        <div class="login-header">
            <div class="brand">
                <span class="logo"></span> Food Delivery System
            </div>
        </div>
        <div class="login-content">
            <form  method="POST" class="margin-bottom-0">
                <div class="form-group m-b-20">
                    <div style="color: red;" align="center" ><?php echo $fail; ?></div>
                    <div id="msg" style="color: green;" align="center" ></div>
                </div>
                <div class="form-group m-b-20">
                    <input type="email" name="email" value="" class="form-control input-lg" placeholder="Email" required/>
                </div>
                <div class="form-group m-b-20">
                    <input type="password" name="password" value="" class="form-control input-lg" placeholder="Password" required/>
                </div>
                <div class="login-buttons">
                    <input type="submit" name="login" value="login" class="btn btn-success btn-block btn-lg">
                </div>
            </form>
        </div>
    </div>
</div>
<script src="assets/js/jquery-1.9.1.min.js"></script>
<script src="assets/js/jquery-migrate-1.1.0.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/jquery.cookie.js"></script>
<script src="assets/js/apps.min.js"></script>
<script>
    $(document).ready(function()
    {
        App.init();
    });
</script>
</body>
</html>