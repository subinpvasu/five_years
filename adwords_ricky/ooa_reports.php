<?php
header("Content-type: text/html; charset=utf-8");
if (! isset($_SESSION['user_name'])) {
    header("Location:index.php");
}
if ($type != "ADVERT" || $id == '') {

    header("Location:account_details.php");
}

?>
<div id="listhead">
	<table width="100%" height="100%" border="0">
		<tr>

			<th style='width: 10%'>Campaign Name</th>
			<th style='width: 10%'>Adgroup Name</th>
			<th style='width: 5%'>Adgroup Status</th>
			<th style='width: 5%'>Ad Type</th>
			<th style='width: 5%'>Ad Status</th>
			<th style='width: 10%'>Headline</th>
			<th style='width: 10%'>Description1</th>
			<th style='width: 10%'>Description2</th>
			<th style='width: 10%'>Display Url</th>
			<th style='width: 5%'>Ctr</th>
			<th style='width: 5%'>Clicks</th>
			<th style='width: 5%'>Cost</th>
			<th style='width: 5%'>Conv</th>
			<th style='width: 5%'>Conv Rate</th>


		</tr>
	</table>
</div>
<div id="listitems">
	<table width="100%" border="0" >
<?php

$startDate = date("Y-m-d", strtotime("-1 months"));
// $startDate = date("Y-m-d",strtotime('first day of this month', strtotime($date)));
$endDate = date("Y-m-d");

/*
 * $startDate = "2014-07-01";
 * $endDate = "2014-08-01";
 */

$sql = "SELECT max(ad_report_id) id ,ad_ads_adword_status,ad_adgroup_adword_status, ad_AdGroupId ,ad_AdGroupName , ad_AdType ,ad_CampaignName ,`ad_Headline`,`ad_Description1`,`ad_Description2`,`ad_DisplayUrl`, SUM(ad_Clicks) clicks , SUM(ad_Impressions) impressions ,  ROUND(((SUM(ad_Clicks)/SUM(ad_Impressions)) * 100),2) ctr ,SUM(ad_Conversions) convrns ,ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2) convrate , ROUND((SUM(ad_Cost)/1000000),2) cost FROM `adword_ad_reports` A INNER JOIN  (SELECT a.`ad_adgroup_adword_id`, ad_ads_adword_status ,ad_adgroup_adword_status
FROM `adword_ads` a
INNER JOIN adword_adgroups c on a.ad_adgroup_adword_id = c.ad_adgroup_adword_id
INNER JOIN adword_campaigns b on a.ad_campaign_adword_id = b.ad_campaign_adword_id
WHERE b.ad_account_id = '$id'  AND  ad_ads_adword_status ='ENABLED' AND  ad_adgroup_adword_status ='ENABLED'
GROUP BY `ad_adgroup_adword_id` HAVING  COUNT(`ad_ads_adword_id`) = 1 ) B ON A.ad_AdGroupId = B.ad_adgroup_adword_id  WHERE ad_account_id ='$id' AND `ad_Date` BETWEEN '$startDate' AND '$endDate' AND ad_AdType!='Product listing ad' GROUP BY ad_AdGroupId,ad_Id having clicks>0 ORDER BY clicks ASC ; ";

// echo $sql ; //exit;

$results = $main->getResults($sql);

foreach ($results as $key => $value) {

    ?>
<tr>

			<td style='width: 10%;'><?php echo utf8_encode($value ->ad_CampaignName) ;  ?></td>
			<td style='width: 10%;'><?php echo utf8_encode($value ->ad_AdGroupName) ;  ?></td>
			<td style='width: 5%'><?php echo $value ->ad_adgroup_adword_status ;  ?></td>
			<td style='width: 5%'><?php echo $value ->ad_AdType ;  ?></td>
			<td style='width: 5%'><?php echo $value ->ad_ads_adword_status ;  ?></td>
			<td style='width: 10%'><?php echo utf8_encode($value ->ad_Headline) ;  ?></td>
			<td style='width: 10%'><?php echo utf8_encode($value ->ad_Description1) ;  ?></td>
			<td style='width: 10%'><?php echo utf8_encode($value ->ad_Description2) ;  ?></td>
			<td style='width: 10%'><?php echo $value ->ad_DisplayUrl ;  ?></td>
			<td style='width: 5%'><?php echo $value ->ctr ;  ?></td>
			<td style='width: 5%'><?php echo $value ->clicks ;  ?></td>
			<td style='width: 5%'><?php echo $value ->cost ;  ?></td>
			<td style='width: 5%'><?php echo $value ->convrns ;  ?></td>
			<td style='width: 5%'><?php echo $value ->convrate ;  ?></td>
		</tr>
<?php }
echo '<!-- '.$sql.' -->';
echo '<script>
    $(document).ready(function(){
  $("#listitems td").css("text-align","center");
});
    </script>';
?> </table>
</div>