<?php
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$querystring=$_POST['category_id'];
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];

$subcat = $admin->getsubcategorywithcatid($id);
print_r($subcat);
if($subcat)
{
    foreach ($subcat as $sval)
    {
        $admin->deletesubcategory($sval->id);
        $admin->deletecategoryres($sval->id);
    }
}
$removeimage = $admin->categorydetail($id);
if($removeimage)
{
    $image=$removeimage->image;
    $admin->unlinkimage($image,"../uploads/restaurant");
}
$profile = $admin->deletecategory($id);
$delcategoryres=$admin->deletecategoryres($id);
if($profile)
{
    echo "True";
}
else
{

}
?>