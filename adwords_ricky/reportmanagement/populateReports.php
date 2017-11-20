<?php
/**
 * This file will populate the database with the values in the spreadsheets provided.
 */
require_once '../includes/includes.php' ;

require_once 'src/Google_Client.php';
require_once 'vendor/autoload.php';
include_once 'CustomClasses/Constants.php';
include_once 'CustomClasses/fileOperations.php';
include_once 'CustomClasses/dbOperations.php';
include_once 'CustomClasses/responseClass.php';
include_once 'CustomClasses/helperFunctions.php';
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
use CustomClasses\Constants;

if(Constants::$THIS_MONTH=="" || Constants::$PREVIOUS_MONTH=="")
{
    Constants::$THIS_MONTH = date(Constants::$MONTH_OF_DATE);
    Constants::$PREVIOUS_MONTH = (date(Constants::$MONTH_OF_DATE, strtotime(date(Constants::$MONTH_OF_DATE)." -1 month")));
}
$clientId = Constants::$GOOGLE_CLIENT_ID;
$clientSecret = Constants::$GOOGLE_CLIENT_SECRET;
$redirectUrl = Constants::$GOOGLE_CLIENT_REDIRECT_URL;


/* $file = getcwd(). Constants::$DIRECTORY_SEPERATOR.Constants::$SETUP_DIRECTORY_NAME.Constants::$DIRECTORY_SEPERATOR."config.ini";
 */
$file = SITE_DIR."reportmanagement/setup/config.ini";

$fileOperations = new CustomClasses\fileOperations();
$response = $fileOperations->readFile($file);
if($response->responseCode == Constants::$RESPONSE_CODE_OK){
    $tokenString = $response->returnObject;
}else{
    echo $response->responseMessage;
    exit();
}

$tokens = json_decode($tokenString);
$accessToken = $tokens->access_token;
$refreshToken = $tokens->refresh_token;


$previousRow = 0;
$previousColumn = 0;
$previousMonthCounter = 0;
$thisMonthCounter = 0;
$headerSettingStatus = Constants::$HEADER_SETTING_NOT_STARTED;
$summeryHeaderSettingStatus = Constants::$HEADER_SETTING_NOT_STARTED;
$dataRowStatus = 0;
$clientHeadingCount = 0;
$helper = new CustomClasses\helperFunctions();
$dailyReportsSql = "INSERT INTO `".Constants::$DAILY_REPORT_TABLE_NAME."`(`user_id_fk`,`user_name`, `client_name`, `report_status`, `Budget`, `ppc_visitors_last_month`, `ppc_visitors_current_month`, `percent_at_this_point_last_month`, `cpc_last_month`, `cpc_current_month`, `change_in_cpc`, `ppc_spend_last_month`, `ppc_spend_current_month`, `remaining_budget`, `remaining_budget_at_ppc_spend`, `daily_budget`, `avg_daily_spends_mtd`, `plus_or_minus_daily_budget_available`, `yesterday_spends`, `adwords_conversions_last_month`, `adwords_conversions_current_month`, `conversions_at_current_rate`, `percent_on_last_month_at_current_rate`, `ppc_cpa_last_month`, `ppc_cpa_current_month`, `change_in_cpa`, `last_updated`, `client_id`,`cpa_target`,`budget_cap`) VALUES ";
$summeryReportsSql = "INSERT INTO `".Constants::$SUMMERY_REPORT_TABLE_NAME."`(`user_id`,`user_name`, `client_name`, `Top_5_biggest_increse_in_visitors`, `Biggest_Increases_in_CPC`, `Biggest_underspends`, `Worst_5_with_biggest_decrease_in_visitors`, `Best_Decreases_in_CPC`, `biggest_Overspends`, `Biggest_Gain_in_Expected_Conversions`, `Biggest_Change_in_CPA`, `Worst_drop_in_expected_conversions`, `Best_Change_in_CPA`, `percent_Visitors_to_Last_Month`, `CPC_Diff`, `Remaining_Spends`, `percent_Conversions_to_Last_Month`, `CPC_Change`, `CPA_Change`) VALUES ";
$summeryReportsSqlValues="";
$summeryValues = "([value-2],'[value-3]','[value-4]',[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],[value-13],[value-14],'[value-15]','[value-16]','[value-17]','[value-18]','[value-19]','[value-20]')";


