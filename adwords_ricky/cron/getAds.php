<?php
try { 
	logToFile("Get Ads",'START' , $customer);
	
	if($main->updateDailyLimit($customerId)){
	
		$adGroupIds = array();  $adGroupsInaCampaigns = array();

		$adGroups = $main -> getResults("SELECT ad_adgroup_adword_id,ad_campaign_id 
		
		FROM adword_adgroups  WHERE ad_account_id = '$customer' and ad_delete_status<>1  ");
					
		foreach($adGroups as $adGroup){ $adGroupsInaCampaigns[$adGroup->ad_campaign_id][]= $adGroup->ad_adgroup_adword_id ; }
		
		foreach($adGroupsInaCampaigns as $campaignId => $adgroupArray){

			logToFile("Get Ads",'START' ,$campaignId , $customer);
			
			if($main ->updateDailyLimit($customerId)){
			
				$adGroupAds = $services -> GetTextAds($user,$adgroupArray);
		 
				$criterionCount = count($adGroupAds);
				
				logToFile("Get Ads",'Ad Count '.$criterionCount ,$campaignId , $customer);
						
				$balance = $criterionCount % 1000 ;
				
				$criterionCount1 = $criterionCount - $balance  ;
				
				$sql_insert = "INSERT INTO csv (`col1`,`col2`,`col3`,`col4`,`col5`,`col6`,`col7`,`col8`,`col9`,`col10`,`col11`,`col12`,`col13`,`col14`,`col15`,`col16`) VALUES ";
				
				unset($count); $count=0;
				
				foreach($adGroupAds as $adGroupAd){	
		
				//echo "<pre>"; print_r($adGroupAd) ; exit;
 		
					if($adGroupAd->status=='REMOVED') $delete_status = 3;  else $delete_status = 0;	
				
					$ad = $adGroupAd -> ad ;
					$adGroupId = $adGroupAd -> adGroupId ;
								
					$count++; 
					
					$sqlArray[] = $t = "('".$ad->id."','".addslashes($ad->headline)."','".addslashes($ad->description1)."','".addslashes($ad->description2)."','".addslashes($ad->url)."','".addslashes($ad->displayUrl)."','".$adGroupId."','".$adGroupAd->status."','".$delete_status."','".$ad->AdType."','".$ad->devicePreference."','".addslashes($ad->headlinePart1)."','".addslashes($ad->headlinePart2)."','".addslashes($ad->path1)."','".addslashes($ad->path2)."','".addslashes($ad->longHeadline)."')";
						
					if($count % 1000 ==0 || $count-$criterionCount1 == $balance ){
					
						$sql = implode(",",$sqlArray);
							
						$sql = $sql_insert . $sql ;
											
						unset($sqlArray) ; $sqlArray = array();
						
						$insertionResult = $main ->Query($sql);
						
						if($insertionResult){}
						else{}
						unset($sql);				
					}		
				}
			
				$sql = "
			
				UPDATE
					adword_ads	
				INNER JOIN
					csv  
				ON
					adword_ads.ad_ads_adword_id = csv.col1 and
					adword_ads.ad_adgroup_adword_id = csv.col7 and
					adword_ads.ad_campaign_adword_id = '$campaignId'
					
				SET
					adword_ads.ad_ads_adword_id = csv.col1,
					adword_ads.ad_ads_headline = csv.col2,
					adword_ads.ad_ads_description1 = csv.col3,
					adword_ads.ad_ads_description2 = csv.col4,
					adword_ads.ad_ads_url = csv.col5,
					adword_ads.ad_ads_displayUrl = csv.col6,
					adword_ads.ad_adgroup_adword_id = csv.col7,
					adword_ads.ad_ads_adword_status = csv.col8,
					adword_ads.ad_delete_status = csv.col9, 
					adword_ads.ad_ads_type = csv.col10, 
					adword_ads.ad_ads_devicePreference = csv.col11, 
					adword_ads.ad_ads_headlinePart1 = csv.col12, 
					adword_ads.ad_ads_headlinePart2 = csv.col13, 
					adword_ads.ad_ads_path1 = csv.col14, 
					adword_ads.ad_ads_path2 = csv.col15, 
					adword_ads.ad_ads_longHeadline = csv.col16, 
					adword_ads.ad_campaign_adword_id = '$campaignId', 
					adword_ads.ad_account_id = '$customer' ,
					adword_ads.updated_time = NOW()	 
				";
				$update =$main -> Query($sql) ;
				
				logToFile("Get Ads",'Update' ,$update ,$campaignId, $customer);
				
				unset($sql) ;
					
				$sql = "INSERT INTO adword_ads (`ad_ads_adword_id`,`ad_ads_headline`,`ad_ads_description1`,`ad_ads_description2`,`ad_ads_url`,`ad_ads_displayUrl`,`ad_campaign_adword_id`,`ad_adgroup_adword_id`,`ad_ads_adword_status`,`ad_delete_status`,`ad_ads_type`,`updated_time`,`ad_account_id`,ad_ads_devicePreference,ad_ads_headlinePart1,ad_ads_headlinePart2,ad_ads_path1,ad_ads_path2,ad_ads_longHeadline) SELECT  col1, col2 ,col3,col4,col5,col6,'$campaignId',col7,col8,col9,col10,NOW(),'$customer',`col11`,`col12`,`col13`,`col14`,`col15`,`col16` FROM csv WHERE (col1,col7) NOT IN (SELECT ad_ads_adword_id,ad_adgroup_adword_id from adword_ads WHERE ad_campaign_adword_id = '$campaignId' ) ";
				
				$insert =$main -> Query($sql) ;
				
				logToFile("Get Ads",'Insert' ,$insert ,$campaignId, $customer);
				
				unset($sql) ;
				
				$main->Query("truncate `csv`");	
				
				logToFile("Get Ads",'End' ,$campaignId, $customer);
			
				
			}
			else{ logToFile("Get Ads",$campaignId,$customer,'Daily Limit Exceed'); $dailylimitExceed = 1 ;}
		}
		
	
	}
	else{ logToFile("Get Keywords",$customer,'Daily Limit Exceed'); $dailylimitExceed = 1 ;}
}
catch (Exception $e) {

	logToFile("Get Ads",$customer,"ERROR",$e->getCode(),$e->getMessage());
  
}




?>