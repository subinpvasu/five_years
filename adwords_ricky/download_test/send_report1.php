<?php
require_once dirname(__FILE__) . '/../includes/includes.php';
require_once dirname(__FILE__) . '/smtp/PHPMailerAutoload.php';


$oldday = date('Y-m-d',strtotime("-7 days"));


$sql = "delete from csvreports where col1 < '$oldday'" ;

$main -> query($sql);


$html ="<h3>Overview Last 7 Days report download for each MCC Account </h3>";

$html .= "<table border=1 style=\"border-collapse : collapse ; border:1px #CCC solid;\" width=\"90%\">";

$html .= "<tr><td width=10%>Date of Download</td>
<td width=10%>MCC</td>
<td  width=25%>Report Name</td>
<td  width=10%>Count Of accounts that has no reports to be inserted</td>
<td  width=10%>Count Of accounts that has reports to be inserted</td>
<td width=15%>Total Number of Enabled Accounts</td>
<td width=10%>Number of records inserted</td>
<td width=10%>No. of clicks on the date</td>
<td width=10%>No. of impressions on the date</td>
</tr>";



for($i=0; $i<7; $i++ ){
	
	$date = date('Y-m-d',strtotime("-".$i." days"));
	$sql = "SELECT `id`,`col4`,`col5` FROM `csvreports` WHERE `col1` LIKE '".$date."%' and `col3`='MCC' ";

	$res = $main ->getResults($sql);
	
	for($j=0; $j<count($res); $j++){		
		
		$r = $res[$j]; $r2 = $res[$j+1] ? $res[$j+1] : array() ;
		
		$from_id = $r->id ;  $to_id = $r2->id ;
		
		if($to_id<>0){ $id= "`id` BETWEEN $from_id AND $to_id ";}
		else{$id= "`id` > $from_id";}
		
		
		
		$sql = "SELECT '$date' as dat,'".$r->col4."' as MCC,`col3` as rpt, COUNT(IF(`col6`=0,1,NULL)) as zerocount, COUNT(IF(`col6`<>0,1,NULL)) as nozerocount ,count(*) as total_accounts,SUM(`col6`) as totalrecords FROM `csvreports` WHERE $id AND `col5` LIKE 'INSERT%' AND `col4` ='SUCCESS' AND `col1` LIKE '".$date."%' GROUP BY `col3`";
			
		//echo $sql ; echo "<br />"; 
		
		$results = $main ->getResults($sql);
	
		foreach($results as $result){

			switch($result->rpt){
				
				case "ACCOUNT REPORT" : $sql1 = "SELECT SUM(`ad_Clicks`) as cls,SUM(`ad_Impressions`) as imp FROM ".$r->col5.".`adword_monthly_report` a inner join ".$r->col5.".adword_accounts b on a.`ad_account_adword_id` = b.ad_account_adword_id where a.ad_Month='".date("Y-m",strtotime($date))."' and b.ad_mcc_id='".$r->col4."'"; break;
				case "AD REPORT" : $sql1 = "SELECT SUM(`ad_Clicks`) as cls,SUM(`ad_Impressions`) as imp FROM ".$r->col5.".`adword_ad_reports` a inner join ".$r->col5.".adword_accounts b on a.`ad_account_id` = b.ad_account_adword_id where a.ad_Date ='".$date."'  and b.ad_mcc_id='".$r->col4."'"; break ;
				case "CAMPAIGN REPORT" : $sql1 = "SELECT SUM(`ad_Clicks`) as cls,SUM(`ad_Impressions`) as imp FROM ".$r->col5.".`adword_campaign_reports` a inner join ".$r->col5.".adword_accounts b on a.`ad_account_id` = b.ad_account_adword_id where a.ad_Date ='".$date."'  and b.ad_mcc_id='".$r->col4."'"; break ;
				case "KEYWORD REPORT" : $sql1 = "SELECT SUM(`ad_Clicks`) as cls,SUM(`ad_Impressions`) as imp FROM ".$r->col5.".`adword_keyword_report1` a inner join ".$r->col5.".adword_accounts b on a.`ad_account_id` = b.ad_account_adword_id where a.ad_Date ='".$date."'  and b.ad_mcc_id='".$r->col4."'"; break ;
				case "CONVERSION TYPE REPORT" : $sql1 = ""; break;
				case "SEARCH QUERY REPORT" : $sql1 = "SELECT SUM(`ad_Clicks`) as cls,SUM(`ad_Impressions`) as imp FROM ".$r->col5.".`adword_search_query_reports` a inner join ".$r->col5.".adword_accounts b on a.`ad_account_id` = b.ad_account_adword_id where a.ad_Date ='".$date."'  and b.ad_mcc_id='".$r->col4."'"; break ;
				default : $sql1 = "";
			}
		
			if($sql1 <> ""){
				
				$res2 = $main->getRow($sql1);
		
				$html .= "<tr>
				<td>".$result->dat."</td>
				<td>".$result->MCC."</td>
				<td>".$result->rpt."</td>
				<td>".$result->zerocount."</td>
				<td>".$result->nozerocount."</td>
				<td>".$result->total_accounts."</td>
				<td>".$result->totalrecords."</td>
				<td>".$res2->cls."</td>
				<td>".$res2->imp."</td>
				</tr>";
			
			}
		}
		
	}
}


