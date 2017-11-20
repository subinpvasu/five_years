<?php
//error_reporting(0);
ini_set('max_execution_time', 1200);
ini_set("memory_limit", "1024M");
require_once (dirname(__FILE__).'/../../config/config.php');
if (defined('STDIN')) {
    $master = $argv[1];
    $account = $argv[2];
} else {
    $account = $_REQUEST['account'];
$master = $_REQUEST['master'];
}
$_SESSION['master'] = $master;
$_SESSION['account'] = $account;
//$account = 4329064370;
$sqla = "SELECT adgroupid FROM adgroup_data a INNER JOIN campaign_data c ON a.campaignid=c.campaignid INNER JOIN account_details b ON
		b.account_number=c.customerid WHERE b.account_number=$account AND type!='SHOPPING'";//AND type='SHOPPING',,currency_code,AND type!='SHOPPING'
$sqlb = "SELECT adgroupid FROM adgroup_data a INNER JOIN campaign_data c ON a.campaignid=c.campaignid INNER JOIN account_details b ON
b.account_number=c.customerid WHERE b.account_number=$account AND type='SHOPPING'";//AND type='SHOPPING',currency_code,AND type='SHOPPING'
mail_alert($_SESSION['account'],' 1st sql started',1);		
$resulta = $conn->query($sqla);
$adGroupIda = array();
while($row = $resulta->fetch_object()) {
$adGroupIda[]=$row->adgroupid;

}
mail_alert($_SESSION['account'],' 1st sql ended');
mail_alert($_SESSION['account'],' 2nd sql started');
$resultb = $conn->query($sqlb);
$adGroupIdb = array();
while($row = $resultb->fetch_object()) {
	$adGroupIdb[]=$row->adgroupid;
	
}
mail_alert($_SESSION['account'],' 2nd sql ended');
$flag = false;
$slag = false;
if(count($adGroupIda)>8000)
{
	$flag = true;
}
if(count($adGroupIdb)>8000)
{
	$slag = true;
}
try{
    mail_alert($account, 'sub1 began',1);
$sql = "SELECT campaign_name,adgroup_name,bid,adgroupid FROM adgroup_data WHERE customerid=".$account;
$result = $conn->query($sql);
$adgroup_details = array();
while($row = $result->fetch_object())
{
    $adgroup_details[$row->adgroupid] = array('campaign_name'=>$row->campaign_name,'adgroup_name'=>$row->adgroup_name,'bid'=>$row->bid);
}
mail_alert($account, 'sub2 began',1);
$sql = "SELECT a.campaign_name, a.adgroup_name, c.crbid, c.crname,c.criterionid,a.adgroupid
FROM adgroup_data a
LEFT JOIN criterion_data c ON a.adgroupid = c.adgroupid
WHERE c.customerid=".$account;
$result = $conn->query($sql);
$criterion_details = array();
while($row = $result->fetch_object())
{
    $criterion_details[$row->criterionid.'-'.$row->adgroupid] = array('campaign_name'=>$row->campaign_name,'adgroup_name'=>$row->adgroup_name,'crbid'=>$row->crbid,'crname'=>$row->crname,'crid'=>$row->criterionid);
}
}catch(Exception $e){
    mail_alert($account, $e->getMessage());
}
mail_alert($account, 'Process begun to execution',1);
/* switch($currency)
{
	case 'GBP':
$cur_code = "£";
break;

case 'USD':
$cur_code = "$";
break;

case 'EUR':
$cur_code ="€";
break; 

case 'CAD':
$cur_code = "CA$";
break; 

case 'MAD':
$cur_code = "MAD";
break;

case 'NOK':
$cur_code ="kr";
break;

case 'BRL':
$cur_code = "R$";
break;

case 'DKK':
$cur_code = "kr.";
break;

case 'SAR':
$cur_code = "SAR";
break;

case 'AUD':
$cur_code = "AU$";
break;

case 'HKD':
$cur_code = "HK$";
break;

case 'TRY':
$cur_code = "TRY";
break;

default:
	$cur_code = "$";
	break;
} */


// echo count($adGroupId);
// print_r($adGroupId);
/**
 * This example gets all available keyword bid simulations within an ad group.
 * To get ad groups, run BasicOperation/GetAdGroups.php.
 *
 * Restriction: adwords-only
 *
 * Copyright 2014, Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package    GoogleApiAdsAdWords
 * @subpackage v201509
 * @category   WebServices
 * @copyright  2015, Google Inc. All Rights Reserved.
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License,
 *             Version 2.0
 */

