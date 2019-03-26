<?php
session_start();
$uid = $_SESSION['uid'];
include("../application/db_config.php");
$query_res = mysqli_query($conn,"select * from fooddelivery_res_owner where id='".$uid."'");
$res = mysqli_fetch_array($query_res);
$res_id = $res['res_id'];
if(isset($_POST['view'])){
  
// $con = mysqli_connect("localhost", "root", "", "notif");

if($_POST["view"] != ' ')
{
   $update_query = "UPDATE fooddelivery_bookorder SET notify=2  where notify=1 and res_id='".$res_id."'";
   mysqli_query($conn, $update_query);
}

$query = "SELECT * FROM fooddelivery_bookorder WHERE notify=1 and res_id='".$res_id."'";
$result = mysqli_query($conn, $query);
$output = '';
if(mysqli_num_rows($result) > 0)
{

  $output .= '
  <li>
  <a href="dashboard.php">
  <strong>You have '.mysqli_num_rows($result).' New Order</strong>
  </a>
  </li>

  ';
}

else{
 $output .= '
  <li>
  <a href="dashboard.php">
  <strong>You have '.mysqli_num_rows($result).' New Order</strong>
  </a>
  </li>

  ';
}

$status_query = "SELECT * FROM fooddelivery_bookorder WHERE notify=1 and res_id='".$res_id."'";
$result_query = mysqli_query($conn, $status_query);
$count = mysqli_num_rows($result_query);

$data = array(
   'notification' => $output,
   'unseen_notification'  => $count
);

echo json_encode($data);
}
?>