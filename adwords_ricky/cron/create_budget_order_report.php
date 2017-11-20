<?php 
	$insertCH = array();
	logToFile($customer,"CREATE BUDGET ORDER REPORT","START",$customerId);
	$budget_order = $main -> getBudgetOrder($customerId);
	
	foreach($budget_order as $bo){
				
		$insertCH[] = "('".$bo->ad_budget_order_adword_id."','".addslashes($bo->ad_budget_order_name)."','".$bo->ad_po_number."','".$bo->ad_billing_account_id."','".addslashes($bo->ad_billing_account_name)."','".addslashes($bo->ad_account_company)."','".$bo->ad_primary_billing_id."','".$bo->ad_start_time."','".$bo->ad_end_time."','".$bo->ad_budget_order_status."','".addslashes($bo->ad_account_name)."','".$bo->ad_account_id."','".$bo->ad_spending_limit."','".$bo->spent."','".$bo->ad_user_id."','".$bo->ad_currency_code."',NOW(),NOW(),'$customerId')";
	}
	
	$insertCHV = implode(",",$insertCH);
		
	$insertCHText =  "INSERT INTO `adword_budget_order_reports` (`ad_budget_order_adword_id`, `ad_budget_order_name`, `ad_po_number`, `ad_billing_account_id`, `ad_billing_account_name`, `ad_account_company`, `ad_primary_billing_id`, `ad_start_time`, `ad_end_time`, `ad_budget_order_status`, `ad_account_name`, `ad_account_id`, `ad_spending_limit`, `ad_spent`, `ad_user_id`, `ad_currency_code`, `created_time`, `updated_time`,`ad_mcc_id`) VALUES ".$insertCHV;
	
	if($insert = $main->Query($insertCHText)){
		logToFile($customer,"CREATE BUDGET ORDER REPORT","SUCCESS","INSERT DB",$insert);
		$delete = $main->Query("DELETE FROM adword_budget_order_reports WHERE created_time < '".date("Y-m-d")."' AND `ad_mcc_id` ='$customerId';");
		logToFile($customer,"CREATE BUDGET ORDER REPORT","SUCCESS","DELETE DB",$delete);
	}
	else{
		logToFile($customer,"CREATE BUDGET ORDER REPORT","FAILED","INSERT DB");
	}
	logToFile($customer,"CREATE BUDGET ORDER REPORT","END",$customerId);
	
?>