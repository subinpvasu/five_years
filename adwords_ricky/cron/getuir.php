<?php
require_once dirname(__FILE__) . '/../includes/init.php';
require_once dirname(__FILE__) . '/../includes/includes.php';

try{
	
	$insertCH = array();

	$sql_mcc_select = "SELECT customerId,prospect_account FROM adword_mcc_accounts WHERE prospect_account <> '10' order by mcc_id asc limit 1 ";

	$res_mcc_selects = $main -> getResults($sql_mcc_select);

	foreach($res_mcc_selects as $res_mcc_select){

		if($res_mcc_select->prospect_account ==0):

			$dbName = DB_DATABASE ;

		else :

			$dbName = DB_DATABASE_PROSPECT ;

		endif;

	$main -> Select($dbName) ;

	$customerId = $res_mcc_select ->customerId ;

	$sql = " select ad_account_adword_id,ad_account_name,ad_user_id from adword_accounts where ad_account_status=1 and ad_delete_status=0 and ad_mcc_id='$customerId' ;";

	$results = $main->getResults($sql);

		foreach($results as $result){

			$ad_account_adword_id = $result->ad_account_adword_id;
			$ad_account_name = $result->ad_account_name;
			
			// change history report generation 
			
			
			$changes = $main -> getChangeHistory($ad_account_adword_id) ;
						
			foreach($changes as $value){
				
				
				$insertCH[] = "('".$ad_account_adword_id."','".addslashes($ad_account_name)."','".$value['campaigns']."','".$value['adgroups']."','".$value['ads']."','".$value['keywords']."','".$value['start']."','".$value['end']."')";
				
			}

			


		}
		
		$insertCHV = implode(",",$insertCH);
		
		$insertCHText =  "INSERT INTO `adword_change_history_reports` (`ad_account_id`, `ad_account_name`, `ad_campaigns`, `ad_adgroups`, `ad_ads`, `ad_keywords`, `ad_start`, `ad_end`) VALUES ".$insertCHV;
		
		if($main->Query($insertCHText)){
			
			$main->Query("DELETE FROM adword_change_history_reports WHERE created_time < '".date("Y-m-d")."';");
		}
		else{
			
		}
		
		echo "Stop ".date("Y-m-d H:i:s")." \t \n" ;

	}
	
}
catch(Exception $e){

	echo "ERROR,".$e->getCode().",".$e->getMessage()."\t \n" ;
	//exit;

}

?>