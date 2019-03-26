<?php
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$submenu_id=$val[1];
$menudetail=$admin->submenucategorydetail($submenu_id);
?>
<input type="hidden" name="submenu_id" value="<?php echo $menudetail->id; ?>">
<input type="hidden" name="querystring" value="<?php echo $querystring; ?>">
<div class="form-group">
    <label class="control-label col-md-4 col-sm-4" for="fullname">Menu Name <span style="color: red;">*</span> :</label>
    <div class="col-md-6 col-sm-6">
        <input class="form-control" type="text" name="smname" value="<?php echo $menudetail->name;?>" placeholder="Menu Name" data-parsley-required="true" />
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4 col-sm-4" for="fullname">Descriptions <span style="color: red;">*</span> :</label>
    <div class="col-md-6 col-sm-6">
        <input class="form-control" type="text"  name="desc" value="<?php echo $menudetail->desc;?>"  placeholder="Short One Line Description " data-parsley-required="true" />
        <div id="errors" style="color: red;"></div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4 col-sm-4" for="fullname">Menu Price <span style="color: red;">*</span> :</label>
    <div class="col-md-6 col-sm-6">
        <input class="form-control" type="text"  name="price" value="<?php echo $menudetail->price;?>" placeholder="Menu Price Ex : 100.00" data-parsley-required="true" />
    </div>
</div>
