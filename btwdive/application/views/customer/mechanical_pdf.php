<!--
Project     : BTW Dive
Author      : Subin
Title      : Mechanical PDF
Description : Mechanical turns to PDF here
-->
<?php  foreach ($customers as $customer):?>
<table style="width:100%;border-collapse:collapse;font-size: 12px;">
<tr><td style="width:49%"><h3 style="height:1px;margin:0px;padding:0px;">MECHANICAL SERVICES</h3></td>
<td style="width:49%;text-align: right;"><h3 style="height:1px;margin:0px;padding:0px;">BTW : 310.918.5631</h3></td></tr>
<tr><td><h4><?php  echo $customer->W; ?></h4></td>
<td style="text-align: left;">Schedule Date <b><?php echo $customer->SD;?></b></td></tr>
<tr><td colspan="2" style="text-align: center;border:2px solid black;border-collapse:collapse;white-space: nowrap;"><span style="width: 38%; float: left;display: inline-block;">
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
foreach ($mechanical as $m):
if($m->WORK_VALUE>0):
echo '
<tr>

<td>'.$m->WORK_DESCRIPTION.'</td>
<td style="width:5%;"><input type="checkbox"/></td><td style="font-weight:bold">Diver</td><td style="font-weight:bold">Date</td></tr>
</tr>
';

endif;
$comments = $m->COMMENTS;
endforeach;
echo '</table>'
?>
</td></tr>
<?php
if($second==0){
?>
<tr><td style="font-weight: bold;">Comments/Quality Control</td></tr>
<tr><td><?php echo $comments;?></td></tr>
<?php }?>
</table>
<?php if($second==0){ ?>
<b style="page-break-after: always;"></b>
<?php }else{
    echo '<hr/><br/>';
}?>
