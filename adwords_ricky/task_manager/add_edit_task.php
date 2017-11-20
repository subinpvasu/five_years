<?php
require_once dirname(__FILE__) . '/includes/includes.php';
$task_id = $_REQUEST['id'];

if($task_id==0){$taskDetails=array(); $add_edit = "Add";}
else{ $taskDetails = $taskmanager -> taskDetails($task_id);$add_edit = "Edit";}

?>

<div id="add_edit_task">

<form name="add_edit_form" onSubmit=" return addEditTask()">
	<table width="100%" height="100%" border="0">

    <tr>
		<td width="25%">Task</td>
		<td width="75%"><input type="text" name="txtName" id="taskName" value = "<?php echo $taskDetails[0]->task_name; ?>" /></td>
	<tr>
	<tr>
		<td>Description</td>
		<td><textarea name="textarDescription" id="taskDesc" ><?php echo $taskDetails[0]->task_details; ?></textarea></td>
	</tr>
	<tr>
		<td>Type</td>
		<td>
		<select name="selType"  id="taskType" >
		<?php
			$taskTypes = $taskmanager -> getTaskTypes();
			foreach($taskTypes as $tasktype=>$tasktypename)
			{
				if($tasktype <>0){
				    if($tasktype==$taskDetails[0]->task_type) $selected = "selected"; else $selected = "";
					echo "<option value='".$tasktype."' $selected >".$tasktypename."</option>";
				}
			}

			?>
		</select>
		
		</td>
	</tr>
	<tr style="display:none;">
		<td>Assigned to</td>
		<td><select name="selTo"  id="taskTo">
		<?php
			$getUserDetails = $users -> getUserDetails(0,1);
			foreach($getUserDetails as $user)
			{
				if($user->ad_user_id == $taskDetails[0]->task_assigned_to) $select = "selected";
				else $select = "";
				
				echo "<option value='".$user->ad_user_id."' $select >".$user->ad_user_name."</option>";
			}

			?>
		</select></td>
	</tr>
	<tr>
		<td>&nbsp;<input type="hidden" name="hiddenId" id="taskId" value="<?php echo $task_id ; ?>" ></td>
		<td><input type="submit" name="add_edit" value="Go" /></td>
	</tr>
	</table>
</form>

</div>