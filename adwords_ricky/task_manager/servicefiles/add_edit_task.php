<?php
require_once dirname(__FILE__) . '/../includes/includes.php';


$taskId = trim($_REQUEST['taskId']);
$taskName = trim($_REQUEST['taskName']);
$taskDesc = trim($_REQUEST['taskDesc']);
$taskType = trim($_REQUEST['taskType']);
$taskTo = trim($_REQUEST['taskTo']);
//$taskId = trim($_REQUEST['taskId']);



$return = array();
$return['error'] = 0;
$return['user'] = 0;

if(!empty($taskName)){

	
	$fieldArray = array(
	
		'task_name'=>$taskName ,
		'task_details'=>$taskDesc ,
		'task_assignee'=>$_SESSION['user_id'] ,
		'task_assigned_to'=>$taskTo ,
		'task_type'=>$taskType ,	
	);
	
	if($taskId==0){
		
		$insert = $main->insert('task_manager_tasks',$fieldArray) ;
	
		if($insert){
		
			$return['user'] = $insert  ;
		
		}
		else{
		
			$return['error'] = "Please Try later.";
		}
		
	}
	else{
		
		$update = $main->update('task_manager_tasks',$fieldArray,"task_id='$taskId'") ;
		
		if($update){
			
			$return['user'] = $update;
		}
		else{
			//$return['error'] = "Please Try later.";
		}
	
	}

}
else{

	$return['error'] = "Please Give Task ";

}


echo json_encode($return);


?>