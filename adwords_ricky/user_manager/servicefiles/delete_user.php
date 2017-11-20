<?php
require_once dirname(__FILE__) . '/../includes/includes.php';


$id = trim($_REQUEST['id']);

$return = array();
$return['error'] = 0;
$return['user'] = $_REQUEST;

if(!empty($id)){

	if($id != $_SESSION['user_id']){
	
		$fieldArray = array('ad_delete_status'=>1);
		
		if($main->update('adword_user',$fieldArray,"ad_user_id='$id'")){
		
			$return['error'] = 0;
		
		}
		else{
		
		$return['error'] = "Try Again";
		
		}
	}
	else{
	
		$return['error'] = "Delete not allowed";
	
	}
	
}
else{

	$return['error'] = "Try again ";

}

$return = array();
$return['error'] = 0;
$return['user'] = $_REQUEST;
echo json_encode($return);


?>