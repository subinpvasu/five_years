<?php
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="APA" || $id=='' ){

	header("Location:account_details.php");
}

?>
<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>
	 
	<th style='width:30%'>Ad</th>
	<th style='width:20%'>Campaign Name</th>
	<th style='width:20%'>Adgroup Name</th>
	<th style='width:5%'>Ctr</th>
	<th style='width:5%'>Clicks</th>
	<th style='width:5%'>Cost</th>
	<th style='width:5%'>Conv</th>
	<th style='width:10%'>Conv Rate</th>
 	
	 
</tr></table>
</div>
<div id="listitems">
<table width="100%"  border="0"> 

<?php
$startDate = date("Y-m-d", strtotime("-1 months"));  
//$startDate = date("Y-m-d",strtotime('first day of this month', strtotime($date)));
$endDate = date("Y-m-d");
$colorAry = array('FFE0D1','E9F8FF','C0D0A0','DBFFB8','FFD6D6','AFCC93','C8ECFF','F7EFD6','CCCCB2','EBD6FF','D6ADFF');
	


$sql = "SELECT ad_AdGroupId ,ad_CampaignName,ad_AdGroupName, ad_ads_type , SUM(ad_Clicks) clicks , SUM(ad_Impressions) impressions ,  ROUND(((SUM(ad_Clicks)/SUM(ad_Impressions)) * 100),2) ctr ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Clicks`))/1000000),2) as ad_avgCpc ,SUM(ad_Conversions) convrns  , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2) convrate ,ROUND(((SUM(`ad_Cost`)/ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2))/1000000),2) as ad_CstPConvR, ROUND((SUM(ad_Cost)/1000000),2) cost ,   
ad_ads_headline , ad_ads_description1 ,ad_ads_description2 ,ad_ads_url ,ad_ads_displayUrl ,	ad_ads_devicePreference , ad_ads_headlinePart1 ,ad_ads_headlinePart2 , ad_ads_path1 , ad_ads_path2 , ad_ads_longHeadline
FROM `adword_ad_reports` report LEFT JOIN adword_ads ads on report.ad_Id = ads.ad_ads_adword_id AND ads.ad_account_id = report.ad_account_id WHERE report.ad_account_id ='" . $id . "' AND `ad_Date` BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND ad_ads_adword_status='ENABLED' GROUP BY ad_Id  HAVING (MAX(ad_Ctr)- AVG(ad_Ctr)) > 0.5 AND (AVG(ad_Ctr)- MIN(ad_Ctr)) > 0.5 AND convrns >1 ORDER BY clicks desc ,convrns desc limit 20; ";

	
	$results = $main -> getResults($sql);
	
	unset($sql);
	
	$ad_AdGroupId = ""; $count=0;
	
	foreach($results as $key => $value){
		
		if($value->ad_ads_displayUrl) { $ad_ads_displayUrl = $value->ad_ads_displayUrl ;}
		elseif($value -> ad_ads_type =="" ) { $ad_ads_displayUrl = "";}
		switch($value -> ad_ads_type ){
						
			case 'ExpandedTextAd' : 
				$test = "<span style='color:blue' >" . utf8_encode($value->ad_ads_headlinePart1) . "</span><br /><span style='color:green' >" . utf8_encode($ad_ads_displayUrl) . "</span><br />" . utf8_encode($value->ad_ads_headlinePart2) . "<br />" . utf8_encode($value->ad_Description1); 
				break ;
				
			case 'TextAd' : 
				$test = "<span style='color:blue' >" . utf8_encode($value->ad_ads_headline) . "</span><br /><span style='color:green' >" . utf8_encode($ad_ads_displayUrl) . "</span><br />" . utf8_encode($value->ad_ads_description1) . "<br />" . utf8_encode($value->ad_ads_description2); 
				break ;
			
			default : 
				$test = "<span style='color:blue' >" . utf8_encode($value->ad_ads_headline) . "</span><br /><span style='color:green' >" . utf8_encode($ad_ads_displayUrl) . "</span><br />" . utf8_encode($value->ad_ads_description1) . "<br />" . utf8_encode($value->ad_ads_description2); 
				break ;
		}
	
		
		if($value ->ad_AdGroupId != $ad_AdGroupId ){
		
			$ad_AdGroupId = $value ->ad_AdGroupId ;
			
			$count++;
			
			$sel = $count%10 ;
			
			$color = $colorAry[$sel];
		
		}
		
	if($results[$key-1]->ad_AdGroupId == $value->ad_AdGroupId ||$results[$key+1]->ad_AdGroupId == $value->ad_AdGroupId ){
	
	?>
<tr style='width:100%;background-color:#<?php echo $color ; ?> !important;'>
	
	<td style='width:30%; text-align:left;'><?php echo $test ;  ?></td>
	<td style='width:20%; text-align:left;'><?php echo $value ->ad_CampaignName ;  ?></td>
	<td style='width:20%; text-align:left;'><?php echo $value ->ad_AdGroupName ;  ?></td>
	<td style='width:5%'><?php echo $value ->ctr ;  ?></td>
	<td style='width:5%'><?php echo $value ->clicks ;  ?></td>
	<td style='width:5%'><?php echo $value ->cost ;  ?></td>
	<td style='width:5%'><?php echo $value ->convrns ;  ?></td>
	<td style='width:10%'><?php echo $value ->convrate ;  ?></td>
</tr>
<?php } 
}?></table>
</div>
