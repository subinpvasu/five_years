<?php
namespace CustomClasses;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author user
 */
class User {
    
    public $userName;
    public $personName;
    public $userId;
    public $userType;
    
    function getUserName() {
        return $this->userName;
    }

    function getUserId() {
        return $this->userId;
    }

    function getUserType() {
        return $this->userType;
    }
    
    function getPersonName() {
        return $this->personName;
    }

    function setPersonName($personName) {
        $this->personName = $personName;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setUserType($userType) {
        $this->userType = $userType;
    }
    
    public function populateModel($mysqliObj){
        $this->userName = $mysqliObj->ad_user_name;
        $this->personName = $mysqliObj->ad_person_name;
        $this->userType = $mysqliObj->ad_user_type;
        $this->userId = $mysqliObj->ad_user_id;
        return $this;
    }
}
