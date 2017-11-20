<?php


if (!isset($_SESSION)) {
    session_start();
}
ini_set("memory_limit", "1024M");

// some changes made by bisjo
/**
 * This will crete ad schedules for all given campaigns
*/
require dirname(__FILE__) . '/examples/AdWords/v201605/init.php';
require dirname(__FILE__) . '/ProductPartitionHelper.php';
require dirname(__FILE__) . '/GetCampaigns.php';
require_once dirname(__FILE__) . '/Classes/AppConstants.php';
require_once dirname(__FILE__) . '/Classes/DatabaseHelper.php';
require_once dirname(__FILE__) . '/extendedAdsHelper.php';
require_once dirname(__FILE__) . '/extendedAdsHelperNew.php';

try {
    // Get AdWordsUser from credentials in "../auth.ini"
    // relative to the AdWordsUser.php file's directory.
    require_once dirname(__FILE__) . '/Classes/PHPExcel/IOFactory.php';
    include_once dirname(__FILE__) . '/Classes/HelperMethods.php';
    ini_set("max_execution_time", 0);
    set_time_limit(0);
    if (defined('STDIN')) {
        $userId = $argv[1];
        $accountId = $argv[2];
//        $start = $argv[3];
//        $end = $argv[4];
    } else {
        $userId = isset($_GET['user_id']) ? $_GET['user_id'] : '';
        $accountId = isset($_REQUEST['accountId']) ? $_REQUEST['accountId'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
        $end = isset($_REQUEST['end']) ? $_REQUEST['end'] : AppConstants::$MUTATE_LIMIT-1;
    }
    $dbHelper = new DbHelper();
    $record = $dbHelper->getRecordByUserId($accountId,4);
      //print_r($record);
    $record_id = $record['id'];
     //echo $record_id;
    
//    echo $dbHelper->getNonProcessedAds($record_id);
//    die();

    $oauth2Infos = array(
        "client_id" => AppConstants::$CLIENTID,
        "client_secret" => AppConstants::$SECRET,
        "refresh_token" => $dbHelper->getAppropriateToken($accountId)
    );
    $user = new AdWordsUser(NULL,AppConstants::$DEVTOKEN,AppConstants::$AGENT,NULL,NULL,$oauth2Infos);
    $user->SetClientCustomerId($accountId);

    /****
     * 
     * 
     * 
     * start from here tomorrow onwards.....
     */
    
    $dataValuesNew = new extendedAdsHelperNew($user, $dbHelper);
    
    startOver:
        
    $start = 0;
    $end = AppConstants::$MUTATE_LIMIT;
//    $end = 0;
    
    $etads = $dbHelper->selectAds($record_id, AppConstants::$NOT_PROCESSED_STATUS, $start, $end);
    
    
    
    
    $z = 0;
    $currentExtAdsStatus = '';

    $extended_ads = array();
    $adsarray = array();
    $summary_ads = array();
    $summary_camp = array();
    $summary_kwd  = array();
    $summary_adgs  = array();

    $kdw = array();
    $adg = array();
    $cmp = array();
    
   
    foreach ($etads as $eta) {
        $missing = array();
        
        $extended_ads[AppConstants::$CAMPAIGN_NAME_DB] = trim($eta[AppConstants::$CAMPAIGN_NAME_DB]);
        $extended_ads[AppConstants::$ADGROUP_NAME_DB] = trim($eta[AppConstants::$ADGROUP_NAME_DB]);
        $extended_ads[AppConstants::$BUDGET_NAME_DB] = trim($eta[AppConstants::$BUDGET_NAME_DB]);
        $extended_ads[AppConstants::$BID_NAME_DB] = trim($eta[AppConstants::$BID_NAME_DB]);
        $extended_ads[AppConstants::$HEAD1_NAME_DB] = trim($eta[AppConstants::$HEAD1_NAME_DB]);
        $extended_ads[AppConstants::$HEAD2_NAME_DB] = trim($eta[AppConstants::$HEAD2_NAME_DB]);
        $extended_ads[AppConstants::$KEY1_NAME_DB] = trim($eta[AppConstants::$KEY1_NAME_DB]);
        $extended_ads[AppConstants::$KEY2_NAME_DB] = trim($eta[AppConstants::$KEY2_NAME_DB]);
        $extended_ads[AppConstants::$KEY3_NAME_DB] = trim($eta[AppConstants::$KEY3_NAME_DB]);
        $extended_ads[AppConstants::$KEY4_NAME_DB] = trim($eta[AppConstants::$KEY4_NAME_DB]);
        $extended_ads[AppConstants::$FINAL_URL_NAME_DB] = trim($eta[AppConstants::$FINAL_URL_NAME_DB]);
        $extended_ads[AppConstants::$DESC_NAME_DB] = trim($eta[AppConstants::$DESC_NAME_DB]);
        $extended_ads[AppConstants::$AVAILABILITY_NAME_DB] = trim($eta[AppConstants::$AVAILABILITY_NAME_DB]);
        $extended_ads[AppConstants::$PATH1_NAME_DB] = trim($eta[AppConstants::$PATH1_NAME_DB]);
        $extended_ads[AppConstants::$PATH2_NAME_DB] = trim($eta[AppConstants::$PATH2_NAME_DB]);
        $extended_ads[AppConstants::$ID_NAME_DB] = trim($eta[AppConstants::$ID_NAME_DB]);
        $extended_ads[AppConstants::$RECORD_ID_NAME_DB] = trim($eta[AppConstants::$RECORD_ID_NAME_DB]);
        
        // validating excell data
        if($extended_ads['campaign_name']==''){$missing[] = 'Campaign Missing';}
        if(strlen($extended_ads['campaign_name'])>AppConstants::$CAMPAIGN_NAME_MAX_LENGTH){$missing[] = 'Campaign Name too long.';}
        if($extended_ads['adgroup_name']==''){$missing[] = 'Ad Group Missing';}
        if(strlen($extended_ads['adgroup_name'])>AppConstants::$ADGROUP_NAME_MAX_LENGTH){$missing[] = 'Ad Group Name too long.';}
        if($extended_ads['bid']==''){$missing[] = 'Bid Missing';}
        if(!is_numeric($extended_ads['bid'])){$missing[] = 'Bid value non numeric';}
        if($extended_ads['budget']==''){$missing[] = 'Budget Missing';}
        if(!is_numeric($extended_ads['budget'])){$missing[] = 'Budget value non numeric';}
        if($extended_ads['headline1']==''){$missing[] = 'Headline1 Missing';}
        if(strlen($extended_ads['headline1'])>AppConstants::$HEADLINE_NAME_MAX_LENGTH){$missing[] = 'Headline1 too long.';}
        if($extended_ads['headline2']==''){$missing[] = 'Headline2 Missing';}
        if(strlen($extended_ads['headline2'])>AppConstants::$HEADLINE_NAME_MAX_LENGTH){$missing[] = 'Headline2 too long.';}
        if($extended_ads['keyword1']==''){$missing[] = 'Keyword1 Missing';}
        if(strlen($extended_ads['keyword1'])>AppConstants::$KEYWORD_NAME_MAX_LENGTH){$missing[] = 'Keyword1 too long.';}
        if($extended_ads['keyword2']==''){$missing[] = 'Keyword2 Missing';}
        if(strlen($extended_ads['keyword2'])>AppConstants::$KEYWORD_NAME_MAX_LENGTH){$missing[] = 'Keyword2 too long.';}
        if($extended_ads['keyword3']==''){$missing[] = 'Keyword3 Missing';}
        if(strlen($extended_ads['keyword3'])>AppConstants::$KEYWORD_NAME_MAX_LENGTH){$missing[] = 'Keyword3 too long.';}
        if($extended_ads['keyword4']==''){$missing[] = 'Keyword4 Missing';}
        if(strlen($extended_ads['keyword4'])>AppConstants::$KEYWORD_NAME_MAX_LENGTH){$missing[] = 'Keyword4 too long.';}
        if($extended_ads['finalurl']==''){$missing[] = 'FinalUrl Missing';}
        if(strlen($extended_ads['finalurl'])>AppConstants::$FINALURL_NAME_MAX_LENGTH){$missing[] = 'FinalUrl too long.';}
        if($extended_ads['description']==''){$missing[] = 'Description Missing';}
        if(strlen($extended_ads['description'])>AppConstants::$DESC_NAME_MAX_LENGTH){$missing[] = 'Description too long.';}
        if($extended_ads['availability']==''){$missing[] = 'Availability Missing';}
        if($extended_ads['path1']==''){$missing[] = 'Path1 Missing';}
        if(strlen($extended_ads['path1'])>AppConstants::$PATH_NAME_MAX_LENGTH){$missing[] = 'Path1 too long.';}
        if($extended_ads['path2']==''){$missing[] = 'Path2 Missing';}
        if(strlen($extended_ads['path2'])>AppConstants::$PATH_NAME_MAX_LENGTH){$missing[] = 'Path2 too long.';}
        
        // validate operation
        if(count($missing)==0){
            $summary_camp[$extended_ads['campaign_name']][] = array('campaign_name'=>$extended_ads['campaign_name'],'budget'=>$extended_ads['budget']);
            $summary_adgs[trim($extended_ads['campaign_name'])][] = array('adgroup_name'=>$extended_ads['adgroup_name'],'bid'=>$extended_ads['bid']);
            $summary_ads[trim($extended_ads['campaign_name'])."|".$extended_ads['adgroup_name']][] = array('headline1'=>$extended_ads['headline1'],'headline2'=>$extended_ads['headline2'],'finalurl'=>$extended_ads['finalurl'],'availability'=>$extended_ads['availability'],'description'=>$extended_ads['description'],'path1'=>$extended_ads['path1'],'path2'=>$extended_ads['path2'],'id'=>$extended_ads['id']);
            $summary_kwd[trim($extended_ads['campaign_name'])."|".$extended_ads['adgroup_name']][] = array('1'=>$extended_ads['keyword1'],'2'=>$extended_ads['keyword2'],'3'=>$extended_ads['keyword3'],'4'=>$extended_ads['keyword4']);
            $dataValuesNew->initialize($extended_ads);
        }else{
            $update = $dbHelper->updateExtendedAdsStatus($eta['id'], 'Row Skipped due to: '.addslashes(implode("-",$missing)),'');
        }
    }
    
    if(count($summary_camp)>0){
        foreach ($summary_camp as $key => $row)
        {
            $tmp = array ();
            foreach ($row as $r)
            {
                if (!in_array($r,$tmp)){ 
                $tmp[] = $r;
                }    
            }
            $cmp[$key] = $tmp;
        }
    }
    if(count($summary_adgs)>0){
        foreach ($summary_adgs as $key => $row)
        {
            $tmp = array ();
            foreach ($row as $r)
            {
                if (!in_array($r,$tmp)){
                    $tmp[] = $r;
                }
            }
            $adg[$key] = $tmp;
        }
    }
    
    if(count($summary_kwd)>0){
        foreach ($summary_kwd as $key => $kwd)
        {    
            $tmp = array ();
            foreach ($kwd as $k)
            {
                if (!in_array($k,$tmp)){
                    $tmp[] = $k;
                }
            }
            $kdw[$key] = $tmp;
        }
    }
    if(count($kdw)>0 && count($summary_ads)>0 && count($adg)>0){
        $dataValuesNew->setAdsOnlyList($summary_ads);
        $dataValuesNew->setAdGroupList($adg);
        $dataValuesNew->setAdKeywordsList($kdw);

        $dataValuesNew->processData();
        $dataValuesNew->updateStatus();

        if($dbHelper->getNonProcessedAds($record_id)>0){
            goto startOver;
        }
    }else{
        $dbHelper->addToTestTable(AppConstants::$UNEXPECTED_ERROR);
    }
    $dbHelper->addToTestTable('Extended ads process finished for record id  '.$record_id);
    $dbHelper->finishUpload($record_id);
    echo 'Extended Text Ads Completed';
     
} catch (Exception $e) {
    printf("An error has occurred: %s\n", $e->getMessage());
}

