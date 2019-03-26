<?php
include '../controllers/apicontroller.php';
$api = new apicontroller();
extract($_GET);
if
(
    isset($user_id) && $user_id != "" &&
    isset($res_id) && $res_id != "" &&
    isset($address) && $address != "" &&
    isset($lat) && $lat != "" &&
    isset($long) && $long != "" &&
    isset($food_desc) && $food_desc != "" &&
    isset($notes) && $notes != "" &&
    isset($total_price) && $total_price != ""
)
{
    $created_at=time();
    $notify=1;
    $status=0;
    $bookorder = $api->bookorder($user_id,$res_id,$address,$lat,$long,$food_desc,$notes,$total_price,$created_at,$notify,$status);

    mysqli_set_charset( $conn, 'utf8');
    $sqlSelect = mysqli_query($conn,"SELECT  fb.id as order_id,fb.res_id , fr.address as restaurant_address , fb.total_price as order_amount,fr.id,fr.name as restaurant_name FROM fooddelivery_bookorder fb 
        inner join fooddelivery_restaurant fr on fb.res_id = fr.id
        ORDER BY fb.id DESC limit 1");
    $res = mysqli_fetch_array($sqlSelect);
    //echo $restaurant_name = $res['restaurant_name']; exit();

        $date = date('Y/m/d H:i:s');
        $order_id = rand(0,100);
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
    //print_r($data); exit;
            if (isset($data)) {
            if (!empty($data)) {
                $arrRecord['success'] = "Order Book Successfully";
                $arrRecord['order_details'] = $data;
            } else {
                $arrRecord['success'] = "0";
                $arrRecord['order_details'] = 'no record found';
            }
        } else {
            $arrRecord['success'] = "0";
            $arrRecord['order_details'] = 'no record found';
        }
    } else {
        $arrRecord['success'] = "0";
        $arrRecord['gallery'] = 'no record found';
    }
    echo json_encode($arrRecord);
    
//     if($bookorder)
//     {
//         echo '[{"status":"Success","Msg":"Order Book Successfully"}]';
//     }
// else
// {
//     echo '[{"status":"Failed","error":"Variable Not Set"}]';
// }

/*
Book Food Order ....
URL http://localhost/fooddeliverysystem/api/bookorder.php?user_id={}&res_id={}&address={}&city={}&zipcode={}&food_desc={}&description={}&total_price={}

*/
?>