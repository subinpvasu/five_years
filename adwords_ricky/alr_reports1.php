<?php
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="ALR" || $id=='' ){

	header("Location:account_details.php");
}

?>
<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>	 
	<th style='width:16%'>Label</th>
	<th style='width:10%'>Clicks</th>
	<th style='width:10%'>Impr. </th>
	<th style='width:7%'>CTR (%)</th>
	<th style='width:10%'>Avg CPC</th>
	<th style='width:7%'>Cost</th>
	<th style='width:10%'>Conv</th>
	<th style='width:10%'>Cost / Conv</th>
	<th style='width:10%'>Cost / Conv Rate</th>
	<th style='width:10%'>Conv Rate(%)</th>
	
	 
</tr></table>
</div>
<div id="listitems">
<table width="100%"  border="0"> 
<?php

	$results = $main -> selectAdLabelReport($id,1);
	
	foreach($results as $key => $value){
	
	
	?>
<tr>
	<td style='width:16%; text-align:left;'><?php echo $value->ad_Labels ; ?></td>
	<td style='width:10%'><?php echo $value->ad_clicks ; ?></td>
	<td style='width:10%'><?php echo $value->ad_impressions ; ?> </td>
	<td style='width:7%'><?php echo $value->ad_ctr ; ?></td>
	<td style='width:10%'><?php echo $value->ad_avgCpc ; ?></td>
	<td style='width:7%'><?php echo $value->ad_cost ; ?></td>
	<td style='width:10%'><?php echo $value->ad_convrns ; ?></td>
	<td style='width:10%'><?php echo $value->ad_CostPerConversion ; ?></td>
	<td style='width:10%'><?php echo $value->ad_CstPConvR ; ?></td>
	<td style='width:10%'><?php echo $value->ad_convrate ; ?></td>
</tr>
<?php } ?></table>
</div>
