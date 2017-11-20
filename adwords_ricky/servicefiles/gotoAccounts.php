<?php 
require_once dirname(__FILE__) . '/../includes/includes.php';

$customer = $_POST["customer"] ;

$sql = "select descriptiveName,prospect_account,customerId from adword_mcc_accounts where customerId = '$customer'";

$res = $main->getRow($sql);


$_SESSION['descriptiveName']=$res->descriptiveName;
$_SESSION['prospect_account']=$res->prospect_account;
$_SESSION['ad_mcc_id']=$res->customerId;

if($res->prospect_account == 0 ){ 

	$_SESSION['user_db']=DB_DATABASE;
}
else {

	$_SESSION['user_db']=DB_DATABASE_PROSPECT;
}



$return['msg'] = 1;

echo json_encode($return);

?>