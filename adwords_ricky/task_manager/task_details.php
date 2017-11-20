<?php
require_once dirname(__FILE__) . '/includes/includes.php';
$task_id = $_REQUEST['id'];

if($task_id==0){$taskDetails=array(); $add_edit = "Add";}
else{ $taskDetails = $taskmanager -> taskDetails($task_id);$add_edit = "Edit";}

?>

<div id="add_edit_task"  >

<form name="add_edit_form" onSubmit=" return addEditTask()">
	<table width="98%" height="100%" border="0">
	
    <tr>
		<td width="25%">Task</td>
		<td width="75%"><?php echo $taskDetails[0]->task_name; ?></td>
	<tr>
	<tr>
		<td>Description</td>
		<td><?php echo $taskDetails[0]->task_details; ?></td>
	</tr>
	<tr>
		<td>Type</td>
		<td>
		
			<?php echo $taskDetails[0]->task_type_name; ?>
		</td>
	</tr>
	<tr style="display:none;">
		<td>Assigned to</td>
		<td><?php echo $taskDetails[0]->task_assigned_to ; ?></td>
	</tr>
	
	<tr>
		<td>&nbsp;<input type="hidden" name="hiddenId" id="taskId" value="<?php echo $task_id ; ?>" ></td>
		<td><!-- input type="submit" name="add_edit" value="Go" / --></td>
	</tr>
		
	</table>
</form>

<?php include_once('task_comments.php'); ?>

</div>