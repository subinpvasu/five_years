<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ResponseClass
 *
 * @author bisjo
 */
class ResponseClass {
    
    public $responseCode;
    public $responseMessage;
    public $responseObject;
    
    function getResponseCode() {
        return $this->responseCode;
    }

    function getResponseMessage() {
        return $this->responseMessage;
    }

    function getResponseObject() {
        return $this->responseObject;
    }

    function setResponseCode($responseCode) {
        $this->responseCode = $responseCode;
    }

    function setResponseMessage($responseMessage) {
        $this->responseMessage = $responseMessage;
    }

    function setResponseObject($responseObject) {
        $this->responseObject = $responseObject;
    }
    
    function getResponseObj(){
        return $this;
    }
    
    function setValuesAndReturn($code, $message, $retObj){
        $this->responseCode = $code;
        $this->responseMessage = $message;
        $this->responseObject = $retObj;
        return $this;
    }


    
    
}
