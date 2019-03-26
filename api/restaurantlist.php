<?php
include '../controllers/apicontroller.php';
include 'error_response.php';

$api = new apicontroller();
extract($_GET);
$query = mysqli_query($conn,"select timezone from fooddelivery_adminlogin where id ='1'");
$fetch = mysqli_fetch_array($query);
$defaulttimezone = $fetch['timezone'];

$default_time = explode(" - ", $defaulttimezone);
$vals = $default_time[0];

if(isset($timezone) && $timezone != "")
{
    date_default_timezone_set($timezone);
    if
    (
        isset($location) && $location != "" &&
        isset($lat) && $lat != "" &&
        isset($lon) && $lon != "" &&
        isset($radius) && $radius != ""
    )
    {
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
            date_default_timezone_set($vals);
        $getrestaurantlist = $api->locatemerestarant($location, $lat, $lon, "location",$offset,$page_result,$radius);

        $pagecount = count($getrestaurantlist);

        $num = $pagecount / $page_result ;
        
        if ($getrestaurantlist)
        {
            $json[] = array("status" => "Success", "Restaurant_list" => $getrestaurantlist);
            echo json_encode($json);
            //echo '<pre>',print_r($json,1),'</pre>';
        }
        else
        {
            echo $not_found;
        }
    }
    elseif
    (
        isset($search) && $search != "" &&
        isset($lat) && $lat != "" &&
        isset($lon) && $lon != "" &&
        isset($radius) && $radius != ""
    )
    {
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
                date_default_timezone_set($vals);
        $searchwithname = $api->locatemerestarant($search, $lat, $lon, "nope",$offset,$page_result,$radius);
        $pagecount = count($searchwithname);
        $num = $pagecount / $page_result ;

        if ($searchwithname) {
            $json[] = array("status"=>"Success", "Restaurant_list" => $searchwithname);
            echo json_encode($json);
            //echo '<pre>',print_r($json,1),'</pre>';

        } else {

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
                date_default_timezone_set($vals);
            $searchwithcategorywise = $api->locatemerestarant($search, $lat, $lon, "category",$offset,$page_result,$radius);
            $pagecount = count($searchwithcategorywise);

            $num = $pagecount / $page_result ;
            if ($searchwithcategorywise) {
                $json[] = array("status" => "Success", "Restaurant_list" => $searchwithcategorywise);
                echo json_encode($json);
                //echo '<pre>',print_r($json,1),'</pre>';
            }
            else
            {
                echo $no_record;
            }
        }
    }
    else
    {
        echo $error;
    }
}
else
{
    echo $timezone_check;
}
?>