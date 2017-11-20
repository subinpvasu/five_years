<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class soap
{
   public function prepare_soap_header($ns,$action)
    {
        $header[] = new SoapHeader($ns,'DeveloperToken',  constants::$DEVELOPER_TOKEN);
        $header[] = new SoapHeader($ns,'Action',  $action);
        $header[] = new SoapHeader($ns,'CustomerAccountId',  constants::$ACCOUNTID);
        $header[] = new SoapHeader($ns,'CustomerId',  constants::$CUSTOMERID);
        $header[] = new SoapHeader($ns,'AuthenticationToken',  constants::$AUTHENTICATION_TOKEN);
        return $header;
    }
}