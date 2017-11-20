<?php
namespace CustomClasses;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BestDecreasesInCPC
 *
 * @author user
 */
class BestDecreasesInCPC {
    
    
    public $cpcDiffer;
    public $client;
    public $userName;
    
    function getCpcDiffer() {
        return $this->cpcDiffer;
    }

    function getClient() {
        return $this->client;
    }

    function getUserNme() {
        return $this->userName;
    }

    function setCpcDiffer($cpcDiffer) {
        $this->cpcDiffer = $cpcDiffer;
    }

    function setClient($client) {
        $this->client = $client;
    }

    function setUserNme($userNme) {
        $this->userName = $userNme;
    }

        
    public function populateModel($mysqliObj){
        $this->client = $mysqliObj->client_name;
        $this->cpcDiffer = $mysqliObj->CPC_Diff;
        $this->userName = $mysqliObj->user_name;
        return $this;
    }
}
