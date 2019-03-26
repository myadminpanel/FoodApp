<?php
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$querystring=$_POST['appuser_id'];
$imagename=$_POST['imagename'];
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
$deletereviewbyappusers=$admin->deletereviewbyuser($id);
$deleteappuser=$admin->deleteappuser($id);
if($deleteappuser){
    if(file_exists("../uploads/restaurant/$imagename"))
    {
        unlink("../uploads/restaurant/$imagename");
    }
    echo "true";
}
else
{

}
?>