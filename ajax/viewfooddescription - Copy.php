<?php
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
$res=$admin->getmoredetail($id);
$res_id=$res->res_id;
$currency=$admin->getcurrencybyid($res_id);
$sign=$currency->currency;
$item_desc=$res->food_desc;
?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>id</th>
        <th>Image</th>
        <th>Menu Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total Price</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $arr = explode(";",$item_desc);
    foreach($arr as $val)
    {
        $a=explode(",",$val);
        unset($arr1);
        foreach($a as $val1)
        {
            $datya=substr($val1, strpos($val1, "=") + 1);
            $arr1[]=$datya;
        }
         /* menu_id=1,quntity=24.00,total_price=489.00;menu_id=1,quntity=24.00,total_price=489.00 */
        /*$selagency=mysqli_query($con,"select * from agency_agencydetail where id='".$arr1[0]."'");
        $age=mysqli_fetch_array($selagency);*/
        $menudetail = $admin->viewmenudetail($arr1[0]);
        ?>
        <tr>
            <td><?php echo $menudetail->id; ?></td>
            <td>
                <div class="email-user" style="color: white;background-color: #00acac;height: 50px;width: 50px;border-radius: 30px;text-align: center;font-size: 28px;line-height: 47px;">
                    <?php $latter = $menudetail->name; echo strtoupper($latter[0]); ?>
                </div>
            </td>
            <td><?php echo $menudetail->name; ?></td>
            <td><?php echo $arr1[1] ?></td>
            <td><?php echo  $sign . $menudetail->price; ?></td>
            <td><?php echo $sign .$arr1[2]; ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
<div align="right">Total Amount :- <?php echo $sign .$res->total_price; ?></div>
