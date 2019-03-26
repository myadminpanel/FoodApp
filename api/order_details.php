<?php
include '../controllers/apicontroller.php';
include 'error_response.php';
if (isset($_GET["order_id"])) {
    mysqli_set_charset( $conn, 'utf8');
    $query = mysqli_query($conn, "SELECT  fb.id as order_id,fb.res_id , fr.address as restaurant_address , 
        fb.total_price as order_amount, fb.created_at , fb.accept_date_time , fb.accept_status , fb.delivery_date_time , fb.delivery_status , fb.delivered_date_time , fb.delivered_status , fb.reject_date_time , fb.reject_status , fr.id,fr.name as restaurant_name , fr.photo , fr.phone , fr.delivery_time FROM fooddelivery_bookorder fb 
        inner join fooddelivery_restaurant fr on fb.res_id = fr.id where fb.id='".$_GET['order_id']."'");

    $res = mysqli_fetch_array($query);
    //echo $restaurant_name = $res['restaurant_name']; exit();
        $stemp = $res['created_at'];
        $odate = date('d-m-Y', $stemp);
        $otime = date('H:i', $stemp);
        $oddate = $odate." ".$otime;
        $delivery_time = $res['delivery_time'];
    
        $date = new DateTime($oddate);
        $date->modify('+'.$delivery_time.' minutes');
        $ddate = $date->format("d-m-Y H:i");

        if ($res['accept_status'] == '') {
            $order_verified = 'Deactivate';
        } else {
            $order_verified = 'Activate';
        }

        if ($res['delivery_status'] == '') {
            $delivery_status = 'Deactivate';
        } else {
            $delivery_status = 'Activate';
        }

        if ($res['delivered_status'] == '') {
            $delivered_status = 'Deactivate';
        } else {
            $delivered_status = 'Activate';
        }

        if ($res['reject_status'] == '') {
            $reject_status = 'Deactivate';
        } else {
            $reject_status = 'Activate';
        }



    {
        $data[] = array(
            "restaurant_name" => $res['restaurant_name'],
            "restaurant_address" => $res['restaurant_address'],
            "restaurant_contact" => $res['phone'],
            "restaurant_image" => $res['photo'],
            "order_amount" => $res['order_amount'],
            "order_time" => $oddate,
            "delivery_time" => $ddate,
            "order_id" => $res['order_id'],
            "order_verified_date" => $res['accept_date_time'],
            "order_verified" => $order_verified,
            "delivery_date_time" => $res['delivery_date_time'],
            "delivery_status" => $delivery_status,
            "delivered_date_time" => $res['delivered_date_time'],
            "delivered_status" => $delivered_status,
            "reject_date_time" => $res['reject_date_time'],
            "reject_status" => $reject_status,
        );
        $data1=array();
    }
        
        if (isset($data)) {
            if (!empty($data)) {
                $arrRecord['success'] = "1";
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
        $arrRecord['success'] = "0";
        $arrRecord['gallery'] = $peramitter_not_set;
    }
    echo json_encode($arrRecord);
    //echo '<pre>',print_r($arrRecord,1),'</pre>';

?>