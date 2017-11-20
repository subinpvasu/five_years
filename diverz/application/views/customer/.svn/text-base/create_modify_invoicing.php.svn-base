<script>
function updateInvoiceText()
{
	var detail1    = document.getElementById("detail1").value;
	var detail2    = document.getElementById("detail2").value;
	var detail3    = document.getElementById("detail3").value;
	

	 $.ajax({url:"/btwdive/index.php/customer/updateInvoiceText/",
			type:"post",
			 data: {
				
				detaila:detail1,
				detailb:detail2,
				detailc:detail3
						 
			 },
			 success:function(result){

				 if(result>0)
				 {
alert("Invoice Text Updated Successfully.");
self.close();
				 }
				 }
	  });
}

</script>
<div style="width:100%;text-align: center;float:left;">
<h3 style="width:100%;text-align: center;float:left;">Customize Invoice Text</h3>
<?php foreach($invoice as $i):?>
<table style="width:60%;margin: 0px auto;text-align: left;">

<tr><td style="width:15%;">Details - 1</td><td style="width:80%"><textarea class="textarea" style="width:80%;" id="detail1"><?php echo $i->ddetail1;?></textarea></td></tr>
<tr><td>Details - 2</td><td><textarea class="textarea" style="width:80%;"  id="detail2"><?php echo $i->ddetail2;?></textarea></td></tr>
<tr><td>Details - 3</td><td><textarea class="textarea" style="width:80%;"  id="detail3"><?php echo $i->ddetail3;?></textarea></td></tr>
<tr><td colspan="2" style="text-align: center;"><button class="btn" onclick="updateInvoiceText()">Modify</button>
 <button class="btn" onclick="self.close()">Exit</button></td></tr>

</table>
<?php endforeach;?>
</div>