<?php
session_start();
date_default_timezone_set("Asia/Calcutta");
$servername = "localhost";
$username = "root";//omnitail
//$username = "omnitail";//omnitail
$password = "";//vbridge123-tooltails@123
//$password = "tooltails@123";//vbridge123-tooltails@123
$dbname = "omnitail_excelupload";

$refresh_token = "1/g7fa5eddYab-M39ZcMK-uBP6TOBswAVxGvhuTkdZap5IgOrJDtdun6zK6XiATCKT";
$developerToken = 'cmGKSWCRtO60ETC-qlFKMA';
$clientId = "246286771689-2gvi0te92vnh6jqq4pacm6cfbsmsi11m.apps.googleusercontent.com";
$clientSecret = "XUe21srsfUP76I-6apSMwHkO";
$redirect_uri = "http://omnitailtools.com/prospect_account/";
$userAgent = 'Omnitail';
$master_account = 6743897063;
// $oauth2Info = array(
// 		"client_id" => "246286771689-2gvi0te92vnh6jqq4pacm6cfbsmsi11m.apps.googleusercontent.com",
// 		"client_secret" => "XUe21srsfUP76I-6apSMwHkO",
// 		"refresh_token" => $refresh_token
// );


$conn = new mysqli($servername, $username, $password, $dbname);//omnitail_bidstrategy
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}