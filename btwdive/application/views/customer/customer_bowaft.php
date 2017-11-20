<!--
Project     : BTW Dive
Author      : Subin
Title      : Customer bow/aft
Description : Customer with bow/aft displayed here
-->
<div style="background-color: white;color:black;width:66%;margin:0% auto;text-align: center;" id="balanceout">
<h2 style="width:100%;text-align:center;padding-top:15px;">List of Customers With Bow/Aft Service</h2>
<table style="text-align:center;border:none;white-space: nowrap;margin:0px auto;">
<tr><td style="border:none;text-align: right;width:100%;line-height:2px;" colspan="3"><h4 style="border:none;text-align: right;width:100%;"><?php echo date("F  d, Y")?></h4></td></tr>
<tr><th style="text-align:left;padding:0 5px;">Customer Name</th><th style="text-align:left;padding:0 5px;">Vessel</th><th style="text-align:left;padding:0 5px;">Location</th></tr>
<?php
foreach ($balances as $balance):
echo '<tr>
<td style="border:none;text-align:left;width:auto;padding:0 5px;">'.$balance->FIRST_NAME.' '.$balance->LAST_NAME.'</td>
<td style="border:none;text-align:left;width:auto;padding:0 5px;">'.$balance->VESSEL_NAME.'</td>
<td style="border:none;text-align:left;width:auto;padding:0 5px;">'.$balance->LOCATION.' &nbsp; '.$balance->SLIP.'</td></tr>';
endforeach;
?>
<tr><td style="border:none;text-align: right;width:100%;line-height:20px;" colspan="6"><h6 style="border:none;text-align: center;width:100%;">
Page <?php echo ceil($current/32)+1;?>/<?php echo ceil(count($total)/32);?>.<br/>
Total <?php echo count($total)?> Results
</h6></td></tr>
</table>
</div>
<input type="hidden" id="findpdf" value="100"/>