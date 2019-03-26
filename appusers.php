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

$clearusercount=$user->clearuserscount();

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8" />

    <title>Food Delivery System | App Users</title>

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

            <li><a href="dashboard.php">Home</a> / App Users</li>

        </ol>

        <h1 class="page-header">Search Users </small></h1>

        <div class="row">

            <div class="col-md-12">

                <div class="result-container">

                    <form method="get">

                        <div class="input-group m-b-20">

                            <input type="hidden" name="page" value="1">

                            <input type="text" name="search" class="form-control input-white" value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>" placeholder="Enter keywords here..." />

                            <div class="input-group-btn">

                                <button type="submit" class="btn btn-inverse"><i class="fa fa-search"></i> Search</button>

                                <a href="appusers.php" type="submit" class="btn btn-inverse"> Reset Filter</a>

                            </div>

                        </div>

                    </form>

                    <?php



                    $per_page = 8;

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

                        $qutotal= $user->getappusers($search,"searchtotal","none","none");

                        $query = $user->getappusers($search,"search",$start,$per_page);

                    }

                    else

                    {

                        $query = $user->getappusers("none","none",$start,$per_page);

                        $qutotal= $user->getappusers("none","total","none","none");

                    }

                    ?>

                    <div class="clearfix">

                    <ul class="pagination pagination-without-border pull-right ">

                        <?php

                        $total = $qutotal;

                        $j1 = ceil($total / $per_page);

                        $next = ceil($total / $per_page);

                        if($total)

                        {

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

                                        <a href="appusers.php?page=<?php echo $prev; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Previous">

                                            <span aria-hidden="true">&laquo;</span>

                                        </a>

                                    </li>

                                    <?php

                                }

                                else{

                                    ?>

                                    <li>

                                        <a href="appusers.php?page=<?php echo $prev; ?>" aria-label="Previous">

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

                                        <li><a href="appusers.php?page=<?php echo $i; ?>&search=<?php echo $_GET['search'];  ?>"><?php echo $i; ?><span

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

                                        <li><a href="appusers.php?page=<?php echo $i; ?>"><?php echo $i; ?><span

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

                                        <a href="appusers.php?page=<?php echo $next1; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Next">

                                            <span aria-hidden="true">&raquo;</span>

                                        </a>

                                    </li>

                                    <?php

                                }

                                else{

                                    ?>

                                    <li>

                                        <a href="appusers.php?page=<?php echo $next1; ?>" aria-label="Next">

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

                    </ul></div>

                    <ul class="registered-users-list clearfix">

                            <?php

                            if($query) {

                                foreach ($query as $val)

                                {

                                    ?>

                                    <li class="col-md-3">

                                        <div style="" align="center">

                                            <?php

                                            if($val['login_with'] == "appuser")

                                            {
                                                $img = $val['image'];
                                                $image = 'uploads/restaurant/'.$img;

                                            }

                                            else

                                            {

                                                $image = $val['image'];

                                            }

                                            ?>

                                            <img  src="<?php echo $image;  ?>" style="border-radius:75px;height: 130px;width: 130px; border :solid 1px <?php echo "#" . $user->random_color(); ?>;">

                                        </div>

                                        <h4 class="username text-ellipsis" align="center">

                                            <?php echo $val['fullname']; ?>

                                            <span class="badge badge-danger">

                                                <?php

                                                $qstring="category_id=".$val['id'];

                                                $enc_str=$user->encrypt_decrypt("encrypt",$qstring);

                                                ?>

                                                <a href="#" onclick="deleteappuser('<?php echo $enc_str; ?>','<?php echo $val['image']; ?>')" style="color: white;">

                                                    <i class="fa fa-remove"></i>

                                                </a>

                                            </span>

                                            <small>Email : <?php echo $val['email']; ?></small>

                                            <small>Phone : <?php echo $val['phone_no']; ?></small>

                                        </h4>

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

                                            <a href="appusers.php?page=<?php echo $prev; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Previous">

                                                <span aria-hidden="true">&laquo;</span>

                                            </a>

                                        </li>

                                        <?php

                                    }

                                    else

                                    {

                                        ?>

                                        <li>

                                            <a href="appusers.php?page=<?php echo $prev; ?>" aria-label="Previous">

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

                                            <li><a href="appusers.php?page=<?php echo $i; ?>&search=<?php echo $_GET['search'];  ?>"><?php echo $i; ?><span

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

                                            <li><a href="appusers.php?page=<?php echo $i; ?>"><?php echo $i; ?><span

                                                        class="sr-only">(current)</span></a></li>

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

                                } else

                                  {

                                    $next1 = $pageval + 1;

                                    if(isset($_GET['search']))

                                    {

                                        ?>

                                        <li>

                                            <a href="appusers.php?page=<?php echo $next1; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Next">

                                                <span aria-hidden="true">&raquo;</span>

                                            </a>

                                        </li>

                                        <?php

                                    }

                                    else{

                                        ?>

                                        <li>

                                            <a href="appusers.php?page=<?php echo $next1; ?>" aria-label="Next">

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

    function deleteappuser(id,imagename)

    {

        var x = confirm("Are you sure want to delete ?");

        if(x)

        {

            $.ajax({

                type: "POST",

                url: "ajax/deleteappuser.php",

                data: {appuser_id: id,imagename:imagename},

                cache: false,

                success: function (data)

                {

                    if (data)

                    {

                        window.location='appusers.php';

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

