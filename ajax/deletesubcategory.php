<?php
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$querystring=$_POST['querystring'];
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
$profile = $admin->deletesubcategory($id);
$delcategoryres=$admin->deletecategoryres($id);
if($profile)
{
    echo "True";
}
else
{

}
?>