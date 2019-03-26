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
if(isset($_POST['addnewmenu']))
{

    if(isset($_POST['mname']))
    {
        extract($_REQUEST);
        $user->addnewmenu($urlid,$mname);
        if($user)
        {
            ?>
            <script>
                window.location='menu.php';
            </script>
            <?php
        }
        else
        {
            ?><script>document.getElementById("error").innerHTML="Error : Please Check Database Connections And Main Clases.";</script><?php
        }
    }
    else
    {
        ?><script>alert("Fill Menu");</script><?php
    }
}
if(isset($_REQUEST['editmenu']))
{
    extract($_REQUEST);
    $edtmenu = $user->editmenudetail($menu_id,$mname);
    if($edtmenu)
    {
        ?>
        <script>
            window.location='menu.php';
        </script>
        <?php
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Food Delivery System | Restaurant Menu Category </title>
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
            <li><a href="dashboard.php">Home</a> / Restaurant Menu</li>
        </ol>
        <h1 class="page-header">Search Menu</small></h1>
        <div class="row">
            <div class="col-md-12">
                <div class="result-container">
                    <form method="get">
                        <div class="input-group m-b-20">
                            <input type="text" name="search" class="form-control input-white" value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>" placeholder="Enter keywords here..." />
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-inverse"><i class="fa fa-search"></i> Search</button>
                                <a href="menu.php" type="submit" class="btn btn-inverse"> Reset Filter</a>
                            </div>
                        </div>
                    </form>
                    <div class="btn-group m-l-10 m-b-20">
                        <a href="#modal-dialog" class="btn btn-white btn-white-without-border" data-toggle="modal">Add New Menu</a>
                    </div>
                    <?php
                    $perpage = 10;
                    if(isset($_GET['page']) & !empty($_GET['page'])){
                        $urlpage = $_GET['page'];
                    }else{
                        $urlpage = 1;
                    }
                    $start = ($urlpage * $perpage) - $perpage;
                    $PageSql = "SELECT * FROM `fooddelivery_menu` where res_id = '".$urlid."'";
                    $pageres = mysqli_query($conn, $PageSql);
                    $totalres = mysqli_num_rows($pageres);
                    $endpage = ceil($totalres/$perpage);
                    $startpage = 1;
                    $nextpage = $urlpage + 1;
                    $previouspage = $urlpage - 1;
                    $ReadSql = "SELECT * FROM `fooddelivery_menu` where res_id = '".$urlid."' LIMIT $start, $perpage";
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
                        $food_menu = mysqli_query($conn,"select * from fooddelivery_menu where name like '%".$_GET['search']."%' and res_id = '".$urlid."' LIMIT $start, $perpage");
                        while ($menu = mysqli_fetch_array($food_menu))
                        {
                        ?>
                        <ul class="list-group list-group-lg no-radius list-email">
                        <li class="list-group-item inverse" >
                            <div class="email-user" style="background-color: #00acac;color: white;">
                                <?php
                                $mname=$menu['name'];
                                preg_match("/./u", $mname, $mname1);
                                echo strtoupper($mname1[0]);
                                ?>
                            </div>
                            <div class="email-info">
                                <span class="email-time"></span>
                                <?php
                                $qstring="menu_id=".$menu['id'];
                                $enc_str=$user->encrypt_decrypt("encrypt",$qstring);
                                ?>
                                <a href="submenu.php?alexe0sdsc=<?php echo $enc_str; ?>" class=" email-time btn btn-info" style="color: white;"><i class="fa fa-plus"></i> Add Submenu</a>
                                <a href="#" onclick="deletemenu('<?php echo $enc_str; ?>')" class=" email-time btn btn-danger" style="color: white;"><i class="fa fa-remove"></i> Delete</a>
                                <a href="#editmenuname" onclick="editmenuname('<?php echo $enc_str; ?>')" class=" email-time btn btn-inverse" data-toggle="modal" style="color: white;"><i class="fa fa-edit"></i>Edit</a>
                                <h5 class="email-title">
                                    <?php echo $menu['name']; ?>
                                </h5>
                                <p class="email-desc">
                                    Created At : <?php echo date("d-M-Y H:s:ia", $menu['created_at']); ?>
                                 </p>
                            </div>
                        </li>
                        </ul>
                        <?php
                        }
                    } else {
                        $food_menu = mysqli_query($conn,"select * from fooddelivery_menu where res_id = '".$urlid."' LIMIT $start, $perpage");
                        while ($menu = mysqli_fetch_array($food_menu))
                        {
                        ?>
                        <ul class="list-group list-group-lg no-radius list-email">
                        <li class="list-group-item inverse" >
                            <div class="email-user" style="background-color: #00acac;color: white;">
                                <?php
                                $mname=$menu['name'];
                                preg_match("/./u", $mname, $mname1);
                                echo strtoupper($mname1[0]);
                                ?>
                            </div>
                            <div class="email-info">
                                <span class="email-time"></span>
                                <?php
                                $qstring="menu_id=".$menu['id'];
                                $enc_str=$user->encrypt_decrypt("encrypt",$qstring);
                                ?>
                                <a href="submenu.php?alexe0sdsc=<?php echo $enc_str; ?>" class=" email-time btn btn-info" style="color: white;"><i class="fa fa-plus"></i> Add Submenu</a>
                                <a href="#" onclick="deletemenu('<?php echo $enc_str; ?>')" class=" email-time btn btn-danger" style="color: white;"><i class="fa fa-remove"></i> Delete</a>
                                <a href="#editmenuname" onclick="editmenuname('<?php echo $enc_str; ?>')" class=" email-time btn btn-inverse" data-toggle="modal" style="color: white;"><i class="fa fa-edit"></i>Edit</a>
                                <h5 class="email-title">
                                    <?php echo $menu['name']; ?>
                                </h5>
                                <p class="email-desc">
                                    Created At : <?php echo date("d-M-Y H:s:ia", $menu['created_at']); ?>
                                 </p>
                            </div>
                        </li>
                        </ul>
                        <?php
                        }
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
                    <h4 class="modal-title">Add New Menu Category</h4>
                </div>
                <div class="modal-body">
                    <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                        <div class="panel-body panel-form">
                            <form class="form-horizontal form-bordered" data-parsley-validate="true" method="post" action="" name="demo-form">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="fullname">Menu Name <span style="color: red;">*</span> :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text"  name="mname" placeholder="Menu Name" data-parsley-required="true" />
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                    <input type="submit" class="btn btn-primary" name="addnewmenu" value="Add Menu" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editmenuname">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Edit Menu Category</h4>
                </div>
                <div class="modal-body" >
                   <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                        <div class="panel-body panel-form">
                            <form class="form-horizontal form-bordered" data-parsley-validate="true" method="post" action="" name="demo-form">
                                <div class="form-group" id="editmenucategory">

                                </div>

                                <div class="modal-footer">
                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                    <input type="submit" class="btn btn-primary" name="editmenu" value="Edit Menu" />
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
    function editmenuname(id)
    {
        $.ajax({
            type: "POST",
            url: "../ajax/editmenucategory.php",
            data: {querystring: id},
            cache: false,
            success: function (data)
            {
                if (data)
                {
                    $('#editmenucategory').replaceWith($('#editmenucategory').html(data));
                }
                else
                {

                }
            }
        });
    }
</script>
<script>
    function deletemenu(id)
    {

        var x = confirm("Are you sure want to delete ?");
        if(x) {

            $.ajax({
                type: "POST",
                url: "../ajax/deletemenu.php",
                data: {menu_id: id},
                cache: false,
                success: function (data)
                {
                    if (data)
                    {
                        window.location='menu.php';
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
