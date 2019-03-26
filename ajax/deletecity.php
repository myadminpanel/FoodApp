<?php
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$querystring=$_POST['city_id'];
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];

$profile = $admin->deletecity($id);
if($profile)
{
    echo "True";
}
else
{

}
?>