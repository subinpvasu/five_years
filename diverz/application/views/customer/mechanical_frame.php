<script>
$(function() {
	$( "#scheduledate" ).datepicker();
	//$( "#scheduledate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	});
function underconstruction()
{
	alert("Under Construction.");
}
function updateMechWorkOrderFrame()
{
	if($(":checkbox").is(":checked"))
	{ 
	
	var diver       = document.getElementById("diver").value;
	var startdate   = document.getElementById("scheduledate").value;
	var comments    = document.getElementById("comments").value;
	var workno      = document.getElementById("wonumber").value;
	var customer    = window.parent.document.getElementById("wocustomer").value;
    var vessel      = window.parent.document.getElementById("wovessel").value;
    
    var wclass = 'M';
    
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
				$("#wopkm").val(result);
				 for(var i=0;i<4;i++)
				    {
				    	try{
				    	var price     = document.getElementById("price"+i).value;
				    	var discount  = document.getElementById("discount"+i).value;
				    	var disprice  = document.getElementById("disprice"+i).value; 
				    	/*var change    = document.getElementById("change"+nums[i]).checked;
				        var need      = document.getElementById("need"+nums[i]).checked;
				    	var inspect   = document.getElementById("inspect"+nums[i]).checked;*/
				    	var process   = document.getElementById("process"+i).checked;
				    	var type      = document.getElementById("type"+i).value;
				    	var descr     = document.getElementById("description"+i).value;
				    	var andate    = '0000-00-00';
				    	var workpk    = document.getElementById("wopkm").value;
				    	var workname  = 0;
				    	var temp      = 0;
				        
				        }catch(e){alert(e.message);
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
				    				wkpk:temp		//e 		 
				    			 },
				    			 
				    	  });
				    	}
				    
				    }
				
				}
  });
   
  //  alert("Mechanical Work Order Updated Successfully!");
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
//alert("No Mechanical Work Order Selected.");
	}
}
function updateDisprice(thisid,thisvalue)
{
	if(isNaN(thisvalue) || thisvalue==''){thisvalue=0;}
	//alert(thisid+"|"+thisvalue);//discount134685|10.00str.replace("Microsoft","W3Schools"); 
	var curid = thisid.replace("discount","price");
	var checkid = thisid.replace("discount","process");
	var curvalue = document.getElementById(curid).value;
	var disvalue = (parseFloat(curvalue)-((parseFloat(curvalue)*parseFloat(thisvalue))/100)).toFixed(2);
	var nid = curid.replace("price","disprice");
	if(parseFloat(disvalue)){document.getElementById(nid).value=disvalue;}
	else{document.getElementById(nid).value='0';}
	document.getElementById(checkid).checked=true;
	
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
document.getElementById("number_work").innerHTML=wonum;
document.getElementById("wonumber").value=wonom;
	}
	else
	{
	alert("Invalid Schedule Date");exit;
	}
}
</script>
<button onclick="updateMechWorkOrderFrame()" style="display:none;" id="saveMechFrame"></button>
<input type="hidden" name="" id="wopkm" value=""/>
<input type="hidden" id="number_work" value="" />
<input type="hidden" id="wonumber" value="" />
<img src="ghghgbh" onerror="changewoNumber()" width="1px" height="1px"/>
<h3 style="float:none;width:100%">Set Mechanical Services</h3>
<div style="text-align:center;">
<table style="padding-bottom:20px;">
<tr>
<th>List Price</th><th>Discount</th><th>Cost</th><th>Process</th><th>Type</th><th>Description</th>
</tr>
<?php 
for($i=0;$i<4;$i++):
echo '
<tr>
<td><input class="textbox" onblur="updateLisprice(this.id)" style="width:auto;" type="text" id="price'.$i.'" value="" /></td>
<td><input class="textbox" onfocus="updateDisprice(this.id,this.value)" onkeyup="updateDisprice(this.id,this.value)" style="width:auto;" type="text" id="discount'.$i.'" value=""/></td>
<td><input class="textbox" style="width:auto;" type="text" id="disprice'.$i.'" value=""/></td>
<td><input type="checkbox"  id="process'.$i.'" value=""/></td>
<td><input class="textbox" style="width:auto;" type="text" id="type'.$i.'" value=""/></td>
<td>
<textarea class="textarea" id="description'.$i.'"></textarea>
<!--<input class="textbox" style="width:auto;" type="text" id="description'.$i.'" value=""/>--></td>
</tr>';
endfor;
?>
</table></div>
<!-- notes and comments -->
<div class="note_comments" style="width:99%;float:left;text-align: center;margin-top:25px;">
<!-- notes -->
<?php 
$komments = '';
foreach($comments as $cmt):
$komments = $cmt->SPECIAL;
endforeach;
?>
<div style="width:48%;float:left;">
<h4 style="width:100%;text-align:center">Notes and Comments For Work Order</h4>
<textarea style="width:55%;height:100px" id="comments"><?php echo $komments;?></textarea>
</div>
<div  style="width:48%;float:left;">
				<br />
				<br />
Schedule Date : <input type="text" name="scheduledate" class="textbox" onchange="changewoNumber()" value="<?php echo date("m/d/Y");?>" id="scheduledate"/><br/><br/>
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