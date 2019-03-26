<?php
session_start();
include'../application/db_config.php';

if($_POST['message1'])
{
$sendresult = array();

$querya=mysqli_query($conn,"select * from fooddelivery_server_key");
$resa=mysqli_fetch_array($querya);
$google_api_key=$resa['android_key'];
$ios_api_key=$resa['ios_key'];

// Notification Data
$query=mysqli_query($conn,"select * from fooddelivery_tokendata where type='android'");
$i=0;
$reg_id=array();
while ($res=mysqli_fetch_array($query))
{

$reg_id[$i]= $res['token'];
$i++;
}

$massage = $_POST['message1'];
    
        $registrationIds =  $reg_id ;
        //print_r($registrationIds); exit;
        $message = array(
        'message' => $massage,
        'title' => 'Notification');

        $fields = array(
            'registration_ids'  => $registrationIds,
            'data'      => $message
        );

        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Authorization: key='.$google_api_key,// . $api_key,
            'Content-Type: application/json'
        );

        $json =  json_encode($fields);

        $ch = curl_init();
       
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$json);

        $result = curl_exec($ch);

        if ($result === FALSE){
                die('Curl failed: ' . curl_error($ch));
            }   

            curl_close($ch);
            $response=json_decode($result,true);
            //print_r($response); exit();
            if($response['success']>0)
            {
                //echo "insert into dr_notification values(NULL,'".$massage."')"; exit;
                $notification="insert into fooddelivery_notify_msg values(NULL,'".$massage."')";
                $insertres = mysqli_query($conn,$notification);
                if($insertres)
                {
                    $sendresult['android'] = $response['success'];
                }
            }
            else
            {
               $sendresult['android'] = 0;
            }

$queryios=mysqli_query($conn,"select * from fooddelivery_tokendata where type='Iphone'");
$i=0;
$reg_id=array();
while ($resios=mysqli_fetch_array($queryios))
{

$reg_id[$i]= $resios['token'];
$i++;
}
$registrationIds = $reg_id;


        $msg = array(
        'body'  => $massage,
        'title'     => "Notification",
        'vibrate'   => 1,
        'sound'     => 1,
        );
        
        $fields = array(
                    'registration_ids'  => $registrationIds,
                    'notification'      => $msg
                );

        $headers = array(
                    'Authorization: key=' . $ios_api_key,
                    'Content-Type: application/json'
                );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );

            if ($result === FALSE){
                die('Curl failed: ' . curl_error($ch));
            }   

            curl_close($ch);
            $response=json_decode($result,true);
            //print_r($response); exit();
            if($response['success']>0)
            {
                {
                    $sendresult['ios'] = $response['success'];
                }
            }
            else
            {
               $sendresult['ios'] = 0;
            }
            echo json_encode($sendresult);

}

?>