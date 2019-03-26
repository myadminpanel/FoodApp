<?php
session_start();
$uid = $_SESSION['uid'];
$role = $_SESSION['role'];
//print_r($role); exit();
if($role !='1')
{
    echo "<script>window.location='index.php'</script>";
    session_destroy();
}
include_once 'controllers/restaurant.php';
$user = new dashboard();
// $uid = $_SESSION['uid'];
// if (!$user->get_session()){
//     header("location:index.php");
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Food Delivery System | Web Services</title>
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
</head>
<body class="boxed-layout">
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<div id="page-container" class="page-container fade page-without-sidebar page-header-fixed page-with-top-menu">
    <?php
        include 'include/header.php';
        include 'include/topmenu.php';
    ?>
    <div id="content" class="content">
        <h1 class="page-header">Web Services List <small>Web Services list with url and descriptions</small></h1>
        <div class="row " >
            <form class="form-horizontal form-bordered" data-parsley-validate="true" name="demo-form" method="post" enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                        <div class="panel-heading">
                            <h4 class="panel-title">Web Services</h4>
                        </div>
                        <?php
                            $local="http://192.168.1.106/FoodDeliverySystem/";
                            $live="http://".$_SERVER['SERVER_NAME']."/";
                        ?>
                        <h4>
                            &nbsp;&nbsp; LocalHost : <font color="#008b8b">http://192.168.1.106/FoodDeliverySystem/</font><br>
                            &nbsp;&nbsp; Live : <font color="#008b8b">http://<?php echo $_SERVER['SERVER_NAME']; ?>/</font>
                        </h4>
                        <div>
                            <h3>&nbsp; 01) App User Register (referral_code is optional field  and (POST WEB SERVICE) )</h3>
<!--                            <p>&nbsp;&nbsp; => local URL <font color="#008b8b"><?php /*echo $local; */?>api/userregister.php?fullname={}&email={}&phone_no={}&password={}&referral_code={}</font></p>
-->                            <p>&nbsp;&nbsp; => live URL <font color="#008b8b"><?php echo $live; ?>api/userregister.php?fullname={}&email={}&phone_no={}&password={}&referral_code={}&&file={}</font></p>
                        </div>
                        <div>
                            <h3>&nbsp; 02) App user Login </h3>
<!--                            <p>&nbsp;&nbsp; => local URL <font color="#008b8b"><?php /*echo $local; */?>api/userlogin.php?email={}&password={}</font></p>
-->                            <p>&nbsp;&nbsp; => live URL <font color="#008b8b"><?php echo $live; ?>api/userlogin.php?email={}&password={}</font></p>
                        </div>
                        <div>
                            <h3>&nbsp; 03) User Login with Google (GET METHOD)</h3>
<!--                            <p>&nbsp;&nbsp; => local URL <font color="#008b8b"><?php /*echo $local; */?>api/userlogin.php?login_type=Google&fullname={}&email={}&phone_no={}&referral_code={}</font></p>
-->                            <p>&nbsp;&nbsp; => live URL <font color="#008b8b"><?php echo $live; ?>api/userlogin.php?login_type=Google&fullname={}&email={}&phone_no={}&referral_code={}&image{}</font></p>
                        </div>
                        <div>
                            <h3>&nbsp; 04) User Login with Facebook(GET METHOD)  </h3>
<!--                            <p>&nbsp;&nbsp; => local URL <font color="#008b8b"><?php /*echo $local; */?>api/userlogin.php?login_type=Facebook&fullname={}&email={}&phone_no={}&referral_code={}</font></p>
-->                            <p>&nbsp;&nbsp; => live URL <font color="#008b8b"><?php echo $live; ?>api/userlogin.php?login_type=Facebook&fullname={}&email={}&phone_no={}&referral_code={}&image{}</font></p>
                        </div>
                        <div>
                            <h3>&nbsp; 05) Restaurant list with Search via location </h3>
<!--                            <p>&nbsp;&nbsp;=> local URL <font color="#008b8b"><?php /*echo $local; */?>api/restaurantlist.php?timezone=asia/Kolkata&lat=21.00&lon=72.00&location=bolivia</font></p>
-->                            <p>&nbsp;&nbsp; => live URL <font color="#008b8b"><?php echo $live; ?>api/restaurantlist.php?timezone=asia/Kolkata&lat=21.00&lon=72.00&location=bolivia</font></p>
                        </div>
                        <div>
                              <h3>&nbsp; 06) Restaurant list with search via restaurant name and category </h3>
