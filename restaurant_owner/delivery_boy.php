<?php
session_start();
@$uid = $_SESSION['uid'];
@$role = $_SESSION['role'];
//print_r($role); exit();
if($role !='2')
{
    echo "<script>window.location='../index.php'</script>";
    session_destroy();
}
include_once 'controllers/restaurant.php';
$user = new dashboard();
// $uid = $_SESSION['uid'];
// if (!$user->get_session()){
//     header("location:index.php");
// }
mysqli_set_charset($conn,"utf8");
$user->clearnotifyreview();
$ressss=$user->getuserinfo($uid);
$urlid = $ressss->res_id;
if(isset($_REQUEST['addnewboy']))
{
    extract($_REQUEST);
    $user->addnewboy($urlid,$name,$phone,$email,$password,$vehicle_no,$vehicle_type);
    if($user)
    {
        ?><script>window.location='delivery_boy.php';</script><?php
    }
    else
    {
        ?><script>document.getElementById("error").innerHTML="Error : Please Check Database Connections And Main Clases.";</script><?php
    }
           
}
if(isset($_REQUEST['editboy']))
{
    extract($_REQUEST);
    $edtboy = $user->editboydetail($boy_id,$name,$phone,$email,$password,$vehicle_no,$vehicle_type);
    if($edtboy)
    {
        ?>
        <script>
            window.location='delivery_boy.php';
        </script>
        <?php
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Food Delivery System | Restaurant Delivery Boy </title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="Food Delivery System " />
    <meta content="" name="Freaktemplate" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="../assets/css/jquery-ui.min.css" rel="stylesheet" />
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="../assets/css/animate.min.css" rel="stylesheet" />
    <link href="../assets/css/style.min.css" rel="stylesheet" />
    <link href="../assets/css/style-responsive.min.css" rel="stylesheet" />
    <link href="../assets/css/default.css" rel="stylesheet" id="theme" />
    <link href="../assets/css/parsley.css" rel="stylesheet" />
    <script src="../assets/js/pace.min.js"></script>
    <script src="../assets/js/jquery-1.9.1.min.js"></script>
</head>
<body class="boxed-layout">
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<div id="page-container" class="page-container fade page-without-sidebar page-header-fixed page-with-top-menu">
    <?php
    include 'include/header.php';
    include 'include/topmenu.php';
    ?>
    <div id="content" class="content">
        <ol class="breadcrumb pull-right">
            <li><a href="dashboard.php">Home</a> / Delivery Boy</li>
        </ol>
        <h1 class="page-header">Search Boy</small></h1>
        <div class="row">
            <div class="col-md-12">
                <div class="result-container">
                    <form method="get">
                        <div class="input-group m-b-20">
                            <input type="text" name="search" class="form-control input-white" value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>" placeholder="Enter keywords here..." />
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-inverse"><i class="fa fa-search"></i> Search</button>
                                <a href="delivery_boy.php" type="submit" class="btn btn-inverse"> Reset Filter</a>
                            </div>
                        </div>
                    </form>
                    <div class="btn-group m-l-10 m-b-20">
                        <a href="#modal-dialog" class="btn btn-white btn-white-without-border" data-toggle="modal">Register New Delivery Boy</a>
                    </div>
                    <?php
                    $perpage = 10;
                    if(isset($_GET['page']) & !empty($_GET['page'])){
                        $urlpage = $_GET['page'];
                    }else{
                        $urlpage = 1;
                    }
                    $start = ($urlpage * $perpage) - $perpage;
                    $PageSql = "SELECT * FROM `fooddelivery_delivery_boy` where res_id = '".$urlid."'";
                    $pageres = mysqli_query($conn, $PageSql);
                    $totalres = mysqli_num_rows($pageres);
                    $endpage = ceil($totalres/$perpage);
                    $startpage = 1;
                    $nextpage = $urlpage + 1;
                    $previouspage = $urlpage - 1;
                    $ReadSql = "SELECT * FROM `fooddelivery_delivery_boy` where res_id = '".$urlid."' LIMIT $start, $perpage";
                    $res = mysqli_query($conn, $ReadSql);
                    ?>
                    <ul class="pagination pagination-without-border pull-right m-t-0">
                      <?php if($urlpage != $startpage){ ?>
                        <li class="page-item">
                          <a class="page-link" href="?page=<?php echo $startpage ?>" tabindex="-1" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">First</span>
                          </a>
                        </li>
                        <?php } ?>
                        <?php if($urlpage >= 2){ ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $previouspage ?>"><?php echo $previouspage ?></a></li>
                        <?php } ?>
                        <li class="page-item active"><a class="page-link" href="?page=<?php echo $urlpage ?>"><?php echo $urlpage ?></a></li>
                        <?php if($urlpage != $endpage){ ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $nextpage ?>"><?php echo $nextpage ?></a></li>
                        <li class="page-item">
                          <a class="page-link" href="?page=<?php echo $endpage ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Last</span>
                          </a>
                        </li>
                        <?php } ?>
                    </ul>
                    
                    <?php
                    if (isset($_GET['search'])) {
                        $food_boy = mysqli_query($conn,"select * from fooddelivery_delivery_boy where name like '%".$_GET['search']."%' and res_id = '".$urlid."' LIMIT $start, $perpage");
                        {
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Contact No</th>
                                    <th>Email</th>
                                    <th>Vehicle No</th>
                                    <th>Vehicle Type</th>
                                    <th>Attendance</th>
                                    <th>Created At</th>
                                    <th style="width: 185px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($boy = mysqli_fetch_array($food_boy))
                                {
                                ?>
                                <tr class="info">
                                    <td style="width: 20px;"><?php echo $boy['id']; ?></td>
                                    <td style="width: 100px;"><?php echo $boy['name']; ?></td>
                                    <td style="width: 50px;"><?php echo $boy['phone']; ?></td>
                                    <td style="width: 50px;"><?php echo $boy['email']; ?></td>
                                    <td style="width: 50px;"><?php echo $boy['vehicle_no']; ?></td>
                                    <td style="width: 50px;"><?php echo $boy['vehicle_type']; ?></td>
                                    <td style="width: 20px;"><?php echo $boy['attendance']; ?></td>
                                    <td style="width: 50px;"><?php echo date("d-M-Y H:s:ia", $boy['created_at']); ?></td>
                                    <td style="width: 50px;">
                                        <?php
                                        $qstring="boy_id=".$boy['id'];
                                        $enc_str=$user->encrypt_decrypt("encrypt",$qstring);
                                        ?>
                                        <a href="#editboyname" onclick="editboyname('<?php echo $enc_str; ?>')" class=" email-time btn btn-inverse" data-toggle="modal" style="color: white;"><i class="fa fa-edit"></i>Edit</a>
                                        <a href="#" onclick="deleteboy('<?php echo $enc_str; ?>')" class=" email-time btn btn-danger" style="color: white;"><i class="fa fa-remove"></i> Delete</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                        }
                    } else {
                        $boy_list = mysqli_query($conn,"select * from fooddelivery_delivery_boy where res_id = '".$urlid."' LIMIT $start, $perpage");
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Contact No</th>
                                    <th>Email</th>
                                    <th>Vehicle No</th>
                                    <th>Vehicle Type</th>
                                    <th>Attendance</th>
                                    <th>Created At</th>
                                    <th style="width: 185px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($list = mysqli_fetch_array($boy_list))
                                {
                                ?>
                                <tr class="info">
                                    <td style="width: 20px;"><?php echo $list['id']; ?></td>
                                    <td style="width: 100px;"><?php echo $list['name']; ?></td>
                                    <td style="width: 50px;"><?php echo $list['phone']; ?></td>
                                    <td style="width: 50px;"><?php echo $list['email']; ?></td>
                                    <td style="width: 50px;"><?php echo $list['vehicle_no']; ?></td>
                                    <td style="width: 50px;"><?php echo $list['vehicle_type']; ?></td>
                                    <td style="width: 20px;"><?php echo $list['attendance']; ?></td>
                                    <td style="width: 50px;"><?php echo date("d-M-Y H:s:ia", $list['created_at']); ?></td>
                                    <td style="width: 50px;">
                                        <?php
                                        $qstring="boy_id=".$list['id'];
                                        $enc_str=$user->encrypt_decrypt("encrypt",$qstring);
                                        ?>
                                        <a href="#editboyname" onclick="editboyname('<?php echo $enc_str; ?>')" class=" email-time btn btn-inverse" data-toggle="modal" style="color: white;"><i class="fa fa-edit"></i>Edit</a>
                                        <a href="#" onclick="deleteboy('<?php echo $enc_str; ?>')" class=" email-time btn btn-danger" style="color: white;"><i class="fa fa-remove"></i> Delete</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Delivery Boy Registration</h4>
                </div>
                <div class="modal-body">
                    <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                        <div class="panel-body panel-form">
                            <form class="form-horizontal form-bordered" data-parsley-validate="true" method="post" action="" name="demo-form">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="fullname">Name <span style="color: red;">*</span> :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text"  name="name" placeholder="Enter Name" data-parsley-required="true" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="fullname">Contact No <span style="color: red;">*</span> :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text"  name="phone" placeholder="Enter Contact Number" data-parsley-required="true" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="fullname">Email <span style="color: red;">*</span> :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="email" name="email" placeholder="Enter Email" data-parsley-required="true" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="fullname">Password <span style="color: red;">*</span> :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="password" name="password" placeholder="Enter Password" data-parsley-required="true" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="fullname">Vehicle No. <span style="color: red;">*</span> :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text"  name="vehicle_no" placeholder="Enter Vehicle No." data-parsley-required="true" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="fullname">Vehicle Type. <span style="color: red;">*</span> :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text"  name="vehicle_type" placeholder="Enter Vehicle Type." data-parsley-required="true" />
                                    </div>
                                </div>
                                

                                <div class="modal-footer">
                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                    <input type="submit" class="btn btn-primary" name="addnewboy" value="Submit" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editboyname">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Edit Delivery Boy Details</h4>
                </div>
                <div class="modal-body" >
                   <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                        <div class="panel-body panel-form">
                            <form class="form-horizontal form-bordered" data-parsley-validate="true" method="post" action="" name="demo-form">
                                <div class="form-group" id="editboydetails">

                                </div>

                                <div class="modal-footer">
                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                    <input type="submit" class="btn btn-primary" name="editboy" value="Update" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/jquery-migrate-1.1.0.min.js"></script>
<script src="../assets/js/jquery-ui.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/jquery.slimscroll.min.js"></script>
<script src="../assets/js/jquery.cookie.js"></script>
<script src="../assets/js/parsley.js"></script>
<script src="../assets/js/apps.min.js"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script>
    function editboyname(id)
    {
        $.ajax({
            type: "POST",
            url: "../ajax/editboy.php",
            data: {querystring: id},
            cache: false,
            success: function (data)
            {
                if (data)
                {
                    $('#editboydetails').replaceWith($('#editboydetails').html(data));
                }
                else
                {

                }
            }
        });
    }
</script>
<script>
    function deleteboy(id)
    {

        var x = confirm("Are you sure want to delete ?");
        if(x) {

            $.ajax({
                type: "POST",
                url: "../ajax/deleteboy.php",
                data: {boy_id: id},
                cache: false,
                success: function (data)
                {
                    if (data)
                    {
                        window.location='delivery_boy.php';
                    }
                    else
                    {
                        alert("Please Try Again Latter..");
                    }
                }
            });
        }
        else
        {
            return false;
        }
    }
</script>
</body>
</html>
