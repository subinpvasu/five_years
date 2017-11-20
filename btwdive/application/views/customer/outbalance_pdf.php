<!--
Project     : BTW Dive
Author      : Subin
Title      : Outstanding Balance PDF
Description : Outstanding Balance Details turn to PDF.
-->
<div style="background-color: white;color:black;width:auto;margin:0% auto;">
<h2 style="width:100%;text-align:center;">OUTSTANDING BALANCE REPORT</h2>
<table style="text-align:center;border:none;white-space: nowrap;margin:0px auto;">
<tr><td style="border:none;text-align: right;width:100%;line-height:2px;" colspan="6"><h4 style="border:none;text-align: right;width:100%;"><?php echo date("F  d, Y")?></h4></td></tr>
<tr><th style="text-align:left;padding:0 5px;">ACCOUNT NO</th><th style="text-align:left;padding:0 5px;">CUSTOMER</th><th style="text-align:left;padding:0 5px;">VESSEL</th><th style="text-align:right;padding:0 5px;">DEBIT</th><th style="text-align:right;padding:0 5px;">CREDIT</th><th  style="text-align:right;padding:0 5px;">BALANCE</th></tr>
<?php
$i = 0;
$total = count($balances);
foreach ($balances as $balance):
echo '<tr><td style="border:none;text-align:left;width:auto;">'.$balance->ACCOUNT_NO.'</td>
<td style="border:none;text-align:left;width:auto;">'.$balance->FIRST_NAME.' '.$balance->LAST_NAME.'</td>
<td style="border:none;text-align:left;width:auto;">'.$balance->VESSEL_NAME.'</td>
<td style="border:none;text-align:right;width:auto;">'.$balance->DEBIT.'</td>
<td style="border:none;text-align:right;width:auto;">'.$balance->CREDIT.'</td>
<td style="border:none;text-align:right;width:auto;">'.$balance->BALANCE.'</td></tr>';
$i++;
 if($i%32==0 && $total>$i){?>
    <tr><td style="border:none;;width:100%;line-height:10px;" colspan="6"><h6 style="border:none;text-align: center;width:100%;">

Page <?php echo $i/32;?>/<?php echo ceil($total/32);?>.<br/>
Total <?php echo $total; ?> Results</h6>


<div  style="page-break-after:always;"></div>
<div style="height:46px;width:100%;"></div>
<?php }?>
</td></tr>

<?php
endforeach;

if($i%32!=0){?>
<tr><td style="border:none;width:100%;line-height:10px;" colspan="6"><h6 style="border:none;text-align: center;width:100%;">
Page <?php echo ceil($i/32);?>/<?php echo ceil($total/32);?>.<br/>
Total <?php echo $total; ?> Results.
</h6></td></tr>
<?php }?>
</table>

</div>