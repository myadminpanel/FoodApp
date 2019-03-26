<?php
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$querystring=$_POST['querystring'];
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];

$query=mysqli_query($conn,"select * from fooddelivery_bookorder WHERE id='$id'");
$row=mysqli_fetch_array($query);
$order_id=$row['id'];

$query = mysqli_query($conn,"select timezone from fooddelivery_adminlogin where id ='1'");
$fetch = mysqli_fetch_array($query);
$timezone = $fetch['timezone'];

$default_time = explode(" - ", $timezone);
$vals = $default_time[0];
date_default_timezone_set($vals);
$date = date('d-m-Y H:i');

$update=mysqli_query($conn,"update fooddelivery_bookorder set status=3,delivery_date_time='$date',delivery_status='active' WHERE id='$order_id'");
if($update )
{
    echo 1;
} else {
	echo 0;
}

?>