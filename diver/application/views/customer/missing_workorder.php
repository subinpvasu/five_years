<script type="text/javascript">
function getMissingWO()
{
	$("#dispMissingWO").html('<img width="100px" height="100px" src="<?php echo base_url() ?>img/loading_gif.gif" style="position:relative;top:0px;left:0px;">');
		$.ajax({url:"/btwdive/index.php/customer/displayMissingWo/",
			type:"post",
			 data: {
				 						
			 },
			 success:function(result){
				 
					$("#dispMissingWO").html(result);
					$("#dispMissingWO tr:even").css("background-color", "#ffffff");
					$("#dispMissingWO tr:odd").css("background-color", "#E5E5E5");
					$("#dispMissingWO tr:even").css("color", "#000000");
					$("#dispMissingWO tr:odd").css("color", "#000000");
					//$("#ctotal").val()
					}
	  });
	
}

</script>
<body onload="getMissingWO()">
<input type="hidden" id="bsurl" value="<?php echo base_url()?>"/>
<img src="asdsa" width="1px" height="1px" onerror="updateList(5)"/>
<h2 style="width:100%;text-align: center;">CUSTOMERS NOT HAVING ANY OPEN WORK ORDERS </h2>

<div style="width:100%;float:left;text-align: center;">
<table style="width:99%;float:left;text-align: center;padding-left:0px;">
<tr style="background-color: grey;">
<th style="width:20%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Account #</th>
<th style="width:25%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Customer Name</th>
<th style="width:15%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Vessel Name</th>
<th style="width:24%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Location</th>
<th style="width:15%;float:left;text-align: center;background-color: grey;">Last Work Order</th>
</tr>
</table>
<div style="width:101.4%;float:left;text-align: center;padding-left:0px;height:450px;overflow-y: scroll;" id="dispMissingWO">

</div>
<div class="exit"><button onclick="self.close();" class="btn" style="margin-top:0%">Exit</button></div>
</div>
</div>

</body>

 