Try{

//setting app details
$client = new Google_Client();
$client->setClientId($clientId);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUrl);
$client->setScopes(array('https://spreadsheets.google.com/feeds'));
$client->setAccessToken($tokenString);


//if access token is expired, then new token will be requested and stored.
if($client->isAccessTokenExpired()){
    $client->refreshToken($refreshToken);
    $accessToken = $client->getAccessToken();
    $accessToken = json_decode($accessToken);
    $accessToken = $accessToken->access_token;
    $tokens->access_token = $accessToken;
    $tokenString = $client->getAccessToken();
    $response = $fileOperations->writeToFile($file, $tokenString);
    if($response->responseCode==0){
        echo $response->responseMessage;
    }
}
$serviceRequest = new DefaultServiceRequest($accessToken);
ServiceRequestFactory::setInstance($serviceRequest);
$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();

//Fetch adwords user Sheet ID from DB
$dbObj = new \CustomClasses\dbOperations();

$getUserQuery = "SELECT * FROM `adword_user`";  
$user_table = $dbObj->exeuteQuery($getUserQuery);
$sheet_id = array();

// loop for loading different spreadsheets
while($user = mysqli_fetch_array($user_table->returnObject)){
    if($user['ad_user_report_link'] != '' && $user['ad_user_type'] != 4) {
		
		echo "<br />User : ".$user['ad_user_name'] ; 

        $ownerName = $user['ad_user_name'];
        $spreadSheetId = $user['ad_user_report_link'];
        //foreach (Constants::$SHEET_IDS as $ownerName => $spreadSheetId) {
        $spreadsheetFeed = $spreadsheetService->getSpreadsheetById($spreadSheetId);
		

        $colNumArray = array();
        $worksheets = $spreadsheetFeed->getWorksheets();
		
		

        //loop for loading sheets
        foreach ($worksheets as $value) {
            $ws = $value->getTitle();
            if($value->getTitle() == Constants::$SHEET_TITLE1 && $ownerName==Constants::$MASTER_NAME){
				
                $entries = $value->getCellFeed()->getEntries();

				$array = array(); $i =0 ;
				
				$count = count($entries);
				
                //loop for loading all cells in the sheet
                foreach ($entries as $key => $entry){
		
					$row = $entry->getRow() ;
					$colum = $entry->getColumn() ;
										
					if($row > 5){					
						for($i=1; $i<= Constants::$MAX_COLUMNS ; $i++){							
							if($i==1 && $entry->getContent()){	 					
								$userName = strtolower($entry->getContent()).Constants::$DEFAULT_EMAIL_TAIL;
								$user = $helper->getUser($userName);
								
								if($user->responseCode==Constants::$RESPONSE_CODE_OK){
									$userId = $user->returnObject->userId;
								} 
								$array[$row][0] = "'".$userId."'" ;					
							}
							
							if($i == $colum) $array[$row][$colum] =  "'".addslashes($entry->getContent())."'";
							else if(!isset($array[$row][$i])) $array[$row][$i] = "''";
						}
	 				}
				} 		
				
				$array2 = array();
				foreach($array  as $key => $value){
					
					if($value[1] != "''") $array2[$key] = "( ".implode(",",$value)." ) ";
					
				}
				
				$dailyReportsSql.=  implode(",",$array2) ;
				
  				$dailyReportsSql.= ";"; 


            }else if($value->getTitle() == Constants::$SHEET_TITLE2){
                $entries = $value->getCellFeed()->getEntries();
                //initializing count and reports
                $clientHeadingCount = 0;
                $firstReport = array();
                $secondReport = array();
                $thirdReport = array();
                $fourthReport = array();
                $fifthReport = array();
                $sixthReport = array();
                $seventhReport = array();
                $eighthReport = array();
                $ninethReport = array();
                $tenthReport = array();

                // lood loading cells
                foreach ($entries as $entry){

                    //counting client name
                    if($entry->getContent() == Constants::$CLIENT_NAME){
                        $clientHeadingCount++;
                        $headingRowNo = $entry->getRow();
                        continue;
                    }

                    //checks whether this cell belongs to the
                    //first set of three reports
                    if($clientHeadingCount == 3 && $entry->getRow()>$headingRowNo && $entry->getRow()<= $headingRowNo+5){
                        if($entry->getColumn()==1 || $entry->getColumn()==2){
                            $firstReport = $helper->addToArray($firstReport, $entry->getColumn(), $entry->getContent(),1,2);
                        }else if($entry->getColumn()==4 || $entry->getColumn()==5){
                            $secondReport = $helper->addToArray($secondReport, $entry->getColumn(), $entry->getContent(),4,5);
                        }else if($entry->getColumn()==7 || $entry->getColumn()==8){
                            $thirdReport = $helper->addToArray($thirdReport, $entry->getColumn(), $entry->getContent(),7,8);
                        }
                    //checks whether this cell belongs to the
                    //second set of three reports
                    }else if($clientHeadingCount == 6 && $entry->getRow()>$headingRowNo && $entry->getRow()<= $headingRowNo+5){
                        if($entry->getColumn()==1 || $entry->getColumn()==2){
                            $fourthReport = $helper->addToArray($fourthReport, $entry->getColumn(), $entry->getContent(),1,2);
                        }else if($entry->getColumn()==4 || $entry->getColumn()==5){
                            $fifthReport = $helper->addToArray($fifthReport, $entry->getColumn(), $entry->getContent(),4,5);
                        }else if($entry->getColumn()==7 || $entry->getColumn()==8){
                            $sixthReport = $helper->addToArray($sixthReport, $entry->getColumn(), $entry->getContent(),7,8);
                        }
                    //checks whether this cell belongs to the
                    //third set of two reports
                    }else if($clientHeadingCount == 8 && $entry->getRow()>$headingRowNo && $entry->getRow()<= $headingRowNo+5){
                        if($entry->getColumn()==1 || $entry->getColumn()==2){
                            $seventhReport = $helper->addToArray($seventhReport, $entry->getColumn(), $entry->getContent(),1,2);
                        }else if($entry->getColumn()==4 || $entry->getColumn()==5){
                            $eighthReport = $helper->addToArray($eighthReport, $entry->getColumn(), $entry->getContent(),4,5);
                        }
                    //checks whether this cell belongs to the
                    //fourth set of two reports
                    }else if($clientHeadingCount == 10 && $entry->getRow()>$headingRowNo && $entry->getRow()<= $headingRowNo+5){
                        if($entry->getColumn()==1 || $entry->getColumn()==2){
                            $ninethReport = $helper->addToArray($ninethReport, $entry->getColumn(), $entry->getContent(),1,2);
                        }else if($entry->getColumn()==4 || $entry->getColumn()==5){
                            $tenthReport = $helper->addToArray($tenthReport, $entry->getColumn(), $entry->getContent(),4,5);
                        }
                    }
                    $previousRow = $entry->getRow();
                    $previousColumn = $entry->getColumn();
                }
                $user = $helper->getUser($ownerName);
                if($user->responseCode==Constants::$RESPONSE_CODE_OK){
                    $userId = $user->returnObject->userId;
                }else{
                    $userId = 0;
                }
                $firstReportValues = $helper->makeSqlValues($summeryValues, $firstReport, $ownerName, $userId,  Constants::$CLIENT_REPLACER,  Constants::$PERCENT_VISITORS_TO_LAST_MONTH_REPLACER,  Constants::$TOP_5_WITH_BIGGEST_INCREASE_IN_VISITORS_REPLACER,  Constants::$USER_REPLACER,Constants::$USER_ID_REPLACER,  Constants::$ZERO_FILL,  Constants::$EMPTY_FILL);
                $secondReportValues = $helper->makeSqlValues($summeryValues, $secondReport, $ownerName,$userId,  Constants::$CLIENT_REPLACER,  Constants::$CPC_DIFF_REPLACER,  Constants::$BIGGEST_INCREASE_IN_CPC_REPLACER,  Constants::$USER_REPLACER,Constants::$USER_ID_REPLACER, Constants::$ZERO_FILL,  Constants::$EMPTY_FILL);
                $thirdReportValues = $helper->makeSqlValues($summeryValues, $thirdReport, $ownerName,$userId,  Constants::$CLIENT_REPLACER,  Constants::$REMAINING_SPENDS_REPLACER,  Constants::$BIGGEST_UNDERSPENDS_REPLACER,  Constants::$USER_REPLACER,Constants::$USER_ID_REPLACER, Constants::$ZERO_FILL,  Constants::$EMPTY_FILL);
                $fourthReportValues = $helper->makeSqlValues($summeryValues, $fourthReport, $ownerName,$userId,  Constants::$CLIENT_REPLACER,  Constants::$PERCENT_VISITORS_TO_LAST_MONTH_REPLACER,  Constants::$WORST_5_WITH_BIGGEST_DECREASE_IN_VISITORS_REPLACER,  Constants::$USER_REPLACER,Constants::$USER_ID_REPLACER, Constants::$ZERO_FILL,  Constants::$EMPTY_FILL);
                $fifthReportValues = $helper->makeSqlValues($summeryValues, $fifthReport, $ownerName,$userId,  Constants::$CLIENT_REPLACER,  Constants::$CPC_DIFF_REPLACER,  Constants::$BEST_DECREASES_IN_CPC_REPLACER,  Constants::$USER_REPLACER,Constants::$USER_ID_REPLACER, Constants::$ZERO_FILL,  Constants::$EMPTY_FILL);
                $sixthReportValues = $helper->makeSqlValues($summeryValues, $sixthReport, $ownerName,$userId,  Constants::$CLIENT_REPLACER,  Constants::$REMAINING_SPENDS_REPLACER,  Constants::$BIGGEST_OVERSPENDS_REPLACER,  Constants::$USER_REPLACER,Constants::$USER_ID_REPLACER, Constants::$ZERO_FILL,  Constants::$EMPTY_FILL);
                $seventhReportValues = $helper->makeSqlValues($summeryValues, $seventhReport, $ownerName,$userId,  Constants::$CLIENT_REPLACER,  Constants::$PERCENT_CONVERSIONS_TO_LAST_MONTH_REPLACER,  Constants::$BIGGEST_GAIN_IN_EXPECTED_CONVERSIONS_REPLACER,  Constants::$USER_REPLACER,Constants::$USER_ID_REPLACER, Constants::$ZERO_FILL,  Constants::$EMPTY_FILL);
                $eighthReportValues = $helper->makeSqlValues($summeryValues, $eighthReport, $ownerName,$userId,  Constants::$CLIENT_REPLACER,  Constants::$CPC_CHANGE_REPLACER,  Constants::$BIGGEST_CHANGE_IN_CPA_REPLACER,  Constants::$USER_REPLACER,Constants::$USER_ID_REPLACER, Constants::$ZERO_FILL,  Constants::$EMPTY_FILL);
                $ninethReportValues = $helper->makeSqlValues($summeryValues, $ninethReport, $ownerName,$userId,  Constants::$CLIENT_REPLACER,  Constants::$PERCENT_CONVERSIONS_TO_LAST_MONTH_REPLACER,  Constants::$WORST_DROP_IN_EXPECTED_CONVERSIONS_REPLACER,  Constants::$USER_REPLACER,Constants::$USER_ID_REPLACER, Constants::$ZERO_FILL,  Constants::$EMPTY_FILL);
                $tenthReportValues = $helper->makeSqlValues($summeryValues, $tenthReport, $ownerName,$userId,  Constants::$CLIENT_REPLACER,  Constants::$CPA_CHANGE_REPLACER,  Constants::$BEST_CHANGE_IN_CPA_REPLACER,  Constants::$USER_REPLACER,Constants::$USER_ID_REPLACER, Constants::$ZERO_FILL,  Constants::$EMPTY_FILL);

                if($summeryReportsSqlValues != ""){
                    if(substr($summeryReportsSqlValues,-1)==','){
                        $summeryReportsSqlValues .= ($firstReportValues!='')?$firstReportValues.',':'';
                    }else{
                        $summeryReportsSqlValues .= ($firstReportValues!='')?','.$firstReportValues.',':'';
                    }
                }
                else{
                    $summeryReportsSqlValues .= ($firstReportValues!='')?$firstReportValues.',':'';
                }
                $summeryReportsSqlValues .= ($secondReportValues!='')?$secondReportValues.',':'';
                $summeryReportsSqlValues .= ($thirdReportValues!='')?$thirdReportValues.',':'';
                $summeryReportsSqlValues .= ($fourthReportValues!='')?$fourthReportValues.',':'';
                $summeryReportsSqlValues .= ($fifthReportValues!='')?$fifthReportValues.',':'';
                $summeryReportsSqlValues .= ($sixthReportValues!='')?$sixthReportValues.',':'';
                $summeryReportsSqlValues .= ($seventhReportValues!='')?$seventhReportValues.',':'';
                $summeryReportsSqlValues .= ($eighthReportValues!='')?$eighthReportValues.',':'';
                $summeryReportsSqlValues .= ($ninethReportValues!='')?$ninethReportValues.',':'';
                $summeryReportsSqlValues .= $tenthReportValues;
            }
        }
    }
}

}  catch (\Exception $ex){
    echo $ex->getMessage(); echo $ex->getCode();
    mail('rdvarmaa@gmail.com', 'Cron finished with error at '.date('d-m-y H:i:s'), $ex->getMessage());
    exit();
}

