<?php
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$querystring=$_POST['querystring'];
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];

$active = $admin->getrestaurantbyid($id);
if($active)
{
    $value=$active->is_active;
    if($value == 1)
    {
        $updateactive=$admin->editactiverestaurant($id,0);
    }
    else
    {
        $updateactive=$admin->editactiverestaurant($id,1);
    }
}
if($updateactive)
{
    echo "True";
}
else
{

}
?>