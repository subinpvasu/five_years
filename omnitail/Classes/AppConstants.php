<?php

/**
 * Constants class
 */
class AppConstants {
    
    //VPS server
//     public static $SERVER_NAME = "localhost";
//     public static $USER_NAME = "omnitail_omnitai";
//     public static $PASSWORD = "tooltails@123";
//     public static $DB_NAME = "omnitail_excelupload";
    
    //Shared server
//    public static $SERVER_NAME = "localhost";
//    public static $USER_NAME = "omnitail";
//    public static $PASSWORD = "tooltails@123";
//    public static $DB_NAME = "omnitail_excelupload";
     
    //local
    public static $SERVER_NAME = "localhost";
    public static $USER_NAME = "root";
    public static $PASSWORD = "";
    public static $DB_NAME = "omnitail_excelupload";
    
    public static $MASTER  = 6743897063;
    public static $CLIENTID = "246286771689-2gvi0te92vnh6jqq4pacm6cfbsmsi11m.apps.googleusercontent.com";
    public static $SECRET = "XUe21srsfUP76I-6apSMwHkO";
    public static $DEVTOKEN = "cmGKSWCRtO60ETC-qlFKMA";
    public static $AGENT = "Omnitail";
    public static $PER_RUN_COUNT = 150;
    
    public static $YES_BOOL = true;
    public static $NO_BOOL = false;
    public static $YES_INT = 1;
    public static $NO_INT = 0;
    public static $UPDATED_INT = 2;
    public static $YES_STR = "Yes";
    public static $NO_STR = "No";
    
    public static $CAMPAIGN_TYPE_SEARCH = 'SEARCH';
    public static $CAMPAIGN_STATUS_ENABLED = 'ENABLED';
    public static $CAMPAIGN_STATUS_PAUSED = 'PAUSED';
    public static $BID_STRATEGY_TYPE_MAN_CPC = 'MANUAL_CPC';
    
    public static $CREATE_OPERAND = 'ADD';
    public static $UPDATE_OPERAND = 'SET';
    
    public static $NAME = 'name';
    public static $AMOUNT = 'amount';
    public static $IS_DOWNLOADED = 'isDownloaded';
    public static $IS_UPDATED = 'isUpdated';
    public static $BUDGET_ID = 'budgetid';
    public static $CAMPAIGN_ID_VAR = 'campaignId';
    


    public static $NOT_PROCESSED_STATUS = "Not Processed";
    public static $MYSQL_CONNECTION_ERROR = "Failed to conencto to MySQL: ";
    public static $TARGET_NAME = 'Target';
    public static $TARGET_DATA_NAME = 'Target Data';
    public static $BRAND_NAME = 'Brand';
    public static $CLO_NAME = 'CL0';
    public static $CAMPAIGN_NAME = 'Campaign Name';
    public static $CAMPAIGN_ID = 'Campaign ID';
    public static $ADGROUP_NAME = 'Ad Group Name';
    public static $ADGROUP_ID = 'Ad Group ID';
    public static $AUDIENCE_NAME = 'Audience Name';
    public static $AUDIENCE_ID = 'Audience ID';
    public static $BID_ADJUST = 'Bid Adjust';
    public static $TARGET_SETTING = 'Targeting Setting';
    public static $BID_NAME = 'Bid';
    public static $PRIORITY_NAME = 'Priority';
    public static $MERCHANTID_NAME = 'Merchant Id';
    public static $BUDGET_NAME = 'Budget';
    public static $LABEL_NAME = 'Label';
    public static $COUNTRY_NAME = 'Country';
    public static $STATUS_NAME = 'STATUS';
    public static $COMMAND = "php ";
    
    public static $ERROR_MESSAGE = "Error Message";
    public static $SCHEDULE_NAME = "Schedule";
    
    public static $CAMPAIGN_BID_MULTIPLIER = 1000000;
    
