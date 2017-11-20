<script>
$(function() {
	$( "#scheduledate" ).datepicker();
	//$( "#scheduledate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	});

$(document).ready(function(){
	$(":text.textbox.date").click(function() {
		 var di = $(this).attr("id");
		$("#"+di).datepicker(); 
	});
});
function loadAJAX()
{
	if (window.XMLHttpRequest){
	  xmlhttp=new XMLHttpRequest();
	  }	else {
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  return xmlhttp;
}

function underconstruction()
{
	alert("Under Construction.");
}
function updateAnodeWorkOrderFrame()
{
	//var saved = document.getElementById("saved").value;
	if($(":checkbox").is(":checked"))
	{ 
	var pkw         = document.getElementById("workpart").value;
	var nums = pkw.split("|");
	var diver       = document.getElementById("diver").value;
	var startdate   = document.getElementById("scheduledate").value;
	var comments    = document.getElementById("comments").value;
	var workno      = document.getElementById("wonumber").value;
	var customer    = window.parent.document.getElementById("wocustomer").value;
    var vessel      = window.parent.document.getElementById("wovessel").value;
    
    var wclass = 'A';
    var workname = 'Zinc / Anode Change';
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
				$("#wopka").val(result);
				
				
				 for(var i=1;i<(nums.length);i++)
				    {
				    	try{
				    	var price     = document.getElementById("price"+nums[i]).value;
				    	var discount  = document.getElementById("discount"+nums[i]).value;
				    	var disprice  = document.getElementById("disprice"+nums[i]).value; 
				    	var change    = document.getElementById("change"+nums[i]).checked;
				        var need      = document.getElementById("need"+nums[i]).checked;
				    	var inspect   = document.getElementById("inspect"+nums[i]).checked;
				    	var type      = document.getElementById("type"+nums[i]).value;
				    	var andate    = document.getElementById("date"+nums[i]).value; 
				    	var workpk    = document.getElementById("wopka").value;
				    	var changed    = document.getElementById("changed"+nums[i]).value;
				    	var descr     = '';
				    	var temp      = nums[i];

				        if(change)  {proc=3;} 
				   else if(need)    {proc=2;} 
				   else if(inspect) {proc=1;} 
				   else             {proc=0;}
				        }catch(e){//alert(e.message);
				        	}
				    	
				        
				    		$.ajax({url:"/btwdive/index.php/customer/addWorkOrderParts/",
				    			type:"post",
				    			 data: {
				    				pkwork:workpk,
				    				wkname:workname,
				    				wkclass:wclass,
				    				wkprice:price,
				    				description:descr,
				    				wkdiscount:discount,
				    				wkdisprice:disprice,
				    				wkprocess:proc,
				    				wktype:type,
				    				date:andate,
				    				changes:changed,
				    				wkpk:temp		 		 
				    			 },
				    			 success:function(result){descr=result;}
				    			 
				    	  });
					    	 
				    		//setTimeout(function(){},1000);
				    	
				    	
				    	
				    
				    }
				
				}
  });
   
  //  alert("Anode Work Order Updated Successfully!");
	}
   else
	{

alert("Schedule Date  is not Valid!");
exit;
	}
	}
	else
	{
		var totalwork = window.parent.document.getElementById("workordertotal").value;
		var total = parseInt(totalwork);
		total++;
		window.parent.document.getElementById("workordertotal").value=total;
//alert("No Anode Work Order Selected.");
	}
}
function updateDisprice(thisid,thisvalue)
{
	if(isNaN(thisvalue) || thisvalue==''){thisvalue=0;}
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
function updateAnodeWorkOrderFramesed()
{
	var s = document.getElementById("subin").value;
	alert(s);
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
$(document).ready(function(){
	$(".textbox.date").click();
});

$(document).ready(function(){
$("input:checkbox").click(function(){
var group = "input:checkbox[name='"+$(this).attr("name")+"']";
    
    if(!($(this).is(":checked")))
    {
        $(group).attr("checked",false);
        $(this).prop("checked",false);
    }
    else
    {
        $(group).attr("checked",false);
     $(this).prop("checked",true);   
    }
});
});
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
<?php if(count($open)==0){?>
<input type="hidden" name="" id="saved" value="0"/>
<button style="display:none" id="saveAnodeFrame" onclick="updateAnodeWorkOrderFrame()"></button>
<input type="hidden" name="" id="wopka" value=""/>
<input type="hidden" name="" id="wopkpart" value=""/>  
<input type="hidden" id="number_work" value="" />
<input type="hidden" id="wonumber" value="" />
<img src="ghghgbh" onerror="changewoNumber()" width="1px" height="1px"/>
		<h3 style="float:none;width:100%">Schedule Anode Work</h3>

		<!-- table with cleaning details -->
<div style="text-align:center;">
<table style="padding-bottom:20px;">
				<tr>
					<th>List Price</th>
					<th>Discount</th>
					<th>Cost</th>
					<th>Anodes on Boat</th>
					<th>Last Changed On</th>
					<th>Change Anode</th>
					<th>Change if Needed</th>
					<th>Inspect Anode</th>
				</tr>
<?php
$workparts = '';

//$change = '';
 foreach ($anodes as $anode):
echo '
<tr>
<td style="width:10%"><input type="text" onblur="updateLisprice(this.id)" name="" id="price'.$anode->PK_VESSEL_ANODE.'" value="'.$anode->LIST_PRICE.'" class="textbox" style="width:95%;"/></td>
<td style="width:10%"><input type="text" name="" id="discount'.$anode->PK_VESSEL_ANODE.'"  onfocus="updateDisprice(this.id,this.value)" onkeyup="updateDisprice(this.id,this.value)"   value="'.$anode->DISCOUNT.'" class="textbox" style="width:95%;"/></td>
<td style="width:10%"><input type="text" name="" id="disprice'.$anode->PK_VESSEL_ANODE.'"  value="'.$anode->DISCOUNT_PRICE.'" class="textbox" style="width:95%;"/></td>
<td>
<textarea id="type'.$anode->PK_VESSEL_ANODE.'">'.$anode->ANODE_TYPE.'</textarea>
<!--<input type="text" name="" id="type'.$anode->PK_VESSEL_ANODE.'"  value="'.$anode->ANODE_TYPE.'" class="textbox" style="width:auto;"/>-->
</td>
<td><input type="text" name="" id="date'.$anode->PK_VESSEL_ANODE.'" value="'.$anode->ADDFIELD1.'" class="textbox date" style="width:auto;"/></td>
<td><input type="checkbox" name="work'.$anode->PK_VESSEL_ANODE.'" value="3" id="change'.$anode->PK_VESSEL_ANODE.'" /></td>
<td><input type="checkbox" name="work'.$anode->PK_VESSEL_ANODE.'" value="2" id="need'.$anode->PK_VESSEL_ANODE.'" /></td>
<td><input type="checkbox" name="work'.$anode->PK_VESSEL_ANODE.'" value="1" id="inspect'.$anode->PK_VESSEL_ANODE.'" />
<input type="hidden" id="changed'.$anode->PK_VESSEL_ANODE.'" value="'.$anode->SCHEDULE_CHANGE.'" /></td>
</tr>';
$workparts = $workparts."|".$anode->PK_VESSEL_ANODE;

//$change = $change."|".$anode->SCHEDULE_CHANGE;
endforeach;
?>
</table>
<input type="hidden" id="workpart" value="<?php echo $workparts?>"/>

		</div>

		<!-- notes and comments -->
		<div class="note_comments"
			style="width: 99%; float: left; text-align: center; margin-top: 25px;">
			<!-- notes -->
			<?php 
$komments = '';
foreach($comments as $cmt):
$komments = $cmt->BILLING;
endforeach;
?>
			<div style="width: 48%; float: left;">
				<h4 style="width: 100%; text-align: center">Notes and Comments For
					Work Order</h4>
				<textarea style="width: 55%; height: 100px" id="comments"><?php echo $komments;?></textarea>
			</div>
			<div style="width: 48%; float: left;">
				
				<br />
				<br /> Schedule Date : <input type="text" onchange="changewoNumber()" name="scheduledate"
					class="textbox" value="<?php echo date("m/d/Y");?>" id="scheduledate" /><br />
				<br /> Assigned Diver:<select name="diver" class="select" id="diver">
				<option value="">Select Diver</option>
<?php
foreach ($divers as $diver):

    echo '<option  value="'.$diver->PK_DIVER.'">'.$diver->DIVER_NAME.'</option>';

endforeach;
?>
</select>
			</div>
		</div>
<?php }else
{
    $pkwork = 0;
    foreach ($open as $o)
    {
        $pkwork = $o->PK_WO;
    }
    ?>
    
    
    <div style="color:white;text-align: center;width:90%;float: left;top:25%;position:absolute;">
    
    <h2 style="text-align: center;width:100%;margin:0px auto;">Open Anode Work Order Found</h2>
    <button class="btn" style="width:auto" onclick='window.open("<?php echo base_url()?>index.php/customer/anode_work_order/<?php echo $pkwork;?>")'>Edit / Update Work Order Here</button>
    </div>
    
    
    
    
    
    
    <?php 
}
    
    
    