// Include the initialization file
require_once dirname(dirname(__FILE__)) . '/init.php';

/**
 * Runs the example.
 * @param AdWordsUser $user the user to run the example with
 * @param string $adGroupId the id the ad group containing keyword bid
 *     simulations
 */

$csva = "Campaign ID,Campaign Name,Adgroup ID,Adgroup Name,Start Date,End Date,Current Bid,Bid,Clicks,Costs,Impressions\n";
$csvb = "Campaign ID,Campaign Name,Adgroup ID,Adgroup Name,Criterion ID,Criterion Name,Start Date,End Date,Current Bid,Bid,Clicks,Costs,Impressions\n";
$k=0;
$time = time();
$_SESSION['index'] = $account."|".$time."|".date('m/d/Y H:i');
$filea = 'tmp/Bid_Strategy_Generated_'.$time.'_'.$account.'.csv';//1/26/2016 14:30
$fileb = 'tmp/Bid_Strategy_Shopping_'.$time.'_'.$account.'.csv';//1/26/2016 14:30




function GetKeywordBidSimulationsExample(AdWordsUser $user, $adGroupId,$flag,$type=1) {
    mail_alert($_SESSION['account'],'Very start-'.count($adGroupId));
	global $conn,$csva,$csvb,$filea,$fileb,$adgroup_details,$criterion_details;//,$cur_code
	$k=0;$l=0;
  // Get the service, which loads the required classes.
  $dataService = $user->GetService('DataService', ADWORDS_VERSION);
  mail_alert($_SESSION['account'],'DataService call end');

  // Create selector.
  $selector = new Selector();
  if($type==1)
  { mail_alert($_SESSION['account'],'type 1');
			$_SESSION['bid_statusa']=0;
			if($flag)
			{
			    mail_alert($_SESSION['account'],'flag');
				$len = count($adGroupId);
				$part = 8000;
				$seg = 8000;
				$count = ceil($len/8000);
				for($i=0;$i<$count;$i++)
				{
				    mail_alert($_SESSION['account'],'for loop a '.$i);
				    
						$selector->fields = array('CampaignId','AdGroupId', 'StartDate', 'EndDate','Bid', 'LocalClicks', 'LocalCost', 'LocalImpressions');
						// Create predicates.
						$selector->predicates[] = new Predicate('AdGroupId', 'IN', array_slice($adGroupId, $i*$part, $seg));
						// Create paging controls.
						$selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
						mail_alert($_SESSION['account'],'while loop aa');
						do{
						   
						    
							// Make the getCriterionBidLandscape request.
							$page = $dataService->getAdGroupBidLandscape($selector);
							mail_alert($_SESSION['account'],'Adgroup bid lanscape request end');
							// $page = $dataService->getCriterionBidLandscape($selector);
							// Display results.
							if (isset($page->entries)) {
								//print_r($page->entries);
							    	foreach ($page->entries as $bidLandscape) {
								    mail_alert($_SESSION['account'],'First foreach');
									$campaignid = $bidLandscape->campaignId;
									$adgroupid = $bidLandscape->adGroupId;
									$criterionid =  $bidLandscape->criterionId;
									$startdate = $bidLandscape->startDate;
									$enddate = $bidLandscape->endDate;
									foreach ($bidLandscape->landscapePoints as $bidLandscapePoint) {
									    mail_alert($_SESSION['account'],'Second foreach');
// 										$sql = "SELECT campaign_name,adgroup_name,bid FROM adgroup_data WHERE adgroupid=$bidLandscape->adGroupId";
// 										mail_alert($_SESSION['account'],'sql started');
// 										$result = $conn->query($sql);
// 										$obj=mysqli_fetch_object($result);
// 										mail_alert($_SESSION['account'],'sql ended');
										$cost = $bidLandscapePoint->cost->microAmount/1000000;
										//$cost = $cur_code.$cost;
										$bid  = number_format($bidLandscapePoint->bid->microAmount/1000000,2);
										//$bid  = $cur_code.$bid;
										$cbid = number_format($adgroup_details[$bidLandscape->adGroupId]['bid']/1000000,2);
										//$csv .= "%s,$obj->campaign_name,%s,$obj->adgroup_name,%s,%s,%.0f,%d,%.0f,%d, $bidLandscape->campaignId,$bidLandscape->adGroupId,$bidLandscape->startDate,$bidLandscape->endDate,$bidLandscapePoint->bid->microAmount,$bidLandscapePoint->clicks,$bidLandscapePoint->cost->microAmount,$bidLandscapePoint->impressions\n";
										$csva .= sprintf("%s,".$adgroup_details[$bidLandscape->adGroupId]['campaign_name'].",%s,".$adgroup_details[$bidLandscape->adGroupId]['adgroup_name'].",%s,%s,".$cbid.",".$bid.",%d,".$cost.",%d", $bidLandscape->campaignId,$bidLandscape->adGroupId,$bidLandscape->startDate,$bidLandscape->endDate,$bidLandscapePoint->clicks,$bidLandscapePoint->impressions);
										$csva .= "\n";
										$k++;
									}
								}
							}else {
							    mail_alert($_SESSION['account'],'no bid landscape',1);
							}
							// Advance the paging index.
							$selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
						} while (isset($page->entries) && count($page->entries) > 0);
				}
				
			}
			else
			{
			    mail_alert($_SESSION['account'],'!flag');
				$selector->fields = array('CampaignId','AdGroupId', 'StartDate', 'EndDate','Bid', 'LocalClicks', 'LocalCost', 'LocalImpressions');
				// Create predicates.
				$selector->predicates[] = new Predicate('AdGroupId', 'IN', $adGroupId);
				// Create paging controls.
				$selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
				do{
				    mail_alert($_SESSION['account'],'while loop a');
					// Make the getCriterionBidLandscape request.
					try{
					$page = $dataService->getAdGroupBidLandscape($selector);
					}catch(Exception $e)
					{
					    mail_alert($_SESSION['account'],$e->getMessage());
					}
					// $page = $dataService->getCriterionBidLandscape($selector);
					// Display results.
					if (isset($page->entries)) {
					//print_r($page->entries);
					    mail_alert($_SESSION['account'],$page->entries);
					foreach ($page->entries as $bidLandscape) {
					    mail_alert($_SESSION['account'],'First foreach');
							$campaignid = $bidLandscape->campaignId;
							$adgroupid = $bidLandscape->adGroupId;
							$criterionid =  $bidLandscape->criterionId;
							$startdate = $bidLandscape->startDate;
							$enddate = $bidLandscape->endDate;
							foreach ($bidLandscape->landscapePoints as $bidLandscapePoint) {
							    mail_alert($_SESSION['account'],'Second foreach');
// 								$sql = "SELECT campaign_name,adgroup_name,bid FROM adgroup_data WHERE adgroupid=$bidLandscape->adGroupId";
// 								mail_alert($_SESSION['account'],'Sql started');
// 								$result = $conn->query($sql);
// 								mail_alert($_SESSION['account'],'Sql ended');
// 								$obj=mysqli_fetch_object($result);
// 								mail_alert($_SESSION['account'],'sql object fetch');
								$cost = $bidLandscapePoint->cost->microAmount/1000000;
								//$cost = $cur_code.$cost;
								$bid  = number_format($bidLandscapePoint->bid->microAmount/1000000,2);
								//$bid  = $cur_code.$bid;
								$cbid = number_format($adgroup_details[$bidLandscape->adGroupId]['bid']/1000000,2);
								//$csv .= "%s,$obj->campaign_name,%s,$obj->adgroup_name,%s,%s,%.0f,%d,%.0f,%d, $bidLandscape->campaignId,$bidLandscape->adGroupId,$bidLandscape->startDate,$bidLandscape->endDate,$bidLandscapePoint->bid->microAmount,$bidLandscapePoint->clicks,$bidLandscapePoint->cost->microAmount,$bidLandscapePoint->impressions\n";
								$csva .= sprintf("%s,".$adgroup_details[$bidLandscape->adGroupId]['campaign_name'].",%s,".$adgroup_details[$bidLandscape->adGroupId]['adgroup_name'].",%s,%s,".$cbid.",".$bid.",%d,".$cost.",%d", $bidLandscape->campaignId,$bidLandscape->adGroupId,$bidLandscape->startDate,$bidLandscape->endDate,$bidLandscapePoint->clicks,$bidLandscapePoint->impressions);
								$csva .= "\n";
								$k++;
								mail_alert($_SESSION['account'],'Second foreach end');
							}
							mail_alert($_SESSION['account'],'First foreach end');
						}
					}
					else
					{
					
							    mail_alert($_SESSION['account'],'no bid landscape',1);
							
					}
				// Advance the paging index.
				$selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
				} while (isset($page->entries) && count($page->entries) > 0);
			}
			if($k>0)
			{
			    mail_alert($_SESSION['account'],'doc a ready-'.$k,1);
			  $fd = fopen ('/home/omnitailtools/public_html/omnitail/cron/'.$filea, "w");
			  fputs($fd, $csva);
			}
			  $_SESSION['bid_statusa']=$k;
			  if ($selector->paging->startIndex === 0) {
			      mail_alert($_SESSION['account'],'no doc a',1);
			    print "No criterion bid landscapes were found.\n";
			  }
	}
	else
	{
		$_SESSION['bid_statusb']=0;
		
		if($flag)
		{mail_alert($_SESSION['account'],'flagb');
			$len = count($adGroupId);
			$part = 8000;
			$seg = 8000;
			$count = ceil($len/8000);
			for($i=0;$i<$count;$i++)
			{
			    mail_alert($_SESSION['account'],'for loop b'.$i);
				$selector->fields = array('CampaignId','AdGroupId', 'StartDate','CriterionId', 'EndDate','Bid', 'LocalClicks', 'LocalCost', 'LocalImpressions');
				// Create predicates.
				$selector->predicates[] = new Predicate('AdGroupId', 'IN', array_slice($adGroupId, $i*$part, $seg));
				// Create paging controls.
				$selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
				do{
				    mail_alert($_SESSION['account'],'while lopp b');
					// Make the getCriterionBidLandscape request.
					//$page = $dataService->getAdGroupBidLandscape($selector);
					$page = $dataService->getCriterionBidLandscape($selector);
					mail_alert($_SESSION['account'],'Criterion bid landscape api end');
					// Display results.
					if (isset($page->entries)) {
						//print_r($page->entries);
						foreach ($page->entries as $bidLandscape) {
						    mail_alert($_SESSION['account'],'First foreach');
							$campaignid = $bidLandscape->campaignId;
							$adgroupid = $bidLandscape->adGroupId;
							$criterionid =  $bidLandscape->criterionId;
							$startdate = $bidLandscape->startDate;
							$enddate = $bidLandscape->endDate;
							foreach ($bidLandscape->landscapePoints as $bidLandscapePoint) {
							    mail_alert($_SESSION['account'],'Second foreach');
								//$sql = "SELECT campaign_name,adgroup_name,bid,crname FROM adgroup_data WHERE adgroupid=$bidLandscape->adGroupId";
// 								$sql = "SELECT a.campaign_name, a.adgroup_name, c.crbid, c.crname
// FROM adgroup_data a
// LEFT JOIN criterion_data c ON a.adgroupid = c.adgroupid
// WHERE a.adgroupid =".$adgroupid." AND a.campaignid=".$campaignid." AND c.criterionid=".$criterionid;
// 								mail_alert($_SESSION['account'],'sql started');
// 								$result = $conn->query($sql);
// 								$obj=mysqli_fetch_object($result);
// 								mail_alert($_SESSION['account'],'sql ended');
								
								$cost = $bidLandscapePoint->cost->microAmount/1000000;
								//$cost = $cur_code.$cost;
								$bid  = number_format($bidLandscapePoint->bid->microAmount/1000000,2);
								//$bid  = $cur_code.$bid;
								$crbid = number_format($criterion_details[$criterionid.'-'.$adgroupid]['crbid']/1000000,2);
								$name = $criterion_details[$criterionid.'-'.$adgroupid]['crname'];
								//$csv .= "%s,$obj->campaign_name,%s,$obj->adgroup_name,%s,%s,%.0f,%d,%.0f,%d, $bidLandscape->campaignId,$bidLandscape->adGroupId,$bidLandscape->startDate,$bidLandscape->endDate,$bidLandscapePoint->bid->microAmount,$bidLandscapePoint->clicks,$bidLandscapePoint->cost->microAmount,$bidLandscapePoint->impressions\n";
								$csvb .= sprintf("%s,".$criterion_details[$criterionid.'-'.$adgroupid]['campaign_name'].",%s,".$criterion_details[$criterionid.'-'.$adgroupid]['adgroup_name'].",".$criterionid.",".$name.",%s,%s,".$crbid.",".$bid.",%d,".$cost.",%d", $bidLandscape->campaignId,$bidLandscape->adGroupId,$bidLandscape->startDate,$bidLandscape->endDate,$bidLandscapePoint->clicks,$bidLandscapePoint->impressions);
								$csvb .= "\n";
								$l++;
								mail_alert($_SESSION['account'],'Second foreach ended');
							}
							mail_alert($_SESSION['account'],'First foreach ended');
						}
					}else {
							    mail_alert($_SESSION['account'],'no bid landscape - Shopping',1);
							}
					// Advance the paging index.
					$selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
				} while (isset($page->entries) && count($page->entries) > 0);//isset($page->entries) && count($page->entries) > 0-$page->totalNumEntries > $selector->paging->startIndex
			}
		}
		else 
		{
		    mail_alert($_SESSION['account'],'Flag <8000');
			$selector->fields = array('CampaignId','AdGroupId', 'StartDate','CriterionId', 'EndDate','Bid', 'LocalClicks', 'LocalCost', 'LocalImpressions');
			// Create predicates.
			$selector->predicates[] = new Predicate('AdGroupId', 'IN', $adGroupId);
			// Create paging controls.
			$selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
			do{
			    mail_alert($_SESSION['account'],'while lopp bb');
				// Make the getCriterionBidLandscape request.
				//$page = $dataService->getAdGroupBidLandscape($selector);
				$page = $dataService->getCriterionBidLandscape($selector);
				mail_alert($_SESSION['account'],'Get criterion bid landscape');
				// Display results.
				if (isset($page->entries)) {
					//print_r($page->entries);
					foreach ($page->entries as $bidLandscape) {
					    mail_alert($_SESSION['account'],'First foreach');
						$campaignid = $bidLandscape->campaignId;
						$adgroupid = $bidLandscape->adGroupId;
						$criterionid =  $bidLandscape->criterionId;
						$startdate = $bidLandscape->startDate;
						$enddate = $bidLandscape->endDate;
						
						foreach ($bidLandscape->landscapePoints as $bidLandscapePoint) {
						    mail_alert($_SESSION['account'],'Second foreach');
							//$sql = "SELECT campaign_name,adgroup_name,bid,crname FROM adgroup_data WHERE adgroupid=$bidLandscape->adGroupId";
// 							$sql = "SELECT a.campaign_name, a.adgroup_name, c.crbid, c.crname
// FROM adgroup_data a
// LEFT JOIN criterion_data c ON a.adgroupid = c.adgroupid
// WHERE a.adgroupid =".$adgroupid." AND a.campaignid=".$campaignid;//." AND c.criterionid=".$criterionid
// 							mail_alert($_SESSION['account'],'sql started');
// 							$result = $conn->query($sql);
// 							$obj=mysqli_fetch_object($result);
// 							mail_alert($_SESSION['account'],'sql ended');
							$cost = $bidLandscapePoint->cost->microAmount/1000000;
							//$cost = $cur_code.$cost;
							$bid  = number_format($bidLandscapePoint->bid->microAmount/1000000,2);
							//$bid  = $cur_code.$bid;
							$crbid = number_format($criterion_details[$criterionid.'-'.$adgroupid]['crbid']/1000000,2);
							$name = $criterion_details[$criterionid.'-'.$adgroupid]['crname'];
							//$csv .= "%s,$obj->campaign_name,%s,$obj->adgroup_name,%s,%s,%.0f,%d,%.0f,%d, $bidLandscape->campaignId,$bidLandscape->adGroupId,$bidLandscape->startDate,$bidLandscape->endDate,$bidLandscapePoint->bid->microAmount,$bidLandscapePoint->clicks,$bidLandscapePoint->cost->microAmount,$bidLandscapePoint->impressions\n";
							$csvb .= sprintf("%s,".$criterion_details[$criterionid.'-'.$adgroupid]['campaign_name'].",%s,".$criterion_details[$criterionid.'-'.$adgroupid]['adgroup_name'].",".$criterionid.",".$name.",%s,%s,".$crbid.",".$bid.",%d,".$cost.",%d", $bidLandscape->campaignId,$bidLandscape->adGroupId,$bidLandscape->startDate,$bidLandscape->endDate,$bidLandscapePoint->clicks,$bidLandscapePoint->impressions);
							$csvb .= "\n";
							$l++;
							mail_alert($_SESSION['account'],'Second foreach ended');
						}
						mail_alert($_SESSION['account'],'First foreach ended');
					}
				}
				else {
				    mail_alert($_SESSION['account'],'no bid landscape - Shopping',1);
				}
				// Advance the paging index.
				$selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
			} while (isset($page->entries) && count($page->entries) > 0);
		}
		
		if($l>0)
		{
		    mail_alert($_SESSION['account'],'doc b ready-'.$l,1);
			$fd = fopen ('/home/omnitailtools/public_html/omnitail/cron/'.$fileb, "w");
			fputs($fd, $csvb);
		}
		$_SESSION['bid_statusb']=$l;
		if ($selector->paging->startIndex === 0) {
		    mail_alert($_SESSION['account'],'no doc b',1);
			print "No criterion bid landscapes were found.\n";
		}
	}
	mail_alert($_SESSION['account'],'Very end');
}



