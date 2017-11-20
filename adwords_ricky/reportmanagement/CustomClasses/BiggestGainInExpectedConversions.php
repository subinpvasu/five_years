<?php
namespace CustomClasses;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BiggestGainInExpectedConversions
 *
 * @author user
 */
class BiggestGainInExpectedConversions {
    
    public $percentConversionsToLastMonth;
    public $client;
    public $userName;
    
    function getPercentConversionsToLastMonth() {
        return $this->percentConversionsToLastMonth;
    }

    function getClient() {
        return $this->client;
    }

    function getUserNme() {
        return $this->userName;
    }

    function setPercentConversionsToLastMonth($percentConversionsToLastMonth) {
        $this->percentConversionsToLastMonth = $percentConversionsToLastMonth;
    }

    function setClient($client) {
        $this->client = $client;
    }

    function setUserNme($userNme) {
        $this->userName = $userNme;
    }
    
    public function populateModel($mysqliObj){
        $this->client = $mysqliObj->client_name;
        $this->percentConversionsToLastMonth = $mysqliObj->percent_Conversions_to_Last_Month;
        $this->userName = $mysqliObj->user_name;
        return $this;
    }
}
