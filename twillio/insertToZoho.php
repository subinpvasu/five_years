<?php
$xmldata = '<CustomModule3>';
$xmldata .= '<row no="1">';
$xmldata .= '<FL val="Subject">Message from bob marly</FL>';
$xmldata .= '<FL val="From">bob</FL>';
$xmldata .= '<FL val="To">me</FL>';
$xmldata .= '<FL val="Message">message content received</FL>';
$xmldata .= '<FL val="Messages Owner">zohocrm@crm4ecommerce.com</FL>';
$xmldata .= '<FL val="Phone Number">123456789</FL>';
$xmldata .= '<FL val="status">delivered</FL>';
$xmldata .= '</row>';
$xmldata .= '</CustomModule3>';

//$xmldata = '<CustomModule3>';
//$xmldata .= '<row no="1">';
//$xmldata .= '<FL val="Subject">Message from '.$_REQUEST['From'].'</FL>';
//$xmldata .= '<FL val="From">'.$_REQUEST['From'].'</FL>';
//$xmldata .= '<FL val="To">me</FL>';
//$xmldata .= '<FL val="Message">'.$_REQUEST['Body'].'</FL>';
//$xmldata .= '<FL val="Messages Owner">zohocrm@crm4ecommerce.com</FL>';
//$xmldata .= '<FL val="Phone Number">'.$_REQUEST['From'].'</FL>';
//$xmldata .= '<FL val="status">delivered</FL>';
//$xmldata .= '</row>';
//$xmldata .= '</CustomModule3>';

$ch = curl_init("https://crm.zoho.com/crm/private/xml/CustomModule3/insertRecords");
$params=['authtoken'=>'7762219d429157454c0b6ca2c7574491', 'scope'=>'crmapi', 'xmlData'=>$xmldata];
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

//https://crm.zoho.com/crm/private/json/CustomModule3/searchRecords?authtoken=7762219d429157454c0b6ca2c7574491&scope=crmapi&criteria=(((CUSTOMMODULE3_ID:1356962000000224001)))