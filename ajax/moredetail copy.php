<?php
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
$res=$admin->getmoredetail($id);
?>
    <table class="table table-striped">
        <tbody>
        <tr>
            <th>Address :</th>
            <td><?php echo $res->address; ?></td>
        </tr>
        <tr>
            <th>Food Description :</th>
            <td><?php echo $res->food_desc; ?></td>
        </tr>
        </tbody>
    </table>