// Don't run the example if the file is being included.
// if (__FILE__ != realpath($_SERVER['PHP_SELF'])) {
//   return;
// }
function mail_alert($key,$position,$flag=0)
{
//     $msg = $position . " Account - ".$key;
    
//     // use wordwrap() if lines are longer than 70 characters
//     $msg = wordwrap($msg,70);
    
//     // send email
//     mail("subinpvasu@gmail.com","alert @ ".date("l jS \of F Y h:i:s A"),$msg);
    global $conn;
    $val = $position . " Account id - ".$key;
$sql = "INSERT INTO test_tbl (text) VALUES ('$val')";
if($flag==1)
{
$conn->query($sql);
}
}
function first_mail($key)
{
    global $conn;
    $val = "Process started in Account id - ".$key;
    $sql = "INSERT INTO test_tbl (text) VALUES ('$val')";
    $conn->query($sql);
//     // the message
//     $msg = "First line of text\nSecond line of text -".$key;
    
//     // use wordwrap() if lines are longer than 70 characters
//     $msg = wordwrap($msg,70);
    
//     // send email
//     mail("subinpvasu@gmail.com","My subject",$msg);
}
function last_mail($key)
{
    global $conn;
    $val = "Process ended in Account id - ".$key;
    $sql = "INSERT INTO test_tbl (text) VALUES ('$val')";
    $conn->query($sql);
    // the message
//     $msg = "Last line of text\nSecond line of text -".$key;
    
//     // use wordwrap() if lines are longer than 70 characters
//     $msg = wordwrap($msg,70);
    
//     // send email
//     mail("subinpvasu@gmail.com","My subject",$msg);
}
try {
  // Get AdWordsUser from credentials in "../auth.ini"
  // relative to the AdWordsUser.php file's directory.
  first_mail($account);
  mail_alert($account, 'beginning');
    $sql = "SELECT refresh_token FROM prospect_credentials WHERE account_number='$master'";
    $result = $conn->query($sql);
    $obj=mysqli_fetch_object($result);
    $oauth2Infos = array(
        "client_id" => $clientId,
        "client_secret" => $clientSecret,
        "refresh_token" => $obj->refresh_token
    );
	$user = new AdWordsUser(NULL,$developerToken,$userAgent,NULL,NULL,$oauth2Infos);
	$user->SetClientCustomerId($account);
	//$user = new AdWordsUser ();

  // Log every SOAP XML request and response.
  //$user->LogAll();

  // Run the example.
  if(count($adGroupIdb)>0){
      mail_alert($account, 'first bid');
      GetKeywordBidSimulationsExample($user, $adGroupIdb,$slag,0);}
  if(count($adGroupIda)>0){
      mail_alert($account, 'second bid');
      GetKeywordBidSimulationsExample($user, $adGroupIda,$flag,1);}
      mail_alert($account, 'End',1);
  last_mail($account);
  
 
} catch (Exception $e) {
  printf("An error has occurred: %s\n", $e->getMessage());
}
