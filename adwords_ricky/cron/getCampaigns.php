<?php
try { 
//dsfjksjdkf
	logToFile("Get Campaigns",'Start',$customer);	
	
	if($main->updateDailyLimit($customerId)){
	
		$campaigns = $services -> GetCampaigns($user);
		
		$main->Query("truncate `csv`");
	
		$sql_insert = "INSERT INTO csv (`col1`,`col2`,`col3`,`col4`,`col5`,`col6`) VALUES ";
	
		$criterionCount = count($campaigns);
	
		$balance = $criterionCount % 1000 ;

		$criterionCount1 = $criterionCount - $balance  ;
 
		$count =0; $sqlArray = array();

		foreach($campaigns as $campaign){

			$amount = $campaign -> budget -> amount -> microAmount ;

			if($campaign->status=='REMOVED') $delete_status = 3;
			else $delete_status = 0;
		
			$count++;
		
			$sqlArray[]=$t = "('".$campaign->id."','".addslashes($campaign->name)."','".$campaign->status."','".$campaign->eligible."','".$delete_status."','".$amount."')";

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
			adword_campaigns 		
		INNER JOIN
			csv  
		ON
			adword_campaigns.ad_campaign_adword_id = csv.col1 and
			adword_campaigns.ad_account_id = '$customer' 
		SET
			adword_campaigns.ad_campaign_adword_id = csv.col1,
			adword_campaigns.ad_campaign_name = csv.col2,
			adword_campaigns.ad_campaign_adword_status = csv.col3,
			adword_campaigns.ad_campaign_adword_eligible = csv.col4,
			adword_campaigns.ad_budget = csv.col6,
			adword_campaigns.ad_delete_status = csv.col5, 
			adword_campaigns.updated_time = NOW()	 
		";
		
		$update =$main -> Query($sql) ;
			
		logToFile("Get Campaigns",'Update' ,$update ,$customer);
		
		unset($sql) ;
			
		$sql = "INSERT INTO adword_campaigns (ad_campaign_adword_id,ad_campaign_name,ad_campaign_adword_status,ad_campaign_adword_eligible,ad_delete_status,ad_budget,ad_account_id,updated_time) SELECT  col1, col2 ,col3,col4,col5,col6,'$customer',NOW() FROM csv WHERE col1 NOT IN (SELECT ad_campaign_adword_id from adword_campaigns )";
		
		$insert =$main -> Query($sql) ;
		
		logToFile("Get Campaigns",'Insert' ,$insert ,$customer);
				
		unset($sql) ;
				
	//	$main->Query("truncate `csv`");	
		
		logToFile("Get Campaigns",'End' ,$customer);		
	
	}
	else{ logToFile("Get Campaigns",$customer,'Daily Limit Exceed'); $dailylimitExceed = 1 ;}
}
catch (Exception $e) {

	logToFile("Get Campaigns",$customer , "ERROR",$e->getCode(),$e->getMessage());
   
}




?>