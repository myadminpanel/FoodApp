<?php
// Turn off error reporting
error_reporting(0);

// Report runtime errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Report all errors
error_reporting(E_ALL);

// Same as error_reporting(E_ALL);
ini_set("error_reporting", E_ALL);

// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);
?> 
<?php
include "application/db_config.php";
class dashboard
{
    public $db;
    public function __construct()
    {
        $this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if(mysqli_connect_errno())
        {
            echo "Error: Could not connect to database.";
            exit;
        }
    }
    function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }
    function random_color() {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }
    function encrypt_decrypt($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = SECRET_KEY;
        $secret_iv = SECRET_IV;
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if($action == 'encrypt')
        {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' )
        {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
    public function unlinkimage($icon,$path)
    {
        if(file_exists("$path/$icon"))
        {
            unlink("$path/$icon");
        }
        else{
            return false;
        }
    }
    public function get_session()
    {

        $uid=$_SESSION['uid'];
        $role=$_SESSION['role'];
        $check=$this->checksession($uid,$role);
        if($check){
            return $_SESSION['login'];
        }
        else{
            return false;
        }
    }
    public function checksession($uid)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_adminlogin WHERE id=:id");
        $stmt->bindParam("id", $uid,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function user_logout()
    {
        $_SESSION['login'] = FALSE;
        session_destroy();
    }
    public function getuserinfo($uid)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_adminlogin WHERE id=:id");
        $stmt->bindParam("id", $uid,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        if($count)
        {
            return $data;
        }
        else
        {
            return false;
        }
    }
    public function addnewcategory($cname,$imagename)
    {
        $db = getDB();
        $time=time();
        if($GLOBALS['demo']!="YES"){
        $stmt = $db->prepare("INSERT INTO `fooddelivery_category`(`cname`,`image`,`created_at`) VALUES (:cname,:image,:time)");
        $stmt->bindParam("cname", $cname,PDO::PARAM_STR);
        $stmt->bindParam("image", $imagename,PDO::PARAM_STR);
        $stmt->bindParam("time", $time,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{

        }
        }else{
            
        }
    }
    public function addnewcity($cname)
    {
        $db = getDB();
        $time=time();
        $stmt = $db->prepare("INSERT INTO `fooddelivery_city`(`cname`,`created_at`) VALUES (:cname,:time)");
        $stmt->bindParam("cname", $cname,PDO::PARAM_STR);
        $stmt->bindParam("time", $time,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{

        }
    }
    public function checkcategoryisnow()
    {
        $db = getDB();
        $stmt = $db->prepare("select * from `fooddelivery_category`");
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            foreach($stmt as $row)
            {
                $array[]=$row;
            }
            return $array;
        }
        else
        {
            return false;
        }
    }
    public function getcategory()
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT id,cname FROM fooddelivery_category");
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            foreach ($stmt as $val){
                $array[]=$val;
            }
            return $array;
        }
        else{
            return false;
        }
    }
    public  function  getsubcategoryname($id){
        $db=getDB();
        $stmt = $db->prepare("Select `id`,`name` from `fooddelivery_subcategory` where cat_id=:id ");
        $stmt->bindParam("id", $id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count){
            while($data = $stmt->fetch(PDO::FETCH_OBJ)){
                $arr[]=$data;
            }
            return $arr;
        }
        else{
            return false;
        }
    }
    public function addrestaurantdetail( $name, $address,$desc,$email,$phone,$website,$del_time,$open_time,$close_time,$category,$city,$location,$latitude,$longitude,$imagename,$currency,$dcharge)
    {
        $db = getDB();
        $timestamp=time();
        $stmt = $db->prepare("INSERT INTO `fooddelivery_restaurant`(`name`,`address`,`open_time`,`close_time`,`delivery_time`,
`timestamp`,`currency`,`photo`,`phone`,`lat`,`lon`,`desc`,`email`,`website`,`city`,`location`,`del_charge`)
 VALUES (:rname,:address,:open_time,:close_time,:delivery_time,:ctimestamp,
 :currency,:photo,:phone,:lat,:lon,:description,:email,:website,:city,:location,:dcharge)");
        $stmt->bindParam("rname", $name,PDO::PARAM_STR);
        $stmt->bindParam("address", $address,PDO::PARAM_STR);
        $stmt->bindParam("open_time", $open_time,PDO::PARAM_STR);
        $stmt->bindParam("close_time", $close_time,PDO::PARAM_STR);
        $stmt->bindParam("delivery_time", $del_time,PDO::PARAM_STR);
        $stmt->bindParam("ctimestamp", $timestamp,PDO::PARAM_STR);
        $stmt->bindParam("currency", $currency,PDO::PARAM_STR);
        $stmt->bindParam("photo", $imagename,PDO::PARAM_STR);
        $stmt->bindParam("phone", $phone,PDO::PARAM_STR);
        $stmt->bindParam("lat", $latitude,PDO::PARAM_STR);
        $stmt->bindParam("lon", $longitude,PDO::PARAM_STR);
        $stmt->bindParam("description", $desc,PDO::PARAM_STR);
        $stmt->bindParam("email", $email,PDO::PARAM_STR);
        $stmt->bindParam("website", $website,PDO::PARAM_STR);
        $stmt->bindParam("city", $city,PDO::PARAM_STR);
        $stmt->bindParam("location", $location,PDO::PARAM_STR);
        $stmt->bindParam("dcharge", $dcharge,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        $stmt1 = $db->prepare("SELECT * FROM fooddelivery_restaurant where email=:email && name=:name && photo=:photo ");
        $stmt1->bindParam("name", $name,PDO::PARAM_STR);
        $stmt1->bindParam("email", $email,PDO::PARAM_STR);
        $stmt1->bindParam("photo", $imagename,PDO::PARAM_STR);
        $stmt1->execute();
        $data=$stmt1->fetch(PDO::FETCH_OBJ);
        $res_id=$data->id;
        foreach($category as $rows)
        {
            $stmt2 = $db->prepare("INSERT INTO fooddelivery_category_res(res_id,cat_id) VALUES (:res_id,:cat_id)");
            $stmt2->bindParam("res_id", $res_id,PDO::PARAM_STR);
            $stmt2->bindParam("cat_id", $rows,PDO::PARAM_STR);
            $stmt2->execute();
        }
        if($count)
        {
            return true;
        }
        else
        {
            return true;
        }
        /*
        $name=mysql_real_escape_string(trim($name));
        $address=mysql_real_escape_string(trim($address));
        $desc=mysql_real_escape_string(trim($desc));
        $email=mysql_real_escape_string(trim($email));
        $location=mysql_real_escape_string(trim($location));
        $timestamp=time();
        $sql4="
         INSERT INTO `fooddelivery_restaurant` SET `name`='$name',`address`='$address',`open_time`='$open_time',
          `close_time`='$close_time',`delivery_time`='$del_time',`timestamp`='$timestamp',
          `currency`='$currency',`photo`='$imagename',`phone`='$phone',
          `lat`='$latitude',`lon`='$longitude',`desc`='$desc',`email`='$email',`website`='$website',`location`='$location' ";
        $result = mysqli_query($this->db,$sql4);

        $sql5="Select * from fooddelivery_restaurant where email='$email' && name='$name' && photo='$imagename'";
        $result12 = mysqli_query($this->db,$sql5);
        $res_detail = mysqli_fetch_array($result12);
        $res_id=$res_detail['id'];
        foreach($category as $value){
            $sql6="insert into fooddelivery_category_res SET res_id='$res_id',cat_id='$value' ";
            mysqli_query($this->db,$sql6);
        }
        return $result;
*/
    }
    public function getrestaurant($search,$check,$start,$per_page)
    {
        $db = getDB();
        if($check == "total")
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_restaurant ORDER BY id DESC");
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count)
            {
                return $count;
            }
            else
            {
                return false;
            }
        }
        elseif($check == "search")
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_restaurant where name LIKE '%".$search."%' ORDER BY id DESC LIMIT $start,$per_page");
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count){
                return $array;
            }
            else{
                return false;
            }
        }
        elseif($check == "searchtotal")
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_restaurant where name LIKE '%".$search."%' ORDER BY id DESC ");
            $stmt->execute();
            $total = $stmt->rowCount();
            if($total) {
                return $total;
            }
            else {
                return false;
            }
        }
        else
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_restaurant ORDER BY id DESC LIMIT $start,$per_page");
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count)
            {
                return $array;
            }
            else{
                return false;
            }
        }
    }
    public function getcategory_passid($res_id,$cat_id,$check)
    {
        $db=getDB();
        if($check == "getrescat")
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_category_res where res_id=:res_id && cat_id=:cat_id");
            $stmt->bindParam("res_id", $res_id,PDO::PARAM_STR);
            $stmt->bindParam("cat_id", $cat_id,PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            $data=$stmt->fetch(PDO::FETCH_OBJ);
            $array = $data;
            if($count)
            {
                return $array;
            }
            else
            {
                return false;
            }
        }
        else
        {

            $stmt = $db->prepare("SELECT * FROM fooddelivery_category_res where res_id=:res_id");
            $stmt->bindParam("res_id", $res_id,PDO::PARAM_STR);
            $stmt->execute();
            foreach($stmt as $rows1)
                //echo '<pre>'; print_r($rows1); exit();
            //print_r($rows1);
            {
                $stmt1= $db->prepare("SELECT id,name FROM fooddelivery_subcategory where id='" . $rows1['cat_id'] ."'");
                //print_r($stmt1);
                $stmt1->execute();
                $data=$stmt1->fetch(PDO::FETCH_OBJ);
                $cdata[] = array("cname" => $data->name);
            }
            //print_r($cdata);
            return @$cdata;
        }
    }
    public function getrestaurantdetail($id)
    {

        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_restaurant where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $array = $data;
        if($count)
        {
            return $array;
        }
        else
        {
            return false;
        }
       /* $sql10 = "SELECT * FROM fooddelivery_restaurant where id='$id'";
        $res3 = mysqli_query($this->db, $sql10);
        $fetchdetail=mysqli_fetch_array($res3);
        return $fetchdetail;*/
    }
     public function getresowner($id)
    {

        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_res_owner where res_id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $array = $data;
        if($count)
        {
            return $array;
        }
        else
        {
            return false;
        }
       /* $sql10 = "SELECT * FROM fooddelivery_restaurant where id='$id'";
        $res3 = mysqli_query($this->db, $sql10);
        $fetchdetail=mysqli_fetch_array($res3);
        return $fetchdetail;*/
    }
    public function deletemultiplecategory($id){

        $db=getDB();
        $stmt = $db->prepare("DELETE FROM fooddelivery_category_res where res_id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }

    }
    public function editrestaurantdetail($id,$name,$address,$desc,$email,$phone,$website,$del_time,$open_time,$close_time,$category,$city,$location,$latitude,$longitude,$imagename,$currency,$dcharge){
        
        $db = getDB();
        if($imagename != "none") {
            $stmt = $db->prepare("
            UPDATE `fooddelivery_restaurant` SET 
            `name`=:rname,
            `address`=:address,
            `delivery_time`=:delivery_time,
            `currency`=:currency,
            `lat`=:lat,
            `lon`=:lon,
            `desc`=:description,
            `email`=:email,
            `website`=:website,
            `city`=:city,
            `location`=:location,
            `open_time`=:open_time,
            `close_time`=:close_time,
            `phone`=:phone,
            `photo`=:photo,
            `del_charge`=:dcharge
            WHERE `id`=:id
             ");
            $stmt->bindParam("rname", $name, PDO::PARAM_STR);
            $stmt->bindParam("address", $address, PDO::PARAM_STR);
            $stmt->bindParam("open_time", $open_time, PDO::PARAM_STR);
            $stmt->bindParam("close_time", $close_time, PDO::PARAM_STR);
            $stmt->bindParam("delivery_time", $del_time, PDO::PARAM_STR);
            $stmt->bindParam("currency", $currency, PDO::PARAM_STR);
            $stmt->bindParam("photo", $imagename, PDO::PARAM_STR);
            $stmt->bindParam("phone", $phone, PDO::PARAM_STR);
            $stmt->bindParam("lat", $latitude, PDO::PARAM_STR);
            $stmt->bindParam("lon", $longitude, PDO::PARAM_STR);
            $stmt->bindParam("description", $desc, PDO::PARAM_STR);
            $stmt->bindParam("email", $email, PDO::PARAM_STR);
            $stmt->bindParam("website", $website, PDO::PARAM_STR);
            $stmt->bindParam("city", $city, PDO::PARAM_STR);
            $stmt->bindParam("location", $location, PDO::PARAM_STR);
            $stmt->bindParam("id", $id, PDO::PARAM_STR);
            $stmt->bindParam("dcharge", $dcharge, PDO::PARAM_STR);
            $stmt->execute();
            $count=$stmt->rowCount();
            $this->deletemultiplecategory($id);
            foreach($category as $rows)
            {
                $stmt2 = $db->prepare("INSERT INTO fooddelivery_category_res(res_id,cat_id) VALUES (:res_id,:cat_id)");
                $stmt2->bindParam("res_id", $id,PDO::PARAM_STR);
                $stmt2->bindParam("cat_id", $rows,PDO::PARAM_STR);
                $stmt2->execute();
            }
            if($count){
                return true;

            }
            else{
                return false;
            }

        }
        else{

            $stmt = $db->prepare("
            UPDATE `fooddelivery_restaurant` SET 
            `name`=:rname,
            `address`=:address,
            `delivery_time`=:delivery_time,
            `currency`=:currency,
            `lat`=:lat,
            `lon`=:lon,
            `desc`=:description,
            `email`=:email,
            `website`=:website,
            `city`=:city,
            `location`=:location,
            `open_time`=:open_time,
            `close_time`=:close_time,
            `phone`=:phone,
            `del_charge`=:dcharge
            WHERE `id`=:id
             ");
            $stmt->bindParam("rname", $name, PDO::PARAM_STR);
            $stmt->bindParam("address", $address, PDO::PARAM_STR);
            $stmt->bindParam("open_time", $open_time, PDO::PARAM_STR);
            $stmt->bindParam("close_time", $close_time, PDO::PARAM_STR);
            $stmt->bindParam("delivery_time", $del_time, PDO::PARAM_STR);
            $stmt->bindParam("currency", $currency, PDO::PARAM_STR);
            $stmt->bindParam("phone", $phone, PDO::PARAM_STR);
            $stmt->bindParam("lat", $latitude, PDO::PARAM_STR);
            $stmt->bindParam("lon", $longitude, PDO::PARAM_STR);
            $stmt->bindParam("description", $desc, PDO::PARAM_STR);
            $stmt->bindParam("email", $email, PDO::PARAM_STR);
            $stmt->bindParam("website", $website, PDO::PARAM_STR);
            $stmt->bindParam("city", $city, PDO::PARAM_STR);
            $stmt->bindParam("location", $location, PDO::PARAM_STR);
            $stmt->bindParam("id", $id, PDO::PARAM_STR);
            $stmt->bindParam("dcharge", $dcharge, PDO::PARAM_STR);
            $stmt->execute();
            $count=$stmt->rowCount();
            $this->deletemultiplecategory($id);
            foreach($category as $rows)
            {
                $stmt2 = $db->prepare("INSERT INTO fooddelivery_category_res(res_id,cat_id) VALUES (:res_id,:cat_id)");
                $stmt2->bindParam("res_id", $id,PDO::PARAM_STR);
                $stmt2->bindParam("cat_id", $rows,PDO::PARAM_STR);
                $stmt2->execute();
            }
            if($count){
                return true;

            }
            else{
                return false;
            }
        }

    }
    public function editreowndetalis($id,$pwd,$email,$phone){
         $db = getDB();
        $stmt = $db->prepare("
            UPDATE `fooddelivery_res_owner` SET 
            `password`=:pwd,
            `phone`=:phone,
            `email`=:email
           
            WHERE `id`=:id
             ");
        $stmt->bindParam("id", $id, PDO::PARAM_STR);
        $stmt->bindParam("pwd", $pwd, PDO::PARAM_STR);
        $stmt->bindParam("email", $email, PDO::PARAM_STR);
        $stmt->bindParam("phone", $phone, PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            return true;

        }
        else{
            return false;
        }
    }
    public function getcategoryall($search,$check,$start,$per_page)
    {
        $db = getDB();
        if($check == "total")
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_category ORDER BY id DESC");
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count)
            {
                return $count;
            }
            else
            {
                return false;
            }
        }
        elseif($check == "search")
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_category where cname LIKE '%".$search."%' ORDER BY id DESC LIMIT $start,$per_page");
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count){
                return $array;
            }
            else{
                return false;
            }
        }
        elseif($check == "searchtotal")
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_category where cname LIKE '%".$search."%' ORDER BY id DESC ");
            $stmt->execute();
            $total = $stmt->rowCount();
            if($total) {
                return $total;
            }
            else {
                return false;
            }
        }
        else
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_category ORDER BY id DESC LIMIT $start,$per_page");
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count)
            {
                return $array;
            }
            else{
                return false;
            }
        }
    }
    public function getcityall($search,$check,$start,$per_page)
    {
        $db = getDB();
        if($check == "total")
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_city ORDER BY id DESC");
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count)
            {
                return $count;
            }
            else
            {
                return false;
            }
        }
        elseif($check == "search")
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_city where cname LIKE '%".$search."%' ORDER BY id DESC LIMIT $start,$per_page");
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count){
                return $array;
            }
            else{
                return false;
            }
        }
        elseif($check == "searchtotal")
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_city where cname LIKE '%".$search."%' ORDER BY id DESC ");
            $stmt->execute();
            $total = $stmt->rowCount();
            if($total) {
                return $total;
            }
            else {
                return false;
            }
        }
        else
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_city ORDER BY id DESC LIMIT $start,$per_page");
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count)
            {
                return $array;
            }
            else{
                return false;
            }
        }
    }
    public function getcategorydetail($id)
    {

        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_category where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $array = $data;
        if($count)
        {
            return $array;
        }
        else
        {
            return false;
        }
    }
    public function getcitydetail($id)
    {

        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_city where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $array = $data;
        if($count)
        {
            return $array;
        }
        else
        {
            return false;
        }
    }
    public function editcategorydetail($id,$cname,$imagename){

        $db = getDB();
        if($imagename != "none") {
            $stmt = $db->prepare("
            UPDATE `fooddelivery_category` SET 
            `cname`=:cname,
            `image`=:image
            WHERE `id`=:id
             ");
            $stmt->bindParam("cname", $cname, PDO::PARAM_STR);
            $stmt->bindParam("image", $imagename, PDO::PARAM_STR);
            $stmt->bindParam("id", $id, PDO::PARAM_STR);
            $stmt->execute();
            $count=$stmt->rowCount();
            if($count){
                return true;

            }
            else{
                return false;
            }

        }
        else{

            $stmt = $db->prepare("
            UPDATE `fooddelivery_category` SET 
            `cname`=:cname
            WHERE `id`=:id
             ");
            $stmt->bindParam("cname", $cname, PDO::PARAM_STR);
            $stmt->bindParam("id", $id, PDO::PARAM_STR);
            $stmt->execute();
            $count=$stmt->rowCount();
            if($count){
                return true;

            }
            else{
                return false;
            }
        }

    }
    public function editcitydetail($id,$cname){
        $db = getDB();
       $stmt = $db->prepare("
            UPDATE `fooddelivery_city` SET 
            `cname`=:cname
            WHERE `id`=:id
             ");
            $stmt->bindParam("cname", $cname, PDO::PARAM_STR);
            $stmt->bindParam("id", $id, PDO::PARAM_STR);
            $stmt->execute();
            $count=$stmt->rowCount();
            if($count){
                return true;

            }
            else{
                return false;
            }
    }
    public function addnewmenu($id,$mname)
    {
        $db = getDB();
        $time=time();
        $stmt = $db->prepare("INSERT INTO `fooddelivery_menu`(`res_id`,`name`,`created_at`) VALUES (:res_id,:mname,:time)");
        $stmt->bindParam("res_id", $id,PDO::PARAM_STR);
        $stmt->bindParam("mname", $mname,PDO::PARAM_STR);
        $stmt->bindParam("time", $time,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{

        }
    }
    public function getallmenu($search,$check,$start,$per_page,$id)
    {
        $db = getDB();
        if($check == "total")
        {
            $stmt = $db->prepare("SELECT * FROM `fooddelivery_menu` WHERE `res_id`=:id ORDER BY id DESC");
            $stmt->bindParam("id", $id,PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count)
            {
                return $count;
            }
            else
            {
                return false;
            }
        }
        elseif($check == "search")
        {
            $stmt = $db->prepare("SELECT * FROM `fooddelivery_menu` WHERE `res_id`=:id AND `name` LIKE '%".$search."%' ORDER BY id DESC LIMIT $start,$per_page");
            $stmt->bindParam("id", $id,PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count){
                return $array;
            }
            else{
                return false;
            }
        }
        elseif($check == "searchtotal")
        {
            $stmt = $db->prepare("SELECT * FROM  `fooddelivery_menu` WHERE `res_id`=:id AND `name` LIKE '%".$search."%'");
            $stmt->bindParam("id", $id,PDO::PARAM_STR);
            $stmt->execute();
            $total = $stmt->rowCount();
            if($total) {
                return $total;
            }
            else {
                return false;
            }
        }
        else
        {
            $stmt = $db->prepare("SELECT * FROM  `fooddelivery_menu` WHERE `res_id`=:id  LIMIT $start,$per_page");
            $stmt->bindParam("id", $id,PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count)
            {
                return $array;
            }
            else{
                return false;
            }
        }
    }
    public function editmenudetail($mid,$mname){

        $db = getDB();
        $stmt = $db->prepare("
            UPDATE `fooddelivery_menu` SET 
            `name`=:mname
            WHERE `id`=:id
             ");
        $stmt->bindParam("mname", $mname, PDO::PARAM_STR);
        $stmt->bindParam("id", $mid, PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            return true;

        }
        else{
            return false;
        }
    }
    public function addnewsubmenu($id,$smname,$price,$desc)
    {
        $db = getDB();
        $time=time();
        $stmt = $db->prepare("INSERT INTO `fooddelivery_submenu`(`menu_id`,`name`,`price`,`desc`,`created_at`) VALUES (:menu_id,:smname,:price,:desc,:time)");
        $stmt->bindParam("menu_id", $id,PDO::PARAM_STR);
        $stmt->bindParam("smname", $smname,PDO::PARAM_STR);
        $stmt->bindParam("price", $price,PDO::PARAM_STR);
        $stmt->bindParam("desc", $desc,PDO::PARAM_STR);
        $stmt->bindParam("time", $time,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function addnewsubcategory($id,$cname,$created_at)
    {
        $db = getDB();
        $time=time();
        $stmt = $db->prepare("INSERT INTO `fooddelivery_subcategory`(`cat_id`,`name`,`created_at`) VALUES (:cat_id,:cname,:time)");
        $stmt->bindParam("cat_id", $id,PDO::PARAM_STR);
        $stmt->bindParam("cname", $cname,PDO::PARAM_STR);
        $stmt->bindParam("time", $created_at,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function getsubmenubyid($search,$check,$start,$per_page,$id)
    {
        $db = getDB();
        if($check == "total")
        {
            $stmt = $db->prepare("SELECT * FROM `fooddelivery_submenu` WHERE `menu_id`=:id ORDER BY id DESC");
            $stmt->bindParam("id", $id,PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count)
            {
                return $count;
            }
            else
            {
                return false;
            }
        }
        elseif($check == "search")
        {
            $stmt = $db->prepare("SELECT * FROM `fooddelivery_submenu` WHERE `menu_id`=:id AND `name` LIKE '%".$search."%' ORDER BY id DESC LIMIT $start,$per_page");
            $stmt->bindParam("id", $id,PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count){
                return $array;
            }
            else{
                return false;
            }
        }
        elseif($check == "searchtotal")
        {
            $stmt = $db->prepare("SELECT * FROM  `fooddelivery_submenu` WHERE `menu_id`=:id AND `name` LIKE '%".$search."%'");
            $stmt->bindParam("id", $id,PDO::PARAM_STR);
            $stmt->execute();
            $total = $stmt->rowCount();
            if($total) {
                return $total;
            }
            else {
                return false;
            }
        }
        else
        {
            $stmt = $db->prepare("SELECT * FROM  `fooddelivery_submenu` WHERE `menu_id`=:id  LIMIT $start,$per_page");
            $stmt->bindParam("id", $id,PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count)
            {
                return $array;
            }
            else{
                return false;
            }
        }
    }



    public function getsubcategory($search,$check,$start,$per_page,$id)
    {
        $db = getDB();
        if($check == "total")
        {
            $stmt = $db->prepare("SELECT * FROM `fooddelivery_subcategory` WHERE `cat_id`=:id ORDER BY id DESC");
            $stmt->bindParam("id", $id,PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count)
            {
                return $count;
            }
            else
            {
                return false;
            }
        }
        elseif($check == "search")
        {
            $stmt = $db->prepare("SELECT * FROM `fooddelivery_subcategory` WHERE `cat_id`=:id AND `name` LIKE '%".$search."%' ORDER BY id DESC LIMIT $start,$per_page");
            $stmt->bindParam("id", $id,PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count){
                return $array;
            }
            else{
                return false;
            }
        }
        elseif($check == "searchtotal")
        {
            $stmt = $db->prepare("SELECT * FROM  `fooddelivery_subcategory` WHERE `cat_id`=:id AND `name` LIKE '%".$search."%'");
            $stmt->bindParam("id", $id,PDO::PARAM_STR);
            $stmt->execute();
            $total = $stmt->rowCount();
            if($total) {
                return $total;
            }
            else {
                return false;
            }
        }
        else
        {
            $stmt = $db->prepare("SELECT * FROM  `fooddelivery_subcategory` WHERE `cat_id`=:id  LIMIT $start,$per_page");
            $stmt->bindParam("id", $id,PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count)
            {
                return $array;
            }
            else{
                return false;
            }
        }
    }




    public function editsubmenudetail($id,$menu_id,$smname,$price,$desc){

        $db = getDB();
        $stmt = $db->prepare("
            UPDATE `fooddelivery_submenu` SET 
            `menu_id`=:menu_id,
            `name`=:smname,
            `price`=:price,
            `desc`=:desc
            WHERE `id`=:id
             ");
        $stmt->bindParam("menu_id", $menu_id, PDO::PARAM_STR);
        $stmt->bindParam("smname", $smname, PDO::PARAM_STR);
        $stmt->bindParam("price", $price, PDO::PARAM_STR);
        $stmt->bindParam("desc", $desc, PDO::PARAM_STR);
        $stmt->bindParam("id", $id, PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            return true;

        }
        else{
            return false;
        }
    }

    public function editsubcategorydetail($subcat_id,$cname){

        $db = getDB();
        $stmt = $db->prepare("
            UPDATE `fooddelivery_subcategory` SET 
            `name`=:cname
            WHERE `id`=:subcat_id
             ");
        $stmt->bindParam("subcat_id", $subcat_id, PDO::PARAM_STR);
        $stmt->bindParam("cname", $cname, PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            return true;

        }
        else{
            return false;
        }
    }


    public function getappusers($search,$check,$start,$per_page)
    {
        $db = getDB();
        if($check == "total")
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_users ORDER BY id DESC");
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count)
            {
                return $count;
            }
            else
            {
                return false;
            }
        }
        elseif($check == "search")
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_users where fullname LIKE '%".$search."%' OR email LIKE '%".$search."%' OR phone_no LIKE '%".$search."%' ORDER BY id DESC LIMIT $start,$per_page");
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count){
                return $array;
            }
            else{
                return false;
            }
        }
        elseif($check == "searchtotal")
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_users where fullname LIKE '%".$search."%' OR email LIKE '%".$search."%' OR phone_no LIKE '%".$search."%' ORDER BY id DESC ");
            $stmt->execute();
            $total = $stmt->rowCount();
            if($total) {
                return $total;
            }
            else {
                return false;
            }
        }
        else
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_users ORDER BY id DESC LIMIT $start,$per_page");
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count)
            {
                return $array;
            }
            else{
                return false;
            }
        }
    }
    public function getuserreview($search,$check,$start,$per_page,$res_id,$yes){
        $db = getDB();
        if($yes == "yes") {
            if ($check == "total") {
                $stmt = $db->prepare("SELECT * FROM  fooddelivery_reviews  WHERE res_id=:res_id ORDER BY id DESC");
                $stmt->bindParam("res_id", $res_id, PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count) {
                    return $count;
                } else {
                    return false;
                }
            } elseif ($check == "search") {
                $stmt = $db->prepare("SELECT * FROM  fooddelivery_reviews where review_text LIKE '%" . $search . "%' AND res_id=:res_id ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->bindParam("res_id", $res_id, PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if ($count) {
                    return $array;
                } else {
                    return false;
                }
            } elseif ($check == "searchtotal") {
                $stmt = $db->prepare("SELECT * FROM fooddelivery_reviews where review_text LIKE '%" . $search . "%' AND res_id=:res_id ORDER BY id DESC ");
                $stmt->bindParam("res_id", $res_id, PDO::PARAM_STR);
                $stmt->execute();
                $total = $stmt->rowCount();
                if ($total) {
                    return $total;
                } else {
                    return false;
                }
            } else {
                $stmt = $db->prepare("SELECT * FROM fooddelivery_reviews WHERE res_id=:res_id ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->bindParam("res_id", $res_id, PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if ($count) {
                    return $array;
                } else {
                    return false;
                }
            }
        }
        else{
            if ($check == "total") {
                $stmt = $db->prepare("SELECT * FROM  fooddelivery_reviews ORDER BY id DESC");
                $stmt->bindParam("res_id", $res_id, PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count) {
                    return $count;
                } else {
                    return false;
                }
            } elseif ($check == "search") {
                $stmt = $db->prepare("SELECT * FROM  fooddelivery_reviews where review_text LIKE '%" . $search . "%'   ORDER BY id DESC LIMIT $start,$per_page");

                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if ($count) {
                    return $array;
                } else {
                    return false;
                }
            } elseif ($check == "searchtotal") {
                $stmt = $db->prepare("SELECT * FROM fooddelivery_reviews where review_text LIKE '%" . $search . "%'  ORDER BY id DESC ");

                $stmt->execute();
                $total = $stmt->rowCount();
                if ($total) {
                    return $total;
                } else {
                    return false;
                }
            } else {
                $stmt = $db->prepare("SELECT * FROM fooddelivery_reviews ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->bindParam("res_id", $res_id, PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if ($count) {
                    return $array;
                } else {
                    return false;
                }
            }
        }

    }
    public function getusername($id){
        $db=getDB();
        $stmt = $db->prepare("SELECT fullname,id,image,login_with FROM fooddelivery_users where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $array = $data;
        if($count)
        {
            return $array;
        }
        else
        {
            return false;
        }
    }
    public function restaurantname($id){
        $db=getDB();
        $stmt = $db->prepare("SELECT id,name FROM fooddelivery_restaurant where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $array = $data;
        if($count)
        {
            return $array;
        }
        else
        {
            return false;
        }
    }
    public function getallrestaurantbyfilter(){
        $db=getDB();
        $stmt = $db->prepare("SELECT name,id FROM fooddelivery_restaurant ORDER BY id DESC");
        $stmt->execute();
        $count = $stmt->rowCount();
        foreach ($stmt as $rows) {
            $array[] = $rows;
        }
        if($count){
            return $array;
        }
        else{
            return false;
        }
    }
    public function editprofile($id,$fullname,$username,$email,$imagename){
        $db=getDB();
        if($imagename == "none"){
            $stmt = $db->prepare("Update `fooddelivery_adminlogin` Set
        `username`=:username,`email`=:email,`fullname`=:fullname where id=:id");
        }
        else {
            $stmt = $db->prepare("Update `fooddelivery_adminlogin` Set
        `username`=:username,`email`=:email,`icon`=:icon,`fullname`=:fullname  where id=:id");
            $stmt->bindParam("icon", $imagename,PDO::PARAM_STR);
        }
        $stmt->bindParam("username", $username,PDO::PARAM_STR);
        $stmt->bindParam("email", $email,PDO::PARAM_STR);
        $stmt->bindParam("fullname", $fullname,PDO::PARAM_STR);
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function updatepassword($id,$newpass){

        $db = getDB();
        $stmt = $db->prepare("
            UPDATE `fooddelivery_adminlogin` SET 
            `password`=:password
            WHERE `id`=:id
             ");
        $stmt->bindParam("password", $newpass, PDO::PARAM_STR);
        $stmt->bindParam("id", $id, PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            return true;

        }
        else{
            return false;
        }
    }
    public function countnewusers(){
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_users where notify=1");
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return $count;
        }
        else
        {
            return false;
        }
    }
    public function countnewreviews()
    {
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_reviews where notify=1 ");
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return $count;
        }
        else
        {
            return false;
        }
    }
    public function clearnotifyreview(){

        $db=getDB();
        $stmt = $db->prepare("UPDATE fooddelivery_reviews SET notify=0  where notify=1 ");
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function clearuserscount(){
        $db=getDB();
        $stmt = $db->prepare("UPDATE fooddelivery_users SET notify=0  where notify=1 ");
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function clearordernotify(){
        $db=getDB();
        $stmt = $db->prepare("UPDATE fooddelivery_bookorder SET notify=0  where notify=1 ");
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function getadminaccess($search,$check,$start,$per_page){
        $db = getDB();
        if($check == "total")
        {
            $stmt = $db->prepare("SELECT * FROM  fooddelivery_adminlogin ORDER BY id DESC");
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count)
            {
                return $count;
            }
            else
            {
                return false;
            }
        }
        elseif($check == "search")
        {
            $stmt = $db->prepare("SELECT * FROM  fooddelivery_adminlogin  ORDER BY id DESC LIMIT $start,$per_page");
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count){
                return $array;
            }
            else{
                return false;
            }
        }
        elseif($check == "searchtotal")
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_adminlogin ORDER BY id DESC ");
            $stmt->execute();
            $total = $stmt->rowCount();
            if($total) {
                return $total;
            }
            else {
                return false;
            }
        }
        else
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_adminlogin ORDER BY id DESC LIMIT $start,$per_page");
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count)
            {
                return $array;
            }
            else{
                return false;
            }
        }

    }
    public function checkadminaccess($email,$username)
    {
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_adminlogin where username=:username OR email=:email");
        $stmt->bindParam("username", $username,PDO::PARAM_STR);
        $stmt->bindParam("email", $email,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return $count;
        }
        else
        {
            return false;
        }
    }
    public function addnewadminaccess($username,$fullname,$password,$email,$imagename)
    {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO `fooddelivery_adminlogin`(`username`,`fullname`,`password`,`email`,`icon`) VALUES (:username,:fullname,:password,:email,:image)");
        $stmt->bindParam("username", $username,PDO::PARAM_STR);
        $stmt->bindParam("fullname", $fullname,PDO::PARAM_STR);
        $stmt->bindParam("password", $password,PDO::PARAM_STR);
        $stmt->bindParam("email", $email,PDO::PARAM_STR);
        $stmt->bindParam("image", $imagename,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{

        }
    }
    public function checkresowneraccess($email,$name)
    {
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_restaurant where name=:name OR email=:email");
        $stmt->bindParam("name", $name,PDO::PARAM_STR);
        $stmt->bindParam("email", $email,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return $count;
        }
        else
        {
            return false;
        }
    }
    public function addnewresowneraccess($name,$password,$time,$mobile,$email)
    {
        $db = getDB();
        $time=time();
        $stmt = $db->prepare("INSERT INTO `fooddelivery_res_owner`(`username`,`password`,`timestamp`,`phone`,`email`,`role`) VALUES (:name,:password,:time,:mobile,:email,'2')");
        $stmt->bindParam("name", $name,PDO::PARAM_STR);
        $stmt->bindParam("password", $password,PDO::PARAM_STR);
        $stmt->bindParam("time", $time,PDO::PARAM_STR);
        $stmt->bindParam("mobile", $mobile,PDO::PARAM_STR);
        $stmt->bindParam("email", $email,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{

        }
    }
    public function getratting($id){
        $db = getDB();
        $stmt = $db->prepare("SELECT id, AVG(ratting) AS ratavg FROM fooddelivery_reviews WHERE res_id=:id");
        $stmt->bindParam("id", $id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count)
        {
            while($data = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $avg = $data['ratavg'];
                $vg1 = (string)round($avg,1);
            }
            return $vg1;
        }
        else
        {
            return false;
        }
    }
    public function res_openandclose($res_id,$time_open,$time_close)
    {
        $db=getDB();
        $time=date('H:i:s');

        $stmt = $db->prepare("SELECT * FROM  fooddelivery_restaurant  WHERE id=:res_id AND '".$time."' >= :open_time and '".$time."' <= :close_time ");
        $stmt->bindParam("res_id", $res_id, PDO::PARAM_STR);
        $stmt->bindParam("open_time", $time_open, PDO::PARAM_STR);
        $stmt->bindParam("close_time", $time_close, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return "open";
        }
        else
        {
            return "closed";
        }
    }
    public function totalresreview($res_id)
    {
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM  fooddelivery_reviews  WHERE res_id=:res_id");
        $stmt->bindParam("res_id", $res_id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return $count;
        }
        else
        {
            return false;
        }
    }
    public function getfoodorder($search,$check,$start,$per_page)
    {
        $db = getDB();
        if($check == "total")
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_bookorder ORDER BY id DESC");
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count)
            {
                return $count;
            }
            else
            {
                return false;
            }
        }
        elseif($check == "search")
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_bookorder WHERE res_id=:search ORDER BY id DESC LIMIT $start,$per_page");
            $stmt->bindParam("search", $search, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count){
                return $array;
            }
            else{
                return false;
            }
        }
        elseif($check == "searchtotal")
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_bookorder WHERE res_id=:search ORDER BY id DESC ");
            $stmt->bindParam("search", $search, PDO::PARAM_STR);
            $stmt->execute();
            $total = $stmt->rowCount();
            if($total)
            {
                return $total;
            }
            else {
                return false;
            }
        }
        else
        {
            $stmt = $db->prepare("SELECT * FROM fooddelivery_bookorder ORDER BY id DESC LIMIT $start,$per_page");
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows)
            {
                $array[] = $rows;
            }
            if($count)
            {
                return $array;
            }
            else{
                return false;
            }
        }
    }
    public function countnotifyorder(){
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_bookorder where notify=1 ");
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return $count;
        }
        else
        {
            return false;
        }
    }
    public function getresid($id)
    {
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_menu where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $array = $data;
        if($count)
        {
            return $array;
        }
        else{
            return false;
        }
    }
    public function getcurrencybyid($id)
    {
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_restaurant where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $array = $data;
        if($count)
        {
            return $array;
        }
        else{
            return false;
        }
    }
    public function getresname($res_id){
        $db=getDB();
        $stmt = $db->prepare("SELECT `name` FROM fooddelivery_restaurant where id=:id");
        $stmt->bindParam("id", $res_id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        if($count)
        {
            return $data->name;
        }
        else{
            return false;
        }
    }
}
?>