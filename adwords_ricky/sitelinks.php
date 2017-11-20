<div class="table_tittle" style="text-align: center;background-color: #d3d3d3;color: #0066B6;font-weight: bold;
font-size: large;border-top-right-radius: 5px;
border-top-left-radius: 5px; padding-top:20px; height:30px;">Campaigns with less than 4 Sitelinks</div>                                                                                                                       
<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>
	<th style='width:20%;text-align:left;'>Campaign Id</th>
	<th style='width:20%;text-align:left;'>Campaign Name</th>
	
</tr></table>
</div>
<div id="listitems">
<table width="100%"  border="0"> 

<?php

$results = $main->getResults("SELECT `ad_sitelinks`,`ad_campaign_id`,`ad_campaign_adword_id`,`ad_campaign_name` FROM `adword_campaigns` WHERE ad_account_id='$id' and `ad_campaign_adword_status`='ENABLED'");

foreach($results as $result){

$sitelinks = explode(",",$result->ad_sitelinks);

if(count($sitelinks)<4){

?>

<tr>
	<td style='width:20%;text-align:left;'><?php echo $result -> ad_campaign_adword_id ;?></td>
	<td style='width:20%;text-align:left;'><?php echo $result -> ad_campaign_name ;?></td>

</tr>
                                                                                                                            
<?php }} ?>

</table>
</div>

 <div class="table_tittle" style="text-align: center;background-color: #d3d3d3;color: #0066B6;font-weight: bold;
font-size: large;border-top-right-radius: 5px;
border-top-left-radius: 5px; padding-top:20px; height:30px; margin-top:5px; width:100%; float:left; " >AdGroups with no Mobile Ads</div> 

<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>
	<th style='width:20%;text-align:left;'>Campaign Name</th>
	<th style='width:20%;text-align:left;'>Adgroup Name</th>
	
	
</tr></table>
</div>
<div id="listitems">
<table width="100%"  border="0"> 
 
<?php

/* $sql = "SELECT a.ad_adgroup_adword_id,ad_adgroup_name,c.ad_campaign_adword_id,c.ad_campaign_name FROM adword_adgroups a LEFT JOIN (SELECT count(ad_ads_id) cnt ,ad_adgroup_adword_id from adword_ads where ad_ads_type='MobileAd' and ad_ads_adword_status='ENABLED'  group by ad_adgroup_adword_id  ) b on a.ad_adgroup_adword_id=b.ad_adgroup_adword_id 
INNER JOIN adword_campaigns c on a.ad_campaign_id =  c.ad_campaign_adword_id
WHERE a.ad_account_id='$id' and ad_adgroup_adword_status = 'ENABLED' AND  cnt IS NULL  and `ad_campaign_adword_status`='ENABLED' ;"; */

/* 
$sql = "

SELECT a.ad_adgroup_adword_id, 

ad_adgroup_name,c.ad_campaign_adword_id,c.ad_campaign_name ,count(b.ad_ads_id) cnt

FROM adword_adgroups a inner join adword_campaigns c

ON a.ad_campaign_id =  c.ad_campaign_adword_id

LEFT JOIN adword_ads b

on a.ad_adgroup_adword_id = b.ad_adgroup_adword_id  AND b.ad_ads_type='MobileAd'

WHERE c.ad_account_id='$id' and ad_adgroup_adword_status = 'ENABLED' and c.`ad_campaign_adword_status`='ENABLED' 

group by  ad_adgroup_adword_id having cnt =0 ;

"; */

$sql = "select count(*) total from adword_adgroup_feeds where ad_devicePreference ='30001' and ad_TargetingCampaignId=0 and ad_TargetingAdGroupId=0";

$total = $main ->getRow($sql) ;

if($total->total > 0){$results=array();}
else{
	
	$sql = "select c.ad_campaign_name , a.ad_adgroup_name from adword_adgroups a inner join adword_campaigns c ON a.ad_campaign_id =  c.ad_campaign_adword_id WHERE c.ad_account_id='$id' and ad_adgroup_adword_status = 'ENABLED' and c.`ad_campaign_adword_status`='ENABLED' ";
	$results = $main ->getResults($sql) ;
}

foreach($results as $result){
?>

<tr>
	<td style='width:20%;text-align:left;'><?php echo $result -> ad_campaign_name ;?></td>
	<td style='width:20%;text-align:left;'><?php echo $result -> ad_adgroup_name ;?></td>
	

</tr>


<?php }
?>
</table>
</div>