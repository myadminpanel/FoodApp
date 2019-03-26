<?php
$jsondata = file_get_contents('https://ipapi.co/json/');
$data = json_decode($jsondata, true);
echo '<pre>';
print_r($data);
echo '</pre>';

//Timezone
echo $data['timezone'];

?>