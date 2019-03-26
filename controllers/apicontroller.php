<?php
include "../application/db_config.php";
class apicontroller
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
    public function userregister($fullname,$email,$password,$phone_no,$referral_code,$created_at,$login_with,$imagename)
    {
        $db=getDB();
        $notify=1;
            
        if ($login_with == 'Facebook') {
            $img = "https://graph.facebook.com/$imagename/picture?type=large";
        } elseif ($login_with == 'Google') {
            $img = "https://$imagename";            
        } else {
            $img = $imagename;
        }

        $stmt = $db->prepare("insert into fooddelivery_users 
                  (`fullname`, `phone_no`, `email`, `password`, `referal_code`, `created_at`, `notify`, `login_with`,`image`)
                   values (:fullname,:phone_no,:email,:password,:ref_code,:created_at,:notify,:login_with,:image ) ");
        $stmt->bindParam("fullname", $fullname, PDO::PARAM_STR);
        $stmt->bindParam("email", $email, PDO::PARAM_STR);
        $stmt->bindParam("password", $password, PDO::PARAM_STR);
        $stmt->bindParam("created_at", $created_at, PDO::PARAM_STR);
        $stmt->bindParam("phone_no", $phone_no, PDO::PARAM_STR);
        $stmt->bindParam("ref_code", $referral_code, PDO::PARAM_STR);
        $stmt->bindParam("login_with", $login_with, PDO::PARAM_STR);
        $stmt->bindParam("notify", $notify, PDO::PARAM_STR);
        $stmt->bindParam("image", $img, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count)
        {
            $stmt1 = $db->prepare("Select * from fooddelivery_users where email=:email");
            $stmt1->bindParam("email", $email, PDO::PARAM_STR);
            $stmt1->execute();
            $data = $stmt1->fetch(PDO::FETCH_OBJ);
            if($data->login_with == "appuser")
            {
                $image=$data->image;
            }
            else
            {
                $image=$data->image;
            }
            $arr=array
            (
                "id"=>$data->id,
                "fullname"=>$data->fullname,
                "email"=>$data->email,
                "phone_no"=>$data->phone_no,
                "referal_code"=>$data->referal_code,
                "image"=>$image,
                "created_at"=>$data->created_at,
                "login_with"=>$data->login_with
            );
            return $arr;
        }
        else
        {
            return false;
        }
    }
    public function checkuseremail($email)
    {
        $db=getDB();
        $stmt = $db->prepare("Select id from fooddelivery_users where email=:email");
        $stmt->bindParam("email", $email, PDO::PARAM_STR);
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
    public function checkphoneno($phone)
    {
        $db=getDB();
        $stmt = $db->prepare("Select id from fooddelivery_users where phone_no=:phone");
        $stmt->bindParam("phone", $phone, PDO::PARAM_STR);
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
    public function userlogin($uname,$pass,$email)
    {
        if($uname == "non" && $pass == "non")
        {
            $db = getDB();
            $stmt = $db->prepare("Select * from fooddelivery_users where email=:email OR phone_no=:email");
            $stmt->bindParam("email", $email, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            $data = $stmt->fetch(PDO::FETCH_OBJ);
            if ($count)
            {
                if($data->login_with == "appuser")
                {
                    $image=$data->image;
                }
                else
                {
                    $image=$data->image;
                }
                $arr=
                array
                (
                    "id"=>$data->id,
                    "fullname"=>$data->fullname,
                    "email"=>$data->email,
                    "phone_no"=>$data->phone_no,
                    "referal_code"=>$data->referal_code,
                    "image"=>$image,
                    "created_at"=>$data->created_at,
                    "login_with"=>$data->login_with
                );
                return $arr;
            }
            else
            {
                return false;
            }
        }
        else
        {
            $db = getDB();
            $stmt = $db->prepare("Select * from fooddelivery_users where email=:email AND password=:password");
            $stmt->bindParam("email",$uname, PDO::PARAM_STR);
            $stmt->bindParam("password",$pass, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            $data = $stmt->fetch(PDO::FETCH_OBJ);
            if($count)
            {
                if($data->login_with == "appuser")
                {
                    $image=$data->image;
                }
                else
                {
                    $image=$data->image;
                }
                $arr=array
                (
                    "id"=>$data->id,
                    "fullname"=>$data->fullname,
                    "email"=>$data->email,
                    "phone_no"=>$data->phone_no,
                    "referal_code"=>$data->referal_code,
                    "image"=>$image,
                    "created_at"=>$data->created_at,
                    "login_with"=>$data->login_with
                );
                return $arr;
            }
            else
            {
                return false;
            }
        }
    }
    public function getratting($id)
    {
        $db = getDB();
        //$stmt = $db->prepare("SELECT max (ratting) from (select id, avg(ratting) AS ratavg from fooddelivery_reviews WHERE res_id=:id");
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
    public function locatemerestarant($location,$lat,$lon,$when,$offset,$page_result,$radius)
    {
        $db=getDB();
        if($when == "location")
        {
           $stmt = $db->prepare("SELECT *,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( `lat` ) ) *
                COS( RADIANS( `lon` ) - RADIANS( $lon ) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( `lat` ) ) ) ) AS distance
                from fooddelivery_restaurant where is_active=0 && city RLIKE '[[:<:]]".$location."[[:>:]]' HAVING distance <= {$radius}
ORDER BY distance ASC limit $offset, $page_result");
        }
        elseif($when == "category")
        {
               $stmt = $db->prepare("SELECT *,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( `lat` ) ) *
                COS( RADIANS( `lon` ) - RADIANS( $lon ) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( `lat` ) ) ) ) AS distance
                from fooddelivery_restaurant WHERE is_active=0 HAVING distance <= {$radius}
ORDER BY distance ASC limit $offset, $page_result");
        }
        else
        {
           $stmt = $db->prepare("SELECT *,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( `lat` ) ) *
                COS( RADIANS( `lon` ) - RADIANS( $lon ) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( `lat` ) ) ) ) AS distance
                from fooddelivery_restaurant WHERE `is_active`=0  AND  `name` LIKE '%".$location."%' HAVING distance <= {$radius}
ORDER BY distance ASC limit $offset, $page_result");
        }

        $stmt->execute();

        $count = $stmt->rowCount();
        if($count)
        {
            while($data = $stmt->fetch(PDO::FETCH_OBJ))
            {
                if($when == "category")
                {
                    $categoryid = $this->getcategoryid($location);
                    $is_display=$this->is_displayornot($categoryid,$data->id);
                    $radiusdata = $data->distance * 1.609344;
                    $km = round($radiusdata,2);
                    $currency = $data->currency;
                    $dollar = explode('-', $currency);
                    $val = $dollar[1];

                    if($is_display)
                    {
                        $ratting = $this->getratting($data->id);
                        $category = $this->getrestaurantcategorybyid($data->id);
                        $openclose = $this->res_openandclose($data->id, $data->open_time, $data->close_time);
                        $array[] = array
                        (
                            "id"=>$data->id,
                            "name" => $data->name,
                            "delivery_time" => $data->delivery_time,
                            "currency" => "$val",
                            "image" => $data->photo,
                            "lat" => $data->lat,
                            "lon" => $data->lon,
                            "Category" => $category,
                            "ratting" => $ratting,
                            "res_status" => $openclose,
                            "distance"=>$data->distance,
                            "distancekm" => $km,
                            "open_time"=>$data->open_time,
                            "close_time"=>$data->close_time
                        );
                    }
                }
                else
                {
                    $ratting = $this->getratting($data->id);
                    $category = $this->getrestaurantcategorybyid($data->id);
                    $radiusdata = $data->distance * 1.609344;
                    $km = round($radiusdata,2);
                    $currency = $data->currency;
                    $dollar = explode('-', $currency);
                    $val = $dollar[1];

                    $openclose = $this->res_openandclose($data->id, $data->open_time, $data->close_time);
                    $array[] = array(
                        "id"=>$data->id,
                        "name" => $data->name,
                        "delivery_time" => $data->delivery_time,
                        "currency" => "$val",
                        "image" => $data->photo,
                        "lat" => $data->lat,
                        "lon" => $data->lon,
                        "Category" => $category,
                        "ratting" => $ratting,
                        "res_status" => $openclose,
                        "distance"=>$data->distance,
                        "distancekm" => "$km",
                        "open_time"=>$data->open_time,
                        "close_time"=>$data->close_time
                    );
                }

            }
            // if ($_GET['short_by'] == 'ratting') {
            //     usort($array, function ($a, $b) {
            //         return $a['ratting'] < $b['ratting'];
            //     });
            // }
            if(isset($array))
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
            return false;
        }
    }


    public function getrattingnew($id)
    {
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
    public function locatemerestarantrat($location,$lat,$lon,$when,$radius)
    {
        $db=getDB();
        if($when == "location")
        {
           $stmt = $db->prepare("SELECT *,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( `lat` ) ) *
                COS( RADIANS( `lon` ) - RADIANS( $lon ) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( `lat` ) ) ) ) AS distance
                from fooddelivery_restaurant where is_active=0 && city RLIKE '[[:<:]]".$location."[[:>:]]' HAVING distance <= {$radius}");
        }

        $stmt->execute();

        $count = $stmt->rowCount();
        if($count)
        {
            while($data = $stmt->fetch(PDO::FETCH_OBJ))
            {
                
                $ratting = $this->getrattingnew($data->id);
                $category = $this->getrestaurantcategorybyid($data->id);
                $radiusdata = $data->distance * 1.609344;
                $km = round($radiusdata,2);
                $openclose = $this->res_openandclose($data->id, $data->open_time, $data->close_time);

                $array[] = array(
                    "id"=>$data->id,
                    "name" => $data->name,
                    "delivery_time" => $data->delivery_time,
                    "currency" => $data->currency,
                    "image" => $data->photo,
                    "lat" => $data->lat,
                    "lon" => $data->lon,
                    "Category" => $category,
                    "ratting" => $ratting,
                    "res_status" => $openclose,
                    "distance"=>$data->distance,
                    "distancekm" => "$km",
                    "open_time"=>$data->open_time,
                    "close_time"=>$data->close_time
                );
            }

            if ($_GET['short_by'] == 'ratting') {
                usort($array, function ($a, $b) {
                    return $a['ratting'] < $b['ratting'];
                });
            }

            $offset=0;
            $page_result=$_GET['noofrecords'];

            if($_GET['pageno'])
                {
                    $page_value = $_GET['pageno'];
                    if($page_value > 1)
                {
                    $offset = ($page_value - 1) * $page_result;
                }
            }

            $sortby_rate = array_slice($array, $offset, $page_result);

            $pagecount = count($sql);

            $num = $pagecount / $page_result ;


            if(isset($sortby_rate))
            {
                return $sortby_rate;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public  function  getsubcategoryname($id){
        $db=getDB();
        $stmt = $db->prepare("Select `id`,`name` from `fooddelivery_subcategory` where cat_id=:id ");
        $stmt->bindParam("id", $id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            while($data = $stmt->fetch(PDO::FETCH_OBJ))
            {
                $arr[]=$data;
            }
            return $arr;
        }
        else{
            return false;
        }
    }
    public function restaurantcategory()
    {
        $db=getDB();
        $stmt = $db->prepare("Select * from fooddelivery_category ORDER BY id DESC");
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            while($data = $stmt->fetch(PDO::FETCH_OBJ))
            {
                unset($sub);
                unset($subcategory);
                $sub=$this->getsubcategoryname($data->id);
                if($sub)
                {
                    $subcategory=$sub;
                }
                else
                {
                    $subcategory[]=array("id"=>"Not Found");
                }
                $array[]=array("id"=>$data->id,"name"=>$data->cname,"subcategory"=>$subcategory);
            }
            return $array;
        }
        else
        {
            return false;
        }
    }
    public function restaurantmenu($res_id)
    {
        $db=getDB();
        $stmt = $db->prepare("Select id,name,created_at from fooddelivery_menu WHERE res_id=:res_id ORDER BY id DESC");
        $stmt->bindParam("res_id", $res_id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            while($data = $stmt->fetch(PDO::FETCH_OBJ))
            {
                $array[]=$data;
            }
            return $array;
        }
        else
        {
            return false;
        }
    }
    public function restaurantsubmenu($menucategory_id)
    {
        $db=getDB();
        $stmt = $db->prepare("Select `id`,`name`,`price`,`desc`,`created_at` from `fooddelivery_submenu` WHERE `menu_id`=:menucat_id ORDER BY `id` DESC");
        $stmt->bindParam("menucat_id", $menucategory_id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            while($data = $stmt->fetch(PDO::FETCH_OBJ))
            {
                $array[]=$data;
            }
            return $array;
        }
        else
        {
            return false;
        }
    }
    public function getrestaurantcategorybyid($id)
    {
        $db=getDB();
        $stmt = $db->prepare("Select * from fooddelivery_category_res where res_id=:res_id ");
        $stmt->bindParam("res_id", $id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            while($data = $stmt->fetch(PDO::FETCH_OBJ))
            {
                $category=$this->getcategoryname($data->cat_id);
                $array[]=$category;
            }
            return $array;
        }
        else
        {
            return false;
        }
    }
    public function getcategoryname($cat_id)
    {
        $db=getDB();
        $stmt = $db->prepare("Select `name` from `fooddelivery_subcategory` where id=:cat_id");
        $stmt->bindParam("cat_id", $cat_id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        if($count)
        {
            return $data->name;
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
    public function getcategoryid($search)
    {
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_subcategory WHERE name RLIKE '[[:<:]]".$search."[[:>:]]' ");
        $stmt->execute();
        $count = $stmt->rowCount();
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        if($count)
        {
            return $data->id;
        }
        else
        {
            return false;
        }
    }
    public function is_displayornot($categoryid,$res_id)
    {
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM fooddelivery_category_res WHERE res_id=:res_id AND cat_id=:cat_id ");
        $stmt->bindParam("cat_id", $categoryid, PDO::PARAM_STR);
        $stmt->bindParam("res_id", $res_id, PDO::PARAM_STR);
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
    public function publishreview($res_id,$user_id,$review_text,$ratting,$created_at)
    {
        $db=getDB();
        $notify=1;
        $stmt = $db->prepare("INSERT INTO fooddelivery_reviews (`user_id`, `res_id`, `review_text`, `ratting`, `created_at`,`notify`) VALUES (:user_id,:res_id,:review_text,:ratting,:created_at,:notify)");
        $stmt->bindParam("res_id", $res_id, PDO::PARAM_STR);
        $stmt->bindParam("user_id", $user_id, PDO::PARAM_STR);
        $stmt->bindParam("review_text", $review_text, PDO::PARAM_STR);
        $stmt->bindParam("ratting", $ratting, PDO::PARAM_STR);
        $stmt->bindParam("created_at", $created_at, PDO::PARAM_STR);
        $stmt->bindParam("notify", $notify, PDO::PARAM_STR);
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
    public function getreviews($res_id)
    {
        // Report all errors except E_NOTICE
        error_reporting(E_ALL & ~E_NOTICE);
        $db=getDB();
        $stmt = $db->prepare("Select * from fooddelivery_reviews as fr inner join fooddelivery_users as fu on fu.id=fr.user_id where fr.res_id='".$_REQUEST['res_id']."'  ORDER BY fr.id DESC");
        $stmt->bindParam("res_id", $res_id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            while($data = $stmt->fetch(PDO::FETCH_OBJ))
            {
                $username=$this->getusername($data->user_id);
                //$username=$this->getusername($data->res_id);
                $array[]=array("id"=>$data->id,"username"=>$username->fullname,"image"=>$username->image,"review_text"=>$data->review_text,"ratting"=>$data->ratting,"created_at"=>$data->created_at,"login_with"=>$data->login_with);
            }
            return $array;
        }
        else
        {
            return false;
        }
    }
    public function getusername($user_id)
    {
        $db=getDB();
        $stmt = $db->prepare("SELECT fullname,image FROM fooddelivery_users WHERE id=:user_id ");
        $stmt->bindParam("user_id", $user_id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        if($count)
        {
            return $data;
        }
        else
        {
            return false;
        }
    }
    public function getrestaurantfulldetail($res_id,$lat,$lon)
    {
        $db=getDB();
        $stmt = $db->prepare("SELECT *,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( `lat` ) ) *
                COS( RADIANS( `lon` ) - RADIANS( $lon ) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( `lat` ) ) ) ) AS distance
                from fooddelivery_restaurant WHERE is_active=0 AND id=:res_id  ORDER BY distance ASC ");
        $stmt->bindParam("res_id", $res_id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        if($count)
        {
            $ratting=$this->getratting($data->id);
            $openclose=$this->res_openandclose($data->id,$data->open_time,$data->close_time);
            $category = $this->getrestaurantcategorybyid($data->id);
            $currency = $data->currency;
            $dollar = explode('-', $currency);
            $val = $dollar[1];
            $array=array(
                "id"=>$data->id,
                "name"=>$data->name,
                "address"=>$data->address,
                "time"=>$data->open_time." To ".$data->close_time,
                "delivery_time"=>$data->delivery_time,
                "currency"=>"$val",
                "photo"=>$data->photo,
                "phone"=>$data->phone,
                "lat"=>$data->lat,
                "lon"=>$data->lon,
                "desc"=>$data->desc,
                "email"=>$data->email,
                //"location"=>$data->location,
                "ratting"=>$ratting,
                "res_status"=>$openclose,
                "delivery_charg"=>$data->del_charge,
                "distance"=>$data->distance,
                "Category"=>$category
            );
            return $array;
        }
        else
        {
            return false;
        }
    }
    public function bookorder($user_id,$res_id,$address,$lat,$long,$food_desc,$notes,$total_price,$created_at,$notify)
    {
        $db=getDB();
        $notify=1;
        $stmt = $db->prepare("INSERT INTO fooddelivery_bookorder 
                              (`user_id`, `res_id`, `address`, `lat`, `long`, `food_desc`, `notes`, `total_price`, `created_at`, `notify`)
                              VALUES (:user_id,:res_id,:address,:lat,:long,:food_desc,:notes,:total_price,:created_at,:notify)
                              ");
        $stmt->bindParam("user_id", $user_id, PDO::PARAM_STR);
        $stmt->bindParam("res_id", $res_id, PDO::PARAM_STR);
        $stmt->bindParam("address", $address, PDO::PARAM_STR);
        $stmt->bindParam("lat", $lat, PDO::PARAM_STR);
        $stmt->bindParam("long", $long, PDO::PARAM_STR);
        $stmt->bindParam("food_desc", $food_desc, PDO::PARAM_STR);
        $stmt->bindParam("notes", $notes, PDO::PARAM_STR);
        $stmt->bindParam("total_price", $total_price, PDO::PARAM_STR);
        $stmt->bindParam("created_at", $created_at, PDO::PARAM_STR);
        $stmt->bindParam("notify", $notify, PDO::PARAM_STR);
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