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
// if (!$user->get_session())
// {
//     header("location:index.php");
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Food Delivery System | Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="Food Delivery System" />
    <meta content="" name="Freaktemplate"/>
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
    <script type="text/javascript">
    $.get('https://ipapi.co/timezone', function(data){
        $.get('https://ipapi.co/timezone', function(data){
          $('.timezone').text(data);
        });
    });
    </script>
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
            <li><a href="javascript:;">Home</a></li>
        </ol>
        <h1 class="page-header">Search Restaurant </small></h1>
        <div class="row">
            <div class="col-md-12">
                <div class="result-container">
                    <form method="get">
                        <div class="input-group m-b-20">
                            <input type="hidden" name="page" value="1">
                            <input type="text" name="search" class="form-control input-white" value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>" placeholder="Enter keywords here..." />
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-inverse"><i class="fa fa-search"></i> Search </button>
                                <a href="dashboard.php" type="submit" class="btn btn-inverse"> Reset Filter</a>
                            </div>
                        </div>
                    </form>
                    <div class="btn-group m-l-10 m-b-20">
                        <?php
                            $is_cat= $user->checkcategoryisnow();
                            if($is_cat)
                            {
                              ?>
                                <a href="addrestaurant.php" class="btn btn-white btn-white-without-border">Add New Restaurant</a>
                               <?php
                            }
                            else
                            {
                                ?>
                                    <a onclick="confirm('Please Add Restaurant Category To Unlock Add Restaurant Detail Page')" class="btn btn-white btn-white-without-border">Add New Restaurant</a>
                                <?php
                            }
                        ?>
                        <a href="viewnewresowner.php" class="btn btn-white btn-white-without-border" >View Restaurant Owner</a>
                      
                    </div>
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
                            if (isset($_GET['search']))
                            {
                                $search=$_GET['search'];
                                $qutotal= $user->getrestaurant($search,"searchtotal","none","none");
                                $query = $user->getrestaurant($search,"search",$start,$per_page);
                            }
                            else
                            {
                                $query = $user->getrestaurant("none","none",$start,$per_page);
                                $qutotal= $user->getrestaurant("none","total","none","none");
                            } ?>

                            <ul class="pagination pagination-without-border pull-right m-t-0">
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
                                                <a href="dashboard.php?page=<?php echo $prev; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <li>
                                                <a href="dashboard.php?page=<?php echo $prev; ?>" aria-label="Previous">
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
                                                <li class="active"><a href="#"><?php echo $i; ?><span class="sr-only">(current)</span></a></li>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <li><a href="dashboard.php?page=<?php echo $i; ?>&search=<?php echo $_GET['search'];  ?>"><?php echo $i; ?><span class="sr-only">(current)</span></a></li>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            if ($pageval == $i)
                                            {
                                                ?>
                                                <li class="active">
                                                    <a href="#"><?php echo $i; ?><span class="sr-only">(current)</span></a>
                                                </li>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <li><a href="dashboard.php?page=<?php echo $i; ?>"><?php echo $i; ?><span
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
                                    }
                                    else
                                    {
                                        $next1 = $pageval + 1;
                                        if(isset($_GET['search']))
                                        {
                                            ?>
                                            <li>
                                                <a href="dashboard.php?page=<?php echo $next1; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <li>
                                                <a href="dashboard.php?page=<?php echo $next1; ?>" aria-label="Next">
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
                            <ul class="result-list">
                        <?php
                        if($query)
                        {
                            foreach ($query as $val)
                            {
                                if($val['is_active'] == 1)
                                {
                                    $bgcolor="indianred";
                                    $color="white";
                                }
                                else
                                {
                                    $bgcolor="";
                                    $color="";
                                }
                                ?>
                                <li style="background-color: <?php echo $bgcolor; ?>;color: <?php echo $color; ?>;">
                                    <div class="result-image col-md-3">
                                        <img src="uploads/restaurant/<?php echo $val['photo']; ?>" style="height:197px ;width:240px;" alt=""  />
                                    </div>
                                    <div class="result-info col-md-6" >
                                        <h4 class="title"><?php echo $val['name']; ?></h4>
                                        <div class="location" style="color: <?php echo $color; ?>;white-space: nowrap;width: 100%;overflow: hidden;text-overflow: ellipsis;"><?php echo $val['address']; ?></div>
                                        <div class="desc" style="margin-top: 6px;"><font color="black">Phone No :</font>
                                            <?php echo $val['phone']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <font color="black">Created At
                                                : </font><?php echo date("d-M-Y H:s:ia", $val['timestamp']); ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <font color="black">Currency : </font><?php echo $val['currency']; ?>
                                        </div>
                                        <div class="desc" style="margin-top: -15px;">
                                            <font color="black">Restaurant
                                                Timing:</font> <?php echo date("h:i A",strtotime($val['open_time'])) . " To " . date("h:i A",strtotime($val['close_time'])); ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <font color="black">Delivery Charge : </font> <?php echo $val['del_charge']; ?>
                                        </div>
                                        <div class="desc" style="margin-top: -15px;">
                                            <font color="black">Category : </font>
                                            <?php
                                            $res_id = $val['id'];
                                            $cname = $user->getcategory_passid($res_id, "nope", "nope");

                                            if ($cname) {
                                                foreach ($cname as $val1)
                                                {
                                                    ?>
                                                    <span class="badge badge-primary"><?php echo $val1['cname']; ?></span>
                                                    <?php
                                                }
                                            }
                                            $enc_idval = $user->encrypt_decrypt("encrypt", "res_id=" . $val['id']);
                                            ?>
                                        </div>
                                        <div class="btn-row">
                                            <?php    $Constant = button; 
                                            if ($Constant == "Active") { ?>
                                            <a  href="editrestaurant.php?<?php echo $enc_idval; ?>" data-toggle="tooltip" data-container="body"
                                               data-title="Edit Restaurant"><i class="fa fa-fw fa-edit" style="color: black"></i>
                                            </a>
                                            <a href="#" onclick="deleterestaurant('<?php echo $enc_idval; ?>')" data-toggle="tooltip" data-container="body"
                                               data-title="Delete Restaurant"><i class="fa fa-fw fa-trash" style="color: black"></i>
                                            </a>
                                            <?php } else { ?>
                                            <a onClick="return confirm('This function is currently disable as it is only a demo website, in your admin it will work perfect')"  data-toggle="tooltip" data-container="body"
                                               data-title="Edit Restaurant"><i class="fa fa-fw fa-edit" style="color: black"></i>
                                            </a>
                                            <a onClick="return confirm('This function is currently disable as it is only a demo website, in your admin it will work perfect')" data-toggle="tooltip" data-container="body"
                                               data-title="Delete Restaurant"><i class="fa fa-fw fa-trash" style="color: black"></i>
                                            </a>
                                            <?php
                                            }
                                            if($val['is_active'] == 0)
                                            {
                                                ?>
                                                <a href="#" onclick="activerestaurant('<?php echo $enc_idval; ?>')" data-toggle="tooltip" data-container="body"
                                                   data-title="Deactivate Restaurant"><i class="fa fa-fw fa-arrow-left" style="color: black"></i></a>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <a href="#" onclick="activerestaurant('<?php echo $enc_idval; ?>')" data-toggle="tooltip" data-container="body"
                                                   data-title="Activate Restaurant"><i class="fa fa-fw fa-arrow-right" style="color: black"></i></a>
                                                <?php
                                            }
                                            ?>
                                            <a href="menu.php?AXOsdsdf872=<?php echo $enc_idval;  ?>" data-toggle="tooltip" data-container="body"
                                               data-title="View Menu"><i class="fa fa-fw fa-list" style="color: black"></i></a>
                                            <a href="foodorder.php?AXOsdsdf872=<?php echo $enc_idval;  ?>" data-toggle="tooltip" data-container="body"
                                               data-title="View Orders"><i class="fa fa-fw fa-shopping-cart" style="color: black"></i>
                                            </a>
                                            
                                        </div>
                                    </div>
                                    <div class="result-price col-md-3">
                                        Ratting <?php echo $user->getratting($val['id']); ?>
                                        <small style="color: <?php echo $color; ?>;">TOTAL <?php echo $user->totalresreview($val['id']); ?> REVIEWS</small>
                                        <?php
                                        $query = mysqli_query($conn,"select timezone from fooddelivery_adminlogin where id ='".$uid."'");
                                        $fetch = mysqli_fetch_array($query);
                                        $timezone = $fetch['timezone'];

                                        $default_time = explode(" - ", $timezone);
                                        $vals = $default_time[0];
                                        date_default_timezone_set($vals);
                                        $resstatus=$user->res_openandclose($val['id'],$val['open_time'],$val['close_time']);
                                        if($resstatus == "open")
                                        {
                                            ?>
                                               <div class="btn btn-inverse btn-block">OPEN</div>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                                <div class="btn btn-warning btn-block">Closed</div>
                                            <?php
                                        }
                                            ?>
                                    </div>
                                </li>
                                <?php
                            }
                        }
                    ?>

                    </ul>
                    <div class="clearfix">
                        <ul class="pagination pagination-without-border pull-right">
                            <?php
                            $total = $qutotal;
                            $j1 = ceil($total / $per_page);
                            $next = ceil($total / $per_page);
                            if($total){
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
                                        <a href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
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
                                            <a href="dashboard.php?page=<?php echo $prev; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li>
                                            <a href="dashboard.php?page=<?php echo $prev; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                                <?php
                                for ($i = 1; $i <= $j1; $i++) {
                                    if(isset($_GET['search'])) {

                                        if ($pageval == $i) {
                                            ?>
                                            <li class="active"><a href="#"><?php echo $i; ?><span
                                                        class="sr-only">(current)</span></a>
                                            </li>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <li><a href="dashboard.php?page=<?php echo $i; ?>&search=<?php echo $_GET['search'];  ?>"><?php echo $i; ?><span
                                                        class="sr-only">(current)</span></a></li>
                                            <?php
                                        }
                                    }
                                    else{
                                        if ($pageval == $i)
                                        {
                                            ?>
                                            <li class="active"><a href="#"><?php echo $i; ?><span
                                                        class="sr-only">(current)</span></a>
                                            </li>
                                            <?php
                                        } else {
                                            ?>
                                            <li><a href="dashboard.php?page=<?php echo $i; ?>"><?php echo $i; ?><span
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
                                } else
                                {
                                    $next1 = $pageval + 1;
                                    if(isset($_GET['search']))
                                    {
                                        ?>
                                        <li>
                                            <a href="dashboard.php?page=<?php echo $next1; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li>
                                            <a href="dashboard.php?page=<?php echo $next1; ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                            }
                            else{
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
    function deleterestaurant(id)
    {
        var x = confirm("Are you sure want to delete ?");
        if(x) {
            $.ajax({
                type: "POST",
                url: "ajax/deleterestaurant.php",
                data: {querystring: id},
                cache: false,
                success: function (data)
                {
                    if (data)
                    {
                        window.location='dashboard.php<?php echo $_SERVER['QUERY_STRING']; ?>';
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
    function activerestaurant(id)
    {
        var x = confirm("Are you sure want to Active/Deactive Restaurant ?");
        if(x) {
            $.ajax({
                type: "POST",
                url: "ajax/activerestaurant.php",
                data: {querystring: id},
                cache: false,
                success: function (data)
                {
                    if (data)
                    {
                        window.location='dashboard.php?<?php echo $_SERVER['QUERY_STRING']; ?>';
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
