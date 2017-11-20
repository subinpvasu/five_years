<script>
$(function() {
	$( "#scheduledate" ).datepicker();
	//$( "#scheduledate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	//changewoNumber();
	});
$(function(){
	$("#keepdata").click(function(){
alert("clean");
		});
});
$(document).ready(function(){
	var schdate = window.parent.document.getElementById("schedule").value;
	//alert(schdate);
	$("#scheduledate").val(schdate);
});
function underconstruction()
{
	alert("Under Construction.");
}
function updateCleanWorkOrderFrame()
{
	if($(":checkbox").is(":checked"))
	{ 
	var pkw         = document.getElementById("workpart").value;
	var nums = pkw.split("|");
	var diver       = document.getElementById("diver").value;
	var startdate   = document.getElementById("scheduledate").value;
	var comments    = document.getElementById("comments").value;
	var workno      = window.parent.document.getElementById("wonumber").value;
	var customer    = window.parent.document.getElementById("wocustomer").value;
    var vessel      = window.parent.document.getElementById("wovessel").value;
    
    var wclass = 'C';
    
    var proc;
   if(isValidDate(startdate)){
    $.ajax({url:"/btwdive/index.php/customer/addWorkOrder/",
		type:"post",
		 data: {
			 wocustomer:customer,
			 wovessel:vessel,
			 wonum:workno,
			 woclass:wclass,
			 date:startdate,
			 divers:diver,
			 commentspk:comments
		 },
		 success:function(result){
				$("#wopkc").val(result);
				 for(var i=1;i<(nums.length);i++)
				    {
				    	try{
				    	var price     = document.getElementById("price"+nums[i]).value;
				    	var discount  = document.getElementById("discount"+nums[i]).value;
				    	var disprice  = document.getElementById("disprice"+nums[i]).value; 
				    	/*var change    = document.getElementById("change"+nums[i]).checked;
				        var need      = document.getElementById("need"+nums[i]).checked;
				    	var inspect   = document.getElementById("inspect"+nums[i]).checked;*/
				    	var process   = document.getElementById("process"+nums[i]).checked;
				    	var type      = document.getElementById("type"+nums[i]).value;
				    	var descr     = document.getElementById("description"+nums[i]).value;
				    	var andate    = '0000-00-00';
				    	var workpk    = document.getElementById("wopkc").value;
				    	var workname  = document.getElementById("wkname"+nums[i]).value;
				    	var temp      = nums[i];
				        var changing  = '----';
				        }catch(e){//alert(e.message);
				        	}
				    	if(process)
				    	{ var proc = 1;
				        
				    		$.ajax({url:"/btwdive/index.php/customer/addWorkOrderParts/",
				    			type:"post",
				    			 data: {
				    				pkwork:workpk,//e
				    				wkname:workname,
				    				wkclass:wclass,
				    				wkprice:price,
				    				wkdiscount:discount,
				    				wkdisprice:disprice,
				    				wkprocess:proc,
				    				wktype:type,
				    				date:andate,
				    				description:descr,
				    				changes:changing,
				    				wkpk:temp		//e 		 
				    			 },
				    			 
				    	  });
				    	}
				    
				    }
				
				}
  });
   
  //  alert("Cleaning Work Order Updated Successfully!");
    
	}else
	{
		alert("Schedule Date is not Valid");
		exit;
			}
	}
	else
	{
		var totalwork = window.parent.document.getElementById("workordertotal").value;
		var total = parseInt(totalwork);
		total++;
		window.parent.document.getElementById("workordertotal").value=total;
//alert("No Cleaning Work Order Selected.");
	}
	
}
function updateDisprice(thisid,thisvalue)
{
	if(isNaN(thisvalue) || thisvalue==''){thisvalue=0;}
	//alert(thisid+"|"+thisvalue);//discount134685|10.00str.replace("Microsoft","W3Schools"); 
	var curid = thisid.replace("discount","price");
	var curvalue = document.getElementById(curid).value;
	var disvalue = (parseFloat(curvalue)-((parseFloat(curvalue)*parseFloat(thisvalue))/100)).toFixed(2);
	var nid = curid.replace("price","disprice");
	//document.getElementById(nid).value=disvalue;
	if(parseFloat(disvalue)){document.getElementById(nid).value=disvalue;}
	else{document.getElementById(nid).value='0';}
	
} 
function updateLisprice(thisid)
{
	var curid = thisid.replace("price","discount");
	document.getElementById(curid).focus();
}
function isValidDate(s) {
	 var bits = s.split('/');
	 var y = bits[2], m  = bits[0], d = bits[1];
	  
	  var daysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31];

	  
	  if ( (!(y % 4) && y % 100) || !(y % 400)) {
	    daysInMonth[1] = 29;
	  }
	 return d <= daysInMonth[--m];
} 
function changewoNumber()
{
	var str = document.getElementById("scheduledate").value;//2014-03-14--031414
var won = window.parent.document.getElementById("accountno").value;
	
	if(isValidDate(str))
	{
var d = str.split("");//2,0,1,4,-,0,3,-,1,4
var datepart = d[0]+""+d[1]+""+d[3]+""+d[4]+""+d[8]+""+d[9];
var wonom = won+" - "+datepart;
var wonum = "Work Order # : "+won+" - "+datepart;
//alert(wonum);
window.parent.document.getElementById("number_work").innerHTML=wonum;
window.parent.document.getElementById("wonumber").value=wonom;
	}
	else
	{
	alert("Invalid Schedule Date");exit;
	}
}
$(document).ready(function(){
	if($("#statuschecker").val()>0)
	{//alert("good");
$(":checkbox").click();
	}
});
</script>

