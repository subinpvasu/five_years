<?php
require_once dirname(__FILE__) . '/../includes/includes.php';


$taskId = trim($_REQUEST['id']);

$return = array();
$return['error'] = 0;
$return['user'] = 0;

if(!empty($taskId)){

	
	$fieldArray = array('task_status'=>1);
	
	if($main->update('task_manager_tasks',$fieldArray,"task_id='$taskId'")){
	
		$return['error'] = 0;
	
	}
	else{
	
	$return['error'] = "Try Again";
	
	}
	
}
else{

	$return['error'] = "Try again ";

}


echo json_encode($return);


?>