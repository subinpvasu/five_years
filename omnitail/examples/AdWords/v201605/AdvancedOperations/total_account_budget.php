<?php 
require_once dirname(dirname(__FILE__)) . '/init.php';
function get_total_budget(AdWordsUser $user)
{
    $budgetz = 0;
    $budgetService = $user->GetService('CampaignService', ADWORDS_VERSION);
    $selector = new Selector();
    $selector->fields = array('Id', 'Amount','CampaignStatus','Eligible','IsBudgetExplicitlyShared','Period','AdvertisingChannelType','ServingStatus','BudgetStatus','UrlCustomParameters');
    $selector->ordering[] = new OrderBy('Id', 'ASCENDING');//CampaignStatus
    $selector->predicates[] =  new Predicate('CampaignStatus', 'EQUALS', 'ENABLED'  );
    
    
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    
    do {
        // Make the get request.
        $page = $budgetService->get($selector);
    echo count($page->entries)."<br/>";
        // Display results.
//         echo '<pre>';
//         print_r($page->entries);
//         echo '</pre>';
        if (isset($page->entries)) {
          
             foreach ($page->entries as $budget) {
               
             $budgetz += $budget->budget->amount->microAmount/1000000;
            
             }
           
    
        } else {
            print "No labels were found.\n";
        }
    
        // Advance the paging index.
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex);
    
    echo 'Total :- $'.number_format($budgetz,2);
   
}
try {
    // Get AdWordsUser from credentials in "../auth.ini"
    // relative to the AdWordsUser.php file's directory.
    $user = new AdWordsUser();
    $user->SetClientCustomerId('718-172-2645');
    // Log every SOAP XML request and response.
    $user->LogAll();

    // Run the example.
    get_total_budget($user);
} catch (Exception $e) {
    printf("An error has occurred: %s\n", $e->getMessage());
}