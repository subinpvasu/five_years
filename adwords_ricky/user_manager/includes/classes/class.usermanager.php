<?php
/********************************************************************************************************
 * @Short Description of the File	: Functions using task manager
 * @version 						: 0.1
 * @author 							: Deepa Varma<rdvarmaa@gmail.com>
 * @project 						: ADWORDS RICKY
 * @Created on 						: FEB 19 2015
 * @Modified on 					: FEB 19 2015
********************************************************************************************************/

class UserManager extends Main {

	function userDetails($id="",$type=0){
		$where = "";
		if($id<>""){$where .= "AND `ad_user_id`='$id'";} 
		if($type<>0){$where .= "AND `ad_user_type`='$type'";}
		//ad_delete_status=1  => user deleted
		$sql = "SELECT `ad_user_id`,`ad_user_name`,`ad_person_name`,`ad_user_type`,case when `ad_user_type` = 1 then 'Account Manager' when `ad_user_type` = 3 then 'Account Viewer' when `ad_user_type` =  4 then 'Prospect User' else 'Head of Search' end as user_type_name ,ad_user_report_link,user_users  FROM `adword_user` WHERE `ad_delete_status`<>1 $where ";
	
		return  $this->getResults($sql);
	
	}
	
	
	function getUserTypes(){
	
		$return = array(0=>"All Users",1=>"Account Manager",2=>"Head of Search",3=>"Account Viewer",4=>"Prospect User");
		
		return $return ;
	
	}
	

}

?>