<?php
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$menu_id=$val[1];
$menudetail=$admin->menucategorydetail($menu_id);
?>
<input type="hidden" name="menu_id" value="<?php echo $menudetail->id; ?>">
<input type="hidden" name="querystring" value="<?php echo $querystring; ?>">
<label class="control-label col-md-4 col-sm-4" for="fullname">Menu Name <span style="color: red;">*</span> :</label>
<div class="col-md-6 col-sm-6">
    <input class="form-control" type="text" value="<?php echo $menudetail->name; ?>"  name="mname" placeholder="Menu Name" data-parsley-required="true" />
</div>
