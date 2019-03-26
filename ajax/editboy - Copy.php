<?php
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$order_id=$val[1];
$doydetail=$admin->assign_order($order_id);
$res_id=$doydetail->res_id;
$boy_list = mysqli_query($conn,"select * from fooddelivery_delivery_boy where res_id = '".$res_id."'");
?>
<input type="hidden" name="querystring" value="<?php echo $querystring; ?>">
<label class="control-label col-md-4 col-sm-4" for="fullname">Order ID <span style="color: red;">*</span> :</label>
<div class="col-md-6 col-sm-6">
    <input class="form-control" type="text" value="<?php echo $doydetail->id; ?>"  name="order_id" readonly="" style="cursor: no-drop;"/>
</div>
<label class="control-label col-md-4 col-sm-4" for="fullname"> Select Delivery Boy <span style="color: red;">*</span> :</label>
<div class="col-md-6 col-sm-6">
	<select class="form-control" name="boy_id">
	<option value="">Select Name</option>
	<?php
    while ($list = mysqli_fetch_array($boy_list))
    {
    ?>
	<option value="<?php echo $list['name']; ?>"><?php echo $list['name']; ?></option>
	<?php
	}
	?>
	</select>
</div>
