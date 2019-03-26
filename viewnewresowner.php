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
mysqli_set_charset($conn,"utf8");
$user->clearnotifyreview();
$ressss=$user->getuserinfo($uid);
$urlid = $ressss->res_id;
if(isset($_POST["editboy"]))
{
    $delboy_id = $_POST['boy_id'];
    $del_name = $_POST['name'];
    $del_email = $_POST['email'];
    $del_contact = $_POST['phone'];
    $del_password = $_POST['password'];
    $del_vehicle_no = $_POST['vehicle_no'];
    $del_vehicle_type = $_POST['vehicle_type'];
    $sql_edit = "UPDATE `fooddelivery_res_owner` SET name='".$del_name."',email='".$del_email."',phone='".$del_contact."',password='".$del_password."',vehicle_no='".$del_vehicle_no."',vehicle_type='".$del_vehicle_type."' WHERE `id`='".$delboy_id."'";
    $result_edit = $conn->query($sql_edit);
    if($result_edit)
    {
        $success = "Your Data Is Successfully Updated";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Food Delivery System | Restaurant Owner </title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="Food Delivery System " />
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
    <script src="assets/js/jquery-1.9.1.min.js"></script>
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
            <li><a href="dashboard.php">Home</a> / Restaurant Owner</li>
        </ol>
        <h1 class="page-header">Search Restaurant Name</small></h1>
        <div class="row">
            <div class="col-md-12">
                <div class="result-container">
                    <form method="get">
                        <div class="input-group m-b-20">
                            <input type="text" name="search" class="form-control input-white" value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>" placeholder="Enter keywords here..." />
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-inverse"><i class="fa fa-search"></i> Search</button>
                                <a href="viewnewresowner.php" type="submit" class="btn btn-inverse"> Reset Filter</a>
                            </div>
                        </div>
                    </form>
                    <div class="btn-group m-l-10 m-b-20">
                       <a href="addnewresowner.php" class="btn btn-white btn-white-without-border" >Add Restaurant Owner</a>
                    </div>
                    <?php
                    $perpage = 10;
                    if(isset($_GET['page']) & !empty($_GET['page'])){
                        $urlpage = $_GET['page'];
                    }else{
                        $urlpage = 1;
                    }
                    $start = ($urlpage * $perpage) - $perpage;
                    $PageSql = "SELECT * FROM `fooddelivery_res_owner`";
                    $pageres = mysqli_query($conn, $PageSql);
                    $totalres = mysqli_num_rows($pageres);
                    $endpage = ceil($totalres/$perpage);
                    $startpage = 1;
                    $nextpage = $urlpage + 1;
                    $previouspage = $urlpage - 1;
                    $ReadSql = "SELECT * FROM `fooddelivery_res_owner` LIMIT $start, $perpage";
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
                        $food_boy = mysqli_query($conn,"select * from fooddelivery_res_owner where username like '%".$_GET['search']."%' LIMIT $start, $perpage");
                        {
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Contact No</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Created At</th>>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($boy = mysqli_fetch_array($food_boy))
                                {
                                ?>
                                <tr class="info">
                                    <td style="width: 20px;"><?php echo $boy['id']; ?></td>
                                    <td style="width: 100px;"><?php echo $boy['username']; ?></td>
                                    <td style="width: 50px;"><?php echo $boy['phone']; ?></td>
                                    <td style="width: 50px;"><?php echo $boy['email']; ?></td>
                                    <td style="width: 50px;"><?php echo $boy['password']; ?></td>
                                    <td style="width: 50px;"><?php echo date("d-M-Y H:s:ia", $boy['timestamp']); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                        }
                    } else {
                        $boy_list = mysqli_query($conn,"select * from fooddelivery_res_owner LIMIT $start, $perpage");
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Contact No</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($list = mysqli_fetch_array($boy_list))
                                {
                                ?>
                                <tr class="info">
                                    <td style="width: 20px;"><?php echo $list['id']; ?></td>
                                    <td style="width: 100px;"><?php echo $list['username']; ?></td>
                                    <td style="width: 50px;"><?php echo $list['phone']; ?></td>
                                    <td style="width: 50px;"><?php echo $list['email']; ?></td>
                                    <td style="width: 50px;"><?php echo $list['password']; ?></td>
                                    <td style="width: 50px;"><?php echo date("d-M-Y H:s:ia", $list['timestamp']); ?></td>
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
</div>
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
    function editboyname(id)
    {
        $.ajax({
            type: "POST",
            url: "ajax/editboy_admin.php",
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
                url: "ajax/deleteboy_admin.php",
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
