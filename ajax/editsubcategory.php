<?php
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$submenu_id=$val[1];
$menudetail=$admin->getsubcategory($submenu_id);
?>
<input type="hidden" name="subcat_id" value="<?php echo $menudetail->id; ?>">
<input type="hidden" name="querystring" value="<?php echo $querystring; ?>">
<div class="form-group">
    <label class="control-label col-md-4 col-sm-4" for="fullname">Menu Name <span style="color: red;">*</span> :</label>
    <div class="col-md-6 col-sm-6">
        <input class="form-control" type="text" name="cname" value="<?php echo $menudetail->name;?>" placeholder="Sub Category Name" data-parsley-required="true" />
    </div>
</div>

