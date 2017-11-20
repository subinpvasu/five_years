<?php
/*

  This is file to show keyword discovery report for customer report
 */

require_once dirname(__FILE__) . '/../../includes/includes.php';


$id = $_SESSION['account_id'];
$startDate = $_SESSION['startDate'];
$endDate = $_SESSION['endDate'];
?>
<table  width='100%' border=0 >
    <tr  class='table_head'>
        <td style='width:20%'><?php echo SEARCH_QUERY; ?></td>
        <td style='width:15%'><?php echo CAMPAIGN_NAME; ?></td>
        <td style='width:20%'><?php echo KEYWORD_TEXT; ?></td>
        <td style='width:15%'><?php echo MATCH_TYPE; ?></td>
        <td style='width:5%'><?php echo CLICKS; ?></td>
        <td style='width:5%'><?php echo CONVERSIONS; ?></td>
        <td style='width:5%'><?php echo "Cost (" . $_SESSION['ad_account_currencyCode'] . ")"; ?></td>
        <td style='width:5%'><?php echo "Cost / Conv (" . $_SESSION['ad_account_currencyCode'] . ")"; ?></td>
        <td style='width:5%'><?php echo IMPRESSIONS; ?></td>	
        <td style='width:5%'><?php echo AVERAGE_POSITION; ?></td>	
    </tr>
    <?php
    $sql = "SELECT `ad_Query`,`ad_MatchType`,`ad_KeywordTextMatchingQuery`,`ad_CampaignName`,`ad_AdGroupName`,SUM(`ad_Clicks`) ad_Clicks ,SUM(`ad_Impressions`) ad_Impressions, SUM(`ad_Conversions`) ad_Conversions , SUM(`ad_Cost`) ad_Cost ,SUM(`ad_Cost`)/ SUM(`ad_Conversions`)  as ad_CostPerConversion ,SUM(`ad_ConversionValue`) ad_ConversionValue,`ad_AveragePosition`  FROM `adword_search_query_reports` WHERE `ad_Date` BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND `ad_account_id` ='" . $id . "' AND ad_Query <>ad_KeywordTextMatchingQuery GROUP BY `ad_Query`,`ad_CampaignName`,`ad_AdGroupName` HAVING `ad_Clicks` >0 and ad_Conversions=0 ORDER BY  ad_Clicks DESC ,`ad_CampaignName` DESC LIMIT 25";

    $results = $main->getResults($sql);
    if (count($results) > 0) {
    foreach ($results as $key => $value) {
        ?>
        <tr <?php if ($key % 2 > 0) echo "class ='odd_trs' "; ?> >
            <td style='width:20%; text-align:left;'><?php echo $value->ad_Query; ?></td>
            <td style='width:15%; text-align:left;'><?php echo $value->ad_CampaignName; ?></td>
            <td style='width:20%; text-align:left;'><?php echo $value->ad_KeywordTextMatchingQuery; ?></td>
            <td style='width:15%'><?php echo $value->ad_MatchType; ?></td>
            <td style='width:5%'><?php echo $value->ad_Clicks; ?></td>
            <td style='width:5%'><?php echo $value->ad_Conversions; ?></td>
            <td style='width:5%'><?php echo $value->ad_Cost / 1000000; ?></td>
            <td style='width:5%'><?php echo $value->ad_CostPerConversion / 1000000; ?></td>
            <td style='width:5%'><?php echo $value->ad_Impressions; ?></td>	
            <td style='width:5%'><?php echo round($value->ad_AveragePosition, 2); ?></td>	

        </tr>
    <?php } } else { ?>

         <tr><td colspan="10" align="center">No results found</td></tr> 
    <?php } ?>
</table>
