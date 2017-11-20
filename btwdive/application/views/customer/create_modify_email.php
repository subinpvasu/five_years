<!--
Project     : BTW Dive
Author      : Subin
Title      : Modify Email contents.
Description : Create/Modify Email contents
-->
<script>
function updateEmailText()
{
	var reference  = document.getElementById("refer").value;
	var salutation = document.getElementById("salute").value;
	var detail1    = document.getElementById("detail1").value;
	var detail2    = document.getElementById("detail2").value;
	var detail3    = document.getElementById("detail3").value;
	var detail4    = document.getElementById("detail4").value;

	 $.ajax({url:base_url+"index.php/customer/updateEmailText/",
			type:"post",
			 data: {
				refer:reference,
				salute:salutation,
				detaila:detail1,
				detailb:detail2,
				detailc:detail3,
				detaild:detail4
			 },
			 success:function(result){

				 if(result>0)
				 {
alert("Email Text Updated Successfully.");
self.close();
				 }
				 }
	  });
}

</script>
<div style="width: 100%; text-align: center; float: left">
	<h3 style="width: 100%; text-align: center;">Edit Email Text</h3>
<?php foreach($mail as $m):?>
<table style="width: 50%; text-align: center; margin: 0px auto;">

		<tr>
			<td style="width: 20%"><b>Reference</b></td>
			<td style="text-align: left; width: 70%"><input type="text"
				class="textbox" style="width: 75%" id="refer" value="<?php echo $m->dcode;?>" /></td>
		</tr>
		<tr>
			<td>Salutation</td>
			<td style="text-align: left; width: 70%"><input type="text"
				class="textbox" style="width: 75%" value="<?php echo $m->dheader;?>" id="salute" /></td>
		</tr>
		<tr>
			<td>Details - 1</td>
			<td style="text-align: left; width: 70%"><textarea class="textarea" id="detail1"
					style="width: 75%"><?php echo $m->ddetail1;?></textarea></td>
		</tr>
		<tr>
			<td>Details - 2</td>
			<td style="text-align: left; width: 70%"><textarea class="textarea" id="detail2"
					style="width: 75%"><?php echo $m->ddetail2;?></textarea></td>
		</tr>
		<tr>
			<td>Details - 3</td>
			<td style="text-align: left; width: 70%"><textarea class="textarea" id="detail3"
					style="width: 75%"><?php echo $m->ddetail3;?></textarea></td>
		</tr>
		<tr>
			<td>Details - 4</td>
			<td style="text-align: left; width: 70%"><textarea class="textarea" id="detail4"
					style="width: 75%"><?php echo $m->ddetail4;?></textarea></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: center;"><button class="btn" onclick="updateEmailText()" >Modify</button>
				<button class="btn" onclick="self.close()">Exit</button></td>
		</tr>

	</table>

<?php endforeach;?>

</div>