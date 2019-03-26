<?php
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
$res=$admin->getmoredetail($id);
$res_id=$res->res_id;

$currency = mysqli_query($conn,"SELECT currency FROM fooddelivery_restaurant where id='$res_id'");
$get_currency = mysqli_fetch_array($currency);
$sign = $get_currency['currency'];

$query_order = mysqli_query($conn,"SELECT * FROM fooddelivery_bookorder WHERE id = '$id'");
$row_order = mysqli_fetch_array($query_order);
$user_details = $row_order['user_id'];

$query_user = mysqli_query($conn,"SELECT * FROM fooddelivery_users WHERE id = '$user_details'");
$row_user = mysqli_fetch_array($query_user);

?>


    <div class="modal-header">
        <button id="non-printable" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel1">Order No <?php echo $id ?> - <?php echo $res->total_price . '$'; ?> </h3>
    </div>
     <table class="table page">
        <thead>
          <tr>
            <th>Item Name</th>
            <th>Qty</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody>
            <?php
            mysqli_set_charset( $conn, 'utf8');
            $Item= mysqli_query($conn,"SELECT * from fooddelivery_food_desc Where order_id='".$id."'");
            while($get_Item = mysqli_fetch_array($Item))
            {
            ?>
          <tr>
                <?php
                    $name = $get_Item['ItemId'];

                    $query_Subcategory = mysqli_query($conn,"SELECT * FROM fooddelivery_submenu WHERE id = '$name'");
                    $row_getSubCategory = mysqli_fetch_array($query_Subcategory);

                    $str         = $row_getSubCategory['name'];
                    $subcategory = explode(',', $str);
                    foreach ($subcategory as $arraysubcat) {
                        echo '<td>' . $arraysubcat . '</td>';
                    }
                ?>
                <td><?php echo $get_Item['ItemQty']; ?></td>
                <td><?php echo $get_Item['ItemAmt']; ?></td>
          </tr>
            <?php
            }
            ?>
        </tbody>
      </table>

    <table class="table table-striped">
        <h3 id="myModalLabel1">Person Detail</h3>
        <tbody>
        <tr>
        <th>Name :</th>
        <td><?php echo $row_user['fullname']; ?></td>
        </tr>
        <tr>
            <th>Email :</th>
            <td><?php echo $row_user['email'];?></td>
        </tr>
        <tr>
            <th>Phone :</th>
            <td><?php echo $row_user['phone_no']; ?></td>
        </tr>
        <tr>
            <th style="width: 85px;">Address :</th>
            <td><?php echo $res->address; ?></td>
        </tr>
        </tbody>
    </table>
    <div class="modal-footer">
        <a href="" target="_blank" class="badge badge-success" onClick="window.print()">Print</a>
        <!-- <button id="non-printable" class="" onClick="window.print()"></button> -->
    </div>