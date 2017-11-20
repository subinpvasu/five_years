<div style="background-color: white;color:black;font-size:12px;width:100%;margin:0% auto;text-align: center;" id="balanceout">
<h3 style="width:100%;text-align:left;margin:0px">B.T.W Dive Service </h3>
<h3 style="width:100%;text-align:center;margin:0px">Commission Report </h3>
<h3 style="width:100%;text-align:center;margin:0px"> <?php echo "Report From:".$from.' To '.$to; ?> </h3>
<p style="text-align: left;width:100%;"><?php echo date("m/ d/Y")?><p>
<table style="text-align:center;border:none;white-space: nowrap;margin:0px auto;border-collapse:collapse;">
<tr>
<td style="border:none;text-align: right;width:100%;line-height:2px;" colspan="8">
</td></tr>
<tr><th style="text-align:left;">VESSEL NAME</th>
<th style="text-align:left;padding:0 1px;">LOCATION</th>
<th style="text-align:left;padding:0 1px;">WORK TYPE</th>
<th style="text-align:left;padding:0 1px;">WORK ORDER</th>
<th style="text-align:right;padding:0 1px;">SCH DATE</th>
<th style="text-align:right;padding:0 1px;">COUNT</th>
<th style="text-align:right;padding:0 1px;">RATE</th>
<th style="text-align:right;padding:0 1px;">COMMISSION</th>
</tr>
<?php 
$i = 0;
$total = count($diver);
foreach ($diver as $divercom):
echo '<tr>
<td style="border:none;text-align:left;">'.$divercom->vessel_name.'</td>
<td style="border:none;text-align:left;width:auto;padding:0 1px;">'.$divercom->location.'</td>
<td style="border:none;text-align:left;width:auto;padding:0 1px;">'.$divercom->work_type.'</td>
<td style="border:none;text-align:left;width:auto;padding:0 1px;">'.$divercom->wo_number.'</td>
<td style="border:none;text-align:right;width:auto;padding:0 1px;">'.$divercom->schedule_date.'</td>
<td style="border:none;text-align:right;width:auto;padding:0 1px;">'.$divercom->scount.'</td>
<td style="border:none;text-align:right;width:auto;padding:0 1px;">'.$divercom->commission_rate.'</td>
<td style="border:none;text-align:right;width:auto;padding:0 1px;">'.$divercom->commission_amount.'</td>
</tr>';
$i++;
if($i%32==0 && $total>$i){?>
    <tr><td style="border:none;;width:100%;line-height:10px;" colspan="8"><h6 style="border:none;text-align: center;width:100%;">
    
Page <?php echo $i/32;?>/<?php echo ceil($total/32);?>.<br/>
Total <?php echo $total; ?> Results</h6>


<div  style="page-break-after:always;"></div>
<div style="height:46px;width:100%;"></div>

</td></tr>
<tr>
<th style="text-align:left;">VESSEL NAME</th>
<th style="text-align:left;padding:0 1px;">LOCATION</th>
<th style="text-align:left;padding:0 1px;">WORK TYPE</th>
<th style="text-align:left;padding:0 1px;">WORK ORDER</th>
<th style="text-align:right;padding:0 1px;">SCH DATE</th>
<th style="text-align:right;padding:0 1px;">COUT</th>
<th style="text-align:right;padding:0 1px;">RATE</th>
<th style="text-align:right;padding:0 1px;">COMMISSION</th>
</tr>
<?php }?>
<?php 
endforeach;

if($i%32!=0){?>
<tr><td style="border:none;width:100%;line-height:10px;" colspan="6"><h6 style="border:none;text-align: center;width:100%;">
Page <?php echo ceil($i/32);?>/<?php echo ceil($total/32);?>.<br/>
Total <?php echo $total; ?> Results.
</h6></td></tr>
<?php }
?>
	<tr><td style="border:none;text-align:right;width:auto;padding:0 5px;border-bottom:1pt solid black;border-top:1pt solid black;" colspan="7"><b>Commission Total :</b></td>
<td style="border:none;text-align:right;width:auto;padding:0 5px;border-bottom:1pt solid black;border-top:1pt solid black;"><?php foreach ($comm_total as $ctotal):
$total_comm=$ctotal->comtotal;
echo $total_comm;
endforeach;?></b></td></tr>
<tr><td style="border:none;text-align:right;width:auto;padding:0 5px;border-bottom:1pt solid black;" colspan="7"><b>Deduction</b> &nbsp;MATERIALS<b> </td>
<td style="border:none;text-align:right;width:auto;padding:0 5px;border-bottom:1pt solid black;"><?php foreach ($materials as $material):
$material_deduction=$material->deductions;
echo  $material_deduction;
endforeach;?></b></td></tr>
<tr><td style="border:none;text-align:right;width:auto;padding:0 5px;border-bottom:1pt solid black;" colspan="7"><b>Total :</td>
<td style="border:none;text-align:right;width:auto;padding:0 5px;border-bottom:1pt solid black;"><?php 
$new_total=$total_comm-$material_deduction;
echo  $new_total;
?></b></td></tr>


</table>

</div>
