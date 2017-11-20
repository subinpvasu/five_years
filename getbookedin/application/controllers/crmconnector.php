<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class crmconnector extends CI_Controller {
    
    private $crmConnector;
    
    public function __construct() {
            parent::__construct();
            $this->load->library('CRMConnctor');
            $this->crmConnector = new CRMConnctor(Config::CRM_ADMIN_USER, Config::CRM_ADMIN_USER_PASSWORD, Config::APP_NAME, Config::CRM_SERVER_URL.Config::CRM_REST_ENDPOINT);
	}
        
        /**
         * Index page for CRM Connector
         */
        function index(){
            error_reporting(E_ALL);
ini_set('display_errors', 'On');
//            $fieldArray = array('id', 'subject', 'contact', 'start date');
            $fieldArray = array();
//            $fieldArray = array('id', 'name', 'title');
//            $leads = $this->crmConnector->getModuleRows(Config::SUB_DOMAIN_MODULE_NAME);
            $accId = "15c85970-a50b-107c-76a7-55f2c133fec1";
            $leads = $this->crmConnector->getSubDomainsOfAccount($accId);
//            $leads = $this->crmConnector->getSubDomains();
//            $leads = $this->crmConnector->getContactsFromCRM();
//            $leads = $this->crmConnector->getCRMUserContact1();
//            $leads = $this->crmConnector->getAvailableModules();
//            $leads = $this->crmConnector->getAccountsFromCRM();
//            $leads = $this->crmConnector->getCRMUserContact();
//            $leads = $this->crmConnector->getModuleRows('Meetings', $fieldArray, 10);
//        print_r($leads->entry_list[0]->name_value_list->assigned_user_name->value);
            echo '<pre>';
            print_r($leads);
            echo '</pre>';
        }
        
        function save(){
            echo 'Hi,<br>';
            $associativeArray = array();
            $associativeArray['last_name'] = 'last_name';
            $associativeArray['first_name'] = 'first_name';
            $fname = 'first';
            $lname = 'last';
            $gender = 'Male';
            $password = md5("password");
            $mobile = '9496371432';
            $email = 'bisjo.music@gmail.com';
            $commPref = "Email";
//            $leads = $this->crmConnector->saveModuleRecord('Leads', $associativeArray);
            $leads = $this->crmConnector->userRegistration($fname, $lname, $gender, $mobile, $email, $password, $commPref);
            echo '<br><pre>';
            print_r($leads);
        }
        
        function subDomainSave(){
//            $id = "f14e6f08-8825-303f-b7ea-57cfef3c92a4";
            $accId = "15c85970-a50b-107c-76a7-55f2c133fec1";
            $name = "bob y m";
            $leads = $this->crmConnector->createSubDomain($name, $accId);
            echo '<br><pre>';
            print_r($leads);
        }
        
        function subDomainDel(){
            $id = "f14e6f08-8825-303f-b7ea-57cfef3c92a4";
            $leads = $this->crmConnector->deleteSubDomain($id);
            echo '<br><pre>';
            print_r($leads);
        }
       

}