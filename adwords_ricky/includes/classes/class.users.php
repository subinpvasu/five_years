<?php
/********************************************************************************************************
 * @Short Description of the File	: Functions using for reports
 * @version 						: 0.1
 * @author 							: Deepa Varma<rdvarmaa@gmail.com>
 * @project 						: ADWORDS RICKY
 * @Created on 						: FEB 19 2015
 * @Modified on 					: FEB 19 2015
********************************************************************************************************/

class Users extends Main {

	function  getUserDetails($id=0,$type=0){
	
		$where = "";
		
		if($id <>0) {$where .= "and ad_user_id='$id'"; }
		if($type <>0) {$where .= "and ad_user_type='$type'"; }
		
		$sql = "select ad_user_id,ad_user_name,ad_user_type from adword_user where ad_delete_status=0 $where order by ad_user_name asc";
		
		return $this -> getResults($sql);
	
	}

}



?>