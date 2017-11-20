<?php
require_once dirname(__FILE__) . '/../includes/includes.php';

//sanitize post value
$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

$item_per_page = ITEMS_PER_PAGE ;
if(!is_numeric($page_number)){die('Invalid page number!');}

$position = ($page_number * $item_per_page);

$search_term = strtolower($_POST["search_term"]);
 
//echo "page : $page_number";

if($_SESSION['user_type']==4){ $where = "and created_user ='".$_SESSION['user_id']."'";}
elseif($_SESSION['user_type']<>2){$where = "AND created_user =0";}
 
$account_details = $main -> Paginate("SELECT `customerId`,`descriptiveName`,`companyName`,prospect_account

 FROM ".DB_DATABASE.".`adword_mcc_accounts` 
 WHERE (LOWER(`customerId`) 
 LIKE '$search_term%' OR  LOWER(`descriptiveName`) LIKE '$search_term%'  OR LOWER(`companyName`) LIKE '$search_term%') 
 $where AND prospect_account <> 10

 ORDER BY prospect_account ASC,descriptiveName ASC",$item_per_page,$page_number);
 

$str = "<table width=\"100%\"  border=\"1\" >"; 
foreach($account_details[0] as $key=>$value)
{	
	if($value['prospect_account'] ==1){ $pros = "&nbsp; &nbsp;<span style=\"vertical-align:super; color:#FF6600;\">Prospect</span>";

		$check = "<input type=\"checkbox\" name='en_dis_".$value["customerId"]."' id='en_dis_".$value["customerId"]."' value='".$value["customerId"]."' />"	;}

	else if($value['prospect_account'] ==3){ $pros = "&nbsp; &nbsp;<span style=\"vertical-align:super; color:#FF0000;\">Processing</span>"; $check ="";}
	else{ $pros =""; $check ="";}
	
	$str .= "<tr>";
	if($_SESSION['user_type']==2) { $str .="<td width=\"10%\" align=center > $check &nbsp;</td>";  } 
	$str .="
      <td width=\"20%\" style=\"text-align:left;\">&nbsp;<a href='javascript:gotoAccounts(".$value["customerId"].")'  id='gotoAccounts_".$value["customerId"]."'> ".$value["customerId"]."</a>$pros</td>
	  <td width=\"20%\" style=\"text-align:left;\">&nbsp;".$value["descriptiveName"]."</td>
      <td width=\"30%\"  style=\"text-align:left;\">&nbsp;".$value["companyName"]."</td>
      <td width=\"10%\" align=\"center\" >&nbsp;</td>
      <td width=\"10%\" align=\"center\">&nbsp;</td>
	  
    </tr>";
	
}

//echo $str ;
if(count($account_details[0])==0){

	$str .= "<tr>
      <td colspan=6 align=center > <b> No Adwords Accounts are found under this user. Please click <a href='addCustomer.php'>here </a> to add a new customer . </b> </td>
	  
    </tr>";

}

$str .= "</table>";
$return['str'] = $str ;
$return['pag'] = $account_details[1] ;

echo json_encode($return);


?>