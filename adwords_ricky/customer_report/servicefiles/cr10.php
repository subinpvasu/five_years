<?php
/*

  This is file to show DEVICE PERFORMANCE report for customer report
 */

require_once dirname(__FILE__) . '/../../includes/includes.php';

$id = $_SESSION['account_id'];
$startDate = $_SESSION['startDate'];
$endDate = $_SESSION['endDate'];
?>
<table width='100%' border=0 >
    <tr class='table_head'>
        <td style='width:20%'>Ad</td>
        <td style='width:12%'>Campaign</td>
        <td style='width:13%'>Adgroup</td>
        <td style='width:5%'><?php echo CLICKS; ?></td>
        <td style='width:5%'><?php echo IMPRESSIONS; ?></td>
        <td style='width:5%'><?php echo CTR_PERCENTAGE; ?></td>
        <td style='width:5%'><?php echo AVERAGE_CPC; ?></td>
        <td style='width:5%'><?php echo COST_EURO; ?></td>
        <td style='width:5%'><?php echo CONVERSIONS; ?></td>
        <td style='width:5%'><?php echo COST_PER_CONVERSION_EURO; ?></td>
        <td style='width:5%'><?php echo COST_PER_CONVERSION_RATE_EURO; ?></td>
        <td style='width:5%'><?php echo CONVERSION_RATE_PERCENTAGE; ?></td>
    </tr>
<?php
$sql = "SELECT ad_AdGroupId ,ad_CampaignName,ad_AdGroupName, ad_ads_type , SUM(ad_Clicks) clicks , SUM(ad_Impressions) impressions ,  ROUND(((SUM(ad_Clicks)/SUM(ad_Impressions)) * 100),2) ctr ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Clicks`))/1000000),2) as ad_avgCpc ,SUM(ad_Conversions) convrns  , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2) convrate ,ROUND(((SUM(`ad_Cost`)/ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2))/1000000),2) as ad_CstPConvR, ROUND((SUM(ad_Cost)/1000000),2) cost ,   
ad_ads_headline , ad_ads_description1 ,ad_ads_description2 ,ad_ads_url ,ad_ads_displayUrl ,	ad_ads_devicePreference , ad_ads_headlinePart1 ,ad_ads_headlinePart2 , ad_ads_path1 , ad_ads_path2 , ad_ads_longHeadline
FROM `adword_ad_reports` report INNER JOIN adword_ads ads on report.ad_AdGroupId = ads.ad_adgroup_adword_id AND report.ad_Id = ads.ad_ads_adword_id AND ads.ad_account_id = report.ad_account_id WHERE report.ad_account_id ='" . $id . "' AND `ad_Date` BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND ad_Status='ENABLED' GROUP BY ad_Id having clicks > 0 ORDER BY clicks desc ,convrns desc limit 20; ";

$results = $main->getResults($sql);

if (count($results) > 0) {

    foreach ($results as $key => $value) {
		if($value->ad_ads_displayUrl) { $ad_ads_displayUrl = $value->ad_ads_displayUrl ;}
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
	
        
        ?>
            <tr  <?php if ($key % 2 > 0) echo "class ='odd_trs' "; ?>>
                <td style='width:20%; text-align:left;'><?php echo $test; ?></td>
                <td style='width:12%; text-align:left;'><?php echo $value->ad_CampaignName; ?></td>
                <td style='width:13%; text-align:left;'><?php echo $value->ad_AdGroupName; ?></td>
                <td style='width:5%'><?php echo $value->clicks; ?></td>
                <td style='width:5%'><?php echo $value->impressions; ?> </td>
                <td style='width:5%'><?php echo $value->ctr; ?></td>
                <td style='width:5%'><?php echo $value->ad_avgCpc; ?></td>
                <td style='width:5%'><?php echo $value->cost; ?></td>
                <td style='width:5%'><?php echo $value->convrns; ?></td>
                <td style='width:5%'><?php if($value->convrns >0) echo $value->ad_CostPerConversion; else echo 0 ; ?></td>
                <td style='width:5%'><?php if($value->convrns >0) echo $value->ad_CstPConvR;  else echo 0 ; ?></td>
                <td style='width:5%'><?php echo $value->convrate; ?></td>
            </tr>
    <?php } } else { ?>
        <tr><td colspan="12" align="center">No results found</td></tr> 
    <?php } ?>

</table>