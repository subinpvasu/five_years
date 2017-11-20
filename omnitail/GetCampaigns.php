<?php

/**
 * Runs the example.
 * @param AdWordsUser $user the user to run the example with
 */
function GetCampaignByName(AdWordsUser $user, CampaignService $service, $name) {

  // Create selector.
  $selector = new Selector();
  $selector->fields = array('Id', 'Name');
  
  // Create predicates.
  $selector->predicates[] =
      new Predicate('Name', 'EQUALS', $name);

  $page = $service->get($selector);
  $value = (object) array('id' => $page->entries[0]->id, 'name' => $page->entries[0]->name);
  return $value;
}

