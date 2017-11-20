<?php
//print_r($balances);
?>

<div style="background-color: white;color:black;width:66%;margin:0% auto;text-align: center;" id="balanceout">
<h2 style="width:100%;text-align:left;padding-top:15px;">B.T.W Dive Service </h2>
<h2 style="width:100%;text-align:center;padding-top:5px;">Monthly Invoice Report </h2>
<h2 style="width:100%;text-align:center;padding-top:5px;"> <?php echo $from.' To '.$to; ?> </h2>
<p style="text-align: left;width:100%;"><?php echo date("m/ d/Y")?><p>
<table style="text-align:center;border:none;white-space: nowrap;margin:0px auto;">
<tr>
<td style="border:none;text-align: right;width:100%;line-height:2px;" colspan="6">
</td></tr>
<tr><th style="text-align:left;padding:0 5px;">Customer Name</th>
<th style="text-align:left;padding:0 5px;">Invoice Number</th>
<th style="text-align:left;padding:0 5px;">Invoice Date</th>
<th style="text-align:right;padding:0 5px;">List Price Value</th>
<th style="text-align:right;padding:0 5px;">Invoiced Value</th>
</tr>
<?php 
foreach ($balances as $balance):
echo '<tr>
<td style="border:none;text-align:left;width:auto;padding:0 5px;">'.$balance->CUSTOMER_NAME.'</td>
<td style="border:none;text-align:left;width:auto;padding:0 5px;">'.$balance->PK_INVOICE.'</td>
<td style="border:none;text-align:left;width:auto;padding:0 5px;">'.$balance->INVOICE_DATE.'</td>
<td style="border:none;text-align:right;width:auto;padding:0 5px;">'.$balance->LP_AMOUNT_INVOICED.'</td>
<td style="border:none;text-align:right;width:auto;padding:0 5px;">'.$balance->NET_AMOUNT_INVOICED.'</td>
</tr>';
endforeach;
?>
<tr><td style="border:none;text-align: right;width:100%;line-height:20px;" colspan="6"><h6 style="border:none;text-align: center;width:100%;">
Page <?php echo ceil($current/32)+1;?>/<?php echo ceil(count($total)/32);?>.<br/>
Total <?php echo count($total)?> Results
</h6></td></tr>
</table>
</div> 
<input type="hidden" id="from" value="<?php echo $from;?>"/>
<input type="hidden" id="to" value="<?php echo $to;?>" />
<input type="hidden" id="findpdf" value="101"/>