<?php
require_once dirname(__FILE__) . '/../includes/includes.php';

$user       =	$main->FormatString($_POST['user'],1);
$pass       =	$main->FormatString($_POST['pass'],1);
 

$error = array();


if($validator->ValidateEmail($user)){

	if($main->IsDuplicateExist('adword_user',"`ad_user_name`='".$user."' and `ad_user_password`='".md5($pass)."' and ad_delete_status=0")){
		
		$result = $main -> getRow("select ad_user_id,ad_user_name,ad_user_type,user_users from adword_user WHERE  `ad_user_name`='".$user."' and `ad_user_password`='".md5($pass)."';");
				
		$_SESSION['user_name']=$user;
		$_SESSION['user_id']=$result->ad_user_id;
		$_SESSION['user_type']=$result->ad_user_type;
		$_SESSION['user_users']=$result->user_users;
		
		$_SESSION['user_db'] = DB_DATABASE ;
		
		$_SESSION['user_usernames'] = array();
		$users = explode(",",$result->user_users);
		foreach($users as $usr){
			$result1 = $main->getRow("select ad_user_name from adword_user WHERE `ad_user_id`='".$usr."'");
			$_SESSION['user_usernames'][]=$result1->ad_user_name;
		}
		
		if($result->ad_user_type==4){ $created_user = $result->ad_user_id ;} else{ $created_user = 0 ;}
		$result2 = $main->getRow("select descriptiveName,prospect_account,customerId from adword_mcc_accounts where created_user = '".$created_user."'");
		
		$_SESSION['descriptiveName']=$result2->descriptiveName;
		$_SESSION['prospect_account']=$result2->prospect_account;
		$_SESSION['ad_mcc_id']=$result2->customerId;
                
                $_SESSION['logout_status'] = $result->ad_user_id;
                
                
		
		$_SESSION['session_time']=time();
		$error['msg'] =$result->ad_user_type;
                
                $rezult = $main -> Query("INSERT INTO login_statistics(user_id, mccid, login_time) VALUES (".$_SESSION['user_id'].",".$_SESSION['ad_mcc_id'].",NOW())") ;
                $_SESSION['logout_user'] = $main->insert_id;
                
	}
	else{
		$error['msg']="Please check your username and password";
	}
	
}
else{

	$error['msg']="Please check your username and password";
}

print json_encode($error);

?>