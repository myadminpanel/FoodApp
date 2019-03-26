<?php
    $userinfo = $user->getuserinfo($uid);
?>
<div id="header" class="header navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="dashboard.php" class="navbar-brand"><span class="navbar-logo"></span> Food Delivery System</a>
        </div>
        <ul class="nav navbar-nav navbar-right">

            <!--<li class="dropdown">
                <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
                    <i class="fa fa-bell-o"></i>
                    <span class="label">5</span>
                </a>
                <ul class="dropdown-menu media-list pull-right animated fadeInDown">
                    <li class="dropdown-header">Notifications (5)</li>
                    <li class="media">
                        <a href="javascript:;">
                            <div class="media-left"><i class="fa fa-bug media-object bg-red"></i></div>
                            <div class="media-body">
                                <h6 class="media-heading">Server Error Reports</h6>
                                <div class="text-muted f-s-11">3 minutes ago</div>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-footer text-center">
                        <a href="javascript:;">View more</a>
                    </li>
                </ul>
            </li>-->
            <li class="dropdown navbar-user">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="uploads/<?php echo  $userinfo->icon; ?>" alt="" />
                    <span class="hidden-xs"><?php echo $userinfo->username;  ?></span> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInLeft">
                    <li class="arrow"></li>
                    <li><a href="editprofile.php">Edit Profile</a></li>
                    <li><a href="changepassword.php">Change Password</a></li>
                    <li><a href="notification_settings.php">Notification Settings</a></li>
                    <li><a href="set_timezone.php">Set Timezone</a></li>
                    <li><a href="notification.php">Send Notification</a></li>
                    <li class="divider"></li>
                    <li><a href="logout.php">Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>