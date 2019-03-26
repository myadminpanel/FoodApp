<?php
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$id=$_POST['id'];
$delete=$admin->deletereview($id);
if($delete)
{
    echo "true";
}
else
{

}

?>