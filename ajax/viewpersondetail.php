<?php
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
$res=$admin->getpersondetail($id);
?>

<table class="table table-striped">
    <tbody>
    <tr>
        <th>Name :</th>
        <td><?php echo $res->fullname; ?></td>
    </tr>
    <tr>
        <th>Email :</th>
        <td><?php echo $res->email;?></td>
    </tr>
    <tr>
        <th>Phone :</th>
        <td><?php echo $res->phone_no; ?></td>
    </tr>
    <tr>
        <th>Referal Code :</th>
        <td><?php echo $res->referal_code; ?></td>
    </tr>
    </tbody>
</table>