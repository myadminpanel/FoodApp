<?php
$countnewuser=$user->countnewusers();
$countrenewview=$user->countnewreviews();
$countorder=$user->countnotifyorder();
$slq = mysqli_query($conn,"SELECT currency FROM fooddelivery_adminlogin where id='1'");
$get_currency = mysqli_fetch_array($slq);
?>
<div id="top-menu" class="top-menu" style="position: fixed;">
    <!-- begin top-menu nav -->
    <ul class="nav">
        <li class="has-sub">
            <a href="dashboard.php">
                <i class="fa fa-home"></i>
                <span>Dashboard </span>
            </a>
        </li>
        <li class="has-sub">
            <a href="editrestaurant.php">
                <i class="fa fa-shopping-bag"></i>
                <span>Restaurant Details  </span>
            </a>
        </li>
        <li class="has-sub">
            <a href="reviews.php">
                <i class="fa fa-comment"></i>
                <span>User Review <span class="label label-theme m-l-5"><?php echo $countrenewview; ?></span></span>
            </a>
        </li>
        <li class="has-sub">
            <a href="menu.php">
                <i class="fa fa-bars"></i>
                <span>Menu</span>
            </a>
        </li>
        <li class="has-sub">
            <a href="delivery_boy.php">
                <i class="fa fa-truck"></i>
                <span>Delivery Boy</span>
            </a>
        </li>
    </ul>
</div>