<?php

try { 

	logToFile("Get Keywords",'START' , $customer);
	
	if($main->updateDailyLimit($customerId)){
	
		$adGroupIds = array();  $adGroupsInaCampaigns = array();

		$adGroups = $main -> getResults("SELECT ad_adgroup_adword_id,ad_campaign_id 
		
		FROM adword_adgroups  WHERE ad_account_id = '$customer' and ad_delete_status<>1  ");
				
		foreach($adGroups as $adGroup){ $adGroupsInaCampaigns[$adGroup->ad_campaign_id][]= $adGroup->ad_adgroup_adword_id ; }
		
		foreach($adGroupsInaCampaigns as $campaignId => $adgroupArray){
			
			logToFile("Get Keywords",'START' ,$campaignId , $customer);
			
			if($main ->updateDailyLimit($customerId)){			
			
				$adGroupCriterions = $services -> GetKeywords($user,$adgroupArray);  
				
				$criterionCount = count($adGroupCriterions);
				if($criterionCount == 1) { /* echo "<pre>"; print_r($adGroupCriterions); echo "</pre>"; */ }

				logToFile("Get Keywords",'Keyword Count '.$criterionCount ,$campaignId , $customer);
										
				$balance = $criterionCount % 1000 ;
				
				$criterionCount1 = $criterionCount - $balance  ;
				
				$sql_insert = "INSERT INTO csv (`col1`,`col2`,`col3`,`col4`,`col5`,`col6`,`col7`,`col8`,`col9`,`col10`) VALUES ";
				
				unset($count); $count=0;
				
				foreach($adGroupCriterions as $adGroupCriterion){
					
					if($adGroupCriterion->userStatus=='REMOVED') $delete_status = 1;  else $delete_status = 0;	
				
					$keyword = $adGroupCriterion -> criterion ;
					$adGroupId = $adGroupCriterion -> adGroupId ;
					$qualityScore = $adGroupCriterion -> qualityInfo ->qualityScore ;
					$bids = $adGroupCriterion -> biddingStrategyConfiguration ->bids ;

					
					$maxCpc = $bidSource = array();
					foreach($bids as $val){

						$maxCpc[] = $val -> bid ->  microAmount ;
						$bidSource[] = $val -> cpcBidSource ; 

					}

					$adMaxCpc = implode(',',$maxCpc);
					$adBidSource = implode(',',$bidSource);

					$count++; 
					
					$sqlArray[] = $t = "('".$keyword->id."','".addslashes($keyword->text)."','".$keyword->matchType."','".$adGroupId."','".$adGroupCriterion->userStatus."','".$delete_status."','".$qualityScore."','".$adMaxCpc."','".$adBidSource."','".$adGroupCriterion->criterionUse."')";
					
					
					if($count % 1000 ==0 || $count-$criterionCount1 == $balance ){
					
						$sql = implode(",",$sqlArray);
							
						$sql = $sql_insert . $sql ;
						
						unset($sqlArray) ; $sqlArray = array();
						
						$insertionResult = $main ->Query($sql);
						
						if($insertionResult){ }
						else{ }
						
						unset($sql);				
					}		
				}
				unset($adGroupCriterions);
				
				$sql = "
			
				UPDATE
					adword_keywords	
				INNER JOIN
					csv  
				ON
					adword_keywords.ad_keyword_adword_id = csv.col1 and
					adword_keywords.ad_adgroup_adword_id = csv.col4 and
					adword_keywords.ad_campaign_adword_id = '$campaignId'
					
				SET
					adword_keywords.ad_keyword_adword_id = csv.col1,
					adword_keywords.ad_keyword_text = csv.col2,
					adword_keywords.ad_keyword_matchtype = csv.col3,
					adword_keywords.ad_adgroup_adword_id = csv.col4,
					adword_keywords.ad_keyword_adword_status = csv.col5,
					adword_keywords.ad_delete_status = csv.col6, 
					adword_keywords.ad_campaign_adword_id = '$campaignId', 
					adword_keywords.ad_account_id = '$customer' ,
					adword_keywords.updated_time = NOW(),	 
					adword_keywords.ad_QualityScore = csv.col7,
					adword_keywords.ad_CpcBid = csv.col8,
					adword_keywords.ad_BidSource = csv.col9,
					adword_keywords.ad_CriterionUse = csv.col10
					
				";
				$update =$main -> Query($sql) ;
				
				logToFile("Get Keywords",'Update' ,$update ,$campaignId, $customer);
				
				unset($sql) ;
					
				$sql = "INSERT INTO adword_keywords (ad_keyword_adword_id,ad_keyword_text,ad_keyword_matchtype,ad_adgroup_adword_id,ad_keyword_adword_status,ad_delete_status,ad_campaign_adword_id,updated_time,ad_QualityScore,ad_CpcBid,ad_BidSource,ad_CriterionUse,ad_account_id) SELECT  col1, col2 ,col3,col4,col5,col6,'$campaignId',NOW(),col7,col8,col9,col10,'$customer' FROM csv WHERE (col1,col4) NOT IN (SELECT ad_keyword_adword_id,ad_adgroup_adword_id from adword_keywords WHERE ad_campaign_adword_id = '$campaignId' and ad_account_id='$customer' ) ";		
				
				$insert =$main -> Query($sql) ;
				
				logToFile("Get Keywords",'Insert' ,$insert ,$campaignId, $customer);
				
				unset($sql) ;
					
				$main->Query("truncate `csv`");	
				
				logToFile("Get Keywords",'End' ,$campaignId, $customer);
			}
			else{ logToFile("Get Keywords",$campaignId,$customer,'Daily Limit Exceed'); $dailylimitExceed = 1 ;}
		}
	}
	else{ logToFile("Get Keywords",$customer,'Daily Limit Exceed'); $dailylimitExceed = 1 ;}	
}
catch (Exception $e) {

logToFile("Get Keywords",$customer,"ERROR",$e->getCode(),$e->getMessage());

  
  
}




?>