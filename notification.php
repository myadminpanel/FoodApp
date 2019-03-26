<?php
session_start();
@$uid = $_SESSION['uid'];
@$role = $_SESSION['role'];
//print_r($role); exit();
if($role !='1')
{
    echo "<script>window.location='index.php'</script>";
    session_destroy();
}
include_once 'controllers/restaurant.php';
$user = new dashboard();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Food Delivery System | Send Notification</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="Food Delivery System" />
    <meta content="" name="Freaktemplate" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="assets/css/jquery-ui.min.css" rel="stylesheet" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <link href="assets/css/style.min.css" rel="stylesheet" />
    <link href="assets/css/style-responsive.min.css" rel="stylesheet" />
    <link href="assets/css/default.css" rel="stylesheet" id="theme" />
    <link href="assets/css/bwizard.min.css" rel="stylesheet" />
    <link href="assets/css/bootstrap-timepicker.min.css" rel="stylesheet" />
    <link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="assets/css/parsley.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<style>
    .no-js #loader {  display: none;  }
    .js #loader { display: block; position: absolute; left: 100px; top: 0; }
    .se-pre-con
    {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url(uploads/gifloading.gif) center no-repeat #fff;
        opacity: 0.7;
    }
</style>
</head>
<body class="boxed-layout">
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<div id="page-container" class="page-container fade page-without-sidebar page-header-fixed page-with-top-menu">
    <?php
    include 'include/header.php';
    include 'include/topmenu.php';
    ?>
    <div id="content" class="content">
        <h1 class="page-header">Send Notification <small>Send Notification Detail Form</small></h1>
        <div class="row " >
            <form class="form-horizontal form-bordered" data-parsley-validate="true" method="post" enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                        <div class="panel-heading">
                            <h4 class="panel-title">Send Notification</h4>
                        </div>
                        <h4 style="color: red;" id="error"></h4>
                        <div class="panel-body panel-form">
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="fullname">Message :</label>
                                <div class="col-md-4 col-sm-4">
                                    <textarea class="form-control" name="message" id="message" placeholder="Message" data-parsley-required="true"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4"></label>
                                <div class="col-md-6 col-sm-6">
                                    <button type="reset"  class="btn btn-primary">Reset</button>
                                    <input type="button" onClick="myFunction()" class="btn btn-primary" value="Send Notification">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="se-pre-con" hidden id="loading"></div>
        </div>
    </div>
</div>

<script>
function myFunction() {
    
var message = document.getElementById("message").value;
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'message1=' + message;
if (message == '') {
alert("Please Fill The Message Fields");
} else {
    $("#loading").show();
// AJAX code to submit form.
$.ajax({
type: "POST",
url: "ajax/send_notification.php",
data: dataString,
cache: false,
    success: function(html) {
    var json=$.parseJSON(html);
    if (json['android']==0 && json['ios']==0) 
    {
        $("#loading").hide();
        alert("!!! Something went wrong !");
        window.location.href = "notification.php";
    } else {
        $("#loading").hide();
        
        alert("!!! Notification Sent \n Android" + json ['android']+" \n IOS" + json ['ios']);
        window.location.href = "notification.php";
    }
    //alert(html);

    }
});
}
return false;
}
</script>

<!--<script src="assets/js/jquery-migrate-1.1.0.min.js"></script>-->
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery-migrate-1.1.0.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/jquery.cookie.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/ion.rangeSlider.min.js"></script>
<script src="assets/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/js/masked-input.min.js"></script>
<script src="assets/js/bootstrap-timepicker.min.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="assets/js/bwizard.js"></script>
<script src="assets/js/parsley.js"></script>
<script src="assets/js/form-wizards.demo.min.js"></script>
<script src="assets/js/form-wizards-validation.demo.min.js"></script>
<script src="assets/js/form-plugins.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<script>
    $(document).ready(function() {
        App.init();
        FormWizardValidation.init();
        FormPlugins.init();
    });
</script>
</body>
</html>