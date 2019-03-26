<?php
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$boy_id=$val[1];
$doydetail=$admin->boydetail($boy_id);
?>
<input type="hidden" name="boy_id" value="<?php echo $doydetail->id; ?>">
<input type="hidden" name="querystring" value="<?php echo $querystring; ?>">
<label class="control-label col-md-4 col-sm-4" for="fullname">Name <span style="color: red;">*</span> :</label>
<div class="col-md-6 col-sm-6">
    <input class="form-control" type="text" value="<?php echo $doydetail->name; ?>"  name="name" placeholder="Enter Name" data-parsley-required="true" />
</div>
<label class="control-label col-md-4 col-sm-4" for="fullname">Contact No <span style="color: red;">*</span> :</label>
<div class="col-md-6 col-sm-6">
    <input class="form-control" type="text" value="<?php echo $doydetail->phone; ?>"  name="phone" placeholder="Enter Contact No" data-parsley-required="true" />
</div>
<label class="control-label col-md-4 col-sm-4" for="fullname">Email <span style="color: red;">*</span> :</label>
<div class="col-md-6 col-sm-6">
    <input class="form-control" type="email" value="<?php echo $doydetail->email; ?>"  name="email" placeholder="Enter Email" data-parsley-required="true" />
</div>
<label class="control-label col-md-4 col-sm-4" for="fullname">Password <span style="color: red;">*</span> :</label>
<div class="col-md-6 col-sm-6">
    <input class="form-control" type="password" value="<?php echo $doydetail->password; ?>"  name="password" placeholder="Enter Password" data-parsley-required="true" />
</div>
<label class="control-label col-md-4 col-sm-4" for="fullname">Vehicle No. <span style="color: red;">*</span> :</label>
<div class="col-md-6 col-sm-6">
    <input class="form-control" type="text" value="<?php echo $doydetail->vehicle_no; ?>"  name="vehicle_no" placeholder="Enter Vehicle No" data-parsley-required="true" />
</div>
<label class="control-label col-md-4 col-sm-4" for="fullname">Vehicle Type. <span style="color: red;">*</span> :</label>
<div class="col-md-6 col-sm-6">
    <input class="form-control" type="text" value="<?php echo $doydetail->vehicle_type; ?>"  name="vehicle_type" placeholder="Enter Vehicle Type" data-parsley-required="true" />
</div>
