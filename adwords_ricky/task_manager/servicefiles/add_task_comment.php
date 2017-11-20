<?php
require_once dirname(__FILE__) . '/../includes/includes.php';


$taskComment = trim($_REQUEST['taskComment']);
$taskId =  trim($_REQUEST['id']);


$return = array();
$return['error'] = 0;
$return['user'] = 0;

if(!empty($taskComment)){

	
	$fieldArray = array(
	
		'task_comment'=>$taskComment ,
		'task_id'=>$taskId	,
		'task_comment_by'=>$_SESSION['user_id']
	);
	
	
		
	$insert = $main->insert('task_manager_comments',$fieldArray) ;

	if($insert){
	
		$return['user'] = $insert  ;
	
	}
	else{
	
		$return['error'] = "Please Try later.";
	}
	
	
}
else{

	$return['error'] = "Please Give Comment ";

}


echo json_encode($return);


?>