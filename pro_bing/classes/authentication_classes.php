<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class authentication_token{
    private $username;
    private $password;
    private $developer_token;
    private $authentication_token;
    private $refresh_token;
    private $accountid;
    private $customerid;
  
    public function __construct() {
       
            $this->username = constants::$USERNAME;
            $this->password = constants::$PASSWORD;
            $this->developer_token = constants::$DEVELOPER_TOKEN;
            $this->authentication_token = constants::$AUTHENTICATION_TOKEN;
            $this->refresh_token = constants::$REFRESH_TOKEN;
            $this->accountid = constants::$ACCOUNTID;
            $this->customerid = constants::$CUSTOMERID;
                       
     }
}

