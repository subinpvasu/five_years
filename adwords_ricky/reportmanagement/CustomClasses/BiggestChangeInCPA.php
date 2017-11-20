<?php
namespace CustomClasses;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BiggestChangeInCPA
 *
 * @author user
 */
class BiggestChangeInCPA {
    
    public $cpcChange;
    public $client;
    public $userName;
    
    function getCpcChange() {
        return $this->cpcChange;
    }

    function getClient() {
        return $this->client;
    }

    function getUserNme() {
        return $this->userName;
    }

    function setCpcChange($cpcChange) {
        $this->cpcChange = $cpcChange;
    }

    function setClient($client) {
        $this->client = $client;
    }

    function setUserNme($userNme) {
        $this->userName = $userNme;
    }
    
    public function populateModel($mysqliObj){
        $this->client = $mysqliObj->client_name;
        $this->cpcChange = $mysqliObj->CPC_Change;
        $this->userName = $mysqliObj->user_name;
        return $this;
    }


    
}
