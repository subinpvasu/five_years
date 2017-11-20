<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CustomClasses;

/**
 * Description of responseClass
 *
 * @author user
 */
class responseClass {
    
    public $responseCode;
    public $responseMessage;
    public $returnObject;
    
    
    function getResponseCode() {
        return $this->responseCode;
    }

    function getResponseMessage() {
        return $this->responseMessage;
    }

    function getReturnObject() {
        return $this->returnObject;
    }

    function setResponseCode($responseCode) {
        $this->responseCode = $responseCode;
    }

    function setResponseMessage($responseMessage) {
        $this->responseMessage = $responseMessage;
    }

    function setReturnObject($returnObject) {
        $this->returnObject = $returnObject;
    }


    
}
