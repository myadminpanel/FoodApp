<?php
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$querystring=$_POST['boy_id'];
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
$delboy=$admin->deleteboy($id);
if($delboy)
{
    echo "True";
}
else
{

}
?>