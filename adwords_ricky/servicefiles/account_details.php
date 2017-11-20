<?php
require_once dirname(__FILE__) . '/../includes/includes.php';

//sanitize post value
$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

$item_per_page = ITEMS_PER_PAGE ;
if(!is_numeric($page_number)){die('Invalid page number!');}

$position = ($page_number * $item_per_page);

$search_term = strtolower($_POST["search_term"]);
 
//echo "page : $page_number";

 
$account_details = $main -> Paginate("SELECT `ad_account_adword_id`,`ad_account_name`,`ad_account_login`,
case when `ad_account_status`=1 then 'Enabled' else 'Disabled' end as status

 FROM `adword_accounts` 
 WHERE LOWER(`ad_account_adword_id`) 
 LIKE '$search_term%' OR  LOWER(`ad_account_name`) LIKE '$search_term%'  OR LOWER(`ad_account_login`) LIKE '$search_term%'
 AND ad_mcc_id='".$_SESSION['ad_mcc_id']."'
 ORDER BY ad_account_status DESC,ad_account_name ASC",$item_per_page,$page_number);

  

$str .= "<div class='row resultHead' style='width:100%'>
	<div style='width:10%'>Enable/Disable</div>
	<div style='width:20%'>Adwords ID</div>
	<div style='width:20%'>Name</div>
	<div style='width:30%'>Login Details</div>	
	<div style='width:4%'>Status</div>		
	<div style='width:8%'>Reports</div>					<div style='width:8%'> Report Summery</div>		
</div>";
foreach($account_details[0] as $key=>$value)
{	
	$str .= "<div class='row resultData' style='width:100%'>
		<div style='padding:10px; width:10%'><input type='checkbox' name='en_dis_".$value["ad_account_adword_id"]."' id='en_dis_".$value["ad_account_adword_id"]."' value='".$value["ad_account_adword_id"]."' /></div>
		<div style=' padding:10px;width:20%'>".$value["ad_account_adword_id"]."</div>
		<div style=' padding:10px;width:20%'>".$value["ad_account_name"]."</div>
		<div style=' padding:10px;' class='colLogin'>".$value["ad_account_login"]."</div>		
		<div style=' padding:10px; width:10%'>".$value["status"]."</div>		
		<div style=' padding:10px; width:10%'><a href='reports.php?id=".$value["ad_account_adword_id"]."&type=TO'>Report</a> </div>				<div style=' padding:10px; width:10%'><a href='customer_report.php?id=".$value["ad_account_adword_id"]."'>Report Summery</a> </div>
	</div>";
}
$str .= "<div class='row resultFooter resultFooterSub' style='width:100%'>
		<div style='padding:10px; width:20%'><input type='checkbox' name='en_dis_all' id='en_dis_all'  /> Select All</div>
		<div  style='padding:10px; width:80%'>
			<input type='button' name='Button' value='Enable' class='En_Dis'  />
			<input type='button' name='Button' value='Disable' class='En_Dis' /></div>
		 	
	</div>";
$str .= "<div class='row resultFooter'  style='width:100%'> ".$account_details[1]."</div>";
echo $str ;

?>