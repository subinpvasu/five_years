<?php
/*

  This is file to show daily hourly report for customer report
 */
// to get detils of the report type DAILY & HOURLY REPORT 
require_once dirname(__FILE__) . '/../../includes/includes.php';

$id = $_SESSION['account_id'];
$startDate = $_SESSION['startDate'] ;
$endDate = $_SESSION['endDate'] ;

?>
<table  width='100%' border=0 >
    <tr  class='table_head'>
        <td style='width:12%;'><?php echo CAMPAIGN_NAME; ?> Name</td>
        <td style='width:12%;' ><?php echo ADGROUP_NAME; ?> Name</td>
        <td style='width:11%'><?php echo KEYWORD_TEXT; ?></td>
        <td style='width:8%;'  ><?php echo MATCH_TYPE; ?></td>
        <td style='width:7%;'  ><?php echo STATUS; ?></td>
        <td style='width:5%'><?php echo QUALITY_SCORE; ?></td>
        <td style='width:5%'><?php echo CLICKS; ?></td>
        <td style='width:5%'><?php echo IMPRESSIONS; ?></td>

        <td style='width:5%'><?php echo "Cost (" . $_SESSION['ad_account_currencyCode'] . ")"; ?></td>		
        <td style='width:5%'><?php echo CONVERSIONS; ?></td>
        <td style='width:5%'><?php echo CONVERSION_RATE_PERCENTAGE; ?></td>
        <td style='width:5%'><?php echo "Cost / Conv (" . $_SESSION['ad_account_currencyCode'] . ")"; ?></td>
        <td style='width:4%'><?php echo CTR_PERCENTAGE; ?></td>
        <td style='width:6%'><?php echo AVERAGE_POSITION; ?></td>
        <td style='width:5%'><?php echo TOP_PAGE_OF_CPC; ?></td>


    </tr>

    <?php
    $results = $main ->getResults("SELECT NULL ,a.`ad_CampaignName`,a.`ad_AdGroupName`,a.`ad_KeywordText`,ROUND((SUM(a.ad_Clicks)/SUM(a.ad_Impressions)*100),2) Ctr, SUM(a.`ad_Clicks`) ad_Clicks,SUM(a.`ad_Impressions`) ad_Impressions ,ROUND(SUM(a.`ad_Cost`)/1000000,2) ad_Cost , SUM(a.`ad_Conversions`) Conversions_sum , ROUND((SUM(a.ad_Conversions)/SUM(a.ad_Clicks))*100,2) ad_ConversionRate , ROUND(((SUM(a.`ad_Cost`)/SUM(a.`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(AVG(a.ad_AveragePosition),2) as ad_AveragePosition , MAX(a.ad_FirstPageCpc) as ad_FirstPageCpc , MAX(a.ad_TopOfPageCpc) ad_TopOfPageCpc ,SUM(a.ad_ConversionValue) as ad_ConversionValue ,a.`ad_Keyword_Id`,a.`ad_CampaignId`,a.`ad_AdGroupId`,a.`ad_KeywordMatchType` , b.ad_QualityScore,b.ad_keyword_adword_status,b.ad_CpcBid  FROM `adword_keyword_report1` as a inner join adword_keywords as b on a.`ad_CampaignId` = b.ad_campaign_adword_id and a.`ad_AdGroupId`=b.ad_adgroup_adword_id and a.`ad_Keyword_Id` = b.ad_keyword_adword_id WHERE a.`ad_Date` BETWEEN '".$startDate."' AND '".$endDate."' AND a.ad_account_id='".$id."' AND ad_keyword_adword_status='ENABLED' GROUP BY a.`ad_Keyword_Id`,a.`ad_CampaignId`,a.`ad_AdGroupId` HAVING Ctr < 2 AND Ctr >0 AND Conversions_sum <> 0 order by a.`ad_AdGroupName` desc LIMIT 25;");

    if (count($results) > 0) {

        foreach ($results as $key => $result) {

            $ad_TopOfPageCpc = round($result->ad_TopOfPageCpc / 1000000, 2);
			
            ?>
            <tr <?php if ($key % 2 > 0) echo "class ='odd_trs' "; ?> >
                <td style='width:12%; text-align:left;'><?php echo $result->ad_CampaignName; ?> </td>
                <td style='width:12%; text-align:left;'><?php echo $result->ad_AdGroupName; ?> </td>
                <td style='width:11%; text-align:left;'><?php echo $result->ad_KeywordText; ?> </td>
                <td style='width:8%'><?php echo $result->ad_KeywordMatchType; ?> </td>
                <td style='width:7%'><?php echo $result->ad_keyword_adword_status; ?> </td>
                <td style='width:5%'><?php echo $result->ad_QualityScore; ?> </td>	
                <td style='width:5%'><?php echo $result->ad_Clicks; ?> </td>		
                <td style='width:5%'><?php echo $result->ad_Impressions; ?> </td>		
                <td style='width:5%'><?php echo $result->ad_Cost; ?> </td>		
                <td style='width:5%'><?php echo $result->ad_Conversions; ?> </td>		
                <td style='width:5%'><?php echo $result->ad_ConversionRate; ?> </td>		
                <td style='width:5%'><?php echo $result->ad_CostPerConversion; ?> </td>		
                <td style='width:4%'><?php echo $result->ad_Ctr; ?> </td>	
                <td style='width:6%'><?php echo $result->ad_AveragePosition; ?> </td>

                <td style='width:5%'><?php echo $ad_TopOfPageCpc; ?> </td>

            </tr> 

    <?php }
} else { ?>

        <tr><td colspan='14' align="center"> No Results Found</td></tr>
    <?php } ?>
</table>