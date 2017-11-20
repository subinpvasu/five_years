<?php
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="MTO" || $id=='' ){

	header("Location:account_details.php");
}

?>
<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>
	<th style='width:20%'>Campaign Name</th>
	<th style='width:20%'>Broad Match Keywords</th>
	<th style='width:20%'>Exact Match Keywords</th>
	<th style='width:20%'>Phrase Match Keywords</th>	
	<th style='width:20%'>Total Active Keywords</th>		
</tr></table>
</div>
<div id="listitems">
<table width="100%"  border="0"> 

<?php
	 
 	$results = $main -> getResults("SELECT count(*) cnt,ad_keyword_matchtype,A.ad_campaign_adword_id ,ad_campaign_name FROM (SELECT `ad_keyword_adword_status`,a.`ad_campaign_adword_id`,b.`ad_campaign_name`,`ad_keyword_matchtype` FROM `adword_keywords` a INNER JOIN `adword_campaigns` b ON a.`ad_campaign_adword_id`=b.`ad_campaign_adword_id` and b.ad_account_id ='$id' WHERE `ad_campaign_adword_status` ='ENABLED' AND  ad_keyword_adword_status = 'ENABLED' ) A GROUP BY A.`ad_campaign_adword_id`,`ad_keyword_matchtype`
	");  
	//echo 
	foreach($results as $result){
		$count =
		$count=($result->cnt >0)?$result->cnt:0 ;		
		$array[$result->ad_campaign_name][$result->ad_keyword_matchtype] = $result->cnt ;
	
	}
	foreach($array as $key => $value){
	?>
<tr>
	<td style='width:20%; text-align:left;'><?php echo $key ; ?></td>
	<td style='width:20%'><?php echo $broad=(isset($value['BROAD']))?$value['BROAD']:0 ; ?></td>
	<td style='width:20%'><?php echo $exact=(isset($value['EXACT']))?$value['EXACT']:0 ; ?></td>
	<td style='width:20%'><?php echo $phrase=(isset($value['PHRASE']))?$value['PHRASE']:0 ; ?></td>	
	<td style='width:20%'><?php echo ($broad+$exact+$phrase) ; ?></td>				
	
</tr>
<?php } ?></table>
</div>