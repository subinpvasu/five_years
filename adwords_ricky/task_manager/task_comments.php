<?php
require_once dirname(__FILE__) . '/includes/includes.php';
$task_id = $_REQUEST['id'];
$comments = $taskmanager -> getTaskComments($task_id);

?>
	<table width="98%" height="100%" border="0">
	<tr>
		<td  class="txtcolor2"><b> Task Comments </b></td>
		
	<tr>
	<?php
	foreach($comments as $comment){

	?>

		<tr>
		<td> <b><?php echo $comment-> ad_user_name ; ?> </b> at <?php echo $comment-> created_on ; ?> <hr />
			<?php echo $comment-> task_comment ; ?> 
		</td>
		</tr>
		


	<?php } ?>
	
	
	
	</table>
	<?php if($_SESSION['user_type']==2){ ?>
	<table width="98%" height="100%" border="0" style="margin:10px auto;">
	<tr>
		<td> <textarea name="taskComment" id="taskComment"   rows=5 cols = 125></textarea><br />
		
		<input type="button" name="addcomment" value ="ADD COMMENT" onclick="return add_comment(<?php echo $task_id ; ?>)" />
		</td>
		</tr>
		</table>
		<?php } ?>