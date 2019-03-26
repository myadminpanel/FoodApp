<?php
$countnewuser=$user->countnewusers();
$countrenewview=$user->countnewreviews();
$countorder=$user->countnotifyorder();
include('currencyarray.php');
if (isset($_POST['set_currency'])) {

    $currency = $_POST['currency'];
    $sql = mysqli_query($conn,"UPDATE `fooddelivery_adminlogin` SET `currency`='".$currency."' WHERE id='".$uid."'");
    echo "<script>
    window.location='".$_SERVER['REQUEST_URI']."';</script>";
}
$slq = mysqli_query($conn,"SELECT currency FROM fooddelivery_adminlogin where id='".$uid."'");
$get_currency = mysqli_fetch_array($slq);
?>
<div id="top-menu" class="top-menu" style="position: fixed;">
    <!-- begin top-menu nav -->
    <ul class="nav">
        <li class="has-sub">
            <a href="dashboard.php">
                <i class="fa fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="has-sub">
            <a href="category.php">
                <i class="fa fa-list"></i>
                <span>Category</span>
            </a>
        </li>
        <li class="has-sub">
            <a href="city.php">
                <i class="fa fa-list"></i>
                <span>City</span>
            </a>
        </li>
        <li class="has-sub">
            <a href="foodorder.php">
                <i class="fa fa-shopping-bag"></i>
                <span>Food Order <span class="label label-primary m-l-5"><?php echo $countorder; ?></span> </span>
            </a>
        </li>
        <li class="has-sub">
            <a href="appusers.php">
                <i class="fa fa-users"></i>
                <span>App Users <span class="label label-danger m-l-5"><?php echo $countnewuser; ?></span></span>
            </a>
        </li>
        <li class="has-sub">
            <a href="reviews.php">
                <i class="fa fa-comment"></i>
                <span>User Review <span class="label label-theme m-l-5"><?php echo $countrenewview; ?></span></span>
            </a>
        </li>
        <li class="has-sub">
            <a href="adminaccess.php">
                <i class="fa fa-adn"></i>
                <span>Admin Access</span>
            </a>
        </li>
        <li class="has-sub">
            <a href="webservice.php">
                <i class="fa fa-code"></i>
                <span>Web Services</span>
            </a>
        </li>
        <li class="has-sub">
            <span data-toggle="modal" data-target="#myModal" style="padding: 10px 18px;color: #a8acb1;line-height: 20px; cursor: pointer;">
                <i class="fa fa-dollar"></i>
                Currency
            </span>
        </li>
    </ul>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form method="post">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Currency</h4>
      </div>
      <div class="modal-body">
        <div class="panel-body panel-form">
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-4" for="website">Set Currency</label>
                <div class="col-md-6 col-sm-6">
                    <select name="currency" class="form-control" required>
                        <?php
                        foreach($currency_symbols as $key => $value):
                        echo '<option value="'.$key. " - " .$value.'">'.$key. " - " .$value.'</option>'; //close your tags!!
                        endforeach;
                        ?>
                    </select>
                    <br>
                    <span>Current Currency is : <?php echo $get_currency['currency']; ?></span>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="set_currency" class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>

  </div>
</div>