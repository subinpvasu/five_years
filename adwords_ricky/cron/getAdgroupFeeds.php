<?php

try { 
//dsfjksjdkf
	logToFile("Get ADGROUP FEEDS",'Start',$customer);	
	
	if($main->updateDailyLimit($customerId)){
	
		$adgroupFeeds = $services -> getFeedItemService($user);
		
		$main->Query("truncate `csv`");
	
		$sql_insert = "INSERT INTO csv (`col1`,`col2`,`col3`,`col4`,`col5`,`col6`) VALUES ";
	
		$criterionCount = count($adgroupFeeds);
	
		$balance = $criterionCount % 1000 ;

		$criterionCount1 = $criterionCount - $balance  ;
 
		$count =0; $sqlArray = array();

		foreach($adgroupFeeds as $adgroupFeed){

		
			$count++;
		
			$sqlArray[]=$t = "('".$adgroupFeed -> feedId."','".$adgroupFeed -> feedItemId."','".$adgroupFeed -> status."','".$adgroupFeed -> devicePreference ->devicePreference."','".$adgroupFeed ->campaignTargeting -> TargetingCampaignId."','".$adgroupFeed ->adGroupTargeting -> TargetingAdGroupId."')";

			if( $count % 1000 ==0  || $count-$criterionCount1 == $balance ){
					
				$sql = implode(",",$sqlArray);
			
				$sql = $sql_insert . $sql ;  			
						
				unset($sqlArray) ; $sqlArray = array();
			
				$insertionResult = $main ->Query($sql);
				
				if($insertionResult){
							
				}
				else{
				
				}
			
			unset($sql);					
			}	
		}
		
		unset($campaigns);
	
		$sql = "
		
		UPDATE
			adword_adgroup_feeds 		
		INNER JOIN
			csv  
		ON
			adword_adgroup_feeds.ad_feedItemId = csv.col2 and
			adword_adgroup_feeds.ad_account_id = '$customer' 
		SET
			adword_adgroup_feeds.ad_feedId = csv.col1,
			adword_adgroup_feeds.ad_feedItemId = csv.col2,
			adword_adgroup_feeds.ad_status = csv.col3,
			adword_adgroup_feeds.ad_devicePreference = csv.col4,
			adword_adgroup_feeds.ad_TargetingCampaignId = csv.col6,
			adword_adgroup_feeds.ad_TargetingAdGroupId = csv.col5, 
			adword_adgroup_feeds.updated = NOW()	 
		";
		
		$update =$main -> Query($sql) ;
			
		logToFile("Get ADGROUP FEEDS",'Update' ,$update ,$customer);
		
		unset($sql) ;
			
		$sql = "INSERT INTO adword_adgroup_feeds (ad_feedId,ad_feedItemId,ad_status,ad_devicePreference,ad_TargetingCampaignId,ad_TargetingAdGroupId,ad_account_id,updated) SELECT  col1, col2 ,col3,col4,col5,col6,'$customer',NOW() FROM csv WHERE col2 NOT IN (SELECT ad_feedItemId from adword_adgroup_feeds where ad_account_id='$customer')";
		
		$insert =$main -> Query($sql) ;
		
		logToFile("Get ADGROUP FEEDS",'Insert' ,$insert ,$customer);
				
		unset($sql) ;
				
	//	$main->Query("truncate `csv`");	
		
		logToFile("Get ADGROUP FEEDS",'End' ,$customer);		
	
	}
	else{ logToFile("Get ADGROUP FEEDS",$customer,'Daily Limit Exceed'); $dailylimitExceed = 1 ;}
}
catch (Exception $e) {

	logToFile("Get ADGROUP FEEDS",$customer , "ERROR",$e->getCode(),$e->getMessage());
   
}




?>


