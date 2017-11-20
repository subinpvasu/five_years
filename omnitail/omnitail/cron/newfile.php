<?php 
require_once ('../../config/config.php');
require_once dirname(dirname(__FILE__)) . '/init.php';

function GetAccountBudgets(AdWordsUser $user)
{
    global $conn;
    //add code todownload the budget
    
    $budgetService = $user->GetService ( 'BudgetService', ADWORDS_VERSION );
   $budget_id = array();
    // Get an array of all campaign ids.
   
    $selector = new Selector ();
    $selector->fields = array (
        'Amount','BudgetId','BudgetName','BudgetReferenceCount','BudgetStatus','DeliveryMethod','IsBudgetExplicitlyShared'
    );
    $selector->predicates[] = new Predicate('BudgetReferenceCount', 'EQUALS', 0);
    $selector->predicates[] = new Predicate('BudgetStatus', 'EQUALS', 'ENABLED');
    $selector->paging = new Paging ( 0, AdWordsConstants::RECOMMENDED_PAGE_SIZE );
    $i=0;
    echo '<pre>';
    do {
       
        $page = $budgetService->get ( $selector );
        if (isset ( $page->entries )) {
            print_r($page->entries);
            foreach ( $page->entries as $budget ) {
                
                $i++;
                //$budget_id[] = $budget->budgetId;
                try{
                    $budgets = new Budget();
                    $budgets->budgetId = $budget->budgetId;
                    $operations = array();
                
                    // Create operation.
                    $operation = new BudgetOperation();
                    $operation->operand = $budgets;
                    $operation->operator = 'REMOVE';
                    $operations[] = $operation;
                
                    $result = $budgetService->mutate($operations);
                    
                }
                catch(Exception $e)
                {
                    echo $e->getMessage();
                }
    
                
    
    
    
            }
        }
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ( $page->totalNumEntries > $selector->paging->startIndex );
    echo '</pre>'." Total -- ".$i;
    echo "<br/>";
  // print_r($budget_id);
    /* $l=0;
    foreach ($budget_id as $id)
    {
        try{
        $budget = new Budget();
        $budget->budgetId = $id;
        $operations = array();
        
        // Create operation.
        $operation = new BudgetOperation();
        $operation->operand = $budget;
        $operation->operator = 'REMOVE';
        $operations[] = $operation;
        
        $result = $budgetService->mutate($operations);
        $l++;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    } */
    
//     echo "Total ".$l." budgets removed";
    
    
    
}


function GetCampaignsExample(AdWordsUser $user) {
    global $conn;

    // Get the service, which loads the required classes.
    $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);

    // Create selector.
    $selector = new Selector();
    $selector->fields = array('Id', 'Name','BudgetId');
    $selector->ordering[] = new OrderBy('Name', 'ASCENDING');

    // Create paging controls.
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    $i=0;
    echo '<pre>';
    do {
        // Make the get request.
        $page = $campaignService->get($selector);

        // Display results.
        echo '<pre>';
        if (isset($page->entries)) {
            //     	echo count($page->entries);
            foreach ($page->entries as $campaign) {
                $i++;
                print_r($campaign);
               
            }
        } else {
        print "No campaigns were found.\n";
        }

        // Advance the paging index.
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex);
    echo '</pre>'." Total -- ".$i;
}

try{
    $sqla = "SELECT *,a.account_number AS account FROM prospect_credentials p INNER JOIN account_details a ON p.account_number=a.mccid WHERE p.manage=1 AND account_status=1 AND a.account_number=9768094975  limit 1";//12268117756539291121  AND a.account_number=1226811775
    $resulta = $conn->query($sqla);
    $account = array();
    
    if ($resulta->num_rows > 0) {
        while ($row = $resulta->fetch_object()) {
    
            $userAgent = 'Omnitail';
            $oauth2Infos = array(
                "client_id" => $clientId,
                "client_secret" => $clientSecret,
                "refresh_token" => $row->refresh_token
            );
            $user = new AdWordsUser(NULL, $developerToken, $userAgent, NULL, NULL, $oauth2Infos); // clientCustomerId = "6743897063"9197135874
            $user->SetClientCustomerId($row->account);
            $_SESSION['account_number'] = $row->account;
    
            //$user->LogAll();
            //getCampaigns($user);
            GetAccountBudgets($user);
           // GetCampaignsExample($user);
            }
            }

} catch (Exception $e) {
    printf("An error has occurred: %s\n", $e->getMessage());
}

?>