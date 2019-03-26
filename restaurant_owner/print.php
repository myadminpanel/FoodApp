<?php
$querystring=$_REQUEST['order_id'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
$res=$admin->getmoredetail($id);
$res_id=$res->res_id;

$currency = mysqli_query($conn,"SELECT name,email,phone,currency,location FROM fooddelivery_restaurant where id='$res_id'");
$get_currency = mysqli_fetch_array($currency);
$sign = $get_currency['currency'];
$location = $get_currency['location'];

$query_order = mysqli_query($conn,"SELECT * FROM fooddelivery_bookorder WHERE id = '$id'");
$row_order = mysqli_fetch_array($query_order);
$user_details = $row_order['user_id'];

$query_user = mysqli_query($conn,"SELECT * FROM fooddelivery_users WHERE id = '$user_details'");
$row_user = mysqli_fetch_array($query_user);

?>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<style type="text/css">
    .invoice-title h2, .invoice-title h3 {
        display: inline-block;
    }

    .table > tbody > tr > .no-line {
        border-top: none;
    }

    .table > thead > tr > .no-line {
        border-bottom: none;
    }

    .table > tbody > tr > .thick-line {
        border-top: 2px solid;
    }
    @page {
      size: A4;
      margin: 15px;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="invoice-title">
                <h2>Invoice</h2><h3 class="pull-right">Order # <?php echo $id ?></h3>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                    <strong>Billed To:</strong><br>
                        <?php echo $get_currency['name']; ?><br>
                        <?php echo $get_currency['email'];?><br>
                        <?php echo $get_currency['phone']; ?><br>
                        <?php echo wordwrap($location, 20, "<br />\n"); ?>
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                    <strong>Shipped To:</strong><br>
                        <?php echo $row_user['fullname']; ?><br>
                        <?php echo $row_user['email'];?><br>
                        <?php echo $row_user['phone_no']; ?><br>
                        <?php echo wordwrap($res->address, 40, "<br />\n"); ?>
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <!-- <address>
                        <strong>Payment Method:</strong><br>
                        Visa ending **** 4242<br>
                        jsmith@email.com
                    </address> -->
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Order Date:</strong><br>
                        <?php 
                        $date = date("d-M-Y", $row_order['created_at']);
                        echo $date; ?>
                        <br><br>
                    </address>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Order summary</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <td><strong>#</strong></td>
                                    <td><strong>Item Name</strong></td>
                                    <td class="text-center"><strong>Quantity</strong></td>
                                    <td class="text-right"><strong>Amount</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                mysqli_set_charset( $conn, 'utf8');
                                $Item= mysqli_query($conn,"SELECT * from fooddelivery_food_desc Where order_id='".$id."'");
                                $t = 1;
                                while($get_Item = mysqli_fetch_array($Item))
                                {
                                ?>
                                <tr>
                                    <td> <?= $t;?></td>
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
                                    <td class="text-center"><?php echo $get_Item['ItemQty']; ?></td>
                                    <td class="text-right"><?php echo $get_Item['ItemAmt']; ?></td>
                                </tr>
                                <?php
                                $t++;
                                }
                                ?>
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-center"><strong>Total</strong></td>
                                    <td class="no-line text-right"><?php echo $res->total_price . '$'; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        window.print();
        window.close();
    });
</script>