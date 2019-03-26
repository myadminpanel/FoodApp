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
$clearordercount=$user->clearordernotify();
$ressss=$user->getuserinfo($uid);
$urlid = $ressss->res_id;
$food_order = mysqli_query($conn,"SELECT * FROM fooddelivery_bookorder where res_id = '".$urlid."' ORDER BY id DESC");
$review = mysqli_query($conn,"SELECT * FROM fooddelivery_reviews where res_id = '".$urlid."' ORDER BY id DESC");
$boy = mysqli_query($conn,"SELECT * FROM fooddelivery_delivery_boy where res_id = '".$urlid."' ORDER BY id DESC");

if(isset($_REQUEST['assign']))
{

    include('assign_order.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Food Delivery System | Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="Food Delivery System" />
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
            background: url(uploads/loading.gif) center no-repeat #fff;
            opacity: 0.7;
        }
        #printable { display: none; }

        @media print
        {
            #non-printable { display: none; }
            #printable { display: block; }
        }
        @page { size: auto;  margin: 0mm; }
        @media print {
           body { font-size: 6pt; background-color: #000;}
        }
        @page {
          size: A4;
          margin-top: -70px;
        }
    </style>
<div class="se-pre-con" hidden id="loading"></div>
</head>
<body class="boxed-layout">
    <div id="page-loader" class="fade in"><span class="spinner"></span></div>
    <div id="page-container" class="page-container fade page-without-sidebar page-header-fixed page-with-top-menu">
        <span id="non-printable">
        <?php
        include 'include/header.php';
        include 'include/topmenu.php';
        ?>
        </span>
        <div id="content" class="content">
            <ol class="breadcrumb pull-right">
                <li id="non-printable"><a  href="dashboard.php">Home</a> / Dashboard</li>
            </ol>
            <h1  id="non-printable" class="page-header">Food Order </small></h1>

            <div class="btn-group m-l-10 m-b-20" id="non-printable">
                <a href="editrestaurant.php" class="btn btn-white btn-white-without-border" >Edit Restaurant Details</a>
            </div>
            
            <div id="non-printable" class="row">
                <div class="col-md-12">
                    <div class="col-md-4 ui-sortable">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <h4 class="panel-title">Total Order</h4>
                            </div>
                            <div>
                                <div class="btn-group m-l-10 m-b-20">
                                    <h3>&nbsp; <font color="#008b8b" style="text-align: center;"><?php echo mysqli_num_rows($food_order); ?></font></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ui-sortable">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <h4 class="panel-title">Review</h4>
                            </div>
                            <div>
                                <div class="btn-group m-l-10 m-b-20">
                                    <h3>&nbsp; <font color="#008b8b" style="text-align: center;"><a href="reviews.php"><?php echo mysqli_num_rows($review); ?></a></font></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ui-sortable">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <h4 id="non-printable" class="panel-title">Delivery Boy</h4>
                            </div>
                            <div>
                                <div class="btn-group m-l-10 m-b-20">
                                    <h3>&nbsp; <font color="#008b8b" style="text-align: center;"><a id="non-printable" href="delivery_boy.php"><?php echo mysqli_num_rows($boy); ?></a></font></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" id="non-printable">
                    <div class="result-container">
                        <div class="panel panel-inverse" data-sortable-id="table-basic-6">
                            <div class="panel-heading">
                                <h4 class="panel-title"><i class="fa fa-shopping-cart"></i> Restaurant Orders</h4>
                            </div>
                            <div class="panel-body">
                                <?php
                                $perpage = 5;
                                if(isset($_GET['page']) & !empty($_GET['page'])){
                                    $urlpage = $_GET['page'];
                                }else{
                                    $urlpage = 1;
                                }
                                $start = ($urlpage * $perpage) - $perpage;
                                $totalres = mysqli_num_rows($food_order);
                                $endpage = ceil($totalres/$perpage);
                                $startpage = 1;
                                $nextpage = $urlpage + 1;
                                $previouspage = $urlpage - 1;
                                $ReadSql = "SELECT * FROM fooddelivery_bookorder where res_id = '".$urlid."' LIMIT $start, $perpage";
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
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Address</th>
                                            <th>Total Price</th>
                                            <th>More Detail</th>
                                            <th>Print</th>
                                            <th style="width: 185px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $food_orders = mysqli_query($conn,"SELECT * FROM fooddelivery_bookorder 
                                            where res_id = '".$urlid."' ORDER BY id DESC LIMIT $start, $perpage");
                                        while ($order = mysqli_fetch_array($food_orders))
                                        {
                                            ?>
                                            <tr class="info">
                                                <td><?php echo $order['id']; ?></td>
                                                <td><?php echo $order['address']; ?></td>
                                                
                                                <td><?php echo $order['total_price'].'$'; ?></td>
                                                <?php
                                                $qstring1="id=".$order['id'];
                                                $enc_str1=$user->encrypt_decrypt("encrypt",$qstring1);
                                                ?>
                                                <td><a href="#viewmoredetail" data-toggle="modal" onclick="viewmoredetail('<?php echo $enc_str1; ?>')" class="badge badge-info">More</a></td>
                                                <td><!-- <a href="#viewfooddescription" data-toggle="modal" onclick="viewfooddescription('<?php echo $enc_str1;?>')" class="badge badge-info">Print</a> -->
                                                    <a href="print.php?order_id=<?php echo $enc_str1;?>" class="badge badge-info" target="_blank">Print</a>
                                                </td>
                                                <td style="width: 215px;">
                                                <?php
                                                if ($order['status'] == '0') {
                                                ?>
                                                <a class="badge badge-success" onclick="confirmorder('<?php echo $enc_str1;?>')"><i class="fa fa-check"></i> Accept</a>
                                                <a onclick="rejectorder('<?php echo $enc_str1;?>')" class="badge badge-danger">
                                                    <i class="fa fa-ban"></i> Reject</a>
                                                    <a onclick="deletefoodorder('<?php echo $enc_str1;?>')" class="badge badge-danger">Delete</a>
                                                    <?php
                                                } elseif ($order['status'] == '1') {
                                                    ?>
                                                    <?php
                                                    $qstring="order_id=".$order['id'];
                                                    $enc_str=$user->encrypt_decrypt("encrypt",$qstring);
                                                    ?>
                                            <!-- <a onclick="outfordelivery('<?php echo $enc_str1;?>')" class="badge badge-info">
                                                <i class="fa fa-truck"></i> Out For Delivery</a> -->
                                                <a href="#assign_order" onclick="assign_order('<?php echo $enc_str; ?>')" class="badge badge-success" data-toggle="modal" style="color: white;"><i class="fa fa-check"></i>Assign Order</a>
                                                <?php
                                            } elseif ($order['status'] == '5') {
                                                ?>
                                                <a class="badge badge-success"><i class="fa fa-refresh"></i> In Pickup</a>
                                                <?php
                                            } elseif ($order['status'] == '2') {
                                                ?>
                                                <a class="badge badge-danger"><i class="fa fa-ban"></i> Rejected</a>
                                                <?php
                                            } elseif ($order['status'] == '3') {
                                                ?>
                                                <a onclick="delivered('<?php echo $enc_str1;?>')" class="badge badge-inverse">
                                                    <i class="fa fa-check"></i> Delivered</a>
                                                    <?php
                                                } elseif ($order['status'] == '4') {
                                                    ?>
                                                    <a onclick="deletefoodorder('<?php echo $enc_str1;?>')" class="badge badge-danger">Delete</a>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="viewmoredetail" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="#" class="form-horizontal" id="validation-form" method="post">
                
                <div class="modal-body" id="moredetail">

                </div>
            </form>
        </div>
    </div>
</div>
<div id="viewfooddescription" class="modal fade" >
    <div class="modal-dialog" style="border:1px solid;">
        <div class="modal-content">
            <form action="#" class="form-horizontal" id="validation-form" method="post">
                <div class="modal-body" id="moredescription">

                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="assign_order">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Assign Order to Delivery Boy</h4>
            </div>
            <div class="modal-body" >
             <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                <div class="panel-body panel-form">
                    <form class="form-horizontal form-bordered" data-parsley-validate="true" method="post" action="" name="demo-form">
                        <div class="form-group" id="order_assign">

                        </div>

                        <div class="modal-footer">
                            <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                            <input type="submit" class="btn btn-primary" name="assign" value="Assign" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    function assign_order(id)
    {
        $.ajax({
            type: "POST",
            url: "../ajax/assign_order.php",
            data: {querystring: id},
            cache: false,
            success: function (data)
            {
                if (data)
                {
                    $('#order_assign').replaceWith($('#order_assign').html(data));
                }
                else
                {

                }
            }
        });
    }
</script>
<script>
    function confirmorder(id){
        $("#loading").show();
        $.ajax({
            type: "POST",
            url: '../ajax/confirmorder.php',
            data: {querystring: id},
            success: function (data) {
                if (data == 1) {
                    $("#loading").hide();
                    alert("!!! Order Confirm Successfully !");
                    window.location='dashboard.php';
                }
                else
                {
                    $("#loading").hide();
                    alert("! Try again please!!!");
                }
            }
        });
    }
    function rejectorder(id){
        $("#loading").show();
        $.ajax({
            type: "POST",
            url: '../ajax/rejectorder.php',
            data: {querystring: id},
            success: function (data) {
                if (data == 1) {
                    $("#loading").hide();
                    alert("!!! Order has been Rejected !");
                    window.location='dashboard.php';
                }
                else
                {
                    $("#loading").hide();
                    alert("! Try again please!!!");
                }
            }
        });
    }
    function outfordelivery(id){
        $("#loading").show();
        $.ajax({
            type: "POST",
            url: '../ajax/outfordelivery.php',
            data: {querystring: id},
            success: function (data) {
                if (data == 1) {
                    $("#loading").hide();
                    alert("!!! Order Is Out For Delivery !");
                    window.location='dashboard.php';
                }
                else
                {
                    $("#loading").hide();
                    alert("! Try again please!!!");
                }
            }
        });
    }
    function delivered(id){
        $("#loading").show();
        $.ajax({
            type: "POST",
            url: '../ajax/delivered.php',
            data: {querystring: id},
            success: function (data) {
                if (data == 1) {
                    $("#loading").hide();
                    alert("!!! Order Is Delivered !");
                    window.location='dashboard.php';
                }
                else
                {
                    $("#loading").hide();
                    alert("! Try again please!!!");
                }
            }
        });
    }
    function viewuserdetail(id)
    {
        $.ajax({
            type: "POST",
            url: "../ajax/viewpersondetail.php",
            data: {querystring: id},
            cache: false,
            success: function (data)
            {
                if (data)
                {
                    $('#userdetail').replaceWith($('#userdetail').html(data));
                }
                else
                {

                }
            }
        });
    }
    function viewmoredetail(id)
    {
        $.ajax({
            type: "POST",
            url: "../ajax/moredetail.php",
            data: {querystring: id},
            cache: false,
            success: function (data)
            {
                if (data)
                {
                    $('#moredetail').replaceWith($('#moredetail').html(data));
                }
                else
                {

                }
            }
        });
    }
    function viewfooddescription(id)
    {
        $.ajax({
            type: "POST",
            url: "../ajax/viewfooddescription.php",
            data: {querystring: id},
            cache: false,
            success: function (data)
            {
                if (data)
                {
                    $('#moredescription').replaceWith($('#moredescription').html(data));
                }
                else
                {

                }
            }
        });
    }
</script>
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
    function deletefoodorder(id)
    {
        var x = confirm("Are you sure want to delete ?");
        if(x)
        {
            $.ajax({
                type: "POST",
                url: "../ajax/deletefoodorder.php",
                data: {querystring: id},
                cache: false,
                success: function (data)
                {
                    if (data)
                    {
                        window.location='dashboard.php';
                    }
                    else
                    {
                        alert(" Please Try Again Latter.. ");
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
