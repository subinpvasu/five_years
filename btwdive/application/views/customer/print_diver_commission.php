<!--
Project     : BTW Dive
Author      : Subin
Title      : Print Diver Commission
Description : Diver Commission displays here.
-->
<?php
$total_result=count($total);
$a=$total_result/45;
$a=(int)$a;
$lastpage=$a*45;
?>
<script>
$(document).ready(function(){
	$("#searchfind").hide();
});

</script>
<div style="background-color: white;color:black;width:66%;margin:0% auto;text-align: center;" id="balanceout">
<h2 style="width:100%;text-align:left;padding-top:15px;">B.T.W Dive Service </h2>
<h2 style="width:100%;text-align:center;padding-top:15px;">COMMISSION REPORT</h2>
DIVER NAME:</h2><?php
foreach ($diverdetails as $diver1):
 echo $diver1->diver_name;
 endforeach;
 ?>
 <br>
 Date Range From <?php echo $from?> To <?php echo $to ?>
<table style="text-align:center;border:none;white-space: nowrap;margin:0px auto;border-collapse: collapse;">
<tr><th style="text-align:left;padding:0 5px;">VESSEL NAME</th>
<th style="text-align:left;padding:0 5px;">LOCATION</th>
<th style="text-align:left;padding:0 5px;">WORK TYPE</th>
<th style="text-align:right;padding:0 5px;">WORK ORDER</th>
<th style="text-align:right;padding:0 5px;">SCH DATE</th>
<th style="text-align:right;padding:0 5px;">COUNT</th>
<th style="text-align:right;padding:0 5px;">RATE</th>
<th style="text-align:right;padding:0 5px;">COMMISSION</th>
</tr>
<?php
$k = '';
foreach ($diver as $divercom):
if($divercom->work_type=='Zinc Change')
{
    $k=' Ea';
}
else
{
    $k = ' %';
}
echo '<tr id="'.$divercom->pk_diver_trans.'"><td style="border:none;text-align:left;width:auto;padding:0 5px;">'.$divercom->vessel_name.'</td>
<td style="border:none;text-align:left;width:auto;padding:0 5px;">'.$divercom->location.'</td>
<td style="border:none;text-align:left;width:auto;padding:0 5px;">'.$divercom->work_type.'</td>
<td style="border:none;text-align:right;width:auto;padding:0 5px;">'.$divercom->wo_number.'</td>
<td style="border:none;text-align:right;width:auto;padding:0 5px;">'.$divercom->schedule_date.'</td>' .
		'<td style="border:none;text-align:right;width:auto;padding:0 5px;">'.$divercom->scount.'</td>
<td style="border:none;text-align:right;width:auto;padding:0 5px;">'.$divercom->commission_rate.$k.'</td>
<td style="border:none;text-align:right;width:auto;padding:0 5px;">'.$divercom->commission_amount.'</td></tr>';
endforeach;
?>
<?php
if($current==$lastpage)
{
?>
<tr><td style="border:none;text-align:right;width:auto;padding:0 5px;border-bottom:1pt solid black;border-top:1pt solid black;" colspan="7"><b>Commission Total :</b></td>
<td style="border:none;text-align:right;width:auto;padding:0 5px;border-bottom:1pt solid black;border-top:1pt solid black;"><?php foreach ($comm_total as $ctotal):
$total_comm=$ctotal->comtotal;
echo number_format($total_comm,2);
endforeach;?></b></td></tr>
<tr><td style="border:none;text-align:right;width:auto;padding:0 5px;border-bottom:1pt solid black;" colspan="7"><b>Deduction</b> &nbsp;MATERIALS<b> </td>
<td style="border:none;text-align:right;width:auto;padding:0 5px;border-bottom:1pt solid black;"><?php foreach ($materials as $material):
$material_deduction=$material->deductions;
echo  $material_deduction;
endforeach;?></b></td></tr>
<tr><td style="border:none;text-align:right;width:auto;padding:0 5px;border-bottom:1pt solid black;" colspan="7"><b>Total :</td>
<td style="border:none;text-align:right;width:auto;padding:0 5px;border-bottom:1pt solid black;"><?php
$new_total=$total_comm-$material_deduction;
echo  number_format($new_total,2);
?></b></td></tr>
<?php
}
?>
<tr><td style="border:none;text-align: right;width:100%;line-height:20px;" colspan="8"><h6 style="border:none;text-align: center;width:100%;">
Page <?php echo ceil($current/45)+1;?>/<?php echo ceil(count($total)/45);?>.<br/>

<tr><td style="border:none;width:auto;padding:0 5px;align:right" colspan="8">
</table>
</div>
<input type="hidden" id="from" value="<?php echo $from;?>"/>
<input type="hidden" id="to" value="<?php echo $to;?>" />
<input type="hidden" id="diverid" value="<?php echo $diverid;?>" />
<input type="hidden" id="findpdf" value="105"/>