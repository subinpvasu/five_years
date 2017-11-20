<?php
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="WA" || $id=='' ){

	header("Location:account_details.php");
}


	$results = $main -> selectWastageAnalysis($id,1);
	$campaign = array();


	for($i=0,$j=count($results);$i<$j;$i++)
	{
	$campaign[$i] = $results[$i]->ad_CampaignName;
	 }

	$campaign = array_unique($campaign);
 	asort($campaign);
 	$campaign = array_values($campaign);

 	$resultz = $main -> selectWastageAnalysis($id,1,$cname);
 	//print_r($resultz);
				?>

		<div id="listhead">
		  <table width="100%" height="100%" border="0">
		    <tr>
			<th style='width:15%'>Query</th>
			<th style='width:15%'>
			<select name="campaign" id="campaign" style="font-weight: bold; border: 1px solid grey; width: 100%; height: 30px; font-family: gibsonregular; color: rgb(67, 67, 67); text-align: center;">
			<option value="all">All Campaigns</option>
<?php

for($i=0,$j=count($campaign);$i<$j;$i++)
{
?>

				    <option <?php if($campaign[$i]==$_REQUEST['cname']){echo 'selected';}?> value="<?php echo $campaign[$i];?>"><?php echo $campaign[$i];?></option>
			<?php }?>
			</select>


			</th>
			<th style='width:15%'>Keyword Text</th>
			<th style='width:15%'>Match Type</th>
			<th style='width:5%'>Clicks</th>
			<th style='width:5%'>Conv</th>
			<th style='width:5%'>Cost</th>
			<th style='width:5%'>Cost/ Conv</th>
			<th style='width:5%'>Impr</th>
			<th style='width:5%'>Avg Position</th>
			<!--th style='width:10%'>Conversion Value</th-->
			</tr>
			</table>
		</div>
		<div id="listitems">
		<table width="100%"  border="0">
		<?php
	foreach($resultz as $key => $value){
	?>
<tr>
	<td style='width:15%; text-align:left;'><?php echo $value->ad_Query ; ?></td>
	<td style='width:15%; text-align:left;'><?php echo $value->ad_CampaignName ; ?></td>
	<td style='width:15%; text-align:left;'><?php echo $value->ad_KeywordTextMatchingQuery ; ?></td>
	<td style='width:15%'><?php echo $value->ad_MatchType ; ?></td>
	<td style='width:5%'><?php echo $value->ad_Clicks ; ?></td>
	<td style='width:5%'><?php echo $value->ad_Conversions ; ?></td>
	<td style='width:5%'><?php echo $value->ad_Cost /1000000 ; ?></td>
	<td style='width:5%'><?php echo $value->ad_CostPerConversion  /1000000; ?></td>
	<td style='width:5%'><?php echo $value->ad_Impressions ; ?></td>
	<td style='width:5%'><?php echo $value->ad_AveragePosition ; ?></td>
	<!--td style='width:5%'><?php echo $value->ad_ConversionValue ; ?></td-->
</tr>
<?php } ?>
</table>
</div>