$html.="</table>";

$html .= "<br/><table border=1 style=\"border-collapse : collapse ; border:1px #CCC solid;\">";

$html .= "<tr><th>REPORT NAME</th><th>No Of DUPLICATE ENTRIES</th><th>Time Period</th></tr>";

$d_acr = getDuplicateNo(5); if($d_acr) $color = "red" ; else $color = "white" ;
$d_cr = getDuplicateNo(2); if($d_cr) $color1 = "red" ; else $color1 = "white" ;
$d_kr = getDuplicateNo(1); if($d_kr) $color2 = "red" ; else $color2 = "white" ;
$d_ar = getDuplicateNo(3); if($d_sr) $color3 = "red" ; else $color3 = "white" ;
$d_sr = getDuplicateNo(4); if($d_sr) $color4 = "red" ; else $color4 = "white" ;

$html .= "<tr bgcolor='".$color."'><td>ACCOUNT REPORT</td><td>".$d_acr."</td><td>Last 6 months</td></tr>";
$html .= "<tr bgcolor='".$color1."'><td>CAMPAIGN REPORT</td><td>".$d_cr."</td><td>Last 7 days</td></tr>";
$html .= "<tr bgcolor='".$color2."'><td>KEYWORD REPORT</td><td>".$d_kr."</td><td>Last 7 days</td></tr>";
$html .= "<tr bgcolor='".$color3."'><td>AD REPORT</td><td>".$d_ar."</td><td>Last 7 days</td></tr>";
$html .= "<tr bgcolor='".$color4."'><td>SEARCH QUERY REPORT</td><td>".$d_sr."</td><td>Last 7 days</td></tr>";


$html.="</table>";


/* 
$sql = "SELECT `id`, `col1`, `col2`, `col3`, `col4`, `col5`, `col6` FROM `csvreports` WHERE `col2`='Get Entities finish' and `col3` <>'' and `col1` > '".date("Y-m-d",strtotime('-7 days'))."'";


$html.="</table>";

$html .= "<br/><table border=1 style=\"border-collapse : collapse ; border:1px #CCC solid;\">";

$html .= "<tr><th>Date</th><th>No Of Account's entity Downloaded</th><th>MCC</th></tr>";

$results = $main->getResults($sql);



foreach($results as $res){
	
	$date = explode(" ", $res->col1);
	
	$html .= "<tr><td>".$date[0]."</td><td>".$res->col3."</td><td>".$res->col4."</td></tr>";
}


$html.="</table>"; */


$html .= "<br/><table border=1 style=\"border-collapse : collapse ; border:1px #CCC solid;\">";

$html .= "<tr><th>MCC</th><th>No of Enabled Accounts</th><th>Entities Downloaded for Accounts in last 5 days</th></tr>";

$sql = "SELECT `customerId`, case when `prospect_account`=1 then 'pushanalyser_prospect' else 'pushanalyser' end as db FROM `adword_mcc_accounts`";

$res = $main ->getResults($sql);

foreach($res as $r){
	
	$sql1 = "SELECT count(`ad_account_adword_id`) enb,count(id) down FROM `".$r->db."`.`adword_accounts` left join (SELECT DISTINCT(`col4`) id FROM `pushanalyser`.`csvreports` WHERE `col1` > '".date("Y-m-d",strtotime('-5 days'))."' and `col3`='Account' and `col2`='Get Entities') A on A.id=`adword_accounts`.`ad_account_adword_id` WHERE `ad_account_status` = 1 and `ad_delete_status` =0";
	
	$res1 = $main -> getRow($sql1);
	
	if($res1->enb <> $res1->down) { $color = "red";} else{$color = "white";}
	
	$html .= "<tr bgcolor='".$color."'><td>".$r->customerId."</td><td>".$res1->enb."</td><td>".$res1->down."</td></tr>";
}

$html.="</table>"; 


$output = shell_exec("df -H") ;

$output = explode("\n",$output);
$output = explode(" ",$output[1]);

$used = $output[count($output)-2];


$html .= "<h3>Alert : disk space usage $used <h3>";


