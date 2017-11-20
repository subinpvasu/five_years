<?php
require_once dirname(__FILE__) . '/../includes/includes.php';

$ids = json_decode($_POST['ids']);

$flag = $_POST['flag'];

 

$error = array();

foreach($ids as $id){

	$fieldArray = array(
	
		'ad_account_status' => $flag
	);
	
	$main -> Update('adword_accounts',$fieldArray,"`ad_account_adword_id`='".$id."'");

}

$error['msg']=$flag;

print json_encode($error);

?>