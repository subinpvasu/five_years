<?php

require_once dirname(__FILE__) . '/includes/includes.php';
$result = $main -> getRow("select * from adword_user WHERE  `ad_user_name`='ricky@pushgroup.co.uk'");
				
$_SESSION['user_name']=$result->ad_user_name;
$_SESSION['user_id']=$result->ad_user_id;
$_SESSION['user_type']=$result->ad_user_type;
$_SESSION['user_users']=$result->user_users;
$_SESSION['user_usernames'] = array();
$users = explode(",",$result->user_users);
foreach($users as $usr){
	$result1 = $main->getRow("select ad_user_name from adword_user WHERE `ad_user_id`='".$usr."'");
	$_SESSION['user_usernames'][]=$result1->ad_user_name;
}
//$_SESSION['session_time']=time();

print_r($_SESSION);
?>
<div style="margin:auto;"><img src="img/updating.png" alt="Updating Application.. Please wait..." /></div>