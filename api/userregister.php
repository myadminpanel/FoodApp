<?php
include '../controllers/apicontroller.php';
include 'error_response.php';

$api = new apicontroller();
extract($_REQUEST);
//echo $referral_code;
if
(
    isset($fullname) && $fullname != "" &&
    isset($email) && $email != "" &&
    isset($phone_no) && $phone_no != "" &&
    isset($password) && $password != "" &&
    isset($referral_code)
)
{
    $pass=$api->encrypt_decrypt("encrypt",$password);
    $checkemail=$api->checkuseremail($email);
    if($checkemail)
    {
        echo $mail_check;
    }
    else
     {
        $chephone=$api->checkphoneno($phone_no);
        if($chephone)
        {
            echo $phone_check;
        }
        else
        {
            $login_with="appuser";
            $created_at=time();
            // print_r($_FILES);
            // var_dump($_FILES['file']['name'] != "");
            if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")

            {
                $filename=$_FILES['file']['name'];
                $tmp_file=$_FILES['file']['tmp_name'];
                $imageuploadpath="../uploads/restaurant/profile_".time().".png";
                $imagename="profile_".time().".png";
                if(move_uploaded_file($tmp_file,$imageuploadpath))
                {
                    $register = $api->userregister($fullname, $email, $pass, $phone_no, $referral_code, $created_at, $login_with,$imagename);
                    //print_r($register);
                    if ($register)
                    {
                        $json[] = array("status" => "Success", "user_detail" => $register);
                        echo json_encode($json);
                    }
                    else
                    {
                        echo $fail;
                    }
                }
                else
                {
                    echo $file_upload;
                }
            }
            else{
                echo $image_check;
            }
        }
    }
}
else
{
    echo $error;
}

?>