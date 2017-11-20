<?php
require_once dirname(__FILE__) . '/../../includes/includes.php';

try{
	

if(isset($_REQUEST['img'])) $url =  $_REQUEST['img'] ;

$name =time().'_'.substr(str_shuffle('abcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'),3,5).'.jpg' ;
$img = '../img/'.$name;


if(file_put_contents($img, file_get_contents($url))){ echo $name ; }
/* $ch = curl_init($url);
$fp = fopen($img, 'wb');
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp); */

else{ echo "No";}

}
catch (Exception $e) {
	
	

	logToFile("Get Campaigns",$customer , "ERROR",$e->getCode(),$e->getMessage());
   
    echo "Error ,".$e->getCode().",".$e->getMessage() ;
}

exit;