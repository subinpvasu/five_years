<?php
  
try { 
	logToFile("Get Adgroups",'START' , $customer);
	
	if($main->updateDailyLimit($customerId)){	
		
		$campaignIds = array(); 
	
		// selecting all enabled campaignes
		$campaigns = $main -> getResults("SELECT ad_campaign_adword_id
	
		FROM adword_campaigns a 
	
		WHERE ad_delete_status <> 1 and ad_account_id = '$customer'"); 	
	
		foreach($campaigns as $campaign){ $campaignIds[] =  $campaign->ad_campaign_adword_id ;  }
	
		$adgroups = $services -> GetAdGroups($user,$campaignIds);	
					
		$main->Query("truncate `csv`");
		
		$sql_insert = "INSERT INTO csv (`col1`,`col2`,`col3`,`col4`,`col5`) VALUES ";
		
		$criterionCount = count($adgroups); 

		$balance = $criterionCount % 1000 ;

		$criterionCount1 = $criterionCount - $balance  ;
		
		$count =0; $sqlArray = array(); 
		
		foreach($adgroups as $adgroup){
					
			if($adgroup->status=='REMOVED') $delete_status = 3;
			
			else $delete_status = 0;

			$count++;
			
			$sqlArray[] = $t = "('".$adgroup->id."','".addslashes($adgroup->name)."','".$adgroup->campaignId."','".$adgroup->status."','".$delete_status."')"; 
			 
			if($count % 1000 ==0 || $count-$criterionCount1 == $balance ){
					
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
		
		unset($adgroups);
		
		$sql = "
		
			UPDATE
				adword_adgroups 
				
			INNER JOIN
				csv  
			ON
				adword_adgroups.ad_adgroup_adword_id = csv.col1 and
				adword_adgroups.ad_campaign_id = csv.col3 and 
				adword_adgroups.ad_account_id = '$customer'
				
			SET
				adword_adgroups.ad_adgroup_adword_id = csv.col1,
				adword_adgroups.ad_adgroup_name = csv.col2,
				adword_adgroups.ad_campaign_id = csv.col3,
				adword_adgroups.ad_adgroup_adword_status = csv.col4, 
				adword_adgroups.ad_delete_status = csv.col5,		
				adword_adgroups.updated_time = NOW()	 
			";
			
		$update =$main -> Query($sql) ;
			
		logToFile("Get Adgroups",'Update' ,$update ,$customer);
			
		unset($sql) ;
		
		$sql = "INSERT INTO adword_adgroups (ad_adgroup_adword_id,ad_adgroup_name,ad_campaign_id,ad_adgroup_adword_status,ad_delete_status,ad_account_id,updated_time) SELECT  col1, col2 ,col3,col4,col5,'$customer',NOW() FROM csv WHERE (col1,col3) NOT IN (SELECT ad_adgroup_adword_id,ad_campaign_id from adword_adgroups )";
		
		$insert =$main -> Query($sql) ;
		
		logToFile("Get Adgroups",'Insert' ,$update ,$customer);
				
		$main->Query("truncate `csv`");	
		
		unset($str); $str ="";
		
		logToFile("Get Adgroups",'END' ,$customer);
	
	}
	else{ logToFile("Get Adgroups",$customer,'Daily Limit Exceed'); $dailylimitExceed = 1 ;}
}
catch (Exception $e) {

	logToFile("Get Adgroups",$customer,"ERROR",$e->getCode(),$e->getMessage());
}




?>