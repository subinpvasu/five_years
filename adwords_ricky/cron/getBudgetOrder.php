<?php
try { 
//dsfjksjdkf
	logToFile("Get Budget Order",'Start',$customer);	
	
	if($main->updateDailyLimit($customerId)){
	
		$budgetOrders = $services -> getBudgetOrderService($user);
		
		foreach($budgetOrders as $budgetOrder){
			

			$spendingLimit = $budgetOrder -> spendingLimit -> microAmount ;

            if($spendingLimit < 0) {$spendingLimit =0;}
			
			$start = $budgetOrder -> startDateTime ;
			
			$start = date('Y-m-d H:i:s', strtotime($start));
			
			$end = $budgetOrder -> endDateTime ;
			
			$end = date('Y-m-d H:i:s', strtotime($end));
			
			$status = 1 ;
			
			if($end < date('Y-m-d H:i:s')) {$status = 0;}
			
			$fieldArray = array(
			
				'ad_budget_order_adword_id' => $budgetOrder ->id ,
				'ad_budget_order_name' => $budgetOrder ->budgetOrderName ,
				'ad_primary_billing_id' => $budgetOrder ->primaryBillingId ,
				'ad_billing_account_id' => $budgetOrder ->billingAccountId ,
				'ad_billing_account_name' => $budgetOrder ->billingAccountName ,
				'ad_spending_limit' => $spendingLimit ,
				'ad_start_time' => $start ,
				'ad_end_time' => $end ,
				'ad_budget_order_status' => $status ,
				'ad_account_id' => $customer ,
				'ad_po_number' => $budgetOrder ->poNumber ,
				'updated' => date('Y-m-d H:i:s') 
		
			);
						
			if($main->IsDuplicateExist('adword_budget_orders',"ad_budget_order_adword_id='".$budgetOrder ->id."' and ad_account_id ='".$customer."' ")){
				
				
				$update = $main -> Update('adword_budget_orders',$fieldArray ,"ad_budget_order_adword_id='".$budgetOrder ->id."' and ad_account_id ='".$customer."' " );
								
			}
			
			else{
				
				$insert = $main -> Insert('adword_budget_orders',$fieldArray);
				
			}			
	
		}
	}
	else{ logToFile("Get Budget Order",$customer,'Daily Limit Exceed'); $dailylimitExceed = 1 ;}
}
catch (Exception $e) {

	logToFile("Get Budget Order",$customer , "ERROR",$e->getCode(),$e->getMessage());
   
}




?>