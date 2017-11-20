<?php
namespace CustomClasses;

/**
 * Description of BiggestIncreaseInCpc
 *
 * @author user
 */
class BiggestIncreaseInCpc {
    
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
