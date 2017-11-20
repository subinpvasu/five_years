<?php
namespace CustomClasses;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of topFiveBiggestIncreaseInVisitors
 *
 * @author user
 */
class topFiveBiggestIncreaseInVisitors {
    
    
    public $percentVisitorsToLastMonth;
    public $client;
    public $userName;
    
    function getPercentVisitorsToLastMonth() {
        return $this->percentVisitorsToLastMonth;
    }

    function getClient() {
        return $this->client;
    }

    function getUserNme() {
        return $this->userName;
    }

    function setPercentVisitorsToLastMonth($percentVisitorsToLastMonth) {
        $this->percentVisitorsToLastMonth = $percentVisitorsToLastMonth;
    }

    function setClient($client) {
        $this->client = $client;
    }

    function setUserNme($userNme) {
        $this->userName = $userNme;
    }


    public function populateModel($mysqliObj){
        $this->client = $mysqliObj->client_name;
        $this->percentVisitorsToLastMonth = $mysqliObj->percent_Visitors_to_Last_Month;
        $this->userName = $mysqliObj->user_name;
        return $this;
    }
}
