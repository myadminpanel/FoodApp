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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Food Delivery System | Reviews</title>
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
            <li><a href="dashboard.php">Home</a> / Reviews</li>
        </ol>
        <h1 class="page-header">User Reviews </small></h1>
        <div class="row">
            <div class="col-md-12">
                <div class="result-container">
                    
                    
                    <ul class="chats">
                        <?php
                        $food_review = mysqli_query($conn,"SELECT * FROM fooddelivery_reviews where res_id = '".$urlid."' ORDER BY id DESC");
                        while ($review = mysqli_fetch_array($food_review))
                        {
                        ?>
                        <li class="left">
                            <div class="date-time" style="width: 50px;height: auto">
                               &nbsp;&nbsp; <a href="" onclick="deletereview(<?php echo $review['id']; ?>)" class="badge badge-danger" >Delete</a>
                            </div>
                            <span class="date-time" style="color: black;"><?php echo date("D H:ia  m/y",$review['created_at']); ?></span>
                            <?php
                            $username = mysqli_query($conn,"select * from fooddelivery_users where id = '".$review['user_id']."'");
                            $name = mysqli_fetch_array($username);
                            ?>
                            <a href="javascript:;" class="name"><?php echo $name['fullname']; ?></a>
                            <div class="image"">
                                <?php 
                                if ($name['login_with'] == 'appuser') {
                                ?>
                                    <img src="../uploads/restaurant/<?php echo $name['image']; ?>">
                                <?php
                                } else {
                                ?>
                                    <img src="<?php echo $name['image']; ?>">
                                <?php
                                }
                                ?>
                            </div>
                            <div class="message">
                                <?php
                                  echo $review['review_text'];
                                ?>
                                <div align="right">
                                    <?php
                                    for($i=1;$i<=$review['ratting'];$i++)
                                    {
                                        ?>
                                        <i class="fa fa-2x fa-star" style="color:#00acac;"></i>
                                        <?php
                                    }
                                    $mi=5-$review['ratting'];
                                    for($i=1;$i<=$mi;$i++)
                                    {
                                        ?>
                                        <i class="fa fa-2x fa-star"></i>
                                        <?php
                                    }
                                    ?>
                                </div>

                            </div>

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
<script>
    function deletereview(id)
    {
        var x = confirm("Are you sure want to delete ?");
        if(x)
        {
            $.ajax({
                type: "POST",
                url: "../ajax/deletereview.php",
                data: {id: id},
                cache: false,
                success: function (data)
                {
                    if (data)
                    {
                        window.location='reviews.php?<?php echo $_SERVER['QUERY_STRING']; ?>';
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
<script src="../assets/js/jquery-migrate-1.1.0.min.js"></script>
<script src="../assets/js/jquery-ui.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/jquery.slimscroll.min.js"></script>
<script src="../assets/js/jquery.cookie.js"></script>
<script src="../assets/js/parsley.js"></script>
<script src="../assets/js/apps.min.js"></script>
<script>
    $(document).ready(function()
    {
        App.init();
    });
</script>
</body>
</html>
