<script>
function updateCleaningOption(str)
{$("#servicenumber").val(str);
	$.ajax({url:"/btwdive/index.php/customer/updateCleaningOption/",
		type:"post",
		 data: {
            clean:str
				 },
		 success:function(result){
var sbn = result.split("|");
$("#hull").val(sbn[0]);
$("#first").val(sbn[1]);
$("#second").val(sbn[2]);
$("#listf").val(sbn[3]);
$("#lists").val(sbn[4]);
$("#frequency").val(sbn[5]);
document.getElementById("service_one").setAttribute('onclick','location.reload()');
document.getElementById("service_one").innerHTML='Add New';
		 }
	});
}

function updateHullcleanOption()
{
	if(isNaN($("#servicenumber").val()))
	{
alert("No Service Selected");exit;
	}
	$.ajax({url:"/btwdive/index.php/customer/updateHullcleanOption/",
		type:"post",
		 data: {
		hull:$("#servicenumber").val(),
		name:$("#hull").val(),
		descf:$("#first").val(),
		descs:$("#second").val(),
		ratef:$("#listf").val(),
		frequ:$("#frequency").val(),
		rates:$("#lists").val()
				 },
		 success:function(result){
alert("Record for Hull Clean Updated");
location.reload();
		 }
	});
}
function createHullcleanOption()
{
	if($("#hull").val()==''||$("#first").val()==''||$("#listf").val()=='')
	{
alert("Please Complete the form");exit;
	}
	$.ajax({url:"/btwdive/index.php/customer/createHullcleanOption/",
		type:"post",
		 data: {
		
		name:$("#hull").val(),
		descf:$("#first").val(),
		descs:$("#second").val(),
		ratef:$("#listf").val(),
		frequ:$("#frequency").val(),
		rates:$("#lists").val()
				 },
		 success:function(result){
alert("Record for Hull Clean Inserted.");
location.reload();
		 }
	});
}
$(document).ready(function(){
	$("#cleandelete").click(function(){
		if(!isNaN($("#servicenumber").val())){
		var r = confirm("Are You Sure You Want to Delete the record?");
		if(!r){exit;}
		}else{
alert("No Service Selected");
			exit;}
$.ajax({url:"/btwdive/index.php/customer/removeHullcleanOption/",
	type:"post",
	data:{
hull:$("#servicenumber").val()
		},
		success:function(result){
alert("Data Deleted ");
location.reload();
			}
	
});
		});
});
function isNumber(n){
	  return (parseFloat(n) == n);
	}


	
	$("document").ready(function(){
	    $("#listf").keyup(function(event){
	        var input = $(this).val();
	        if(!isNumber(input)){
	           
	            $(this).val(input.substring(0, input .length-1));
	        }
	           
	    });
	});
	$("document").ready(function(){
	    $("#lists").keyup(function(event){
	        var input = $(this).val();
	        if(!isNumber(input)){
	           
	            $(this).val(input.substring(0, input .length-1));
	        }
	           
	    });
	});
</script>
<input type="hidden" id="servicenumber" value="a"/>
 <div style="width:100%;text-align: center;float: left;"><!-- Top Region -->
<h2>Create / Modify Hull Cleaning</h2></div>
<div style="width:100%;float:left;text-align: center;">
<h4 style="width:100%;text-align: center;">Select Hull Cleaning Service to Modify</h4>

<select class="select" style="width:40%;" onchange="updateCleaningOption(this.value)">
<option></option>
<?php 
foreach($clean as $c):
echo '<option value="'.$c->PK_HC.'">'.$c->SERVICE_NAME.'</option>';
endforeach;
?>
</select><form id="service_clean">
<fieldset style="width:40%;margin: 0px auto;border-right:2px solid white;">
<legend><b style="color:white;">Hull Cleaning Rates</b></legend>
<input type="text" class="textbox" style="width:70%;" id="hull"/>
<b style="display: block;text-align: left;">First Service</b>
<textarea class="textarea" style="width:70%;" id="first"></textarea>
<b style="display: block;text-align: left;">Second Service</b>
<textarea class="textarea" style="width:70%;" id="second"></textarea>
<table style="width:100%;text-align: center;">
<tr><td style="width:30%;text-align: right;">Frequency</td><td style="width:60%;text-align:left;"><select class="select" style="" id="frequency">
<option value="7" >Weekly</option>
<option value="2">Bi-Monthly</option>
<option value="3">Three Weeks</option>
<option value="1" selected>Monthly</option>
<option value="6">Six Weeks</option>
<option value="8">Two Months</option>
<option value="12">Three Months</option>
<option value="16">Four Months</option>
</select></td></tr>
<tr><td style="width:30%;text-align: right;">First Service List Price</td><td style="width:60%;text-align:left;"><input type="text" class="textbox" style="width:auto;" id="listf"/></td></tr>
<tr><td style="width:30%;text-align: right;">Second Service List Price</td><td style="width:60%;text-align:left;"><input type="text" class="textbox" style="width:auto;" id="lists"/></td></tr></table>
</fieldset>
</form>
</div>
<div style="width:100%;float: left;text-align: center;">
<button class="btn" onclick="createHullcleanOption()" id="service_one">Save New</button>
<button class="btn" id="cleandelete">Delete</button>
<button class="btn" style="width:auto;" onclick="updateHullcleanOption()">Update Hull Cleaning</button>
<button class="btn" onclick="self.close()">Exit</button>
</div>