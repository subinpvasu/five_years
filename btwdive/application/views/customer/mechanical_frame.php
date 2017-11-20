<!--
Project     : BTW Dive
Author      : Subin
Title      : Mechanical  FRame
Description : Mechanical Frame for adding mechanical work order @ add new work order.
-->
<style>
#print_tbl th, td {
    width: 150px;
}
#add {
margin-left: 155px;
}
</style>
<script>
$(function() {
	$( "#scheduledate" ).datepicker();
	//$( "#scheduledate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
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
function onscreenSearch(str)
{
	document.getElementById("screen").style.display='block';
	if(str.length<=0){str = 'All';}
	loadAJAX().onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
		      searchDistribution(xmlhttp.responseText);
	    }
	  };
	xmlhttp.open("POST",base_url+"index.php/customer/mwoChoicesSearchResults/"+str,true);
	xmlhttp.send();

}
function searchDistribution(str)
{
	var line = "";
	var first = str.split("!");
	for(var i=0;i<first.length;i++)
	{
	var second = first[i].split("|");
	line = line + '<span id="" style="width:700px;height:auto;display:block;"><input id="'+second[0]+'" onclick="showDetailBox(this.id,this.value)" type="checkbox" name[]="anodes_added" style="width:10px;" value="'+second[0]+'"/>'+second[1]+'</span>';

	}
	document.getElementById("screen").innerHTML=line;

	//alert("good"+str);
}
function showDetailBox(str)
{
	if(document.getElementById(str).checked==true)
	{
		loadAJAX().onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
			    anodeDistribution(xmlhttp.responseText);
		    }
		  };
		xmlhttp.open("POST",base_url+"index.php/customer/getmwoDetails/"+str,true);
		xmlhttp.send();
	}
}
function anodeDistribution(str)
{

	var anode = str.split("|");
	str = encodeURI(str);

try
{
var a = anode[1];
var b = anode[2];
//alert(a+"|"+b);
}
catch(e){}


	var dis   = 0;
	var disprice = eval(parseFloat(anode[3])-parseFloat(anode[3])*parseFloat(dis)/100);
	if(!isNaN(dis)){
	var boxTable = '<table><tr><td colspan="3" style="text-align:center;">Add Mechanicalwork order Choices</td></tr><tr><td>MWO Type</td><td colspan="2">         <input id="anodetype" type="text" class="textbox" value=""/></td></tr>		<tr><td>Description</td><td colspan="2">        <input id="description" type="text" class="textbox" value=""/></td></tr>		<tr><td>Schedule Change</td><td colspan="2">    <input id="schedule" type="text" class="textbox" value="'+anode[4]+' Months"/></td></tr>		<tr><td>List Price</td><td colspan="2">         <input id="listprice" type="text" class="textbox" value="'+anode[3]+'"/></td></tr> <tr><td>Installation charge</td><td colspan="2">         <input id="instalation_charge" type="text" class="textbox" value="'+anode[5]+'"/></td></tr></table>';



	boxTable = boxTable + '<button class="btn" id="add" onclick="addAnode(&quot;'+str+'&quot;,'+anode[0]+')">Add</button><button class="btn"  onclick="donotaddAnode('+anode[0]+')">Do Not Add</button>';

	var anDialog;
	var anMask;
	anMask = document.createElement("div");
	anDialog = document.createElement("div");
	anMask.id="maskid";
	anDialog.id="dialogid";
	document.body.appendChild(anMask);
	document.body.appendChild(anDialog);
	anDialog.innerHTML=boxTable;

	document.getElementById("anodetype").value=a;
	document.getElementById("description").value=b;
	$(function() {
		$( "#datepickeranode" ).datepicker();
		});


}
}
function donotaddAnode(anode)
{
	removeDialogBox("maskid","dialogid");
	document.getElementById("screen").style.display='none';
}
function addAnode(anode,anodeid)
{
	anode = decodeURI(anode);
	var inpt_count_current = document.getElementById("inpt_count").value;
	var inpt_count_new = parseInt(inpt_count_current);
	var ftype=document.getElementById("anodetype").value;
	var	fdescription=document.getElementById("description").value;
	var flist_price=document.getElementById("listprice").value;
	var row_to_add = '<tr id="tbl_row'+inpt_count_new+'"><td><input class="textbox" onblur="updateLisprice(this.id)" style="width:auto;" type="text" id="price'+inpt_count_new+'" value="'+flist_price+'" /></td><td><input class="textbox" onfocus="updateDisprice(this.id,this.value)" onkeyup="updateDisprice(this.id,this.value)" style="width:auto;" type="text" id="discount'+inpt_count_new+'" value=""/></td><td><input class="textbox" style="width:auto;" type="text" id="disprice'+inpt_count_new+'" value="'+flist_price+'"/></td><td><input type="checkbox"  id="process'+inpt_count_new+'" value="" checked/></td><td><input class="textbox" style="width:auto;" type="text" id="type'+inpt_count_new+'" value="'+ftype+'"/></td><td><textarea class="textarea" id="description'+inpt_count_new+'">'+fdescription+'</textarea></td></tr>';
	 inpt_count_new = parseInt(inpt_count_current) + 1;
	$('#inpt_count').val(inpt_count_new);
	$('#mwo_listing_tbl').append(row_to_add);	
	removeDialogBox("maskid","dialogid");
	document.getElementById("screen").style.display='none';
	//document.getElementById("screen").style.display='none';
}
function removeDialogBox(mask,dialog)
{
	 	var elemo = document.getElementById(mask);
	    var elemt = document.getElementById(dialog);
	    elemt.parentNode.removeChild(elemt);
	    elemo.parentNode.removeChild(elemo);
	    return false;
}
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
    var workname = 'Mechanical Services';

    var proc;
   if(isValidDate(startdate)){
    $.ajax({url:base_url+"index.php/customer/addWorkOrder/",
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

				    	var temp      = 0;

				        }catch(e){alert(e.message);
				        	}
				    	if(process)
				    	{ var proc = 1;

				    		$.ajax({url:base_url+"index.php/customer/addWorkOrderParts/",
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
				    				changes:0,
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
<div class="select_mwo_choice" style="width:100%; float:left;">
<b style="width:20%; float:left;">Add MWO choice</b>
<input class="textbox" id="anodes" style="width:20%; float:left;" name="MWOchoice" onkeyup="onscreenSearch(this.value)" type="text" value="" />
</div>
<?php
echo '<div id="screen" style="border:1px solid ;width:717px;right:1px;height:auto;max-height: 200px;overflow:auto;background-color:white;color:black;margin-left: 20%;top:20px;display:none;"></div>';
echo '<div id="addedanodes" style="width:850px;height:400px;overflow:auto;margin-top:50px;">';
echo '<input type="hidden" name="inpt_count" id= "inpt_count" value=0 >';
	?>


<table id="mwo_listing_tbl" style="padding-bottom:20px;">
<tr>
<th>List Price</th><th>Discount</th><th>Cost</th><th>Process</th><th>Type</th><th>Description</th>
</tr>
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