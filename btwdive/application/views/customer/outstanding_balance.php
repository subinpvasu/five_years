<!--
Project     : BTW Dive
Author      : Subin
Title      : Outstanding Balance
Description : Outstanding Balance Details are displayed here.
-->

<div style="background-color: white;color:black;width:66%;margin:0% auto;text-align: center;" id="balanceout">
<h2 style="width:100%;text-align:center;padding-top:15px;">OUTSTANDING BALANCE REPORT</h2>
<table style="text-align:center;border:none;white-space: nowrap;margin:0px auto;">
<tr><td style="border:none;text-align: right;width:100%;line-height:2px;" colspan="6"><h4 style="border:none;text-align: right;width:100%;"><?php echo date("F  d, Y")?></h4></td></tr>
<tr><th style="text-align:left;padding:0 5px;">ACCOUNT NO</th><th style="text-align:left;padding:0 5px;">CUSTOMER</th><th style="text-align:left;padding:0 5px;">VESSEL</th><th style="text-align:right;padding:0 5px;">DEBIT</th><th style="text-align:right;padding:0 5px;">CREDIT</th><th  style="text-align:right;padding:0 5px;">BALANCE</th></tr>
<?php
$credit = 0;
$debit  = 0;
$outbal = 0;
foreach($total as $t):
$credit += $t->CREDIT;
$debit  += $t->DEBIT;
$outbal += $t->BALANCE;
endforeach;
foreach ($balances as $balance):
echo '<tr><td style="border:none;text-align:left;width:auto;padding:0 5px;">'.$balance->ACCOUNT_NO.'</td>
<td style="border:none;text-align:left;width:auto;padding:0 5px;">'.$balance->FIRST_NAME.' '.$balance->LAST_NAME.'</td>
<td style="border:none;text-align:left;width:auto;padding:0 5px;">'.$balance->VESSEL_NAME.'</td>
<td style="border:none;text-align:right;width:auto;padding:0 5px;">'.$balance->DEBIT.'</td>
<td style="border:none;text-align:right;width:auto;padding:0 5px;">'.$balance->CREDIT.'</td>
<td style="border:none;text-align:right;width:auto;padding:0 5px;">'.$balance->BALANCE.'</td></tr>';
endforeach;
if((ceil($current/32)+1)==(ceil(count($total)/32)))
{
    echo '<tr>
    <td colspan="3"></td>
    <td style="font-weight:bold;">'.$debit.'</td>
    <td style="font-weight:bold;">'.$credit.'</td>
    <td style="font-weight:bold;">'.$outbal.'</td>
    </tr>';
}
?>
<tr><td style="border:none;text-align: right;width:100%;line-height:20px;" colspan="6"><h6 style="border:none;text-align: center;width:100%;">
Page <?php echo ceil($current/32)+1;?>/<?php echo ceil(count($total)/32);?>.<br/>
Total <?php echo count($total)?> Results
</h6></td></tr>
</table>
</div> <input type="hidden" id="findpdf" value="99"/>