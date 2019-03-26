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
$admininfo = $user->getuserinfo($uid);
if(isset($_POST['editprofile']))
{
    if(isset($_FILES['file']['name']) && $_FILES['file']['name']!="")
    {
        $reomveimage=$user->unlinkimage($_POST['image'],"uploads");
        $path = $_FILES['file']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $tmp_file=$_FILES['file']['tmp_name'];
        $file_path="uploads/"."admin_".time().".".$ext;
        $imagename= "admin_".time().".".$ext;
        if(move_uploaded_file($tmp_file,$file_path))
        {
            extract($_REQUEST);
            $editprofile=$user->editprofile($id,$fullname,$username,$email,$imagename);
            if($editprofile)
            {
                ?>
                <script>
                    window.location='editprofile.php';
                </script>
                <?php
            }
            else
            {
                ?>
                <script>
                    alert("! Please Try Again.. !!!");
                </script>
                <?php
            }
        }
        else
        {
            ?>
            <script>
                alert("! Error For Uploading file !!!");
            </script>
            <?php
        }
    }
    else
    {
        extract($_REQUEST);
        $editprofile=$user->editprofile($id,$fullname,$username,$email,"none");
        if($editprofile)
        {
            ?>
            <script>
                window.location='editprofile.php';
            </script>
            <?php
        }
        else
        {
            ?>
            <script>
                alert("! Please Try Again.. !!!");
            </script>
            <?php
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Food Delivery System | Edit Category</title>
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
        <h1 class="page-header">Edit Profile <small>Edit Profile Detail Form</small></h1>
        <div class="row " >
            <form class="form-horizontal form-bordered" data-parsley-validate="true" name="demo-form" method="post" enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                        <div class="panel-heading">
                            <h4 class="panel-title">Edit Profi Detail</h4>
                        </div>
                        <h4 style="color: red;" id="error"></h4>
                        <div class="panel-body panel-form">
                            <input type="hidden" name="id" value="<?php echo $admininfo->id;?>">
                            <input type="hidden" name="image" value="<?php echo $admininfo->icon; ?>">
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="fullname">Profile Image :</label>
                                <div class="col-md-4 col-sm-4">
                                    <input type="file" onchange="PreviewImage()"   class="form-text"  name="file" id="file" accept="image/*" style="visibility:hidden;" >
                                    <img align="left" id="catimage" onClick="selectimage()" src="uploads/<?php echo $admininfo->icon; ?>" style="height: 100px;width: 120px;border-radius: 15px;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="fullname">User Name :</label>
                                <div class="col-md-4 col-sm-4">
                                    <input class="form-control" type="text"  name="username" value="<?php echo $admininfo->username; ?>" placeholder="User Name" data-parsley-required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="fullname">Full Name :</label>
                                <div class="col-md-4 col-sm-4">
                                    <input class="form-control" type="text"  name="fullname" value="<?php echo $admininfo->fullname; ?>" placeholder="Full Name" data-parsley-required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="fullname">Email :</label>
                                <div class="col-md-4 col-sm-4">
                                    <input class="form-control" type="text"  name="email" value="<?php echo $admininfo->email; ?>" placeholder="Email" data-parsley-required="true" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4"></label>
                                <div class="col-md-6 col-sm-6">
                                    <?php    $Constant = button; 
                                    if ($Constant == "Active") { ?>
                                    <button type="submit" name="editprofile" id="addcat" class="btn btn-primary">Edit Profile</button>
                                    <?php } else { ?>
                                     <button onClick="return confirm('This function is currently disable as it is only a demo website, in your admin it will work perfect')"  class="btn btn-primary">Edit Profile</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function selectimage()
    {
        var x =document.getElementById('file');
        x.click();

    }
    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("file").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("catimage").src = oFREvent.target.result;
        };
    };

</script>
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