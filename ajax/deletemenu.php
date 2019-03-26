<?php
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$querystring=$_POST['menu_id'];
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
$delmenu=$admin->deletemenu($id);
if($delmenu)
{
    echo "True";
}
else
{

}
?>