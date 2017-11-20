<?php
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="KD" || $id=='' ){

	header("Location:account_details.php");
}

?>
<div id="selectDevicex" style="width:100%;font-weight: bold;height:auto; overflow:hidden; margin-bottom:5px;" >
<table width="100%" height="100%" border="0">
<tr><td align='right' width="20%"> <span class="txtcolor2">Select</span> Device Type : &nbsp;</td>
<td><div class="selection_ext" style="margin-top: 0px;"><select id="devices" onchange="getDeviceReport();">
<option value="Select">--- All ---</option>
<option value='Computers'>Computers</option>
<option value='Tablets with full browsers'>Tablets with full browsers</option>
<option value='Mobile devices with full browsers'>Mobile devices with full browsers</option>
</select></div></td></tr>
</table>

</div>





<?php

	$results = $main -> selectKeywordDiscovery($id,1);
	$campaign = array();
	for($i=0,$j=count($results);$i<$j;$i++)
	{
	    $campaign[$i] = $results[$i]->ad_CampaignName;
	}

	$campaign = array_unique($campaign);
	asort($campaign);
	$campaign = array_values($campaign);
	$resultz = $main -> selectKeywordDiscovery($id,1,$cname);
	$_SESSION['deviceResults'] = $results ;
	?>

	<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>
	<th style='width:20%'>Query</th>
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
	<th style='width:5%'>Match Type</th>
	<th style='width:10%'>Device</th>
	<th style='width:5%'>Clicks</th>
	<th style='width:5%'>Conv</th>
	<th style='width:5%'>Cost</th>
	<th style='width:5%'>Cost/ Conv</th>
	<th style='width:5%'>Impr</th>
	 </tr></table>
</div>
<div id="listitems">
<table width="100%"  border="0">

	<?php
	foreach($resultz as $key => $value){
	?>
<tr>
	<td style='width:20%; text-align:left;'><?php echo $value->ad_Query ; ?></td>
	<td style='width:15%; text-align:left;'><?php echo $value->ad_CampaignName ; ?></td>
	<td style='width:15%; text-align:left;'><?php echo $value->ad_KeywordTextMatchingQuery ; ?></td>
	<td style='width:5%'><?php echo $value->ad_MatchType ; ?></td>
	<td style='width:10%'><?php echo $value->ad_Device ; ?></td>
	<td style='width:5%'><?php echo $value->ad_Clicks ; ?></td>
	<td style='width:5%'><?php echo $value->ad_Conversions ; ?></td>
	<td style='width:5%'><?php echo round($value->ad_Cost /1000000,2) ; ?></td>
	<td style='width:5%'><?php echo round($value->ad_CostPerConversion  /1000000,2); ?></td>
	<td style='width:5%'><?php echo $value->ad_Impressions ; ?></td>
</tr>
<?php } ?>
</table>
</div>
