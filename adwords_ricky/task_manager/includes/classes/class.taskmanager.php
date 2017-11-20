<?php
/********************************************************************************************************
 * @Short Description of the File	: Functions using task manager
 * @version 						: 0.1
 * @author 							: Deepa Varma<rdvarmaa@gmail.com>
 * @project 						: ADWORDS RICKY
 * @Created on 						: FEB 19 2015
 * @Modified on 					: FEB 19 2015
********************************************************************************************************/

class TaskManager extends Main {

	function taskDetails($id="",$type=0){
		$where = "";
		if($id<>""){$where .= "AND `task_id`='$id'";}
		if($type<>0){$where .= "AND `task_type`='$type'";}
		//task_status=1  => task deleted
		$sql = "SELECT `task_id`,`task_name`,`task_details`,`task_assignee`,`task_assigned_to`,`task_type`,case when `task_type` = 1 then 'Monthly Task' else 'Single Time Task' end as task_type_name  FROM `task_manager_tasks` WHERE `task_status`<>1 $where ";
	
		return  $this->getResults($sql);
	
	}
	
	
	function gettaskTypes(){
	
		$return = array(0=>"All Task",1=>"Monthly Task",2=>"Single Time Task");
		
		return $return ;
	
	}
	function getTaskComments($id){
	
		$sql = "SELECT `task_comment_id`,`task_comment`,`task_comment_by`,`task_comment_to`,`task_comment_on`,task_id ,b.ad_user_name,a.created_on
		FROM `task_manager_comments` a left join adword_user b on a.task_comment_by =  b.ad_user_id
		WHERE  task_id='$id' and task_comment_status = 0 order by created_on asc ; ";
		
		return  $this->getResults($sql);
	}

}

?>