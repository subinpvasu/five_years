<?php
/**
 * CRMCommector class is for connecting to crm via cURL
 *
 * @author bisjo
 */

include_once __DIR__ . '/external/CRMObjects/ResponseClass.php';

class CRMConnctor {
    
    private $adminUserName;
    private $adminUserPassword;
    private $applicationName;
    private $url;
    private $loggedInSession;


    public function __construct($userName, $password, $appName, $url) {
        $this->adminUserName = $userName;
        $this->adminUserPassword = $password;
        $this->applicationName = $appName;
        $this->url = $url;
        $this->loggedInSession = null;
    }


    /**
     * Method to connect to CRM using cURL
     * @param type $method
     * @param type $parameters
     * @param type $url
     * @return type
     */
    function CRMCurlMethod($method, $parameters, $url){
        ob_start();
        $curl_request = curl_init();

        curl_setopt($curl_request, CURLOPT_URL, $url);
        curl_setopt($curl_request, CURLOPT_POST, 1);
        curl_setopt($curl_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl_request, CURLOPT_HEADER, 1);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_request, CURLOPT_FOLLOWLOCATION, 0);
        $jsonEncodedData = json_encode($parameters);

        $post = array(
             "method" => $method,
             "input_type" => "JSON",
             "response_type" => "JSON",
             "rest_data" => $jsonEncodedData
        );

        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $post);
        $result = curl_exec($curl_request);
        curl_close($curl_request);

        $result = explode("\r\n\r\n", $result, 2);
        $response = json_decode($result[1]);
        ob_end_flush();

        return $response;
    }
    
    /**
     * Establishes a login session
     * @return type
     */
    function loginToCRM(){
        //login ----------------------------------------- 
        $login_parameters = array(
             "user_auth" => array(
                  "user_name" => $this->adminUserName,
                  "password" => md5($this->adminUserPassword),
                  "version" => "1"
             ),
             "application_name" => $this->applicationName,
             "name_value_list" => array(),
        );
        $login_result = $this->CRMCurlMethod("login", $login_parameters, $this->url);
        $this->loggedInSession = $login_result;
        return $login_result;
    }
    
    /**
     * Get list of records of a module from CRM
     * @param type $moduleName
     * @param type $fieldArray
     * @param type $count
     * @param type $linkedFieldsArray
     * @param type $start
     * @param type $incDel
     * @param type $favOnly
     * @param type $condition
     * @param type $orderBy
     * @return type
     */
    function getModuleRows($moduleName, $fieldArray=array(), $count=Config::MAX_GET_RESULT_API, $linkedFieldsArray=array(), $start='0', $incDel='0', $favOnly=false, $condition='', $orderBy=''){
        if($this->loggedInSession==null){
            $this->loginToCRM();
        }
        $session_id = $this->loggedInSession->id;
        //get list of records --------------------------------
        $get_entry_list_parameters = array(
            //session id
            'session' => $session_id,
            //The name of the module from which to retrieve records
            'module_name' => $moduleName,
            //The SQL WHERE clause without the word "where".
            'query' => $condition,
            //The SQL ORDER BY clause without the phrase "order by".
            'order_by' => $orderBy,
            //The record offset from which to start.
            'offset' => $start,
            //Optional. A list of fields to include in the results.
            'select_fields' => $fieldArray,

            /*
            A list of link names and the fields to be returned for each link name.
            Example: 'link_name_to_fields_array' => array(array('name' => 'email_addresses', 'value' => array('id', 'email_address', 'opt_out', 'primary_address')))
            */
            'link_name_to_fields_array' => $linkedFieldsArray,

            //The maximum number of results to return.
            'max_results' => $count,

            //To exclude deleted records
            'deleted' => $incDel,

            //If only records marked as favorites should be returned.
            'Favorites' => $favOnly,
        );

        $get_entry_list_result = $this->CRMCurlMethod('get_entry_list', $get_entry_list_parameters, $this->url);
        if($get_entry_list_result){
            $get_entry_list_result = $this->formatResponseToArrayList($get_entry_list_result->entry_list);
            return $get_entry_list_result;
        }else{
            return array();
        }
        
    }
    
    /**
     * Get list of modules from CRM
     * @return type
     */
    function getAvailableModules(){
        if($this->loggedInSession==null){
            $this->loginToCRM();
        }
        $session_id = $this->loggedInSession->id;
        //get list of records --------------------------------
        $get_entry_list_parameters = array(
            //session id
            'session' => $session_id,
        );

        return $this->CRMCurlMethod('get_available_modules', $get_entry_list_parameters, $this->url);
    }
    
    /**
     * Get module records as an array list
     * @param type $responseArray
     * @return type
     */
    function formatResponseToArrayList($responseArray=array()){
        
        $leads = array();
        foreach ($responseArray as $singleLead) {
            $lead = array();
            foreach ($singleLead->name_value_list as $leadDet){
                $lead[$leadDet->name] = $leadDet->value;
                
            }
            $leads[] = $lead;
        }
        return $leads;
    }
    
    /**
     * This method will save one record in to a module
     * @param type $moduleName
     * @param type $associativeArray
     * @return type
     */
    function saveModuleRecord($moduleName,$associativeArray){
        if($this->loggedInSession==null){
            $this->loginToCRM();
        }
        $session_id = $this->loggedInSession->id;
        $set_entry_parameters = array(
            //session id
            "session" => $session_id,
            //The name of the module from which to retrieve records.
            "module_name" => $moduleName,
            //Record attributes
            "name_value_list" => $this->makeInsertArrayFromAssociativeArray($associativeArray),
        );
        $set_entry_result = $this->CRMCurlMethod("set_entry", $set_entry_parameters, $this->url);
        return $set_entry_result;
    }
    
    /**
     * Formating associative array for inserting
     * @param type $associativeArray
     * @return type
     */
    function makeInsertArrayFromAssociativeArray($associativeArray){
        $insertArray = array();
        foreach ($associativeArray as $key => $value){
            $insertArray[] = array("name" => $key, "value" => $value);
        }
        return $insertArray;
    }
    
    /**
     * 
     * @param type $fieldsArray
     * @param type $count
     * @return type
     */
    public function getContactsFromCRM($fieldsArray = array(), $count = Config::MAX_GET_RESULT_API){
        $responseObj = new ResponseClass();
        $retObj = $this->getModuleRows(Config::CONTACT_MODULE_NAME, $fieldsArray, $count);
        if(count($retObj)>0){
            return $responseObj->setValuesAndReturn(Config::RESPONSE_CODE_SUCCESS, Config::RESPONSE_CODE_SUCCESS_MSG, $retObj);
        }else{
            return $responseObj->setValuesAndReturn(Config::RESPONSE_CODE_ERROR, Config::RESPONSE_CODE_NOT_FOUND_MSG, null);
        }
    }
    
    /**
     * Get accounts from CRM
     * @param type $fieldsArray
     * @param type $count
     * @return type
     */
    public function getAccountsFromCRM($fieldsArray = array(), $count = Config::MAX_GET_RESULT_API){
        $responseObj = new ResponseClass();
        $retObj = $this->getModuleRows(Config::ACCOUNT_MODULE_NAME, $fieldsArray, $count);
        if(count($retObj)>0){
            return $responseObj->setValuesAndReturn(Config::RESPONSE_CODE_SUCCESS, Config::RESPONSE_CODE_SUCCESS_MSG, $retObj);
        }else{
            return $responseObj->setValuesAndReturn(Config::RESPONSE_CODE_ERROR, Config::RESPONSE_CODE_NOT_FOUND_MSG, null);
        }
    }
    
    /**
     * Search in CRM
     * @param type $searchString
     * @param type $modulesArry
     * @param type $selectFields
     * @param type $first
     * @param type $limit
     * @param type $isFav
     * @param type $isUni
     * @return type
     */
    public function searchCRM($searchString,$modulesArry,$selectFields,$first=0,$limit=Config::MAX_GET_RESULT_API,$isFav=false,$isUni=false){
        if($this->loggedInSession==null){
            $this->loginToCRM();
        }
        $session_id = $this->loggedInSession->id;
        $search_by_module_parameters = array(
            "session" => $session_id,
            'search_string' => $searchString,
            'modules' => $modulesArry,
            'offset' => $first,
            'max_results' => $limit,
            'assigned_user_id' => '',
            'select_fields' => $selectFields,
            'unified_search_only' => $isUni,
            'favorites' => $isFav,
        );
        
        $search_by_module_results = $this->CRMCurlMethod('search_by_module', $search_by_module_parameters, $this->url);
        $retArray = $this->formatSearchResult($search_by_module_results->entry_list);
        return $retArray;
    }
    
    public function formatSearchResult($entryList){
        $retArray = array();
        foreach ($entryList as $entry){
            foreach ($entry->records as $record){
                $valArray = array();
                foreach ($record as $value){
                    $valArray[$value->name] = $value->value;
                }
                $retArray[] = $valArray;
            }
        }
        return $retArray;
    }

    /**
     * Authenticate user login 
     * @param type $userName
     * @param type $password
     * @return type
     */
    public function contactLogin($userName, $password){
        $modules = array(
            Config::CONTACT_MODULE_NAME,
        );
        $res_ary = array(
            Config::ID_VAR_NAME,
            Config::PASSWORD_VAR_NAME,
            Config::USERNAME_VAR_NAME,
        );
        $responseObj = new ResponseClass();
        $retArray = $this->searchCRM($userName, $modules, $res_ary);
        foreach ($retArray as $records){
            if($records[Config::PASSWORD_VAR_NAME]==$password){
                return $responseObj->setValuesAndReturn(Config::RESPONSE_CODE_SUCCESS,Config::RESPONSE_CODE_SUCCESS_MSG,$records);
            }
        }
        return $responseObj->setValuesAndReturn(Config::RESPONSE_CODE_ERROR,Config::RESPONSE_CODE_LOGIN_ERROR_MSG,null);
        
    }
    
    /**
     * Save a user
     * @param type $fname
     * @param type $lname
     * @param type $gender
     * @param type $password
     * @param type $mobile
     * @param type $email
     * @param type $commPref
     * @return type
     */
    public function userRegistration($fname, $lname,$gender,$mobile,$email,$password,$commPref){
        $responseObj = new ResponseClass();
        $associativeArray = array();
        $associativeArray[Config::F_NAME] = $fname;
        $associativeArray[Config::L_NAME] = $lname;
        $associativeArray[Config::GENDER_NAME] = $gender;
        $associativeArray[Config::PHONE_MOB] = $mobile;
        $associativeArray[Config::EMAIL_VAR] = $email;
        $associativeArray[Config::PASSWORD_VAR_NAME] = $password;
        $associativeArray[Config::PREF_COMM_MOD] = $commPref;
        $modules = array(
            Config::CONTACT_MODULE_NAME,
        );
        $res_ary = array(
            Config::ID_VAR_NAME,
            Config::PASSWORD_VAR_NAME,
        );
        $retArray = $this->searchCRM($email, $modules, $res_ary );
        if(count($retArray)>0){
            return $responseObj->setValuesAndReturn(Config::RESPONSE_CODE_ERROR,Config::DUPLICATE_ENTRY_MSG,null);
        }
        $returnObj = $this->saveModuleRecord(Config::CONTACT_MODULE_NAME, $associativeArray);
        return $responseObj->setValuesAndReturn(Config::RESPONSE_CODE_SUCCESS,Config::RESPONSE_CODE_SUCCESS_MSG,$returnObj);
    }
    
    /**
     * Save/edit sub domain
     * @param type $name
     * @param type $accountId
     * @param type $id
     * @return type
     */
    public function createSubDomain($name, $accountId, $id=''){
        $responseObj = new ResponseClass();
        $associativeArray = array();
        $associativeArray[Config::ID_VAR_NAME] = $id;
        $associativeArray[Config::SD_NAME_FIELD] = $name;
        $associativeArray[Config::SD_AC_NAME_FIELD] = $accountId;
        $modules = array(
            Config::SUB_DOMAIN_MODULE_NAME,
        );
        $res_ary = array(
        );
        $retArray = $this->searchCRM($name, $modules, $res_ary );
        if(count($retArray)>0){
            return $responseObj->setValuesAndReturn(Config::RESPONSE_CODE_ERROR,Config::DUPLICATE_ENTRY_MSG,null);
        }
        $returnObj = $this->saveModuleRecord(Config::SUB_DOMAIN_MODULE_NAME, $associativeArray);
        return $responseObj->setValuesAndReturn(Config::RESPONSE_CODE_SUCCESS,Config::RESPONSE_CODE_SUCCESS_MSG,$returnObj);
    }
    
    /**
     * Remove a sub domain(soft delete)
     * @return type
     */
    public function deleteSubDomain($id){
        $responseObj = new ResponseClass();
        $associativeArray = array();
        $associativeArray[Config::ID_VAR_NAME] = $id;
        $associativeArray[Config::DELETED_VAR_NAME] = Config::YES_INT_STR;
        $returnObj = $this->saveModuleRecord(Config::SUB_DOMAIN_MODULE_NAME, $associativeArray);
        return $responseObj->setValuesAndReturn(Config::RESPONSE_CODE_SUCCESS,Config::RESPONSE_CODE_SUCCESS_MSG,$returnObj);
    }
    
    /**
     * Get all subdomains (maximum 1000)
     * @return type
     */
    public function getSubDomains(){
        $responseObj = new ResponseClass();
        $retObj = $this->getModuleRows(Config::SUB_DOMAIN_MODULE_NAME);
        if(count($retObj)>0){
            return $responseObj->setValuesAndReturn(Config::RESPONSE_CODE_SUCCESS, Config::RESPONSE_CODE_SUCCESS_MSG, $retObj);
        }else{
            return $responseObj->setValuesAndReturn(Config::RESPONSE_CODE_ERROR, Config::RESPONSE_CODE_NOT_FOUND_MSG, null);
        }
    }
    
    /**
     * Gets all sub domains of an account
     * @param type $accountId
     * @return type
     */
    public function getSubDomainsOfAccount($accountId) {
        return $this->getModuleRows(Config::SUB_DOMAIN_MODULE_NAME, array(), Config::MAX_GET_RESULT_API, array(), 0, 0, false, Config::SD_AC_NAME_FIELD."='".$accountId."'");
    }
    

    

    public function getCRMUserContact1(){
//        echo $this->contactLogin('updates.pooram@gmail.com', 'c');die;
        $searchStr = 'updates.pooram@gmail.com';
        $modules = array(
                'Contacts',
            );
        $res_ary = array(
            'id',
            'password_c',
            );
//        return $this->getModuleRows("Contacts", array(), 10, array(), 0, 1, false, "contacts.id in ( select bean_id from email_addr_bean_rel inner join email_addresses where email_addr_bean_rel.email_address_id = email_addresses.id and bean_module = ‘Contacts’ and email_addresses.email_address = ‘updates.pooram@gmail.com’ )");
//        return $this->getModuleRows("Contacts", array(), 10, array(), 0, 1, false, "contacts.id in ( select bean_id from email_addr_bean_rel inner join email_addresses on email_addr_bean_rel.email_address_id = email_addresses.id where email_addr_bean_rel.deleted=0 and email_addresses.deleted=0 and bean_module = ‘Contacts’ and email_addresses.email_address = ‘updates.pooram@gmail.com’ )");
//        return $this->getModuleRows("Contacts", array("email1"), 10, array(), 0, 1, false, "email_addresses.email_address=‘updates.pooram@gmail.com’");
//        return $this->contactLogin('updates.pooram@gmail.com','a');
        return $this->searchCRM($searchStr, $modules, $res_ary);
//        return $this->getModuleRows("Contacts", array());
//        return $this->getModuleRows("Contacts", array("email1"), 10, array(), 0, 1, false, "");
//        return $this->getModuleRows("Contacts", array(), 10, array(), 0, 1, false, "contacts.department='Player'");
//        return $this->getModuleRows("Contacts", array(), 10, array(), 0, 1, false, "contacts.first_name='Morgan'");
    }
    
}
