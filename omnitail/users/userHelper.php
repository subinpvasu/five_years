<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of userHelper
 *
 * @author shijo k.j
 */


//include('config/config.php');
class userHelper {
    public function getUsers($id=0) {
        global $conn;
		$where ='';
		if($id <>0) {$where = "and id='".$id."'";}
        $sql = "SELECT id,name,email FROM users WHERE user_type != 1 and del_status =0 $where";
	    $result = $conn->query($sql);
		$rows = array();
        while($row = $result->fetch_object()) {
            $rows[] = $row;
        }
		return $rows;
    }
    
    public function checkUserExist($email,$id=0) {
        global  $conn;
		$where ='';
		if($id <> 0) {$where = "and id <> '".$id."'";}
        $sql = "SELECT id FROM users WHERE email = '$email' $where";

        $result = $conn->query($sql);        		
		return $result->num_rows;
    }
    
    public function saveUser($user) {
        global  $conn;
        $sql = "INSERT INTO users(name,email,password,added,updated) VALUES('".$user['name']."', '".$user['email']."', '".$user['password']."',NOW(),NOW())";
        $result = $conn->query($sql);
        
        return $result;
    }
    public function updateUser($user) {
        global  $conn; $set = '';
		if($user['password']<>'') $set = ", password= '".$user['password']."'  ";
        $sql = "update users set name='".$user['name']."' ,email='".$user['email']."',updated=NOW() $set where id='".$user['userid']."'";
        $result = $conn->query($sql);        
        return $result;
    }
    public function deleteUser($user) {
        global  $conn; $set = '';	
        $sql = "update users set del_status=1 where id='".$user."'";
        $result = $conn->query($sql);        
        return $result;
    }
}
