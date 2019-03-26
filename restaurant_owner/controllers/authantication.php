<?php 
include "application/db_config.php";
class Admin
{
    public function check_login($username, $password)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT id,username, password,role
        FROM fooddelivery_adminlogin 
        WHERE username=:username AND password=:password
        UNION 
        SELECT id,username, password,role
        FROM fooddelivery_res_owner 
        WHERE username=:username AND password=:password");
        //$stmt = $db->prepare("SELECT fd.id,fr.id FROM fooddelivery_adminlogin fd  WHERE  username=:username AND  password=:password");
        $stmt->bindParam("username", $username,PDO::PARAM_STR);
        $stmt->bindParam("password", $password,PDO::PARAM_STR);
        $stmt->bindParam("role", $role,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        if($count)
        {
            $_SESSION['login'] = true;
            $_SESSION['uid']=$data->id;
            $_SESSION['role']=$data->role;
            //print_r($_SESSION); exit();
            return true;
        }
        else
        {
            return false;
        }
    }
    public function get_session()
    {
        return $_SESSION['login'];
    }
    public function user_logout()
    {
        $_SESSION['login'] = FALSE;
        session_destroy();
    }
}
?>