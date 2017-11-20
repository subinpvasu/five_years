<?php
 require_once dirname(__FILE__) . '/includes/includes.php';
	$type = $_REQUEST['type'];
?>
<div class="account-details-div">
<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>
     
      <th style='width:10%'>Sl. No</th>
<th style='width:25%' align="left">&nbsp;<?php echo USER_NAME ; ?></th>
<th style='width:35%' align="left">&nbsp;<?php echo EMAIL ; ?></th>
<th style='width:10%' align="left">&nbsp;<?php echo TYPE ; ?></th>	
<th style='width:10%'><?php echo EDIT ; ?></th>		
<th style='width:10%'><?php echo DELETE ; ?></th>		
	
    </tr>
  </table>
</div>
<div id="listitems">
<table width="100%"  border="0">

<?php 

$users = $usermanager -> userDetails('',$type);
$i = 0;
foreach($users as $user){ 



?>
<tr>
     
<td style='width:10%'  align="center"><?php echo ++$i; ?></td>
<td style='width:25%' align="left">&nbsp;<?php echo $user->ad_person_name; ?></td>
<td style='width:35%' align="left">&nbsp;<?php echo $user->ad_user_name; ?></td>
<td style='width:10%' align="left">&nbsp;<?php echo $user->user_type_name; ?></td>	
<td style='width:10%'  align="center">
	<a href="#" onclick="return edit(<?php echo $user->ad_user_id; ?>);" ><?php echo EDIT; ?></a></td>		
<td style='width:10%'  align="center"><a href="#"  onclick="return delet(<?php echo $user->ad_user_id; ?>);"><?php echo DELETE; ?></a></td>		
	
    </tr>
	<?php } ?>
</table>
</div>
</div>