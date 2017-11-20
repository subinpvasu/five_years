<?php
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="DD" || $id=='' ){

	header("Location:account_details.php");
}
$startDate = date("Y-m-d", strtotime("-2 months"));  
$endDate = date("Y-m-d");


	$sql = "SELECT  DISTINCT(`ad_campaign_name`)FROM `adword_display_reports` WHERE   `ad_account_id` ='$id' and `ad_Date` BETWEEN '$startDate' AND '$endDate' ORDER BY ad_campaign_name";
	
	$campaigns = $main->getResults($sql,'ARRAY_A');

	$sql = "SELECT  DISTINCT(`ad_domain`) FROM `adword_display_reports` WHERE   `ad_account_id` ='$id' and `ad_Date` BETWEEN '$startDate' AND '$endDate' order by ad_domain";

	$domains = $main->getResults($sql,'ARRAY_A');

$domainame = $_REQUEST['domainame'];
$cname = $_REQUEST['cname'];

$where = "";

 $group = "GROUP BY `ad_domain` having ad_clicks >0 and ad_conversions>0";
 
if($domainame <> '') { $where .= "and ad_domain='$domainame'"; $group = "GROUP BY `ad_url` having ad_clicks >0 and ad_conversions>0";}
if($cname <> '') {$where .= "and ad_campaign_name='$cname'";}

 
$sql = "SELECT  SUM(`ad_clicks`) ad_clicks,SUM(`ad_impressions`) ad_impressions, SUM(`ad_cost`) ad_cost, SUM(`ad_conversions`) ad_conversions ,SUM(`ad_cost`)/ SUM(`ad_conversions`)  as ad_cpc, `ad_campaign_name`, `ad_domain`, `ad_url`  FROM `adword_display_reports` WHERE   `ad_account_id` ='$id' and `ad_Date` BETWEEN '$startDate' AND '$endDate' $where $group ORDER BY ad_clicks desc LIMIT 50";

$results = $main->getResults($sql);


?>
<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>
	<?php if($domainame <> '') {?><th style='width:30%'>Url</th> <?php } ?>
	<th style='width:20%'><select name="domain" id="domain" style="font-weight: bold; border: 1px solid grey; width: 90%; height: 30px; font-family: gibsonregular; color: rgb(67, 67, 67); text-align: center;">
			<option value="">All Domains</option>
<?php

foreach($domains as $domain)
{
?>


	<option <?php if($domain['ad_domain']==$domainame){echo 'selected';}?> value="<?php echo $domain['ad_domain'];?>"><?php echo $domain['ad_domain'];?></option>

<?php }?>
			
			
			</select></th>
	
	<th style='width:15%'>

		<select name="campaign" id="campaign" style="font-weight: bold; border: 1px solid grey; width: 90%; height: 30px; font-family: gibsonregular; color: rgb(67, 67, 67); text-align: center;">
			<option value="">All Campaigns</option>
<?php

foreach($campaigns as $campaign)
{
?>


				    <option <?php if($campaign['ad_campaign_name']==$cname){echo 'selected';}?> value="<?php echo $campaign['ad_campaign_name'];?>"><?php echo $campaign['ad_campaign_name'];?></option>

<?php }?>
			
			
			</select>


			</th>
	<th style='width:15%'>Impr</th>
	<th style='width:5%'>Clicks</th>
	<th style='width:5%'>Conv</th>
	<th style='width:5%'>Cost</th>
	<th style='width:5%'>Cost/ Conv</th>
	<!--th style='width:10%'>Conversion Value</th-->	
	</tr>
	</table> 
</div>
<div id="listitems">
<table width="100%"  border="0"> 
<?php
	
	foreach($results as $key => $value){
	?>
<tr>
	<?php if($domainame <> '') {?><td style='width:30%; text-align:left;'><?php echo $value->ad_url ; ?></td> <?php } ?>
	<!--td style='width:20%; text-align:left;'><?php echo $value->ad_url ; ?></td-->
	<td style='width:20%; text-align:left;'><?php echo $value->ad_domain ; ?></td>
	<td style='width:15%; text-align:left;'><?php echo $value->ad_campaign_name ; ?></td>
	<td style='width:15%'><?php echo $value->ad_impressions ; ?></td>
	<td style='width:5%'><?php echo $value->ad_clicks ; ?></td>
	<td style='width:5%'><?php echo $value->ad_conversions ; ?></td>
	<td style='width:5%'><?php echo ROUND($value->ad_cost /1000000 ,2) ; ?></td>
	<td style='width:5%'><?php echo round($value->ad_cpc  /1000000,2); ?></td>	

</tr>
<?php } ?>
</table>
</div>