$r = '';
//$dbObj = new \CustomClasses\dbOperations();

$truncate = $dbObj->exeuteQuery("TRUNCATE TABLE ".Constants::$DAILY_REPORT_TABLE_NAME);
if($truncate->responseCode == Constants::$RESPONSE_CODE_OK){
    echo $truncate->responseMessage;
}else{
    echo $truncate->responseMessage;
}
$r .= $truncate->responseMessage;

$response = $dbObj->exeuteQuery($dailyReportsSql);
if($response->responseCode==Constants::$RESPONSE_CODE_OK){
    echo $response->responseMessage;
}else{
    echo $response->responseMessage;
}

$r .= $response->responseMessage;

$truncate = $dbObj->exeuteQuery("TRUNCATE TABLE ".Constants::$SUMMERY_REPORT_TABLE_NAME);
if($truncate->responseCode == Constants::$RESPONSE_CODE_OK){
    echo $truncate->responseMessage;
}else{
    echo $truncate->responseMessage;
}

$r .= $truncate->responseMessage;

$response = $dbObj->exeuteQuery($summeryReportsSql.$summeryReportsSqlValues);
if($response->responseCode==Constants::$RESPONSE_CODE_OK){
    echo $response->responseMessage;
}else{
    echo $response->responseMessage;
}

$r .= $response->responseMessage;
if(strpos($r, 'Failed')!=false){
    mail('rdvarmaa@gmail.com', 'Cron finished with error at '.date('d-m-y H:i:s'), $r.$dailyReportsSql.$summeryReportsSql.$summeryReportsSqlValues);
}

//echo $dailyReportsSql;
//echo $summeryReportsSql.$summeryReportsSqlValues;