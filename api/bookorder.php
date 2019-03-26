<?php
include "../application/db_config.php";
include 'error_response.php';

if (isset($_POST['user_id']))
{
    $user_id = $_POST['user_id'];
    $res_id = $_POST['res_id'];
    $address = $_POST['address'];
    $lat = $_POST['lat'];
    $long = $_POST['long'];
    $food_desc = $_POST['food_desc'];
    $notes = $_POST['notes'];
    $total_price = $_POST['total_price'];
    $notify = '1';
    $status = '0';
    $new = str_replace("%20"," ", $address);
    $created_at=time();

    mysqli_set_charset($conn,"utf8");
    $sql = "insert into fooddelivery_bookorder (`id`, `user_id`, `res_id`, `address`, `lat`, `long`, `notes`, `total_price`, `payment`, `created_at`, `notify`, `status`) values(NULL,'".$user_id."','".$res_id."','".$new."','".$lat."','".$long."','".$notes."','".$total_price."','COD','".$created_at."','".$notify."','".$status."')";
    $res = mysqli_query($conn,$sql);
    $last_id = mysqli_insert_id($conn);

        $datadesc = json_decode($food_desc, true);
        $Order = $datadesc['Order'];
        foreach($Order as $val)
        {
            $sql_qry = "INSERT INTO fooddelivery_food_desc(order_id,res_id,ItemId,ItemQty,ItemAmt) VALUES('$last_id','$res_id','".$val['ItemId']."', '".$val['ItemQty']."', '".$val['ItemAmt']."')";
            $qry = mysqli_query($conn,$sql_qry);
        }

    mysqli_set_charset( $conn, 'utf8');
    $sqlSelect = mysqli_query($conn,"SELECT  fb.id as order_id,fb.res_id , fr.address as restaurant_address , fb.total_price as order_amount,fr.id,fr.name as restaurant_name FROM fooddelivery_bookorder fb 
        inner join fooddelivery_restaurant fr on fb.res_id = fr.id
        ORDER BY fb.id DESC limit 1");
    $res = mysqli_fetch_array($sqlSelect);
    $date = date('Y/m/d H:i:s');
    {
        $data[] = array(
            "restaurant_name" => $res['restaurant_name'],
            "restaurant_address" => $res['restaurant_address'],
            "order_amount" => $res['order_amount'],
            "order_date" => $date,
            "order_id" => $res['order_id'],
        );
        $data1=array();
    }
    if (isset($data)) {
            if (!empty($data)) {
                $arrRecord['success'] = "Order Book Successfully";
                $arrRecord['order_details'] = $data;
            } else {
                $arrRecord['success'] = "0";
                $arrRecord['order_details'] = $data_not_found;
            }
        } else {
            $arrRecord['success'] = "0";
            $arrRecord['order_details'] = $data_not_found;
        }        
} else {
         $arrRecord['data']['success'] = 0;
        $arrRecord['data']['order_details'] = $peramitter_not_set;
}
echo json_encode($arrRecord);
?>