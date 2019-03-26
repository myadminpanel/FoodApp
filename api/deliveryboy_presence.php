<?php

include "../application/db_config.php";
include 'error_response.php';
$arrRecord = array();

if (isset($_POST["status"])) {

    $attendance = $_POST['status'];
    $deliverboy_id = $_POST['deliverboy_id'];
        $sql = mysqli_query($conn,"UPDATE `fooddelivery_delivery_boy` SET `attendance`='".$attendance."' WHERE id='".$deliverboy_id."'");

        if ($sql) {
                $arrRecord['data']['success'] = "1";
                $arrRecord['data']['presence'] = $attendance;
        } else {
            $arrRecord['data']['success'] = 0;
            $arrRecord['data']['presence'] = $invalid;
        }      

} else {
    $arrRecord['data']['success'] = 0;
    $arrRecord['data']['presence'] = $data_not_found;
}

echo json_encode($arrRecord);
 ?>