echo $html ; exit;

//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "anruthathilakan@gmail.com";

//Password to use for SMTP authentication
$mail->Password = "vBridge1";

//Set who the message is to be sent from
$mail->setFrom('anruthathilakan@gmail.com', 'Vbridge Info');

//Set an alternative reply-to address
$mail->addReplyTo('anruthathilakan@gmail.com', 'Vbridge Info');

//Set who the message is to be sent to
$mail->addAddress('rdvarmaa@gmail.com', 'Deepa Varma');
$mail->addAddress('muralihere@gmail.com', 'Murali Mohan');

//Set the subject line
$mail->Subject = 'Report / Entity downloading Test Results ';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($html, dirname(__FILE__));

//Replace the plain text body with one created manually
$mail->AltBody = 'This is the Report / Entity downloading Test Results';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}

function getDuplicateNo($type){
	
	global $main ;
	
	$date = date("Y-m-d",strtotime("-7 days"));
	
	if($type==1){
	
		// keyword report
		
		$sql = "SELECT count(*) cnt , count(distinct(CONCAT(`ad_account_id`,`ad_CampaignId`,`ad_AdGroupId`,`ad_Keyword_Id`,`ad_Clicks`,`ad_Impressions`,`ad_Cost`,`ad_Conversions`,`ad_ConversionRate`,`ad_CostPerConversion`,`ad_Ctr`,`ad_AveragePosition`,`ad_FirstPageCpc`,`ad_TopOfPageCpc`,`ad_Device`,`ad_KeywordMatchType`))) dist , ad_Date FROM `adword_keyword_report1` WHERE `ad_Date` > '".$date."' group by `ad_Date` having cnt <> dist order by ad_Date desc";
		
	}
	elseif($type==2){
	
		//campaign
		
		$sql = "SELECT count(*) cnt , COUNT(DISTINCT(CONCAT(`ad_account_id`,`ad_CampaignId`,`ad_Clicks`,`ad_Impressions`,`ad_ExpImpressions`,`ad_Cost`,`ad_Conversions`,`ad_ConversionRate`,`ad_CostPerConversion`,`ad_Ctr`,`ad_AveragePosition`,`ad_ConversionValue`,`ad_AverageCpc`,`ad_DayOfWeek`,`ad_HourOfDay`,`ad_SearchImpressionShare`))) dist , `ad_Date` FROM `adword_campaign_reports` WHERE `ad_Date` >'".$date."' GROUP BY `ad_Date` HAVING cnt <> dist order by ad_Date desc";
	}
	
	elseif($type==3){
	
		//ad
		
		$sql = "SELECT count(*) cnt , count(distinct(CONCAT(`ad_account_id`,`ad_CampaignId`,`ad_AdGroupId`,`ad_Id`,`ad_AdType`,`ad_Clicks`,`ad_Impressions`,`ad_Cost`,`ad_Conversions`,`ad_ConversionRate`,`ad_Ctr`,`ad_ConversionValue`,`ad_Device`))) dist , ad_Date FROM `adword_ad_reports` WHERE `ad_Date` > '".$date."' group by `ad_Date` having cnt <> dist order by ad_Date desc";
	}
	
	elseif($type==4){
		
		$sql = "SELECT count(*) cnt , count(distinct(CONCAT(`ad_account_id`,`ad_CampaignId`,`ad_AdGroupId`,`ad_KeywordId`,`ad_CreativeId`,`ad_Query`,`ad_Clicks`,`ad_Impressions`,`ad_Cost`,`ad_Ctr`,`ad_Conversions`,`ad_CostPerConversion`,`ad_AveragePosition`,`ad_ConversionValue`,`ad_MatchType`,`ad_Device`,`ad_KeywordTextMatchingQuery`))) dist , ad_Date FROM `adword_search_query_reports` WHERE `ad_Date` > '".$date."' group by `ad_Date` having cnt <> dist order by ad_Date desc";
	}
	
	elseif($type==5){
		//account
		
		$sql = "SELECT count(*) cnt , count(distinct(CONCAT(`ad_account_adword_id`,`ad_Clicks`,`ad_Impressions`,`ad_Cost`,`ad_Ctr`,`ad_AverageCpc`,`ad_ConversionRate`,`ad_Conversions`,`ad_CostPerConversion`,`ad_ConversionValue`,`ad_EstimatedTotalConversions`,`ad_SearchImpressionShare`))) dist , `ad_month` FROM `adword_monthly_report`  group by `ad_month` having cnt <> dist order by `ad_month` desc limit 6";
	}
	
	$res = $main->getResults($sql);

	if(count($res)>0){return 1;}
	else{return 0 ;}
	
	
}

?>