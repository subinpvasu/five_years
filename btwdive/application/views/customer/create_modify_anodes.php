<!--
Project     : BTW Dive
Author      : Subin
Title      : Modify Anodes
Description : Create/Modify anodes by this page.
-->
<script>
$(document).ready(function(){
$("#fieldsearch").keyup(function(){
	var qry = $(this).val();
	 $.ajax({url:base_url+"index.php/customer/searchAnodesEditing/",
			type:"post",
			 data: {
				query:qry
			 },
			 success:function(result){

				 $("#resultant").html(result);
				 $("#resultant tr:even").css("background-color", "#ffffff");
					$("#resultant tr:odd").css("background-color", "#E5E5E5");
				 }
	  });
});
});
function listAllAnodesNow()
{ var qry = '';
	 $.ajax({url:base_url+"index.php/customer/searchAnodesEditing/",
			type:"post",
			 data: {
				query:qry
			 },
			 success:function(result){

				 $("#resultant").html(result);
				 $("#resultant tr:even").css("background-color", "#ffffff");
					$("#resultant tr:odd").css("background-color", "#E5E5E5");
					document.getElementById("anode_one").setAttribute('onclick','addnewAnodeList(1)');
					document.getElementById('anode_one').style.width='auto';
					document.getElementById('anode_one').innerHTML='Save and Exit';
					document.getElementById('anode_two').setAttribute('onclick','addnewAnodeList(2)');
					document.getElementById('anode_two').style.width='auto';
					document.getElementById('anode_two').innerHTML='Save and Continue';
				 }
	  });
}
function displayAnodeList(sbn)
{
	$.ajax({url:base_url+"index.php/customer/displayAnodeList/",
		type:"post",
		 data: {
			anode:sbn
		 },
		 success:function(result){

			var str = result.split("|");
			$("#pk_anode").val(str[0]);
			$("#vessel_type").val(str[1]);
			$("#anode_type").val(str[2]);
			$("#description").val(str[3]);
			$("#rate").val(str[4]);
			$("#installation").val(str[5]);
			$("#schedule_change").val(str[6]);

			document.getElementById("anode_one").setAttribute('onclick','location.reload()');
			document.getElementById('anode_one').innerHTML='NEW';
			document.getElementById('anode_two').setAttribute('onclick','modifyAnodeList()');
			document.getElementById('anode_two').style.width='';
			document.getElementById('anode_two').innerHTML='MODIFY';

			 }
  });
}
function modifyAnodeList()
{
	if($("#vessel_type").val()==''||
			$("#anode_type").val()==''||
			$("#description").val()==''||
			$("#rate").val()==''||
			$("#installation").val()==''||
			$("#schedule_change").val()=='')
		{
		alert("Please Complete the form");
		exit;
		}
	$.ajax({url:base_url+"index.php/customer/modifyAnodeList/",
		type:"post",
		 data: {
            anode:$("#pk_anode").val(),
            vessel:$("#vessel_type").val(),
            anode_type:$("#anode_type").val(),
            description:$("#description").val(),
            rate:$("#rate").val(),
            installation:$("#installation").val(),
            schedule:$("#schedule_change").val()
				 },
		 success:function(result){
alert("Data Updated");
location.reload();
		 }
	});

}
function addnewAnodeList(str)
{
	if($("#vessel_type").val()==''||
			$("#anode_type").val()==''||
			$("#description").val()==''||
			$("#rate").val()==''||
			$("#installation").val()==''||
			$("#schedule_change").val()=='')
		{
		alert("Please Complete the form");
		exit;
		}
	$.ajax({url:base_url+"index.php/customer/addnewAnodeList/",
		type:"post",
		 data: {

            vessel:$("#vessel_type").val(),
            anode_type:$("#anode_type").val(),
            description:$("#description").val(),
            rate:$("#rate").val(),
            installation:$("#installation").val(),
            schedule:$("#schedule_change").val()
				 },
		 success:function(result){
alert("Anode Added.");
if(str==1){self.close();}else{
location.reload();} }
	});

}

function isNumber(n){
	  return (parseFloat(n) == n);
	}



	$("document").ready(function(){
	    $("#rate").keyup(function(event){
	        var input = $(this).val();
	        if(!isNumber(input)){

	            $(this).val(input.substring(0, input .length-1));
	        }

	    });
	});
	$("document").ready(function(){
	    $("#installation").keyup(function(event){
	        var input = $(this).val();
	        if(!isNumber(input)){

	            $(this).val(input.substring(0, input .length-1));
	        }

	    });
	});
	$("document").ready(function(){
	    $("#schedule_change").keyup(function(event){
	        var input = $(this).val();
	        if(!isNumber(input)){

	            $(this).val(input.substring(0, input .length-1));
	        }

	    });
	});
</script>
<img src="dfdsfdsf" width="1px" height="1px" onerror="listAllAnodesNow()"/>
<div style="width:100%;text-align: center;float: left;"><!-- Top Region -->
<h2>Create / Modify Anodes</h2></div>
<div style="width:100%;text-align: center;float: left;height:auto;"><!-- Data Region -->
<div style="width:49.8%;text-align: center;float: left;height:auto;"><!-- Left -->
<h4 style="width:100%;text-align: center;">List Of Existing Anode</h4>
<div style="width:100%;float:left;text-align: center;"><!-- Search Area -->
<input type="text" class="textbox" style="width:70%;" id="fieldsearch"/>
</div>

<div style="width:100%;float:left;text-align: center;margin-top:10px;"><!-- Result Area -->
<div id="resultant" style="width:70%;height:300px;background-color: white;margin: 0px auto;color:black;text-align:left;overflow: auto"></div>
</div>

</div>
<div style="width:49.8%;text-align: center;float: left;height:auto;"><!-- Right -->
<input type="hidden" id="pk_anode" value=""/>
<table style="width:100%;text-align: left;">
<tr><td><b>Vessel Type</b><select class="select" style="display:block;" id="vessel_type">
<option value="0">All</option>
<option value="1">POWER</option>
				<option value="2">POWER WITH OUTDRIVE(S)</option>
				<option value="3">POWER(OUTBOARD)</option>
				<option value="4">SAIL</option>
				<option value="5">TRAWLER</option>
				<option value="6">FISHING BOAT</option>
				<option value="7">OTHER</option>
				<option value="8">YATCH</option>
</select></td></tr>
<tr><td><b>Anode Type</b><textarea class="textarea" style="display:block;" id="anode_type"></textarea></td></tr>
<tr><td><b>Description</b><textarea class="textarea" style="display:block;" id="description"></textarea></td></tr>
<tr><td><b>Anode List Price(Inclucding Installation)</b><input type="text" class="textbox" style="display:block;" id="rate"/></td></tr>
<tr><td><b>Installation Cost</b><input type="text" class="textbox" style="display:block;" id="installation"/></td></tr>
<tr><td><b style="display:block;">Schedule Change</b><input type="text" class="textbox" id="schedule_change"/><b>Months</b></td></tr>
</table>


</div>
</div>
<div style="width:100%;text-align: center;"><!-- Button region -->
<button class="btn" id="anode_one" ></button>
<button class="btn" id="anode_two" ></button>
<button class="btn" onclick="self.close()">Exit</button>
</div>