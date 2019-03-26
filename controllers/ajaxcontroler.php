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
include "../application/db_config.php";
class ajaxcontroler
{
    function encrypt_decrypt($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = SECRET_KEY;
        $secret_iv = SECRET_IV;
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if( $action == 'encrypt' )
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
    public function categorydetail($id)
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
        else{
            return false;
        }

    }
    public function deletecategory($id){
        $db = getDB();
        $stmt = $db->prepare("delete FROM fooddelivery_category WHERE id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount(); 
		if($count){
			return true;
        }
        else{
            return false;
        }
    }
    public function deletecity($id){
        $db = getDB();
        $stmt = $db->prepare("delete FROM fooddelivery_city WHERE id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount(); 
        if($count){
            return true;
        }
        else{
            return false;
        }
    }
    public function deletesubcategory($id){
        $db = getDB();
        $stmt = $db->prepare("delete FROM fooddelivery_subcategory WHERE id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            return true;
        }
        else{
            return false;
        }
    }
    public function deletecategoryres($id){
        $db = getDB();
        $stmt = $db->prepare("delete FROM fooddelivery_category_res WHERE cat_id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
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

    public function menucategorydetail($menu_id){

        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_menu where id=:menu_id");
        $stmt->bindParam("menu_id", $menu_id,PDO::PARAM_STR);
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
    public function deletemenu($id){
        $db = getDB();
        $stmt = $db->prepare("delete FROM fooddelivery_menu WHERE id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt1 = $db->prepare("delete FROM fooddelivery_submenu WHERE menu_id=:id");
        $stmt1->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $stmt1->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function assign_order($order_id){

        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_bookorder where id=:order_id");
        $stmt->bindParam("order_id", $order_id,PDO::PARAM_STR);
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
    public function boydetail($boy_id){

        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_delivery_boy where id=:boy_id");
        $stmt->bindParam("boy_id", $boy_id,PDO::PARAM_STR);
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
    public function deleteboy($id){
        $db = getDB();
        $stmt = $db->prepare("delete FROM fooddelivery_delivery_boy WHERE id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
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
        else{
            return false;
        }
    }
    public function deleterestaurant($id){
        $db = getDB();
        $stmt = $db->prepare("delete FROM fooddelivery_restaurant WHERE id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt1 = $db->prepare("delete FROM fooddelivery_delivery_boy WHERE res_id=:id");
        $stmt1->bindParam("id", $id,PDO::PARAM_STR);
        $stmt2 = $db->prepare("delete FROM fooddelivery_res_owner WHERE res_id=:id");
        $stmt2->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $stmt1->execute();
        $stmt2->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function submenucategorydetail($submenu_id){

        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_submenu where id=:submenu_id");
        $stmt->bindParam("submenu_id", $submenu_id,PDO::PARAM_STR);
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
    public function getsubcategory($cat_id){

        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_subcategory where id=:cat_id");
        $stmt->bindParam("cat_id", $cat_id,PDO::PARAM_STR);
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
    public function getsubcategorywithcatid($cat_id){

        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_subcategory where cat_id=:cat_id");
        $stmt->bindParam("cat_id", $cat_id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            while($data=$stmt->fetch(PDO::FETCH_OBJ))
            {
                $array[]=$data;
            }
            return $array;
        }
        else{
            return false;
        }
    }
    public function deletesubmenu($id){
        $db = getDB();
        $stmt = $db->prepare("delete FROM fooddelivery_submenu WHERE id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    public function getrestaurantbyid($id)
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
    public function editactiverestaurant($id,$is_active){

        $db = getDB();
        $stmt = $db->prepare("
            UPDATE `fooddelivery_restaurant` SET 
            `is_active`=:is_active
            WHERE `id`=:id
             ");
        $stmt->bindParam("is_active", $is_active, PDO::PARAM_STR);
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
    public function deletereviewbyuser($id){
        $db=getDB();
        $stmt = $db->prepare("DELETE FROM fooddelivery_reviews where user_id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function deleteappuser($id){
        $db=getDB();
        $stmt = $db->prepare("DELETE FROM fooddelivery_users where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function adminaccessdetail($id)
    {
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_adminlogin where id=:id");
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
    public function deleteadminaccess($id){
        $db=getDB();
        $stmt = $db->prepare("DELETE FROM fooddelivery_adminlogin where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function getpersondetail($id)
    {
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_users where id=:id");
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
    public function getmoredetail($id)
    {
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_bookorder where id=:id");
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
    public function viewmenudetail($id)
    {
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_submenu where id=:id");
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
    public function deletefoodorder($id){
        $db=getDB();
        $stmt = $db->prepare("DELETE FROM fooddelivery_bookorder where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $stmts = $db->prepare("DELETE FROM fooddelivery_food_desc where order_id=:id");
        $stmts->bindParam("id", $id,PDO::PARAM_STR);
        $stmts->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function getcurrencybyid($res_id)
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
    public function deletecategorymul($res_id)
    {
        $db=getDB();
        $stmt = $db->prepare("DELETE FROM fooddelivery_category_res where res_id=:id");
        $stmt->bindParam("id", $res_id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function deletemenuandsubmenu($res_id){
        $db=getDB();
        $stmt = $db->prepare("Select * FROM fooddelivery_menu where res_id=:id");
        $stmt->bindParam("id", $res_id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            while($data=$stmt->fetch(PDO::FETCH_OBJ)){
                $this->deletesubment($data->id);
                $stmt1 = $db->prepare("DELETE FROM fooddelivery_menu where id=:id");
                $stmt1->bindParam("id", $data->id,PDO::PARAM_STR);
                $stmt1->execute();
            }
            return true;
        }
        else{
            return false;
        }
    }
    public function deletesubment($menu_id)
    {
        $db=getDB();
        $stmt = $db->prepare("DELETE FROM fooddelivery_submenu where menu_id=:id");
        $stmt->bindParam("id", $menu_id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function deleteresfoodorder($res_id){
        $db=getDB();
        $stmt = $db->prepare("DELETE FROM fooddelivery_bookorder where res_id=:id");
        $stmt->bindParam("id", $res_id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function deleteresreviews($res_id){
        $db=getDB();
        $stmt = $db->prepare("DELETE FROM fooddelivery_reviews where res_id=:id");
        $stmt->bindParam("id", $res_id,PDO::PARAM_STR);
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

    public function deletereview($id){
        $db=getDB();
        $stmt = $db->prepare("DELETE FROM fooddelivery_reviews where id=:id");
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


}
?>