<?php
/* ----------------------------------------------------------------------------
 * Easy!Appointments - Open Source Web Scheduler
 * 
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) 2013 - 2015, Alex Tselegidis
 * @license     http://opensource.org/licenses/GPL-3.0 - GPLv3 
 * @link        http://easyappointments.org
 * @since       v1.0.0
 * ---------------------------------------------------------------------------- */

/**
 * Appointments Configuration File
 * 
 * Set your installation BASE_URL * without the trailing slash * and the database 
 * credentials in order to connect to the database. You can enable the DEBUG_MODE
 * while developing the application.
 * 
 * IMPORTANT: 
 * If you are updating from version 1.0 you will have to create a new "config.php"
 * file because the old "configuration.php" is not used anymore.
 */
class Config {
    // ------------------------------------------------------------------------
    // General Settings
    // ------------------------------------------------------------------------
    const BASE_URL      = 'http://localhost/appointment';
    const DEBUG_MODE    = FALSE;
     
    // ------------------------------------------------------------------------
    // Database Settings
    // ------------------------------------------------------------------------
    const DB_HOST       = 'localhost';    
    const DB_NAME       = 'appointment';
    const DB_USERNAME   = 'root';
    const DB_PASSWORD   = '';

    // ------------------------------------------------------------------------
    // Google Calendar Sync
    // ------------------------------------------------------------------------
    const GOOGLE_SYNC_FEATURE   = TRUE; // Enter TRUE or FALSE
//    const GOOGLE_PRODUCT_NAME   = '';
//    const GOOGLE_CLIENT_ID      = '';
//    const GOOGLE_CLIENT_SECRET  = '';
//    const GOOGLE_API_KEY        = '';
    const GOOGLE_PRODUCT_NAME   = 'Test calendar';
    const GOOGLE_CLIENT_ID      = '304804684136-ii5jkj1l8qai218om287o5743be9o9gu.apps.googleusercontent.com';
    const GOOGLE_CLIENT_SECRET  = 'pdUDq-lmVPUR4KuqOnaKskx-';
    const GOOGLE_API_KEY        = 'AIzaSyBWZI-JNaBZ0kUW8VoF_hOr9fm9TubwPcg ';
//    const CRM_SERVER_URL = 'http://localhost/SuiteCRM/';
    const CRM_SERVER_URL = 'http://178.17.41.150/suitecrm/SuiteCRM/';
    const CRM_REST_ENDPOINT = 'service/v4_1/rest.php';
    const CRM_ADMIN_USER = 'admin';
    const CRM_ADMIN_USER_PASSWORD = 'vBr1dge';
    const APP_NAME = 'vBridge';
    const CURR_SESSION_ID = 'CURRENT_SESSION_ID';
    const MAX_GET_RESULT_API = 1000;
    const PASSWORD_VAR_NAME = "password_c";
    const ID_VAR_NAME = "id";
    const USERNAME_VAR_NAME = "user_name_c";
    const DELETED_VAR_NAME = "deleted";
    const F_NAME = 'first_name';
    const L_NAME = 'last_name';
    const GENDER_NAME = 'gender_c';
    const PHONE_MOB = 'phone_mobile';
    const EMAIL_VAR = 'email1';
    const PREF_COMM_MOD = 'pref_comm_mode_c';
    
    const ACCOUNT_MODULE_NAME = "Accounts";
    const CONTACT_MODULE_NAME = "Contacts";
//    const SUB_DOMAIN_MODULE_NAME = "Sub Domain";
    const SUB_DOMAIN_MODULE_NAME = "apmt_SubDomain";
    const SD_NAME_FIELD = "name";
    const SD_AC_NAME_FIELD = "account_id_c";
    
    
    const RESPONSE_CODE_ERROR = 0;
    const RESPONSE_CODE_SUCCESS = 1;
    const DUPLICATE_ENTRY_MSG = "Entered details already exists.";
    const RESPONSE_CODE_SUCCESS_MSG = "Successfully completed process and result returned";
    const RESPONSE_CODE_LOGIN_ERROR_MSG = "Username or password does not match.";
    const RESPONSE_CODE_NOT_FOUND_MSG = "No records found.";
    
    const YES = "yes";
    const NO = "no";
    const YES_BOOL = true;
    const NO_BOOL = false;
    const YES_INT = 1;
    const NO_INT = 0;
    const YES_INT_STR = "1";
    const NO_INT_STR = "0";
    
}
/* End of file config.php */
/* Location: ./config.php */