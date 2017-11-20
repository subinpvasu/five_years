<?php
require_once dirname(__FILE__) . '/../includes/includes.php';

$id = trim($_REQUEST['id']);
$name = trim($_REQUEST['name']);
$email = trim($_REQUEST['email']);
$type = trim($_REQUEST['type']);
$pass = trim($_REQUEST['pass']);
$conf = trim($_REQUEST['conf']);
$url = $_REQUEST['url'];
$check = $_REQUEST['check'];
$checkUrl = $_REQUEST['checkurl'];

$accountManagers = $_REQUEST['values'];
$return = array();
$return['error'] = "";
$return['user'] = 0;


$urlsegs = explode("d/",$url);
$urlsegs = explode("/",$urlsegs[1]);

$url = $urlsegs[0];
$accountManagers = implode(",",$accountManagers);

if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
 {$return['error'] = "Provide Valid Name of User \n";}
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
   $return['error'] .= "Provide valid Email Id\n"; 
}

else if($main->IsDuplicateExist('adword_user',"`ad_user_name`='".$email."' and ad_delete_status=0 and ad_user_id <> $id")){
   $return['error'] .= "Email Id already exists \n"; 
}
if($check=="true") 
    {
        if(!$validator->ValidateNotNull($pass)){$return['error'] .= "Provide Password\n";}
        else if($pass != $conf){$return['error'] .= "Confirmed password is wrong\n";} 
    }
if($return['error']<> "") {echo json_encode($return); exit;}
else{
	
	$fieldArray = array(
            'ad_person_name'=>$name ,
            'ad_user_name'=>$email ,
            'ad_user_type'=>$type ,
            'user_users'=>$accountManagers
	);
	
	if($id==0){ //Add User
            $fieldArray['ad_user_password']=md5($pass);
            $fieldArray['ad_user_report_link']=$url;
            $insert = $main->insert('adword_user',$fieldArray) ;
            if($insert){
                $return['user'] = $check  ;
                $return['error'] = 0;
            }
            else{
                    $return['error'] = "Please Try later.";
            }
	}
	else { //Edit user 
            if($check=="true"){ 
                $fieldArray['ad_user_password']=md5($pass); 
            }
            if($checkUrl=="true"){ 
                $fieldArray['ad_user_report_link']=$url; 
            }
            $update = $main->Update('adword_user',$fieldArray,"ad_user_id='$id'") ;
            if($update){
                $return['user'] = $fieldArray;
                $return['error'] = 0 ;
            }
            else{
                $return['error'] =0 ;
            }
	}
}
echo json_encode($return);
?>