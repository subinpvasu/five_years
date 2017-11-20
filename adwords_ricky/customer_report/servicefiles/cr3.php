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
        <td style='width:19%'><?php echo LABEL; ?></td>
        <td style='width:9%'><?php echo CLICKS; ?></td>
        <td style='width:9%'><?php echo IMPRESSIONS; ?></td>
        <td style='width:9%'><?php echo CTR_PERCENTAGE; ?></td>
        <td style='width:9%'><?php echo AVERAGE_CPC; ?></td>
        <td style='widtd:9%'><?php echo COST_EURO; ?></td>
        <td style='width:9%'><?php echo CONVERSIONS; ?></td>
        <td style='width:9%'><?php echo COST_PER_CONVERSION_EURO; ?></td>
        <td style='width:9%'><?php echo COST_PER_CONVERSION_RATE_EURO; ?></td>
        <td style='width:9%'><?php echo CONVERSION_RATE_PERCENTAGE; ?></td>
    </tr>
    <?php

	/* 
	$sql = "SELECT DISTINCT(ad_Labels) labels FROM adword_ad_reports WHERE ad_Date='".date('Y-m-d',strtotime("-1 day"))."' AND ad_account_id = '".$id."'";

	$result =  $main -> getResults($sql,'ARRAY_A');

	$labels=array();

	foreach($result as $key => $val){
		
		$labels[] = "'".$val['labels']."'";
	}
	
	$labels_in = implode(",",$labels);
	
	$sql = "SELECT t1.`ad_Id` FROM `adword_ad_reports` t1 WHERE t1.`ad_report_id` IN (SELECT MAX(`ad_report_id`) FROM `adword_ad_reports` t2 WHERE t2.`ad_account_id` ='$id' GROUP BY `ad_Id` ) AND t1.`ad_Status`='enabled' AND t1.`ad_Date` BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
	
	$result =  $main -> getResults($sql,'ARRAY_A');

	$adids=array();

	foreach($result as $key => $val){
		
		$adids[] = "'".$val['ad_Id']."'";
	}
	
	$adids_in = implode(",",$adids);
	
	 
     $sql ="SELECT report.ad_Labels, ad_AdGroupId , ad_AdType ,`ad_Headline`,`ad_Description1`, `ad_Description2`,`ad_DisplayUrl`, SUM(ad_Clicks) clicks , SUM(ad_Impressions) impressions ,  ROUND(((SUM(ad_Clicks)/SUM(ad_Impressions)) * 100),2) ctr ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Clicks`))/1000000),2) as ad_avgCpc ,SUM(ad_Conversions) convrns  , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2) convrate ,ROUND(((SUM(`ad_Cost`)/ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2))/1000000),2) as ad_CstPConvR, ROUND((SUM(ad_Cost)/1000000),2) cost FROM `adword_ad_reports` report WHERE report.`ad_Date` BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND (ad_Labels <>'' AND ad_Labels NOT LIKE '%--%' AND ad_Labels IN (".$labels_in.")) AND ad_Id IN (".$adids_in.") AND report.`ad_account_id` ='$id' GROUP BY report.ad_Labels having clicks > 0 ;";   */  

	 $sql ="SELECT report.ad_Labels, ad_AdGroupId , ad_AdType ,`ad_Headline`,`ad_Description1`, `ad_Description2`,`ad_DisplayUrl`, SUM(ad_Clicks) clicks , SUM(ad_Impressions) impressions ,  ROUND(((SUM(ad_Clicks)/SUM(ad_Impressions)) * 100),2) ctr ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Clicks`))/1000000),2) as ad_avgCpc ,SUM(ad_Conversions) convrns  , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2) convrate ,ROUND(((SUM(`ad_Cost`)/ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2))/1000000),2) as ad_CstPConvR, ROUND((SUM(ad_Cost)/1000000),2) cost FROM `adword_ad_reports` report WHERE report.`ad_Date` BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND (ad_Labels <>'' AND ad_Labels NOT LIKE '%--%' AND ad_Labels IN (SELECT DISTINCT(ad_Labels) labels FROM adword_ad_reports WHERE ad_Date='".date('Y-m-d',strtotime("-1 day"))."' AND ad_account_id = '".$id."')) AND ad_Id IN (SELECT t1.`ad_Id` FROM `adword_ad_reports` t1 WHERE t1.`ad_report_id` IN (SELECT MAX(`ad_report_id`) FROM `adword_ad_reports` t2 WHERE t2.`ad_account_id` ='$id' GROUP BY `ad_Id` ) AND t1.`ad_Status`='enabled' AND t1.`ad_Date` BETWEEN '" . $startDate . "' AND '" . $endDate . "') AND report.`ad_account_id` ='$id' GROUP BY report.ad_Labels having clicks > 0 ;";

	 
	 
    $results = $main->getResults($sql);
	
    if (count($results) > 0) {
        foreach ($results as $key => $value) {
			if($value->ad_CostPerConversion) $cpc = $value->ad_CostPerConversion ; else $cpc =0 ;
			if($value->ad_CstPConvR) $cpcr = $value->ad_CstPConvR ; else $cpcr =0 ;
            ?>
            <tr  <?php if ($key % 2 > 0) echo "class ='odd_trs' "; ?>>
                <td style='width:16%; text-align:left;'><?php echo utf8_encode($value->ad_Labels); ?></td>
                <td style='width:10%'><?php echo $value->clicks; ?></td>
                <td style='width:10%'><?php echo $value->impressions; ?> </td>
                <td style='width:7%'><?php echo $value->ctr; ?></td>
                <td style='width:10%'><?php echo $value->ad_avgCpc; ?></td>
                <td style='width:7%'><?php echo $value->cost; ?></td>
                <td style='width:10%'><?php echo $value->convrns; ?></td>
                <td style='width:10%'><?php echo $cpc; ?></td>
                <td style='width:10%'><?php echo $cpcr; ?></td>
                <td style='width:10%'><?php echo $value->convrate; ?></td>
            </tr>
        <?php }
    } else { ?>

        <tr><td colspan="10" align="center">No results found</td></tr> 
<?php } ?>
</table>