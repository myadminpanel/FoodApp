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

$qu_string=$_SERVER['QUERY_STRING'];
$id_val=$user->encrypt_decrypt("decrypt",$qu_string);
$id_exp=explode("=",$id_val);
$id = $id_exp[1];
$res=$user->getrestaurantdetail($id);
$res_own = $user->getresowner($res->id);
if(isset($_REQUEST['editrestaurant']))
{
   
    if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
    {
        $user->unlinkimage($_POST['imageunlink'],"uploads/restaurant");
        $image_info = getimagesize($_FILES['file']['tmp_name']);
        $width = $image_info[0];
        $height = $image_info[1];
        if($width == 800 && $height == 500)
        {
            $path = $_FILES['file']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $tmp_file=$_FILES['file']['tmp_name'];
            $file_path="uploads/restaurant/"."resto_".time().".".$ext;
            $imagename= "resto_".time().".".$ext;
            if(move_uploaded_file($tmp_file,$file_path))
            {
                extract($_REQUEST);
                $user->editrestaurantdetail($id,$name, $address,$desc,$email,$phone,$website,$del_time,$open_time,$close_time,$category,
                    $city,$location,$latitude,$longitude,$imagename,$currency,$dcharge);
                $user->editreowndetalis($res_own->id,$password,$email,$phone);
                if($user)
                {
                    ?><script>window.location='dashboard.php';</script><?php
                }
                else
                {
                    ?><script>document.getElementById("error").innerHTML="Error : Please Check Database Connections And Main Clases.";</script><?php
                }
            }
            else
            {
                ?><script>document.getElementById("error").innerHTML="Error : Image Uploading Problem Please Try Again.";</script><?php
            }
        }
        else
        {
            ?><script>document.getElementById("error").innerHTML="Error : Please Select 800 * 500 Size Image";</script><?php
        }
    }
    else
    {
        extract($_REQUEST);
        $user->editrestaurantdetail($id,$name,$address,$desc,$email,$phone,$website,$del_time,$open_time,$close_time,$category,$city,$location,
            $latitude,$longitude,"none",$currency,$dcharge);
          $user->editreowndetalis($res_own->id,$password,$email,$phone);
        if($user)
        {
            ?><script>window.location='dashboard.php';</script><?php
        }
        else
        {
            ?><script>document.getElementById("error").innerHTML="Error : Please Check Database Connections And Main Clases.";</script><?php
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Food Delivery System | Add New Restaurant</title>
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
    <script type="text/javascript" src='https://maps.google.com/maps/api/js?key=AIzaSyBiVfFZRtrGy8AmV5UH7WZEou_3Hpbc_xg&sensor=false&libraries=places'></script>
    <script src="assets/js/locationpicker.js"></script>
</head>
<body class="boxed-layout">
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<div id="page-container" class="page-container fade page-without-sidebar page-header-fixed page-with-top-menu">
    <?php
        include 'include/header.php';
        include 'include/topmenu.php';
    ?>
    <div id="content" class="content">
        <div class="breadcrumb pull-right" style="padding-right: 16px;">
            <button class="btn btn-inverse" onclick="window.location='dashboard.php'"><i class="fa fa-fw fa-long-arrow-left"></i> Back</button>
        </div>
        <h1 class="page-header">Add Store <small>Add Store Detail Form</small></h1>
        <div class="row">
            <form class="form-horizontal form-bordered" data-parsley-validate="true" name="demo-form" method="post" enctype="multipart/form-data">
                <div class="col-md-6">
                    <input type="hidden" name="imageunlink" value="<?php echo $res->photo; ?>">
                    <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                        <div class="panel-heading">
                            <h4 class="panel-title">Restaurant Detail</h4>
                        </div>
                        <div class="panel-body panel-form">
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="fullname">Restaurant Name * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" value="<?php echo $res->name; ?>"  name="name" placeholder="Restaurant Name" data-parsley-required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="email">Address * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <textarea class="form-control"  name="address"  placeholder="Address" data-parsley-required="true" ><?php echo $res->address; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="email">Restaurant Desc * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <textarea class="form-control"  name="desc"  placeholder="Descriptions" data-parsley-required="true" ><?php echo $res->desc; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="fullname">Email * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="email"  value="<?php echo $res->email; ?>" name="email" placeholder="Email" data-parsley-required="true" />
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="fullname">Password * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text"  value="<?php echo $res_own->password; ?>" name="password" placeholder="Password" data-parsley-required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="message">Phone No :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text"  name="phone" value="<?php echo $res->phone; ?>" placeholder="Phone Number" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="website">Website :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="url"  name="website" data-parsley-type="url" value="<?php echo $res->website; ?>" placeholder="url" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="website">Delivery Time :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="number"  name="del_time" value="<?php echo $res->delivery_time; ?>" placeholder="Delivery Time For Ex : 45" required />
                                    <div style="color: red;">Input must be in number.</div>
                                </div>
                            </div>
                            <input class="form-control" type="hidden" name="currency" value="<?php echo $get_currency['currency']; ?>" required />

                            <div class="form-group">
                                <label class="control-label col-md-4">Opening Time</label>
                                <div class="col-md-8">
                                    <div class="input-group bootstrap-timepicker">
                                        <input id="timepicker" type="text" value="<?php echo $res->open_time;?>" class="form-control" name="open_time" />
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Closing Time</label>
                                <div class="col-md-8">
                                    <div class="input-group bootstrap-timepicker">
                                        <input id="timepicker1" type="text" value="<?php echo $res->close_time;?>" class="form-control" name="close_time" />
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="website">Select Category</label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control" name="category[]" multiple required>
                                        <?php
                                        foreach($user->getcategory() as $value)
                                        {
                                            ?>
                                            <option value="<?php echo $value['id']; ?>" style="font-weight: bold;color: black;"><?php echo $value['cname']; ?>
                                            <?php
                                            $subcategory=$user->getsubcategoryname($value['id']);
                                            if($subcategory)
                                            {
                                                foreach ($subcategory as $val)
                                                {
                                                    $getcteval=$user->getcategory_passid($res->id,$val->id,"getrescat");
                                                    if($getcteval) {
                                                        if ($getcteval->cat_id == $val->id) {
                                                            ?>
                                                            <option value="<?php echo $val->id ?>" selected>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $val->name; ?></option>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <option value="<?php echo $val->id ?>">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $val->name; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    else{
                                                        ?>
                                                        <option value="<?php echo $val->id ?>">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $val->name; ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <br/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-inverse" data-sortable-id="form-validation-2">
                        <div class="panel-heading">
                            <h4 class="panel-title">Restaurant Location Detail</h4>
                        </div>
                        <div class="panel-body panel-form">

                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="website">City</label>
                                <div class="col-md-6 col-sm-6">
                                    <select name="city" class="form-control" required>
                                        <option value="<?php echo $res->city; ?>" selected><?php echo $res->city; ?></option>
                                        <?php
                                        $get_city = mysqli_query($conn,"select * from fooddelivery_city");
                                        while ($city = mysqli_fetch_array($get_city)) {
                                        ?>
                                            <option value="<?php echo $city ['cname']; ?>"><?php echo $city ['cname']; ?></option>
                                        <?php
                                        }
                                        ?>
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4">Delivery Type * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" value="<?php echo $res->del_charge; ?>" name="dcharge" placeholder="Case On Delivery" required data-parsley-required="true" />
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4">Search Location* :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" value="<?php echo $res->location; ?>" id="us2-address" name="location" placeholder="Search location" required data-parsley-required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12">
                                    <div id="us2" style="width: 460px; height: 300px;"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4">Latitude* :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" value="<?php echo $res->lat; ?>" id="us2-lat" name="latitude"  data-type="alphanum" placeholder="Latitude"  data-parsley-required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4">Longitude* :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" id="us2-lon" value="<?php echo $res->lon; ?>" name="longitude"  data-type="alphanum" placeholder="Longitude"  data-parsley-required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4">Selecte Restaurant Image</label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="file" name="file" id="uploadImage" onchange="PreviewImage();" >
                                    <div id="error" style="color: red;">Upload Images 800 * 500</div>
                                </div>
                            </div>
                            <div class="form-group" id="images">
                                <label class="control-label col-md-4 col-sm-4">View Selected Image</label>
                                <div class="col-md-6 col-sm-6">
                                    <img id="uploadPreview" src="uploads/restaurant/<?php echo $res->photo; ?>" style="width: 150px; height: 100px;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4"></label>
                                <div class="col-md-6 col-sm-6">
                                    <button type="submit" name="editrestaurant" id="addresto" class="btn btn-primary">Update Restaurant Detail</button>
                                </div>
                            </div>
                        </div>

                    </div>
            </form>
        </div>
    </div>
</div>
<script>
    var _URL = window.URL || window.webkitURL;
    $("#uploadImage").change(function(e) {
        var file, img;
        if ((file = this.files[0]))
        {
            img = new Image();
            img.onload = function() {
                // alert(this.width + " " + this.height);
                if(this.width == 800 && this.height == 500)
                {
                    $('#addresto').prop("disabled", false);
                    document.getElementById("error").innerHTML=""
                }
                else
                {
                    $('#addresto').prop("disabled", true);
                    document.getElementById("error").innerHTML="Upload Images Size Is Not Valid"
                }
            };
            img.onerror = function()
            {
                $('#addresto').prop("disabled", true);
            };
            img.src = _URL.createObjectURL(file);
        }
    });
    function PreviewImage()
    {

        $("#images").show();
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);
        oFReader.onload = function (oFREvent)
        {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };
    $('#us2').locationpicker({
        location:
        {
            latitude: <?php echo $res->lat; ?>,
            longitude: <?php echo $res->lon; ?>
        },
        radius: 300,
        inputBinding:
        {
            latitudeInput: $('#us2-lat'),
            longitudeInput: $('#us2-lon'),
            radiusInput: $('#us2-radius'),
            locationNameInput: $('#us2-address')
        },
        enableAutocomplete: true
    });
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

