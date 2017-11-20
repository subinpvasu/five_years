<?php
try { 

    logToFile("Get Sitelinks",'START' , $customer);
      
	$feedItemIds = array(); $feedIds = array();
	
	if($main->updateDailyLimit($customerId)){ 

		$campaignFeeds = $services -> getCampaignFeedService($user);                  
	
		foreach($campaignFeeds as $campaignFeed){
					
			$feedId = $campaignFeed ->feedId ;
			$campaignId = $campaignFeed ->campaignId ;
			$matchingFunction = $campaignFeed ->matchingFunction ;
			$rhsOperands = $matchingFunction->rhsOperand ;
			
			foreach($rhsOperands as $rhsOperand){
				
				$feedItemId[$campaignId][] = $rhsOperand ->longValue;
				
			}
		}

		foreach($feedItemId as $campaignId => $sitelinks){
		
			$sitelinks = implode(",",$sitelinks);
			
			$sql = "UPDATE adword_campaigns SET ad_sitelinks = '$sitelinks' WHERE ad_campaign_adword_id='".$campaignId."' and ad_account_id = '$customer'";
			
			$main ->Query($sql) ;
		
		}
		unset($feedItemId); 		

		logToFile("Get Sitelinks",'End' , $customer);
	}
	else{ logToFile("Get Sitelinks",$customer,'Daily Limit Exceed'); $dailylimitExceed = 1 ;}	
}
catch (Exception $e) {

	logToFile("Get sitelinks",$customer,"ERROR",$e->getCode(),$e->getMessage());
  
}




?>