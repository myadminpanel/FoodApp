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
$clearordercount=$user->clearordernotify();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Food Delivery System | Food Order</title>
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
    <link href="assets/css/parsley.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
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
    </style>
<div class="se-pre-con" hidden id="loading"></div>
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
            <li><a href="dashboard.php">Home</a> / Food Order</li>
        </ol>
        <h1 class="page-header">Food Order </small></h1>
        <div class="row">
            <div class="col-md-12">
                <div class="result-container">
                    <?php
                    $per_page = 10;
                    if(isset($_GET['page']))
                    {
                        $pageset = $_GET['page'];
                        if ($pageset == 1)
                        {
                            $start = 0;
                            $page = $per_page;
                        }
                        else
                        {
                            $page = $_GET['page'] * $per_page;
                            $start = $page - $per_page;
                        }
                    }
                    else
                    {
                        $start = 0;
                        $page = $per_page;
                    }
                    if (isset($_GET['AXOsdsdf872']) && $_GET['AXOsdsdf872'])
                    {
                        $search_enc=$_GET['AXOsdsdf872'];
                        $search_data=$user->encrypt_decrypt("decrypt",$search_enc);
                        $val=explode("=",$search_data);
                        $search=$val[1];
                        $qutotal= $user->getfoodorder($search,"searchtotal","none","none");
                        $query = $user->getfoodorder($search,"search",$start,$per_page);
                    }
                    else
                    {
                        $query = $user->getfoodorder("none","none",$start,$per_page);
                        $qutotal= $user->getfoodorder("none","total","none","none");
                    }
                    ?>
                    <div class="panel panel-inverse" data-sortable-id="table-basic-6">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-shopping-cart"></i> Restaurant Orders</h4>
                            <div align="right">
                                <select name="asdasd" class="form-control" style="width: auto;margin-top: -25px;" onchange="filterpage(this.value)">
                                    <option value="">Select Restaurant</option>
                                    <?php
                                    $restaurntlist=$user->getallrestaurantbyfilter();
                                    foreach ($restaurntlist as $list)
                                    {
                                        $qstring1asd="id=".$list['id'];
                                        $enc_str1asd=$user->encrypt_decrypt("encrypt",$qstring1asd);
                                        ?>
                                        <option value="<?php echo $enc_str1asd; ?>"><?php echo $list['name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                    <option value="">asdsadas</option>
                                </select>
                            </div>
                        </div>
                        <script> function filterpage(id) { window.location="foodorder.php?AXOsdsdf872="+id; } </script>
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Restaurant Name</th>
                                        <th>Address</th>
                                        <th>Total Price</th>
                                        <th>More Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if($query)
                                    {
                                        foreach ($query as $res)
                                        {
                                            ?>
                                            <tr class="info">
                                                <td><?php echo $res['id']; ?></td>
                                                <?php
                                                 $qstring="user_id=".$res['user_id'];
                                                 $enc_str=$user->encrypt_decrypt("encrypt",$qstring);
                                                ?>
                                                <td><?php echo $user->getresname($res['res_id']); ?></td>
                                                <td><?php echo $res['address']; ?>

                                                    <!-- $output = str_replace(',', '<br />', $input);
                                                    echo $output; -->
                                                    
                                                </td>
                                                <?php
                                                    $currency=$user->getcurrencybyid($res['res_id']);
                                                    $sign=$currency->currency;
                                                ?>
                                                <td><?php echo $sign ." " ; echo $res['total_price'];?></td>
                                                <?php
                                                $qstring1="id=".$res['id'];
                                                $enc_str1=$user->encrypt_decrypt("encrypt",$qstring1);
                                                ?>
                                                <td><a href="#viewmoredetail" data-toggle="modal" onclick="viewmoredetail('<?php echo $enc_str1; ?>')" class="badge badge-info">More</a></td>
                                                
                                            </tr>
                                            <?php
                                        }
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="clearfix">
                        <ul class="pagination pagination-without-border pull-left">
                            <?php
                            $total = $qutotal;
                            $j1 = ceil($total / $per_page);
                            $next = ceil($total / $per_page);
                            if($total)
                            {
                                if(isset($_GET['page']))
                                {
                                    $pageval = $_GET['page'];
                                }
                                else
                                {
                                    $pageval=1;
                                }
                                if ($pageval == 1)
                                {
                                    ?>
                                    <li class="disabled">
                                        <a href="javascript:void(0)" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                else
                                {
                                    $prev = $pageval - 1;
                                    if(isset($_GET['search']))
                                    {
                                        ?>
                                        <li>
                                            <a href="foodorder.php?page=<?php echo $prev; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li>
                                            <a href="foodorder.php?page=<?php echo $prev; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                                <?php
                                for ($i = 1; $i <= $j1; $i++)
                                {
                                    if(isset($_GET['search']))
                                    {
                                        if ($pageval == $i)
                                        {
                                            ?>
                                            <li class="active"><a href="#"><?php echo $i; ?><span
                                                        class="sr-only">(current)</span></a>
                                            </li>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <li><a href="foodorder.php?page=<?php echo $i; ?>&search=<?php echo $_GET['search'];  ?>"><?php echo $i; ?><span
                                                        class="sr-only">(current)</span></a></li>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        if ($pageval == $i)
                                        {
                                            ?>
                                            <li class="active"><a href="#"><?php echo $i; ?><span
                                                        class="sr-only">(current)</span></a>
                                            </li>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <li><a href="foodorder.php?page=<?php echo $i; ?>"><?php echo $i; ?><span
                                                        class="sr-only">(current)</span></a></li>
                                            <?php
                                        }
                                    }
                                }
                                if ($next == $pageval) {
                                    ?>
                                    <li class="disabled">
                                        <a href="javascript:void(0)"aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                } else {
                                    $next1 = $pageval + 1;
                                    if(isset($_GET['search'])) {
                                        ?>
                                        <li>
                                            <a href="foodorder.php?page=<?php echo $next1; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <li>
                                            <a href="foodorder.php?page=<?php echo $next1; ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                            }
                            else
                            {
                                ?>
                                <li class="disabled">
                                    <a href="javascript:void(0)" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="disabled">
                                    <a href="javascript:void(0)" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div id="persondetail" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="#" class="form-horizontal" id="validation-form" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel1">Person Detail</h3>
                </div>
                <div class="modal-body" id="userdetail">

                </div>
            </form>
        </div>
    </div>
</div> -->
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
<div id="viewfooddescription" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="#" class="form-horizontal" id="validation-form" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel1">Food Description</h3>
                </div>
                <div class="modal-body" id="moredescription">

                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function confirmorder(id){
        $("#loading").show();
        $.ajax({
            type: "POST",
            url: 'ajax/confirmorder.php',
            data: {querystring: id},
            success: function (data) {
                if (data == 1) {
                    $("#loading").hide();
                    alert("!!! Order Confirm Successfully !");
                    window.location='foodorder.php';
                }
                else
                {
                    $("#loading").hide();
                    alert("! Try again please>!!!");
                }
            }
        });
    }
    function rejectorder(id){
        $("#loading").show();
        $.ajax({
            type: "POST",
            url: 'ajax/rejectorder.php',
            data: {querystring: id},
            success: function (data) {
                if (data == 1) {
                    $("#loading").hide();
                    alert("!!! Order has been Rejected !");
                    window.location='foodorder.php';
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
            url: 'ajax/outfordelivery.php',
            data: {querystring: id},
            success: function (data) {
                if (data == 1) {
                    $("#loading").hide();
                    alert("!!! Order Is Out For Delivery !");
                    window.location='foodorder.php';
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
            url: 'ajax/delivered.php',
            data: {querystring: id},
            success: function (data) {
                if (data == 1) {
                    $("#loading").hide();
                    alert("!!! Order Is Delivered !");
                    window.location='foodorder.php';
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
            url: "ajax/viewpersondetail.php",
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
            url: "ajax/moredetail.php",
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
            url: "ajax/viewfooddescription.php",
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
<script src="assets/js/jquery-1.9.1.min.js"></script>
<script src="assets/js/jquery-migrate-1.1.0.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/jquery.cookie.js"></script>
<script src="assets/js/parsley.js"></script>
<script src="assets/js/apps.min.js"></script>
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
                url: "ajax/deletefoodorder.php",
                data: {querystring: id},
                cache: false,
                success: function (data)
                {
                    if (data)
                    {
                        window.location='foodorder.php';
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
