<?php

require_once dirname(__FILE__) . '/../includes/includes.php';



$ids = json_decode($_POST['ids']);



$flag = $_POST['flag'];
if($flag==1) $flag = 3 ;



$error = array();



foreach($ids as $id){



	$fieldArray = array(	

		'prospect_account' => $flag

	);

	

	$main -> Update('adword_mcc_accounts',$fieldArray,"`customerId`='".$id."'");



}



$error['msg']=$flag;



print json_encode($error);



?>