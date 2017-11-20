<?php
namespace CustomClasses;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BestChangeInCPA
 *
 * @author user
 */
class BestChangeInCPA {
    
    public $cpaChange;
    public $client;
    public $userName;
    
    function getCpaChange() {
        return $this->cpaChange;
    }

    function getClient() {
        return $this->client;
    }

    function getUserNme() {
        return $this->userName;
    }

    function setCpaChange($cpaChange) {
        $this->cpaChange = $cpaChange;
    }

    function setClient($client) {
        $this->client = $client;
    }

    function setUserNme($userNme) {
        $this->userName = $userNme;
    }
    
    public function populateModel($mysqliObj){
        $this->client = $mysqliObj->client_name;
        $this->cpaChange = $mysqliObj->CPA_Change;
        $this->userName = $mysqliObj->user_name;
        return $this;
    }
    
}
