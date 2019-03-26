<?php
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$querystring=$_POST['admin_id'];
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];

$removeimage = $admin->adminaccessdetail($id);
if($removeimage)
{
    $image=$removeimage->icon;
    $admin->unlinkimage($image,"../uploads");
}
$deleteadmin=$admin->deleteadminaccess($id);
if($deleteadmin)
{
    echo "True";
}
else
{

}
?>