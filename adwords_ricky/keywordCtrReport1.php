<?php
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="CBR" || $id=='' ){

	header("Location:account_details.php");
}

?>
<style>
.headerSortUp
	{
background-image: url("./images/downn.png");
		 background-position: center top;
    background-repeat: no-repeat;
    background-size: 20px auto;

cursor: pointer;
    }
.headerSortDown
	{
background-image: url("./images/up.png");
		 	 background-position: center top;
    background-repeat: no-repeat;
    background-size: 20px auto;
cursor: pointer;
	}
</style>
<div id="listhead">
  <table width="100%" height="100%" border="0" class="tablesorter">
  <thead>
    <tr>
    <th style='width:10%'>Campaign Name</th>
    <th style='width:15%'>AdGroup Name</th>
    <th style='width:15%'>Keyword Text</th>
    <th style='width:5%'>Match Type</th>
    <th style='width:5%'>Status</th>
    <th style='width:5%'>Q S</th>
    <th style='width:5%'>Clicks</th>
    <th style='width:5%'>Impr</th>
    <th style='width:5%'>Cost</th>
    <th style='width:5%'>Conv</th>
    <th style='width:5%'>Conv Rate</th>
    <th style='width:5%'>Cost / Conv</th>
    <th style='width:5%'>Ctr %</th>
    <th style='width:5%'>Avg Position</th>
    <th style='width:5%'>Top Of Page Cpc</th>
</tr></thead><tbody>

<?php

	$results = $main->selectConversionBoosterReports($id,1);


    foreach($results as $result){

    $ad_FirstPageCpc = round($result -> ad_FirstPageCpc / 1000000 , 2);
    $ad_TopOfPageCpc = round($result -> ad_TopOfPageCpc /1000000 , 2);
    $ad_CpcBid = round($sel_res -> ad_CpcBid /1000000 , 2);

    if($ad_FirstPageCpc > $ad_CpcBid) {$style = "color : red;";} else {$style ="";}

?>

<tr>
    <td style='width:10%; text-align:left;'><?php echo $result -> ad_CampaignName ;?> </td>
    <td style='width:15%; text-align:left;'><?php echo $result -> ad_AdGroupName ;?> </td>
    <td style='width:15%; text-align:left;'><?php echo $result -> ad_KeywordText ;?> </td>
    <td style='width:5%'><?php echo $result -> ad_KeywordMatchType ;?> </td>
    <td style='width:5%'><?php echo $result -> ad_keyword_adword_status; ?> </td>
    <td style='width:5%'><?php echo $result -> ad_QualityScore ;?> </td>
    <td style='width:5%'><?php echo $result -> ad_Clicks ;?> </td>
    <td style='width:5%'><?php echo $result -> ad_Impressions ;?> </td>
    <td style='width:5%'><?php echo $result ->ad_Cost ;?> </td>
    <td style='width:5%'><?php echo $result -> ad_Conversions ;?> </td>
    <td style='width:5%'><?php echo $result ->ad_ConversionRate ;?> </td>
    <td style='width:5%'><?php echo $result ->ad_CostPerConversion ;?> </td>
    <td style='width:5%'><?php echo $result ->ad_Ctr;?> </td>
    <td style='width:5%'><?php echo $result -> ad_AveragePosition ;?> </td>
    <td style='width:5%'><?php echo $ad_TopOfPageCpc ;?> </td>
</tr>

<?php }echo '<!--Sql '.$sql.' <br/> Sel '.$sel.' -->'; ?>
</tbody>
</table>
</div>