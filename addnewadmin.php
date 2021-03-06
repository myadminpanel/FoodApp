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
// $uid = $_SESSION['uid'];
// if (!$user->get_session()){
//     header("location:index.php");
// }
if(isset($_REQUEST['addadmin']))
{
    if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
    {
        extract($_REQUEST);
        $checkadmin=$user->checkadminaccess($email,$username);
        if($checkadmin)
        {
            ?><script>
            alert("Error : Admin Already Exist");
            document.getElementById("error").innerHTML="Error : Admin Already Exist";</script><?php
        }
        else
        {
            if($password == $confirmpwd)
            {
                $path = $_FILES['file']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $tmp_file=$_FILES['file']['tmp_name'];
                $file_path="uploads/"."admin".time().".".$ext;
                $imagename= "admin".time().".".$ext;
                if(move_uploaded_file($tmp_file,$file_path))
                {
                    $user->addnewadminaccess($username,$fullname,$password,$email,$imagename);
                    if($user)
                    {
                        ?><script>window.location='adminaccess.php';</script><?php
                    }
                    else
                    {
                        ?><script>document.getElementById("error").innerHTML="Error : Please Check Database Connections And Main Clases.";</script><?php
                    }
                }
                else
                {
                    ?><script>
                    alert("Error : Image Uploading Problem Please Try Again.");
                    document.getElementById("error").innerHTML="Error : Image Uploading Problem Please Try Again.";</script><?php
                }
            }
            else
            {
                ?><script>
                alert("Error : Password And Confirm Password Not Match");
                document.getElementById("error").innerHTML="Error : Password And Confirm Password Not Match";</script><?php
            }
        }
    }
    else
    {
        ?><script>
        alert("Error : Please Select Admin Image");
        document.getElementById("error").innerHTML="Error : Please Select Admin Image";</script><?php
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Food Delivery System | Admin Access</title>
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
        <h1 class="page-header">Add Admin <small>Add New Admin Detail Form</small></h1>
        <div class="row">
            <form class="form-horizontal form-bordered" data-parsley-validate="true" name="demo-form" method="post" enctype="multipart/form-data">
                <div class="col-md-12">
                    <!-- begin panel -->
                    <input type="hidden" name="imageunlink" value="<?php echo $res->image; ?>">
                    <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                        <div class="panel-heading">
                            <h4 class="panel-title">Admin Access Detail</h4>
                        </div>
                        <h4 style="color: red;" id="error"></h4>
                        <div class="panel-body panel-form">

                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="fullname">User Name * :</label>
                                <div class="col-md-4 col-sm-4">
                                    <input class="form-control" type="text"  name="username" placeholder="User Name" data-parsley-required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="fullname">Full Name * :</label>
                                <div class="col-md-4 col-sm-4">
                                    <input class="form-control" type="text"  name="fullname" placeholder="Full Name" data-parsley-required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="fullname">Password * :</label>
                                <div class="col-md-4 col-sm-4">
                                    <input class="form-control" type="password"  name="password" placeholder="Password" data-parsley-required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="fullname">Confirm Password * :</label>
                                <div class="col-md-4 col-sm-4">
                                    <input class="form-control" type="password"  name="confirmpwd" placeholder="Confirm Password" data-parsley-required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="fullname">Email * :</label>
                                <div class="col-md-4 col-sm-4">
                                    <input class="form-control" type="text"  name="email" placeholder="Email" data-parsley-required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4">Selecte Admin Image * :</label>
                                <div class="col-md-4 col-sm-4">
                                    <input type="file" name="file" id="uploadImage" onchange="PreviewImage();" data-parsley-required="true" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4"></label>
                                <div class="col-md-6 col-sm-6">
                                    <a href="category.php" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                    <button type="submit" name="addadmin" id="addcat" class="btn btn-primary">Add Admin Access</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="assets/js/jquery-migrate-1.1.0.min.js"></script>
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

