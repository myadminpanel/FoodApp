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
            <li><a href="dashboard.php">Home</a> / Reviews</li>
        </ol>
        <h1 class="page-header">Search Reviews </small></h1>
        <div class="row">
            <div class="col-md-12">
                <div class="result-container">
                    <form method="get">
                        <div class="input-group m-b-20">
                            <?php
                                if(isset($_GET['AXOsdsdf872']) && $_GET['AXOsdsdf872'] != ""){
                                    ?>
                                    <input type="hidden" name="AXOsdsdf872" value="<?php echo $_GET['AXOsdsdf872']; ?>">
                                    <?php
                                }
                            ?>
                            <input type="hidden" name="page" value="1">
                            <input type="text" name="search" class="form-control input-white" value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>" placeholder="Enter keywords here..." />
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-inverse"><i class="fa fa-search"></i> Search</button>
                                <a href="reviews.php" type="submit" class="btn btn-inverse"> Reset Filter</a>
                            </div>
                        </div>
                    </form>
                    <script>
                        function selectresid(id)
                        {
                            window.location="reviews.php?AXOsdsdf872="+id;
                        }
                    </script>
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
                    if(isset($_GET['AXOsdsdf872']) && $_GET['AXOsdsdf872'] !== ""){
                        $querystring=$_GET['AXOsdsdf872'];
                        $enc_str=$user->encrypt_decrypt("decrypt",$querystring);
                        $val=explode("=",$enc_str);
                        $res_id=$val[1];
                        if (isset($_GET['search']))
                        {
                            $search=$_GET['search'];
                            $qutotal= $user->getuserreview($search,"searchtotal","none","none",$res_id,"yes");
                            $query = $user->getuserreview($search,"search",$start,$per_page,$res_id,"yes");
                        }
                        else
                        {
                            $query = $user->getuserreview("none","none",$start,$per_page,$res_id,"yes");
                            $qutotal= $user->getuserreview("none","total","none","none",$res_id,"yes");
                        }
                    }
                    else
                     {
                        if (isset($_GET['search']))
                        {
                            $search=$_GET['search'];
                            $qutotal= $user->getuserreview($search,"searchtotal","none","none","","no");
                            $query = $user->getuserreview($search,"search",$start,$per_page,"","no");
                        }
                        else
                        {
                            $query = $user->getuserreview("none","none",$start,$per_page,"","no");
                            $qutotal= $user->getuserreview("none","total","none","none","","no");
                        }
                    }

                    ?>
                    <div class="col-md-3" style="margin-top: 20px">
                        <select class="form-control" name="res_id" id="resid" onchange="selectresid(this.value)">
                            <option value="" selected>Filter Reviews</option>
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
                        </select>
                    </div>
                    <div class="clearfix">
                        <ul class="pagination pagination-without-border pull-right ">
                            <?php
                            $total = $qutotal;
                            $j1 = ceil($total / $per_page);
                            $next = ceil($total / $per_page);
                            if(isset($_GET['AXOsdsdf872']) && $_GET['AXOsdsdf872'] != ""){
                                $url="reviews.php?AXOsdsdf872=".$_GET['AXOsdsdf872']."&";
                            }
                            else{
                                $url="reviews.php?";
                            }

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
                                            <a href="<?php echo $url; ?>page=<?php echo $prev; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li>
                                            <a href="<?php echo $url; ?>page=<?php echo $prev; ?>" aria-label="Previous">
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
                                    if(isset($_GET['search'])) {

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
                                            <li><a href="<?php echo $url; ?>page=<?php echo $i; ?>&search=<?php echo $_GET['search'];  ?>"><?php echo $i; ?><span
                                                        class="sr-only">(current)</span></a></li>
                                            <?php
                                        }
                                    }
                                    else{
                                        if ($pageval == $i)
                                        {
                                            ?>
                                            <li class="active">
                                                <a href="#"><?php echo $i; ?>
                                                    <span class="sr-only">(current)</span>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <li>
                                                <a href="<?php echo $url; ?>page=<?php echo $i; ?>"><?php echo $i; ?>
                                                    <span class="sr-only">(current)</span>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                    }
                                }
                                if ($next == $pageval)
                                {
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
                                            <a href="<?php echo $url; ?>page=<?php echo $next1; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li>
                                            <a href="<?php echo $url; ?>page=<?php echo $next1; ?>" aria-label="Next">
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
                    <ul class="chats">
                        <?php
                        if($query)
                        {
                            foreach ($query as $val)
                            {
                                $userinfo=$user->getusername($val['user_id']);
                                $resname = $user->restaurantname($val['res_id']);
                                ?>
                                <li class="left">
                                    <div class="date-time" style="width: 50px;height: auto">
                                       &nbsp;&nbsp; <a href="" onclick="deletereview(<?php echo $val['id']; ?>)" class="badge badge-danger" >Delete</a>
                                    </div>
                                    <span class="date-time" style="color: black;"><?php echo date("D H:ia  m/y",$val['created_at']); ?></span>
                                    <a href="javascript:;" class="name"><?php echo $userinfo->fullname; ?></a>
                                    <div class="image"
                                         style="height: 60px;width: 65px;background-color: #<?php echo $user->random_color(); ?>;text-align: center;font-size: 40px;color: white;">
                                        <?php
                                        if($userinfo->login_with == "appuser"){
                                        ?>
                                            <img src="uploads/restaurant/<?php echo $userinfo->image; ?>">
                                        <?php
                                        }
                                        else{
                                            $image=$userinfo->image;;
                                        }
                                        ?>
                                        <img src="<?php echo $image; ?>" style="height: 68px;width: 65px;" />
                                        <?php
/*                                            $latter=$userinfo->fullname;
                                             preg_match("/./u", $latter, $latter1);
                                            echo strtoupper($latter1[0]);
                                        */?>
                                    </div>
                                    <div class="message">
                                        <?php
                                          echo $val['review_text'];
                                        ?>
                                        <div align="left">
                                            <font color="#00acac">:-)
                                                <?php echo $resname->name; ?>  </font>
                                        </div>
                                        <div align="right">
                                            <?php
                                            for($i=1;$i<=$val['ratting'];$i++)
                                            {
                                                ?>
                                                <i class="fa fa-2x fa-star" style="color:#00acac;"></i>
                                                <?php
                                            }
                                            $mi=5-$val['ratting'];
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
                        }
                        ?>
                    </ul>
                    <div class="clearfix">
                        <ul class="pagination pagination-without-border pull-right">
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
                                            <a href="<?php echo $url; ?>page=<?php echo $prev; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li>
                                            <a href="<?php echo $url; ?>page=<?php echo $prev; ?>" aria-label="Previous">
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
                                            <li><a href="<?php echo $url; ?>page=<?php echo $i; ?>&search=<?php echo $_GET['search'];  ?>"><?php echo $i; ?><span
                                                        class="sr-only">(current)</span></a></li>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        if ($pageval == $i)
                                        {
                                            ?>
                                            <li class="active"><a href="#"><?php echo $i; ?><span class="sr-only">(current)</span></a>
                                            </li>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <li><a href="<?php echo $url; ?>page=<?php echo $i; ?>"><?php echo $i; ?><span class="sr-only">(current)</span></a></li>
                                            <?php
                                        }
                                    }
                                }
                                if ($next == $pageval)
                                {
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
                                            <a href="<?php echo $url; ?>page=<?php echo $next1; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li>
                                            <a href="<?php echo $url; ?>page=<?php echo $next1; ?>" aria-label="Next">
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
<script>
    function deletereview(id)
    {
        var x = confirm("Are you sure want to delete ?");
        if(x)
        {
            $.ajax({
                type: "POST",
                url: "ajax/deletereview.php",
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
<script src="assets/js/jquery-1.9.1.min.js"></script>
<script src="assets/js/jquery-migrate-1.1.0.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/jquery.cookie.js"></script>
<script src="assets/js/parsley.js"></script>
<script src="assets/js/apps.min.js"></script>
<script>
    $(document).ready(function()
    {
        App.init();
    });
</script>
</body>
</html>
