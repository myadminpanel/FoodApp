<?php
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$querystring=$_POST['querystring'];
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
$removeimage = $admin->getrestaurantdetail($id);
if($removeimage)
{
    $image=$removeimage->photo;
    $admin->unlinkimage($image,"../uploads/restaurant");
}
$categoryres=$admin->deletecategorymul($id);
$menuandsubmenu=$admin->deletemenuandsubmenu($id);
$deletefoodorder=$admin->deleteresfoodorder($id);
$deleteresreviews=$admin->deleteresreviews($id);
$delresto=$admin->deleterestaurant($id);
if($delresto)
{
    echo "True";
}
else
{

}
?>