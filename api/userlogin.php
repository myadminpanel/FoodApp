<?php
include '../controllers/apicontroller.php';
include 'error_response.php';
$api = new apicontroller();
extract($_GET);
$gl="Google";
$fb="Facebook";
if(isset($login_type) && $login_type == "Google")
{
    if
    (
        isset($fullname) && $fullname != "" &&
        isset($email) && $email != "" &&
        isset($image) && $image != "" &&
        isset($phone_no) &&
        isset($referral_code)
    )
    {
        $checkemail=$api->checkuseremail($email);
        if($checkemail)
        {
            $login = $api->userlogin("non","non",$email);
            $json[]=array("status"=>"Success","user_detail"=>$login);
            echo json_encode($json);
        }
        else
        {
            /*$checkphone=$api->checkphoneno($phone_no);
            if($checkphone)
            {
                $login = $api->userlogin("non","non",$phone_no);
                $json[]=array("status"=>"Success","user_detail"=>$login);
                echo json_encode($json);
            }
            else
            {*/
                $created_at=time();
                $registerwithgoogle=$api->userregister($fullname,$email,"",$phone_no,$referral_code,$created_at,$gl,$image);
                if($registerwithgoogle)
                {
                    $json[]=array("status"=>"Success","user_detail"=>$registerwithgoogle);
                    echo json_encode($json);
                }
                else
                {
                    echo $fail;
                }
           /* }*/
        }
    }
    else
    {
        echo $error;
    }
}
elseif(isset($login_type) && $login_type == "Facebook")
{
    if( isset($fullname) && $fullname != "" &&
        isset($email) && $email != "" &&
        isset($image) && $image != "" &&
        isset($phone_no) &&
        isset($referral_code)
    ){
        $checkemail=$api->checkuseremail($email);
        if($checkemail)
        {
            $login = $api->userlogin("non","non",$email);
            $json[]=array("status"=>"Success","user_detail"=>$login);
            echo json_encode($json);
        }
        else
        {
           /* $checkphone=$api->checkphoneno($phone_no);
            if($checkphone)
            {
                $login = $api->userlogin("non","non",$phone_no);
                $json[]=array("status"=>"Success","user_detail"=>$login);
                echo json_encode($json);
            }
            else
            {*/
                $created_at=time();
                $registerwithgoogle=$api->userregister($fullname,$email,"",$phone_no,$referral_code,$created_at,$fb,$image);
                if($registerwithgoogle)
                {
                    $json[]=array("status"=>"Success","user_detail"=>$registerwithgoogle);
                    echo json_encode($json);
                }
                else
                {
                    echo $fail;
                }
           /* }*/
        }
    }
    else
    {
        echo $error;
    }
}
else
{
    if
    (
        isset($email) && $email != "" &&
        isset($password) && $password != ""
    )
    {
        $pass = $api->encrypt_decrypt("encrypt",$password);
        $login = $api->userlogin($email,$pass,"nope");
        if($login)
        {
            $json[]=array("status"=>"Success","user_detail"=>$login);
            echo json_encode($json);
        }
        else
        {
            echo $fail;
        }
    }
    else
    {
        echo $error;
    }
}
?>