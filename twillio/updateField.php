<?php
include_once './CurlGetAndPostMethods.php';
$user_pushed1 = (int) $_REQUEST['Digits'];
$user_pushed = $_REQUEST['Digits'];

$file = 'abc.txt';
//echo '<pre>';

$current = file_get_contents($file);
// Append a new person to the file
$current .= "\n".implode(',', array_keys($_REQUEST))."\n";
$current .= "\n".implode(',', $_REQUEST)."\n";
// Write the contents back to the file
file_put_contents($file, $current);

$curlObj = new CurlGetAndPostMethods();
$res = $curlObj->curlGetMethod("https://crm.zoho.com/crm/private/json/CustomModule3/searchRecords?authtoken=7762219d429157454c0b6ca2c7574491&scope=crmapi&criteria=(((InvoiceId:$user_pushed1)))");
$responce =  json_decode($res);

$rows = $responce->response->result->CustomModule3->row;
foreach ($rows->FL as $value) {
    if($value->val=='CUSTOMMODULE3_ID'){
        $messageId = $value->content;
    }
}

if($messageId){
    $xmldata = '<CustomModule3>';
    $xmldata .= '<row no="1">';
    $xmldata .= '<FL val="status">pending</FL>';
    $xmldata .= '</row>';
    $xmldata .= '</CustomModule3>';
    $ch = curl_init("https://crm.zoho.com/crm/private/xml/CustomModule3/updateRecords");
    $params=['authtoken'=>'7762219d429157454c0b6ca2c7574491', 'scope'=>'crmapi', 'xmlData'=>$xmldata, 'id'=>$messageId];
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    //curl_setopt( $ch, CURLOPT_SSL_CIPHER_LIST, 'rsa_rc4_128_sha' );
    $verbose = fopen('log.txt', 'w+');
    curl_setopt($ch, CURLOPT_STDERR, $verbose);
    $res = curl_exec($ch);
    $responce =  json_decode($res);
    curl_close($ch);
}

header('Content-type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';
	echo '<Response>';
        if($user_pushed){
            $inputArray = str_split($user_pushed);
            $inputString = implode(' ', $inputArray);
            echo '<Say>You have entered '.$inputString.'</Say>';
        }else{
            echo '<Say>You have entered an invalid number.</Say>';
        }
            
	echo '</Response>';