    public static $CAMPAIGN_NAME_DB = 'campaign_name';
    public static $ADGROUP_NAME_DB = 'adgroup_name';
    public static $HEAD1_NAME_DB = 'headline1';
    public static $HEAD2_NAME_DB = 'headline2';
    public static $KEY1_NAME_DB = 'keyword1';
    public static $KEY2_NAME_DB = 'keyword2';
    public static $KEY3_NAME_DB = 'keyword3';
    public static $KEY4_NAME_DB = 'keyword4';
    public static $FINAL_URL_NAME_DB = 'finalurl';
    public static $DESC_NAME_DB = 'description';
    public static $PATH1_NAME_DB = 'path1';
    public static $PATH2_NAME_DB = 'path2';
    public static $AVAILABILITY_NAME_DB = 'availability';
    public static $BID_NAME_DB = 'bid';
    public static $BUDGET_NAME_DB = 'budget';
    public static $RECORD_ID_NAME_DB = 'recordId';
    public static $ID_NAME_DB = 'id';
    public static $STATUS_NAME_DB = 'status';
    public static $TOTAL_ROWS_NAME_DB = 'total_rows';
    
    public static $MUTATE_LIMIT = 49;
    public static $MUTATE_LIMIT_ADS = 15;
    
    public static $CAMPAIGN_NAME_MAX_LENGTH = 128;
    public static $ADGROUP_NAME_MAX_LENGTH = 255;
    public static $HEADLINE_NAME_MAX_LENGTH = 30;
    public static $KEYWORD_NAME_MAX_LENGTH = 80;
    public static $FINALURL_NAME_MAX_LENGTH = 2047;
    public static $PATH_NAME_MAX_LENGTH = 15;
    public static $DESC_NAME_MAX_LENGTH = 80;
    
    public static $ID_NAME_ADWORDS = 'Id';
    public static $STATUS_NAME_ADWORDS = 'Status';
    public static $HEAD1_NAME_ADWORDS = 'HeadlinePart1';
    public static $HEAD2_NAME_ADWORDS = 'HeadlinePart2';
    public static $DESC_NAME_ADWORDS = 'Description';
    public static $FINAL_URL_NAME_ADWORDS = 'CreativeFinalUrls';
    public static $PATH1_NAME_ADWORDS = 'Path1';
    public static $PATH2_NAME_ADWORDS = 'Path2';
    public static $ADGROUP_ID_ADWORDS = 'AdGroupId';
    public static $ADGROUP_NAME_ADWORDS = 'AdGroupName';
    
    public static $AVAIL_STATUS_IN_STOCK = 'in stock';
    
    public static $KEY_WORD = 'Keyword';
    public static $KEY_WORD_NAME = 'keyword';
    public static $KEY_WORD_MATCH_TYPE_NAME = 'matchType';
    
    public static $CAMPAIGN_SKIPPED_STATUS = 'Campaign skipped,';
    public static $CAMPAIGN_UPDATED_STATUS = 'Campaign updated,';
    public static $CAMPAIGN_CREATED_STATUS = 'Campaign created,';
    public static $ADGROUP_CREATED_STATUS = 'Adgroup created,';
    public static $ADGROUP_UPDATED_STATUS = 'Adgroup updated,';
    public static $ADGROUP_SKIPPED_STATUS = 'Adgroup skipped,';
    public static $AD_CREATED_STATUS = 'Ad created,';
    public static $AD_SKIPPED_STATUS = 'Ad skipped,';
    public static $AD_UPDATED_STATUS = 'Ad updated,';
    public static $KEYWORD1_CREATED_STATUS = 'Keyword1 created,';
    public static $KEYWORD1_SKIPPED_STATUS = 'Keyword1 skipped,';
    public static $KEYWORD2_CREATED_STATUS = 'Keyword2 created,';
    public static $KEYWORD2_SKIPPED_STATUS = 'Keyword2 skipped,';
    public static $KEYWORD3_CREATED_STATUS = 'Keyword3 created,';
    public static $KEYWORD3_SKIPPED_STATUS = 'Keyword3 skipped,';
    public static $KEYWORD4_CREATED_STATUS = 'Keyword4 created';
    public static $KEYWORD4_SKIPPED_STATUS = 'Keyword4 skipped';
    
    public static $UNEXPECTED_ERROR = 'Unexpected error occured...!';
    
}