<button onclick="updateCleanWorkOrderFrame()" style="display:none;" id="saveCleanedFrame"></button>
<input type="hidden" name="" id="wopkc" value=""/>

<h3 style="float:none;width:100%">Schedule Cleaning Services</h3>


<!-- table with cleaning details -->
<div style="text-align:center;">
<table style="padding-bottom:20px;">
<tr>
<th>List Price</th><th>Discount</th><th>Cost</th><th>Process</th><th>Type</th><th>Description</th>
</tr>
<?php
//add flag here to check the cond'n

$olderpk = explode("^",urldecode($older));
$workparts = '';
if((count($olderpk)-1)==count($cleanings))
{
    echo '<input type="hidden" name="pppp" id="statuschecker" value="1"/>';
}
else
{
    echo '<input type="hidden" name="pppp" id="statuschecker" value="0"/>';
}
echo '<input type="hidden" id="temper" value="'.count($olderpk).'|'.count($cleanings).'"/>';
 foreach ($cleanings as $c):
echo '
<tr>
<td><input class="textbox" onblur="updateLisprice(this.id)" style="width:auto;" type="text" id="price'.$c->PK_VESSEL_SERVICE.'" value="'.$c->LIST_PRICE.'" /></td>
<td><input class="textbox" style="width:auto;" onfocus="updateDisprice(this.id,this.value)" onkeyup="updateDisprice(this.id,this.value)"  type="text" id="discount'.$c->PK_VESSEL_SERVICE.'" value="'.$c->DISCOUNT.'"/></td>
<td><input class="textbox" style="width:auto;" type="text" id="disprice'.$c->PK_VESSEL_SERVICE.'" value="'.$c->DISCOUNT_PRICE.'"/></td>';

if(in_array($c->PK_VESSEL_SERVICE, $olderpk))
{
    echo ' <td><input type="checkbox"   id="process'.$c->PK_VESSEL_SERVICE.'" value="1"/></td>';
}
else
{
   echo ' <td><input type="checkbox" checked  id="process'.$c->PK_VESSEL_SERVICE.'" value="1"/></td>';
}

echo '<td><input class="textbox" style="width:auto;" type="text" id="type'.$c->PK_VESSEL_SERVICE.'" value="'.$c->SERVICE_TYPE.'"/></td>
<td>
<textarea class="textarea" id="description'.$c->PK_VESSEL_SERVICE.'">'.$c->DESCRIPTION.'</textarea>
<!--<input class="textbox" style="width:auto;" type="text" id="description'.$c->PK_VESSEL_SERVICE.'" value="'.$c->DESCRIPTION.'"/>-->
<input type="hidden" id="wkname'.$c->PK_VESSEL_SERVICE.'" value="'.$c->SERVICE_TYPE.'" /></td>
</tr>
';
 $workparts = $workparts."|".$c->PK_VESSEL_SERVICE;

endforeach;
?>
</table>
<input type="hidden" id="workpart" value="<?php echo $workparts?>"/>
</div>

<!-- notes and comments -->
<div class="note_comments" style="width:99%;float:left;text-align: center;margin-top:25px;">
<!-- notes -->
<div style="width:48%;float:left;">
<h4 style="width:100%;text-align:center">Notes and Comments For Work Order</h4>
<?php 
$komments = '';
foreach($comments as $cmt):
$komments = $cmt->CLEANING;
endforeach;
?>

<textarea style="width:55%;height:100px" id="comments"><?php echo $komments;?></textarea>
</div>
<div  style="width:48%;float:left;">

				<br />
				<br />
Schedule Date : <input type="text" name="scheduledate" class="textbox" onchange="changewoNumber()"  value="" id="scheduledate"/><br/><br/>
Assigned Diver:<select name="diver" class="select" id="diver">
<option value="">Select Diver</option>
<?php
foreach ($divers as $diver):

    echo '<option  value="'.$diver->PK_DIVER.'">'.$diver->DIVER_NAME.'</option>';

endforeach;
?>
</select>
</div>
</div>

