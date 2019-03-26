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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Food Delivery System | City</title>
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
            <li><a href="dashboard.php">Home</a> / City</li>
        </ol>
        <h1 class="page-header">Search City </small></h1>
        <div class="row">
            <div class="col-md-12">
                <div class="result-container">
                    <form method="get">
                        <div class="input-group m-b-20">
                            <input type="hidden" name="page" value="1">
                            <input type="text" name="search" class="form-control input-white" value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>" placeholder="Enter keywords here..." />
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-inverse"><i class="fa fa-search"></i> Search</button>
                                <a href="category.php" type="submit" class="btn btn-inverse"> Reset Filter</a>
                            </div>
                        </div>
                    </form>
                    <div class="btn-group m-l-10 m-b-20">
                      
                        <a href="addnewcity.php"  class="btn btn-white btn-white-without-border">Add New City</a>
                       
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
                        $qutotal= $user->getcityall($search,"searchtotal","none","none");
                        $query = $user->getcityall($search,"search",$start,$per_page);
                    }
                    else
                    {
                        $query = $user->getcityall("none","none",$start,$per_page);
                        $qutotal= $user->getcityall("none","total","none","none");
                    } ?>
                    <ul class="pagination pagination-without-border pull-right m-t-0">
                        <?php
                        $total = $qutotal;
                        $j1 = ceil($total / $per_page);
                        $next = ceil($total / $per_page);
                        if($total){
                            if(isset($_GET['page'])) {
                                $pageval = $_GET['page'];
                            }
                            else{
                                $pageval=1;
                            }
                            if ($pageval == 1) {
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
                                if(isset($_GET['search'])) {
                                    ?>
                                    <li>
                                        <a href="city.php?page=<?php echo $prev; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                else{
                                    ?>
                                    <li>
                                        <a href="city.php?page=<?php echo $prev; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                            <?php
                            for ($i = 1; $i <= $j1; $i++) {
                                if(isset($_GET['search']))
                                {

                                    if ($pageval == $i) {
                                        ?>
                                        <li class="active"><a href="#"><?php echo $i; ?><span
                                                    class="sr-only">(current)</span></a>
                                        </li>
                                        <?php
                                    } else {
                                        ?>
                                        <li><a href="city.php?page=<?php echo $i; ?>&search=<?php echo $_GET['search'];  ?>"><?php echo $i; ?><span
                                                    class="sr-only">(current)</span></a></li>
                                        <?php
                                    }
                                }
                                else{
                                    if ($pageval == $i) {
                                        ?>
                                        <li class="active"><a href="#"><?php echo $i; ?><span
                                                    class="sr-only">(current)</span></a>
                                        </li>
                                        <?php
                                    } else {
                                        ?>
                                        <li><a href="city.php?page=<?php echo $i; ?>"><?php echo $i; ?><span
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
                                        <a href="city.php?page=<?php echo $next1; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <li>
                                        <a href="city.php?page=<?php echo $next1; ?>" aria-label="Next">
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
                                ?>
                                <li>
                                    <div class="col-md-2">
                                        <div class="result-image" style="width: 100px;height: 100px;font-size: 65px;text-align: center;background-color: #2D353C;color: white;">
                                            <?php
                                                $mname=$val['cname'];
                                                preg_match("/./u", $mname, $mname1);
                                                echo strtoupper($mname1[0]);
                                            ?>
                                            <?php
                                            $qstring="city_id=".$val['id'];
                                            $enc_str=$user->encrypt_decrypt("encrypt",$qstring);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="result-info" >
                                            <h1 class="title" style="line-height: 50px;" ><?php echo $val['cname']; ?></h1>
                                            <div>Created At : <font color="#242A30"> </font><?php echo date("d-M-Y H:s:ia", $val['created_at']); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="result-price" align="right">
                                             <?php    $Constant = button; 
                                             if ($Constant == "Active") { ?>
                                            <a href="editcity.php?<?php echo $enc_str; ?>" class="btn btn-inverse"><i class="fa fa-edit"></i> Edit</a>
                                            <a href="#" onclick="deletecity('<?php echo $enc_str; ?>')" class="btn btn-danger"><i class="fa fa-remove"></i> Delete</a>
                                            <?php } else { ?>
                                            <a onClick="return confirm('This function is currently disable as it is only a demo website, in your admin it will work perfect')"  class="btn btn-inverse"><i class="fa fa-edit"></i> Edit</a>
                                            <a onClick="return confirm('This function is currently disable as it is only a demo website, in your admin it will work perfect')"   class="btn btn-danger"><i class="fa fa-remove"></i> Delete</a>
                                            <?php } ?>
                                        </div>
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
                                else{
                                    $pageval=1;
                                }
                                if ($pageval == 1) {
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
                                    if(isset($_GET['search'])) {
                                        ?>
                                        <li>
                                            <a href="category.php?page=<?php echo $prev; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <li>
                                            <a href="category.php?page=<?php echo $prev; ?>" aria-label="Previous">
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
                                        } else {
                                            ?>
                                            <li><a href="category.php?page=<?php echo $i; ?>&search=<?php echo $_GET['search'];  ?>"><?php echo $i; ?><span
                                                        class="sr-only">(current)</span></a></li>
                                            <?php
                                        }
                                    }
                                    else{
                                        if ($pageval == $i) {
                                            ?>
                                            <li class="active"><a href="#"><?php echo $i; ?><span
                                                        class="sr-only">(current)</span></a>
                                            </li>
                                            <?php
                                        } else {
                                            ?>
                                            <li><a href="category.php?page=<?php echo $i; ?>"><?php echo $i; ?><span
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
                                            <a href="category.php?page=<?php echo $next1; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <li>
                                            <a href="category.php?page=<?php echo $next1; ?>" aria-label="Next">
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
    function deletecity(id)
    {
        var x = confirm("Are you sure want to delete ?");
        if(x) {
            $.ajax
            ({
                type: "POST",
                url: "ajax/deletecity.php",
                data: {city_id: id},
                cache: false,
                success: function (data)
                {
                    if (data)
                    {
                        window.location='city.php?<?php echo $_SERVER['QUERY_STRING']; ?>';
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
