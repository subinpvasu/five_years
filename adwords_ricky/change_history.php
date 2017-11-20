<?php
include("header.php");
?>
<div class="report-container">
	<div class="page-header"><h1>CHANGE HISTORY</h1></div>
	<!--div class="nav_left">&nbsp;</div>
	<div class="nav_right" style="text-align:right;padding-left:1%;width:58%" > </div-->
	<div class="report-div">
		<div class="account-details-div">
			<div id="listhead">
			  <table width="100%" height="100%" border="1">
				<tr>				 
				  
				  <th width="40%" align="center">Account</th>
				  <th width="15%" align="center">Campaigns</th>
				  <th width="15%" align="center">Adgroup</th>
				  <th width="15%" align="center">Ads</th>
				  <th width="15%" align="center">Keywords</th>
				  
				</tr>
			  </table>
			</div>
			<div id="listitems">
			
			<table width="100%"  border="1" > 
				<?php 
				
				$reports = $main->getChangeHistoryReport($_SESSION['user_id'],$_SESSION['user_type']);
				
				
				//echo "<pre>"; print_r($reports);
				
				if(count($reports)<1) { 
				
				?>
				
				 <tr><td colspan=5 align=center >No data found</td></tr>
				
				<?php
				
				}
					
				$weekdays = $main -> findWeekDays("-1","Monday","Sunday") ;
				
				foreach($reports as $value)
				
				{
					//echo "<pre>"; print_r($value);
					if($value['ad_start'] ==$weekdays[0] ){
				
					?>
					
					<tr>				 
				  
				  <td width="40%" align="left" id="up_<?php echo $value['ad_account_id'] ; ?>"><a href="#<?php echo $value['ad_account_id'] ;  ?>"><?php echo $value['ad_account_name'] ;  ?>  ( <?php echo $value['ad_account_id'] ;  ?> ) </a></td>
				  <td width="15%" align="center"><?php echo $value['ad_campaigns'] ;  ?></td>
				  <td width="15%" align="center"><?php echo $value['ad_adgroups'] ;  ?></td>
				  <td width="15%" align="center"><?php echo $value['ad_ads'] ;  ?></td>
				  <td width="15%" align="center"><?php echo $value['ad_keywords'] ;  ?></td>
				  
					</tr>
					<?php
					}
				} ?>
			</table>
			
		
			
			<table width="100%"  border="1" > 
				<?php 
				$accountid =0 ;
				foreach($reports as $key => $report)
				
				{
					if($report['ad_account_id'] <> $accountid){
					
					$accountid = $report['ad_account_id'];
					
					
					?>
					
					<td colspan="5" align="left"> <h3 id="<?php echo $accountid ; ?>"><?php echo $report['ad_account_name'] ;  ?>  ( <?php echo $accountid ; ?> ) </h3> <a href="#up_<?php echo $accountid ; ?>">Up</a></td>
				  
					</tr>
					
					
					<tr>				 
				  
				  <th width="40%" align="center">Date Range</th>
				  <th width="15%" align="center">Campaigns</th>
				  <th width="15%" align="center">Adgroup</th>
				  <th width="15%" align="center">Ads</th>
				  <th width="15%" align="center">Keywords</th>
				  
				</tr>
					<?php
					
					 } 
				
					if($report['ad_start'] <> $weekdays[0] ){
				
					?>
					
					<tr>				 
				  
				  <td width="40%" align="left"> <?php echo $report['ad_start']." / ".$report['ad_end'] ?></td>
				  <td width="15%" align="center"><?php echo $report['ad_campaigns'] ;  ?></td>
				  <td width="15%" align="center"><?php echo $report['ad_adgroups'] ;  ?></td>
				  <td width="15%" align="center"><?php echo $report['ad_ads'] ;  ?></td>
				  <td width="15%" align="center"><?php echo $report['ad_keywords'] ;  ?></td>
				  
					</tr>
					<?php
					
				}
				} ?>
			</table>
			</div>
		</div>
		<!--div class="nav_left">&nbsp;</div>
		<div class="nav_right" style="text-align:right;padding-left:1%;width:58%" >&nbsp;</div-->
	</div>
</div>
<?php include("footer.php"); ?>
