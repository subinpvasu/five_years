<?php
require_once dirname(__FILE__) . '/includes/includes.php';
$id = $_REQUEST['id'];

if($id==0){$details=array(); $add_edit = "Add";}
else{ $details = $usermanager -> userDetails($id);$add_edit = "Edit";}

$accountMans = explode(",",$details[0]->user_users);
 
?>

<div id="add_edit_task" >

<form name="add_edit_form" onSubmit="return addEdit()">
    <table width="98%" height="100%" border="0">	
        <tr>
            <td width="25%">Name</td>
            <td width="75%"><input type="text" name="txtName" id="taskName" value = "<?php echo $details[0]->ad_person_name; ?>" /></td>
	<tr>
	<tr>
            <td>Email</td>
            <td><input type="text" name="txtName" id="userEmail" value = "<?php echo $details[0]->ad_user_name; ?>" /></td>
	</tr>
	<tr>
            <td>Type</td>
            <td>
            <select name="selType"  id="ItemType" onchange="SelectAccountManagers(this,'<?php echo $add_edit; ?>');"   >
            <?php
                    $types = $usermanager -> getUserTypes();
                    foreach($types as $type=>$name)
                    {
                        if($type <>0){
                            if($type==$details[0]->ad_user_type) $selected = "selected"; else $selected = "";
                                echo "<option value='".$type."' $selected >".$name."</option>";
                        }
                    }
                    ?>
            </select>
            </td>
	</tr>
	<?php if($id<>0) { ?>
	<tr>
            <td>Check to change Password</td>
            <td><input type="checkbox" id="changePass" style="width:10px;" onchange="passChangeOk();"; /></td>
	</tr>
	<?php } ?>
	<tr class="pass">
            <td width="25%">New Password</td>
            <td width="75%"><input type="password" name="txtName" id="newpass" value = "" /></td>
	<tr>
	<tr class="pass">
            <td>Confirm Password</td>
            <td><input type="password" name="txtName" id="confpass" value = "" /></td>
	</tr>	
	<tr class="urlchk" <?php if($id<>0 && ($details[0]->ad_user_type==1 || $details[0]->ad_user_type == 4)) {} else { ?>  style="display:none;" <?php } ?> >
            <td>Check to change Url to Spread Sheet  </td>
            <td><input type="checkbox" id="changeUrl" style="width:10px;" onchange="urlChangeOk();"; /></td>
	</tr>
	<tr class="url" <?php if($id<>0) { ?>  style="display:none;" <?php } ?>>
		<td>Url to Spread Sheet</td>
		<td><textarea name="txtarSpreadSheet" id="txtarSpreadSheet" rows="5" cols="35" ></textarea></td>
	</tr>
	
	<tr id="SelectAccountManagers" <?php if($details[0]->ad_user_type<>3) { ?> style="display:none;" <?php } ?>>
	 <td><div>Select Account Managers</div></td><td><div>
	 
	 <?php
		$accountManagers = $usermanager -> userDetails("",1);
		foreach($accountManagers as $accountManager){ ?>
		
		<input type="checkbox" name="check_list[]" value="<?php echo $accountManager->ad_user_id ; ?>"  <?php if(in_array($accountManager->ad_user_id,$accountMans)) echo "checked=checked"; ?> style="width:10px;">&nbsp;<?php echo $accountManager->ad_user_name; ?><br/>
	<?php	}
	 
	 ?>
	 
	 </div></td>
	 
	</tr>
	<tr>
		<td>&nbsp;<input type="hidden" name="hiddenId" id="Item_Id" value="<?php echo $id ; ?>" ></td>
		<td><input type="submit" name="add_edit" value="Go" /></td>
	</tr>
	</table>
</form>

</div>