<!--                            <p>&nbsp;&nbsp; => local URL <font color="#008b8b"><?php /*echo $local; */?>api/restaurantlist.php?timezone=asia/Kolkata&lat=21.00&lon=72.00&search={}</font></p>
-->                            <p>&nbsp;&nbsp; => live URL <font color="#008b8b"><?php echo $live; ?>api/restaurantlist.php?timezone=asia/Kolkata&lat=21.00&lon=72.00&search={}</font></p>
                        </div>
                        <div>
                            <h3>&nbsp; 07) Get Restaurant wise reviews </h3>
<!--                            <p>&nbsp;&nbsp; => local URL <font color="#008b8b"><?php /*echo $local; */?>api/getrestaurant_review.php?res_id={}</font></p>
-->                            <p>&nbsp;&nbsp; => live URL <font color="#008b8b"><?php echo $live; ?>api/getrestaurant_review.php?res_id={}</font></p>
                        </div>
                        <div>
                            <h3>&nbsp; 08) Post and Publish Restaurant Review and ratting </h3>
<!--                            <p>&nbsp;&nbsp; => local URL <font color="#008b8b"><?php /*echo $local; */?>api/postrestaurant_review.php?user_id={}&res_id={}&review_text={}&ratting={}</font></p>
-->                            <p>&nbsp;&nbsp; => live URL <font color="#008b8b"><?php echo $live; ?>api/postrestaurant_review.php?user_id={}&res_id={}&review_text={}&ratting={}</font></p>
                        </div>
                        <div>
                            <h3>&nbsp; 09) Get All Restaurant Category </h3>
<!--                            <p>&nbsp;&nbsp; => local URL <font color="#008b8b"><?php /*echo $local; */?>api/restaurant_category.php</font></p>
-->                            <p>&nbsp;&nbsp; => live URL <font color="#008b8b"><?php echo $live; ?>api/restaurant_category.php</font></p>
                        </div>
                        <div>
                            <h3>&nbsp; 10) Get All Restaurant Category </h3>
<!--                            <p>&nbsp;&nbsp; => local URL <font color="#008b8b"><?php /*echo $local; */?>api/restaurant_category.php</font></p>
-->                            <p>&nbsp;&nbsp; => live URL <font color="#008b8b"><?php echo $live; ?>api/restaurant_category.php</font></p>
                        </div>
                        <div>
                            <h3>&nbsp; 11) Restaurant menu category list</h3>
<!--                            <p>&nbsp;&nbsp; => local URL <font color="#008b8b"><?php /*echo $local; */?>api/restaurant_menu.php?res_id={}</font></p>
-->                            <p>&nbsp;&nbsp; => live URL <font color="#008b8b"><?php echo $live; ?>api/restaurant_menu.php?res_id={}</font></p>
                        </div>
                        <div>
                            <h3>&nbsp; 12) Restaurant Menu list </h3>
<!--                            <p>&nbsp;&nbsp; => local URL <font color="#008b8b"><?php /*echo $local; */?>api/restaurant_submenu.php?menucategory_id={}</font></p>
-->                            <p>&nbsp;&nbsp; => live URL <font color="#008b8b"><?php echo $live; ?>api/restaurant_submenu.php?menucategory_id={}</font></p>
                        </div>
                        <div>
                            <h3>&nbsp; 13) Full Restaurant detail </h3>
<!--                            <p>&nbsp;&nbsp; => local URL <font color="#008b8b"><?php /*echo $local; */?>api/getrestaurantdetail.php?res_id={}&lat={}&lon={}</font></p>
-->                            <p>&nbsp;&nbsp; => live URL <font color="#008b8b"><?php echo $live; ?>api/getrestaurantdetail.php?res_id={}&lat={}&lon={}</font></p>
                        </div>
                        <div>
                            <h3>&nbsp; 14) Book Order ( Get Method )</h3>
<!--                            <p>&nbsp;&nbsp; => local URL <font color="#008b8b"><?php /*echo $local; */?>api/bookorder.php?user_id={}&res_id={}&address={}&city={}&zipcode={}&food_desc={}&description={}&total_price={}</font></p>
-->                            <p>&nbsp;&nbsp; => live URL <font color="#008b8b"><?php echo $live; ?>api/bookorder.php?user_id={}&res_id={}&address={}&city={}&zipcode={}&food_desc={}&description={}&total_price={}</font></p>
                            <p>&nbsp;&nbsp;  Note : food_desc value for Example  => menu_id=1,quantity=5,total_price=200.0; menu_id=3,quantity=5,total_price=200.0</p>
                        </div>
                        <br>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
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
    $(document).ready(function()
    {
        App.init();
        FormWizardValidation.init();
        FormPlugins.init();
    });
</script>
</body>
</html>

