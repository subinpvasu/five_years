<!--
Project     : BTW Dive
Author      : Subin
Title      : List Invoice PDF
Description : Invoice details turns to PDF
-->
<div style="background-color: white;color:black;width:100%;margin:0% auto;text-align: center;" id="balanceout">
<h3 style="width:100%;text-align:left;margin:0px">B.T.W Dive Service </h3>
<h3 style="width:100%;text-align:center;margin:0px">Monthly Invoice Report </h3>
<h3 style="width:100%;text-align:center;margin:0px"> <?php echo $from.' To '.$to; ?> </h3>
<p style="text-align: left;width:100%;"><?php echo date("m/ d/Y")?><p>
<table style="text-align:center;border:none;white-space: nowrap;margin:0px auto;">
<tr>
<td style="border:none;text-align: right;width:100%;line-height:2px;" colspan="6">
</td></tr>
<tr><th style="text-align:left;padding:0 2px;">Customer Name</th>
<th style="text-align:left;padding:0 2px;">Invoice Number</th>
<th style="text-align:left;padding:0 2px;">Invoice Date</th>
<th style="text-align:right;padding:0 2px;">List Price Value</th>
<th style="text-align:right;padding:0 2px;">Invoiced Value</th>
</tr>
<?php
$i = 0;
$total = count($balances);
foreach ($balances as $balance):
echo '<tr>
<td style="border:none;text-align:left;width:auto;padding:0 2px;">'.$balance->CUSTOMER_NAME.'</td>
<td style="border:none;text-align:left;width:auto;padding:0 2px;">'.$balance->PK_INVOICE.'</td>
<td style="border:none;text-align:left;width:auto;padding:0 2px;">'.$balance->INVOICE_DATE.'</td>
<td style="border:none;text-align:right;width:auto;padding:0 2px;">'.$balance->LP_AMOUNT_INVOICED.'</td>
<td style="border:none;text-align:right;width:auto;padding:0 2px;">'.$balance->NET_AMOUNT_INVOICED.'</td>
</tr>';
$i++;
if($i==$total && $present=='no'){
    echo '<tr><td colspan="3"></td><td style="text-align:right;font-weight:bold"><h2>'.$amount[0]->LP_AMOUNT.'</h2></td><td style="text-align:right;"><h2>'.$amount[0]->NET_AMOUNT.'</h2></td></tr>';
}
 if($i%32==0 && $total>$i){?>
    <tr><td style="border:none;;width:100%;line-height:10px;" colspan="6"><h6 style="border:none;text-align: center;width:100%;">

Page <?php echo $i/32;?>/<?php echo ceil($total/32);?>.<br/>
Total <?php echo $total; ?> Results</h6>


<div  style="page-break-after:always;"></div>
<div style="height:46px;width:100%;"></div>

</td></tr>
<tr><th style="text-align:left;padding:0 2px">Customer Name</th>
<th style="text-align:left;padding:0 2px">Invoice Number</th>
<th style="text-align:left;padding:0 2px">Invoice Date</th>
<th style="text-align:right;padding:0 2px;">List Price Value</th>
<th style="text-align:right;padding:0 2px">Invoiced Value</th>
</tr>
<?php }?>
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
