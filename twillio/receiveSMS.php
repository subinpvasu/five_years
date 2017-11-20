<?php
$file = 'abc.txt';
//echo '<pre>';

$current = file_get_contents($file);
// Append a new person to the file
$current .= "\n".implode(',', array_keys($_REQUEST))."\n";
$current .= "\n".implode(',', $_REQUEST)."\n";
// Write the contents back to the file
file_put_contents($file, $current);
//echo '</pre>';

$xmldata = '<CustomModule3>';
$xmldata .= '<row no="1">';
$xmldata .= '<FL val="Subject">Message from '.$_REQUEST['From'].'</FL>';
$xmldata .= '<FL val="From">'.$_REQUEST['From'].'</FL>';
$xmldata .= '<FL val="To">me</FL>';
$xmldata .= '<FL val="Message">'.$_REQUEST['Body'].'</FL>';
$xmldata .= '<FL val="Messages Owner">zohocrm@crm4ecommerce.com</FL>';
$xmldata .= '<FL val="Phone Number">'.$_REQUEST['From'].'</FL>';
$xmldata .= '<FL val="status">delivered</FL>';
$xmldata .= '</row>';
$xmldata .= '</CustomModule3>';

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