<?php  foreach ($customers as $customer):?>
<table style="width:100%;border-collapse:collapse;font-size: 12px;">
<tr><td style="width:49%"><h3 style="height:1px;margin:0px;padding:0px;">HULL CLEANING</h3></td>
<td style="width:49%;text-align: right;"><h3  style="height:1px;margin:0px;padding:0px;">BTW : 310.918.5631</h3></td></tr>
<tr><td><h4 ><?php  echo $customer->W; ?></h4></td>
<td style="text-align: left;">Schedule Date <b><?php echo $customer->SD;?></b></td></tr>
<tr><td colspan="2" style="text-align: center;border:2px solid black;border-collapse:collapse;"><span style="width: 30%; float: left;display: inline-block;">
<b>LOCATION : <?php echo $customer->O."&nbsp;".$customer->S;?></b></span>
<span style="width: 30%; float: left;display: inline-block;"><b><?php echo $customer->F.'&nbsp;'.$customer->L;?></b></span>
<span style="width: 30%; float: left;display: inline-block;">
<b>PAINT CYCLE
<?php 
switch ($customer->PC)
{
    case 1:
        echo 'A';
        break;
    case 2:
        echo 'B';
        break;
    case 3:
        echo 'C';
        break;
    case 4:
        echo 'D';
        break;
}

?> 



</b></span></td></tr>
<tr><td colspan="2" style="border:2px solid black;border-collapse:collapse;">
<span style="width:24%;float:left;display: inline-block;">Vessel Name</span>
<span style="width:24%;float:left;display: inline-block;">Length</span>
<span style="width:24%;float:left;display: inline-block;">Vessel Make</span>
<span style="width:24%;float:left;display: inline-block;">Type</span></td></tr>
<tr><td colspan="2" style="border:2px solid black;border-collapse:collapse;">
<span style="width:24%;float:left;display: inline-block;"><?php echo $customer->V;?></span>
<span style="width:24%;float:left;display: inline-block;"><?php echo $customer->LEN;?></span>
<span style="width:24%;float:left;display: inline-block;"><?php echo $customer->MAK;?></span>
<span style="width:24%;float:left;display: inline-block;"><?php echo $customer->TP;?></span></td></tr>
<?php endforeach;?>
<tr><td colspan="2">
<?php
echo '<table style="width:100%;border-collapse:collapse;font-size: 12px;">';
$comments = '';
foreach ($cleanings as $c):
if($c->WORK_VALUE>0):
echo '
<tr>

<td style="width:40%;margin:0px;padding:0px;height:15px;">'.$c->WORK_DESCRIPTION.'</td>
<td style="height:15px;">Vessel Cleaned</td>
 <td style="width:5%;margin:0px;padding:0px;height:15px;"><input style="height:15px;margin-top:-5px;" type="checkbox"/></td>
 <td style="font-weight:bold;height:15px;">Diver</td>
 <td style="font-weight:bold;height:15px;">Date</td></tr>
';

endif;

$comments = $c->COMMENTS;
endforeach;
echo '</table>';


?>
</td></tr><?php 
if($second==0){
?>
<tr><td colspan="2">
<div style="border:2px solid black;width:70%;">
<table style="width:100%;border-collapse:collapse;font-size: 12px;">
<tr>
<th ></th><th style="text-align:left;">Replace?</th>
</tr>
<?php 
foreach($anodes as $and):
echo '<tr><td style="width:90%;margin:0px;padding:0px;height:15px">'.$and->ANODE_TYPE.'</td><td style="height:15px;"><input style="height:15px;"  type="checkbox" /></td></tr>';
endforeach;
?>

</table>
</div>
</td></tr>

<tr><td style="font-weight: bold;">Comments/Quality Control</td></tr>
<tr><td><?php echo $comments;?></td></tr>
<?php }?>
</table>
<?php if($second==0){ ?>
<b style="page-break-after: always;"></b>
<?php }else{
    echo '<hr/><br/>';
}?>