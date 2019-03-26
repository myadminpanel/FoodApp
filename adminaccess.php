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
    <title>Food Delivery System | Category</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="Food Delivery System"/>
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
            <li><a href="dashboard.php">Home</a> / Admin Access</li>
        </ol>
        <h1 class="page-header">Admin Access </small></h1>
        <div class="row">
            <div class="col-md-12">
                <div class="result-container">
                    <div class="btn-group m-l-10 m-b-20">
                         <?php    $Constant = button; 
                         if ($Constant == "Active") { ?>
                        <a href="addnewadmin.php"  class="btn btn-white btn-white-without-border">Add New Admin</a>
                        <?php } else { ?>
                         <a onClick="return confirm('This function is currently disable as it is only a demo website, in your admin it will work perfect')"   class="btn btn-white btn-white-without-border">Add New Admin</a>
                        <?php } ?>
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
                        $qutotal= $user->getadminaccess($search,"searchtotal","none","none");
                        $query = $user->getadminaccess($search,"search",$start,$per_page);
                    }
                    else
                    {
                        $query = $user->getadminaccess("none","none",$start,$per_page);
                        $qutotal= $user->getadminaccess("none","total","none","none");
                    }
                    ?>
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
                                        <a href="adminaccess.php?page=<?php echo $prev; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                else{
                                    ?>
                                    <li>
                                        <a href="adminaccess.php?page=<?php echo $prev; ?>" aria-label="Previous">
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
                                        <li><a href="adminaccess.php?page=<?php echo $i; ?>&search=<?php echo $_GET['search'];  ?>"><?php echo $i; ?><span
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
                                        <li><a href="adminaccess.php?page=<?php echo $i; ?>"><?php echo $i; ?><span
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
                                        <a href="adminaccess.php?page=<?php echo $next1; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                else{
                                    ?>
                                    <li>
                                        <a href="adminaccess.php?page=<?php echo $next1; ?>" aria-label="Next">
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
                    <div class="responsive-table">
                        <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>User Name</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th >Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if($query) {
                                foreach ($query as $res) {
                                    ?>
                                    <tr>
                                        <td><?php echo $res['id']; ?></td>
                                        <td><img src="uploads/<?php echo $res['icon']; ?>" style="height: 75px; width: 100px"></td>
                                        <td><?php echo $res['username']; ?></td>
                                        <td><?php echo $res['fullname']; ?></td>
                                        <td><?php echo $res['email']; ?></td>
                                        <td >
                                            <?php
                                            $qstring="admin_id=".$res['id'];
                                            $enc_str=$user->encrypt_decrypt("encrypt",$qstring);
                                            ?>
                                            <?php
                                            if ($res['id'] == '1') {
                                                echo "Administrator";
                                            } else {
                                            ?>
                                                <a href="#" onclick="deleteadminaccess('<?php echo $enc_str; ?>')" class="btn btn-group"><i class="fa fa-remove"></i> Delete</a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <td colspan="6" align="center">* App User Not Found *</td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="clearfix">
                        <ul class="pagination pagination-without-border pull-right">
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
                                            <a href="adminaccess.php?page=<?php echo $prev; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <li>
                                            <a href="adminaccess.php?page=<?php echo $prev; ?>" aria-label="Previous">
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
                                            <li><a href="adminaccess.php?page=<?php echo $i; ?>&search=<?php echo $_GET['search'];  ?>"><?php echo $i; ?><span
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
                                            <li><a href="adminaccess.php?page=<?php echo $i; ?>"><?php echo $i; ?><span
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
                                            <a href="adminaccess.php?page=<?php echo $next1; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <li>
                                            <a href="adminaccess.php?page=<?php echo $next1; ?>" aria-label="Next">
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
    function deleteadminaccess(id)
    {
        var x = confirm("Are you sure want to delete ?");
        if(x) {
            $.ajax({
                type: "POST",
                url: "ajax/deleteadminaccess.php",
                data: {admin_id: id},
                cache: false,
                success: function (data)
                {
                    if (data)
                    {
                        window.location='adminaccess.php';
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
