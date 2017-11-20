<?php
 require_once dirname(__FILE__) . '/includes/includes.php';
	$type = $_REQUEST['type'];
?>
<div class="account-details-div">
<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>
     
      <th style='width:10%' align="center">Sl. No</th>
		<th style='width:25%' align="left">&nbsp;<?php echo TASK ; ?></th>
		<th style='width:35%' align="left">&nbsp;<?php echo DESCRIPTION ; ?></th>
		<th style='width:10%' align="left">&nbsp;<?php echo TYPE ; ?></th>	
		<th style='width:10%'><?php echo DETAILS ; ?></th>		
		<th style='width:10%'><?php echo COMMENTS ; ?></th>		
	
    </tr>
  </table>
</div>
<div id="listitems">
<table width="100%"  border="0">



<?php 

$tasks = $taskmanager -> taskDetails('',$type);
$i = 0;
foreach($tasks as $task){ 

?>
<tr>
     
<td style='width:10%' align="center" ><?php echo ++$i; ?></td>
<td style='width:25%' align="left">&nbsp;<?php echo $task->task_name; ?></td>
<td style='width:35%' align="left">&nbsp;<?php echo $task->task_details; ?></td>
<td style='width:10%' align="left">&nbsp;<?php echo $task->task_type_name; ?></td>	
<td style='width:10%'  align="center">
	<a href="#" onclick="return taskDetails(<?php echo $task->task_id; ?>);" id="taskDetails_<?php echo $task->task_id; ?>"><?php echo DETAILS; ?></a></td>		
<td style='width:10%'  align="center"><a href="#"  onclick="return taskComments(<?php echo $task->task_id; ?>);" id="taskComments_<?php echo $task->task_id; ?>"><?php echo COMMENTS; ?></a></td>		
	
    </tr>
	<?php } ?>
</table>
</div>
</div>