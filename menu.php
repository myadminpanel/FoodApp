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
$qu_string=$_GET['AXOsdsdf872'];
$id_val=$user->encrypt_decrypt("decrypt",$qu_string);
$id_exp=explode("=",$id_val);
$id = $id_exp[1];
if(isset($_POST['addnewmenu']))
{

    if(isset($_POST['mname']))
    {
        extract($_REQUEST);
        $user->addnewmenu($id,$mname);
        if($user)
        {
            ?>
            <script>
                window.location='menu.php?<?php echo $_SERVER['QUERY_STRING']; ?>';
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
            window.location='menu.php?<?php echo $_SERVER['QUERY_STRING']; ?>';
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
            <li><a href="dashboard.php">Home</a> / Restaurant Menu Category</li>
        </ol>
        <h1 class="page-header">Search Menu Category</small></h1>
        <div class="row">
            <div class="col-md-12">
                <div class="result-container">
                    <form method="get">
                        <div class="input-group m-b-20">
                            <input type="hidden" name="page" value="1">
                            <input type="hidden" name="AXOsdsdf872" value="<?php echo $_GET['AXOsdsdf872']; ?>">
                            <input type="text" name="search" class="form-control input-white" value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>" placeholder="Enter keywords here..." />
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-inverse"><i class="fa fa-search"></i> Search</button>
                                <a href="menu.php?AXOsdsdf872=<?php echo $_GET['AXOsdsdf872'];?>" type="submit" class="btn btn-inverse"> Reset Filter</a>
                            </div>
                        </div>
                    </form>
                    <div class="btn-group m-l-10 m-b-20">
                         
                            <a href="#modal-dialog" class="btn btn-white btn-white-without-border" data-toggle="modal">Add New Menu</a>
                      
                    </div>
                    <?php
                    $per_page = 10;
                    $url="menu.php?AXOsdsdf872=".$_GET['AXOsdsdf872']."&";
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
                        $qutotal= $user->getallmenu($search,"searchtotal","none","none",$id);
                        $query = $user->getallmenu($search,"search",$start,$per_page,$id);
                    }
                    else
                    {
                        $query = $user->getallmenu("none","none",$start,$per_page,$id);
                        $qutotal= $user->getallmenu("none","total","none","none",$id);
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
                                if(isset($_GET['search'])) {
                                    ?>
                                    <li>
                                        <a href="<?php echo $url; ?>page=<?php echo $prev; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                else{
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
                                        <li><a href="<?php echo $url; ?>page=<?php echo $i; ?>&search=<?php echo $_GET['search'];  ?>"><?php echo $i; ?><span
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
                                        <li><a href="<?php echo $url; ?>page=<?php echo $i; ?>"><?php echo $i; ?><span
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
                                else{
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
                    <?php
                    if($query)
                    {
                        foreach ($query as $val)
                        {
                    ?>
                        <ul class="list-group list-group-lg no-radius list-email">
                        <li class="list-group-item inverse" >
                            <div class="email-user" style="background-color: #00acac;color: white;">
                                <?php
                                $mname=$val['name'];
                                preg_match("/./u", $mname, $mname1);
                                echo strtoupper($mname1[0]);
                                ?>
                            </div>
                            <div class="email-info">
                                <span class="email-time"></span>
                                <?php
                                $qstring="menu_id=".$val['id'];
                                $enc_str=$user->encrypt_decrypt("encrypt",$qstring);
                                ?>
                                
                                 <?php    $Constant = button; 
                                 if ($Constant == "Active") { ?>
                                <a href="#" onclick="deletemenu('<?php echo $enc_str; ?>')" class=" email-time btn btn-danger" style="color: white;"><i class="fa fa-remove"></i> Delete</a>
                                <a href="#modal-dialogedit" onclick="getmenucategorydetail('<?php echo $enc_str; ?>')" class=" email-time btn btn-inverse" data-toggle="modal" style="color: white;"><i class="fa fa-edit"></i>Edit</a>
                                <?php } else { ?>
                                 <a  onClick="return confirm('This function is currently disable as it is only a demo website, in your admin it will work perfect')" class=" email-time btn btn-danger" style="color: white;"><i class="fa fa-remove"></i> Delete</a>
                                <a onClick="return confirm('This function is currently disable as it is only a demo website, in your admin it will work perfect')"class=" email-time btn btn-inverse" data-toggle="modal" style="color: white;"><i class="fa fa-edit"></i>Edit</a>
                                <?php } ?>
                                 <a href="submenu.php?alexe0sdsc=<?php echo $enc_str; ?>" class=" email-time btn btn-success" data-toggle="modal" style="color: white;"><i class="fa fa-plus"></i> Add Submenu</a>
                                
                                <h5 class="email-title">
                                    <a href="submenu.php?alexe0sdsc=<?php echo $enc_str; ?>"><?php echo $val['name']; ?></a>
                                </h5>
                                <p class="email-desc">
                                    Created At : <?php echo date("d-M-Y H:s:ia", $val['created_at']); ?>
                                 </p>
                            </div>
                        </li>
                    </ul>
                    <?php
                        }
                    }
                    ?>
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
                                            <a href="<?php echo $url; ?>page=<?php echo $prev; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    else{
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
                                for ($i = 1; $i <= $j1; $i++) {
                                    if(isset($_GET['search'])) {

                                        if ($pageval == $i)
                                        {
                                            ?>
                                            <li class="active"><a href="#"><?php echo $i; ?><span
                                                        class="sr-only">(current)</span></a>
                                            </li>
                                            <?php
                                        } else {
                                            ?>
                                            <li><a href="<?php echo $url; ?>page=<?php echo $i; ?>&search=<?php echo $_GET['search'];  ?>"><?php echo $i; ?><span
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
                                            <li><a href="<?php echo $url; ?>page=<?php echo $i; ?>"><?php echo $i; ?><span
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
                                            <a href="<?php echo $url; ?>page=<?php echo $next1; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    else{
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
    <div class="modal fade" id="modal-dialogedit">
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
    function getmenucategorydetail(id)
    {
        $.ajax({
            type: "POST",
            url: "ajax/editmenucategory.php",
            data: {querystring: id},
            cache: false,
            success: function (data)
            {
                $('#editmenucategory').replaceWith($('#editmenucategory').html(data));
            }
        });

    }
    function deletemenu(id)
    {
        var x = confirm("Are you sure want to delete ?");

        if(x) {
            $.ajax({
                type: "POST",
                url: "ajax/deletemenu.php",
                data: {menu_id: id},
                cache: false,
                success: function (data)
                {
                    if (data)
                    {
                        window.location='menu.php?AXOsdsdf872=<?php echo $_GET['AXOsdsdf872']; ?>';
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
