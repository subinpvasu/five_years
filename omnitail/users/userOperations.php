<?php
include('../config/config.php');
require_once './userHelper.php';

try {
    $obj = new userHelper();
//    print_r($obj->getUsers());

    $succes = 0; $result = array(); $userDetails = array();
    $user = json_decode($_POST['user'],true);
    $operation = trim($user['operation']);
    $userid = trim($user['userid']);
	
	
    
	if($operation == "get") {
	
	   $details =  $obj->getUsers($userid); 
	   $userDetails =  $details[0]; 
	   
	   $result['userName'] = $userDetails ->name ;
	   $result['userEmail'] = $userDetails ->email ;
	
        }elseif($operation == "delete") {
	
		$delete =  $obj->deleteUser($userid);
		
		if($delete) {
					
			$result['status'] = "Deleted Successfully" ;
			$result['succ'] = 1 ;
					
		}else { $result['status'] = "Not Deleted. Try Again" ; }
	
        }else {
	
		$error = '' ;
		
		$name = trim($user['name']);
		$email = trim($user['email']);
		$password = trim($user['password']);
		$userPasswordRepeat = trim($user['userPasswordRepeat']);
	
		if( $name =='' ) {$error = "Provide Valid Name";}
		elseif($email =='' || !filter_var($email, FILTER_VALIDATE_EMAIL) ) {$error = "Provide Valid Email";}
		elseif($password=='' && $operation == "save") {$error = "Provide Valid Passowrd";}
		elseif($password <> $userPasswordRepeat) {$error = "Confirmed Password Mismatch";}

                if($error <> '') { $result['status'] =  $error ; }
			
		else{
		
			$avail = $obj->checkUserExist($email,$userid);
					
			if($avail == 0){
				
				$password = md5($password);
				
				$user = array(
				
					'name' => $name ,
					'email' => $email ,
					'password' => $password ,
					'userid' => $userid ,
				
				);
				
                                if($operation == "save") { $succes = $obj->saveUser($user); }
				
                                elseif($operation == "edit") { $succes = $obj->updateUser($user);}
				
				if($succes) {
					
					$result['status'] = "Saved Successfully" ;
					$result['succ'] = 1 ;
					
				}else { $result['status'] = "Not Saved" ; }
				
			}else {
				$result['status'] = "User Email Already Exist" ;
				
			}
		}
	
        }
	
	echo json_encode($result); exit ;
	
} catch (Exception $ex) {
    print_r($ex);
}