<?php
  
try { 
	logToFile("Get Change History",'START' , $customer);
	
	if($main->updateDailyLimit($customerId)){	
			
		$campaignInsertArray = $adgroupInsertArray = array();
		
		$start_date = date("Ymd 000000",strtotime("-1 day"));
		$end_date = date("Ymd 235959",strtotime("-1 day"));
		$date = date("Y-m-d",strtotime("-1 day"));
		
		$changes = $services -> getChangeHistory($user,$start_date,$end_date);	
		
		if (isset($changes)) {
		
			if (isset($changes->changedCampaigns)) {
				
				foreach($changes->changedCampaigns as $campaignChangeData){
				
					$campaignId = $campaignChangeData ->campaignId ;
					$campaignChangeStatus = $campaignChangeData->campaignChangeStatus ;
					$addedCampaignCriteria = $campaignChangeData->addedCampaignCriteria ;
					$removedCampaignCriteria = $campaignChangeData->removedCampaignCriteria ;
					$changedFeeds = $campaignChangeData->changedFeeds ;
					$removedFeeds = $campaignChangeData->removedFeeds ;
					
					if($campaignChangeStatus <> 'FIELDS_UNCHANGED' || count($addedCampaignCriteria) >0 || count($removedCampaignCriteria) >0 || count($changedFeeds) >0 || count($removedFeeds) >0 ) {
		
					$campaignInsertArray[] = "('".$date."','".$customer."','".$campaignId."','".$campaignChangeStatus."','".$services -> ArrayToString($addedCampaignCriteria)."','".$services -> ArrayToString($removedCampaignCriteria)."','".$services -> ArrayToString($changedFeeds)."','".$services -> ArrayToString($removedFeeds)."',NOW(),NOW())";
				
					}
					
					if (isset($campaignChangeData->changedAdGroups)) {
					
						foreach($campaignChangeData->changedAdGroups as $adGroupChangeData){
							
							$adGroupId = $adGroupChangeData ->adGroupId ;
							$adGroupChangeStatus = $adGroupChangeData->adGroupChangeStatus ;
							$changedAds = $adGroupChangeData->changedAds ;
							$changedCriteria = $adGroupChangeData->changedCriteria ;
							$removedCriteria = $adGroupChangeData->removedCriteria ;
							$changedAdGroupBidModifierCriteria = $adGroupChangeData->changedAdGroupBidModifierCriteria ;
							$removedAdGroupBidModifierCriteria = $adGroupChangeData->removedAdGroupBidModifierCriteria ;
							$changedFeeds = $campaignChangeData->changedFeeds ;
							$removedFeeds = $campaignChangeData->removedFeeds ;
							if($adGroupChangeStatus <> 'FIELDS_UNCHANGED' || count($changedAds) >0 || count($changedCriteria) >0 || count($removedCriteria) >0 || count($changedAdGroupBidModifierCriteria) >0 || count($removedAdGroupBidModifierCriteria) >0 || count($changedFeeds) >0  || count($removedFeeds) >0 ) {
								$adgroupInsertArray[] = "('".$date."','".$customer."','".$campaignId."','".$adGroupId."','".$adGroupChangeStatus."','".$services -> ArrayToString($changedAds)."','".$services -> ArrayToString($changedCriteria)."','".$services -> ArrayToString($removedCriteria)."','".$services -> ArrayToString($changedFeeds)."','".$services -> ArrayToString($removedFeeds)."','".$services -> ArrayToString($changedAdGroupBidModifierCriteria)."','".$services -> ArrayToString($removedAdGroupBidModifierCriteria)."',NOW(),NOW())";	
							}
						}
					}
				}
								
				$campaignInsertPart = implode(",",$campaignInsertArray);
				$adgroupInsertPart = implode(",",$adgroupInsertArray);
				
				if(count($campaignInsertArray)>0) {
					
					$campaignInsert = "INSERT INTO `adword_campain_change_history` (`ad_date`, `ad_account_id`, `ad_campaignId`, `ad_campaignChangeStatus`, `ad_addedCampaignCriteria`, `ad_removedCampaignCriteria`, `ad_changedFeeds`, `ad_removedFeeds`, `created_time`, `updated_time`) VALUES ". $campaignInsertPart ;
					
					$insert = $main -> Query($campaignInsert) ;
			
					if($insert){logToFile("Get Adword Change History","Inserted campaign changes" ,$insert , $customer,$date);}
					
					else{ logToFile("Get Adword Change History","None to insert" , $customer,$date);}
				
				}
				else{
					logToFile("Get Adword Campaign Change History","None to insert" , $customer,$date);
				}
				if(count($adgroupInsertArray)>0) {
					
					$adgroupInsert = "INSERT INTO `adword_adgroup_change_history` (`ad_date`, `ad_account_id`, `ad_campaign_id`, `ad_adGroupId`, `ad_adGroupChangeStatus`, `ad_changedAds`, `ad_changedCriteria`, `ad_removedCriteria`, `ad_changedFeeds`, `ad_removedFeeds`, `ad_changedAdGroupBidModifierCriteria`, `ad_removedAdGroupBidModifierCriteria`, `created_time`, `updated_time`) VALUES ".$adgroupInsertPart ;
					
					
					$insert = $main -> Query($adgroupInsert) ;
							
					if($insert){logToFile("Get Adword Change History","Inserted" ,"$insert adgroup changes" , $customer,$date);}
					
					else{ logToFile("Get Adword Change History","None to insert" , $customer,$date);}
			    
				}
				else{
					logToFile("Get Adword Adgroup Change History","None to insert" , $customer,$date);
				}
			}
		}
		
	}
	else{ logToFile("Get Change History",$customer,'Daily Limit Exceed'); $dailylimitExceed = 1 ;}
}
catch (Exception $e) {
	
	if($e->getMessage() == "[CustomerSyncError.TOO_MANY_CHANGES @ selector]") {
	
		$campaignInsert = "INSERT INTO `adword_campain_change_history` (`ad_date`, `ad_account_id`, `created_time`, `updated_time`) VALUES ('$date','$customer',NOW(),NOW())" ;
					
		$insert = $main -> Query($campaignInsert) ;

		if($insert){logToFile("Get Adword Change History","Everything changed" ,$insert , $customer,$date);}
		
		else{ logToFile("Get Adword Change History","None to insert" , $customer,$date);}
		
	}
	else{
		
		logToFile("Get Change History",$customer,"ERROR",$e->getCode(),$e->getMessage());
	
	}
}




?>