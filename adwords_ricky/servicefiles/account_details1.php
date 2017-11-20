<?php
require_once dirname(__FILE__) . '/../includes/includes.php';

//sanitize post value
$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

$item_per_page = ITEMS_PER_PAGE ;
if(!is_numeric($page_number)){die('Invalid page number!');}

$position = ($page_number * $item_per_page);

$search_term = strtolower($_POST["search_term"]);
 
 
$account_details = $main -> Paginate("SELECT `ad_account_adword_id`,`ad_account_name`,`ad_account_login`,ad_account_status,
case when `ad_account_status`=1 then 'Enabled' when `ad_account_status`=10 then 'Archiving' when `ad_account_status`=3 then 'Archived'  else 'Disabled' end as status

 FROM ".$_SESSION['user_db'].".`adword_accounts` 
 WHERE (LOWER(`ad_account_adword_id`) 
 LIKE '%$search_term%' OR  LOWER(`ad_account_name`) LIKE '%$search_term%'  OR LOWER(`ad_account_login`) LIKE '%$search_term%' )
 AND ad_mcc_id = '".$_SESSION['ad_mcc_id']."' 
 ORDER BY status DESC,ad_account_name ASC ",$item_per_page,$page_number);
 

  
$str = "<table width=\"100%\"  border=\"1\" >"; 
foreach($account_details[0] as $key=>$value)
{	

if($value['status'] <> 'Enabled'){ $pros = "&nbsp; &nbsp;<span style=\"vertical-align:super; color:#FF6600;\">".$value['status']."</span>";}
else{$pros ="";}
	
	$str .= "<tr>";
	if($value['ad_account_status'] <> 10 && $value['ad_account_status'] <> 3 )
		
		{ $str .="
		<td width=\"10%\" align=center ><input type=\"checkbox\" name='en_dis_".$value["ad_account_adword_id"]."' id='en_dis_".$value["ad_account_adword_id"]."' value='".$value["ad_account_adword_id"]."' />&nbsp;</td>";}
	else{
		
		$str .= "<td width=\"10%\" >&nbsp;</td>";
	}  
	$str .=  "
      <td width=\"10%\" style=\"text-align:center;\">".$value["ad_account_adword_id"]."</td>
	  <td width=\"20%\" style=\"text-align:left;\">&nbsp;".$value["ad_account_name"]."&nbsp;".$pros."</td>
      <td width=\"30%\"  style=\"text-align:left;\">&nbsp;".$value["ad_account_login"]."</td>
      <td width=\"10%\" align=\"center\" >".$value["status"]."</td>
      <td width=\"10%\" align=\"center\"><a href='reports.php?id=".$value["ad_account_adword_id"]."&type=TO'>".ANALYSIS."</a></td>
	  <td width=\"10%\" align=\"center\"><a href='customer_report/cr.php?id=".$value["ad_account_adword_id"]."'> ".MONTHLY_REPORT."</a></td>
    </tr>";
	
}

if(count($account_details[0])==0){

	$str .= "<tr>
      <td colspan=7 align=center > <b>Accounts not found </b> </td>
	  
    </tr>";

}



$str .= "</table>";
//echo $str ;
$return['str'] = $str ;
$return['pag'] = $account_details[1] ;

echo json_encode($return);


?>