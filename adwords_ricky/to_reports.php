<?php
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="TO" || $id=='' ){

	header("Location:account_details.php");
}

?>

<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>

      <th style=''>Month</th>
<th style=''>Clicks</th>
<th style=''>Impr</th>
<th style=''>CTR (%)</th>
<th style=''>Avg CPC</th>
<th style=''>Cost</th>
<th style=''>Conv</th>
<th style=''>Conv Rate (%)</th>
<th style=''>Cost/ Conv </th>
<th style=''>Conv Value</th>
<th style=''>Search Impr Share (%)</th>
    </tr>
  </table>
</div>
<div id="listitems">
<table width="100%"  border="0">

<?php
if($_SESSION['ad_account_status']<>3){$dbName = $_SESSION['user_db'];} else { $dbName = DB_DATABASE_ARCHIVE; }
$results = $main->getResults("SELECT `ad_report_id`,`ad_month`,`ad_account_adword_id`,`ad_Clicks`,`ad_Impressions`,`ad_Cost`,`ad_Ctr`,`ad_AverageCpc`,`ad_ConversionRate`,`ad_Conversions`,`ad_CostPerConversion`,`ad_ConversionValue`,`ad_SearchImpressionShare`,SUBSTRING_INDEX(`ad_month`,'-',1) as 'year' , SUBSTRING_INDEX(`ad_month`,'-',-1) as 'month' FROM  ".$dbName.".adword_monthly_report WHERE ad_account_adword_id='".$id."' ORDER BY  year desc , month asc LIMIT 24");

$ad_year = "";
foreach($results as $result){

$cost = round($result -> ad_Cost / 1000000,2) ;
$ad_AverageCpc = round($result -> ad_AverageCpc / 1000000,2) ;
$ad_CostPerConversion = round($result -> ad_CostPerConversion / 1000000,2) ;
$ad_month = explode("-",$result->ad_month);

if($ad_year != $ad_month[0] ){
$ad_year = $ad_month[0] ;
?>
<tr >
<td style="" colspan="11">YEAR : <?php echo $ad_year ;?></td>
</tr>
<?php
}

$monthName = date('F', strtotime($result ->ad_month ));
$style1 =  'color:green;';
$style2 =  'color:red;';

if($result ->ad_month == date("Y-m")){

	$ok=0;

	$yrback = date("Y-m",strtotime("-1 years"));
	$mnthback = date("Y-m",strtotime("-1 months"));


	$sql = "select ad_Ctr ,ad_AverageCpc ,ad_ConversionRate,ad_Cost,ad_Conversions ,ad_month ,round(ad_CostPerConversion/ 1000000,2) as ad_CostPerConversion from adword_monthly_report where ad_account_adword_id='$id' and ad_month in ('$yrback','$mnthback')  ";

	$res = $main -> getResults($sql);

	//print_r($res);

	if(count($res)==1){ $ok=1; ;



	}

	elseif(count($res)>1){

		foreach($res as $val){

			if($val->ad_month==$yrback){ $ok = 1;

			}


		}
	}

}
else{

	$st_ctr= $st_avg =$st_conv = $st_cpc = "";
	$img_ctr= $img_avg =$img_conv = $img_cpc = "";
	$ok = 0;
}
if($ok==1){

	if($result->ad_Ctr - $res[0]->ad_Ctr >0) {

		$st_ctr =$style1 ; $img_ctr = 'up_green.png';

		$img_ctr= '<img src="images/up_green.png" height="10px" style="margin-right:2px;" border=0 >';
	}
	elseif($result->ad_Ctr - $res[0]->ad_Ctr < 0) {

		$st_ctr =$style2 ; $img_ctr= '<img src="images/down_red.png" height="10px" style="margin-right:2px;" border=0 >';

	}
	else {$st_ctr ="" ; $img_ctr =""; }

	if($result->ad_ConversionRate - $res[0]->ad_ConversionRate >0) {

		$st_conv =$style1 ; $img_conv = 'up_green.png';

		$img_conv= '<img src="images/up_green.png" height="10px" style="margin-right:2px;" border=0 >';
	}
	elseif($result->ad_ConversionRate - $res[0]->ad_ConversionRate < 0) {

		$st_conv =$style2 ; $img_conv= '<img src="images/down_red.png" height="10px" style="margin-right:2px;" border=0 >';

	}
	else {$st_conv ="" ; $img_conv =""; }

	if($result->ad_AverageCpc - $res[0]->ad_AverageCpc <0) {

		$st_avg =$style1 ; $img_avg = 'down_green.png';

		$img_avg= '<img src="images/down_green.png" height="10px" style="margin-right:2px;" border=0 >';

	}
	elseif($result->ad_AverageCpc - $res[0]->ad_AverageCpc >0) {

		$st_avg =$style2 ;$img_avg = 'up_red.png';
		$img_avg= '<img src="images/up_red.png" height="10px" style="margin-right:2px;" border=0 >';
	}
	else {$st_avg ="" ; $img_avg =""; }

	if($ad_CostPerConversion - $res[0]->ad_CostPerConversion <0) {

		$st_cpc =$style1 ; $img_cpc = 'down_green.png';

		$img_cpc= '<img src="images/down_green.png" height="10px" style="margin-right:2px;" border=0 >';

	}
	elseif($ad_CostPerConversion - $res[0]->ad_CostPerConversion > 0) {

		$st_cpc =$style2 ;$img_cpc = 'up_red.png';
		$img_cpc= '<img src="images/up_red.png" height="10px" style="margin-right:2px;" border=0 >';
	}
	else {$st_cpc ="" ; $img_cpc =""; }

}



?>

<tr>
<td style='width:10%;'><?php echo $monthName ;?></td>
<td style='width:5%;'><?php echo $result -> ad_Clicks ;?> </td>
<td style='width:10%;'><?php echo $result -> ad_Impressions ;?> </td>
<td style='width:5%;' <?php echo $st_ctr; ?>' ><?php echo $img_ctr ; echo $result -> ad_Ctr ;?></td>
<td style='width:10%;'<?php echo $st_avg; ?>' ><?php echo $img_avg ; echo $ad_AverageCpc ;?></td>
<td style='width:10%;'><?php echo $cost ;?> </td>
<td style='width:10%;'><?php echo $result -> ad_Conversions ;?> </td>
<td style='width:10%;'<?php echo $st_conv; ?>'  ><?php echo $img_conv ; echo $result -> ad_ConversionRate ;?>   </td>
<td style='width:10%;'<?php echo $st_cpc; ?>'  ><?php echo $img_cpc ; echo $ad_CostPerConversion ;?>   </td>
<td style='width:10%;'><?php echo $result -> ad_ConversionValue; ?>   </td>
<td style='width:10%;'><?php echo $result -> ad_SearchImpressionShare ;?>     </td>
</tr>

<?php }

if(count($results)<1){

	?>

	<tr><td align="center"> No report found</td></tr>
<?php

}

?>
</table>
</div>
