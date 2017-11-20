<?php
namespace CustomClasses;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BiggestOverspends
 *
 * @author user
 */
class BiggestOverspends {
    
    public $client;
    public $userName;
    public $remainingSpends;
    
    function getClient() {
        return $this->client;
    }

    function getUserName() {
        return $this->userName;
    }

    function getRemainingSpends() {
        return $this->remainingSpends;
    }

    function setClient($client) {
        $this->client = $client;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    function setRemainingSpends($remainingSpends) {
        $this->remainingSpends = $remainingSpends;
    }

        
    
    public function populateModel($mysqliObj){
        $this->client = $mysqliObj->client_name;
        $this->remainingSpends = $mysqliObj->Remaining_Spends;
        $this->userNme = $mysqliObj->user_name;
        return $this;
    }
    
}
