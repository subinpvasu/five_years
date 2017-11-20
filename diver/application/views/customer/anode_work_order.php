<style>
#hdmk {
	position:fixed;
	top:1px;
	left:1px;
	background-color: black;
	opacity:0.6;
	width:100%;
	height:100%;
}
#cmtbox {
position:absolute;
top:30%;
left:45%;
border:2px solid white;
width:300px;
height:150px;
background-color:black;
text-align:center;
}
#cmtara {
width:auto;
height:100px;
background-color:black;
margin:0px auto;
}
#btarea {
margin:0px auto;
width:250px;
height:35px;
background-color:black;
}
#boxcmt {
margin-top:5px;
width:292px;
height:65px;
}
</style>
<script>
$(function() {
	$( "#scheduledate" ).datepicker();
	//$( "#scheduledate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	});
	
$(document).ready(function(){
	$(":text.textbox.date").click(function() {
		var di = $(this).attr("id");
		$("#"+di).datepicker();
		//$("#"+di).datepicker( "option", "dateFormat", "yy-mm-dd" );
		
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
function voidWorkOrder(str)
{
	var r = confirm("Are you sure you want to Void this Work Order..?");
	if(r){
		loadAJAX().onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
			      //searchDistribution(xmlhttp.responseText);
		      if(xmlhttp.responseText=='Y')
		      {
alert("Work Order Voided.");
realClose();
		      }
		    }
		  };
		xmlhttp.open("POST","/btwdive/index.php/customer/voidWorkOrder/"+str,true);
		xmlhttp.send();

		}
}
function deleteWorkOrder(str)
{
	var r = confirm("Are You Sure want to Delete this Work Order..?");
	if(r){
		loadAJAX().onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
			      //searchDistribution(xmlhttp.responseText);
		      if(xmlhttp.responseText=='Y')
		      {
alert("Work Order Deleted.");
realClose();
		      }
		    }
		  };
		xmlhttp.open("POST","/btwdive/index.php/customer/deleteWorkOrder/"+str,true);
		xmlhttp.send();

		}
}
function parseDate(str)
{
	if(isValidDate(str))
	{//2,0,1,4,-,0,3,-,1,4////12/31/1969--1,2,/,3,1,/,1,9,6,4//2013-12-03
    var d = str.split("/");
        
    //return d[6] + d[7] + d[8] ;
    alert(d[6] + d[7] + d[8]);
    
	}
	else
	{
alert("Please Check the Schedule Date");
exit;
	}
	
}
function compareDate(date1,date2)
{


	var passedDate1 = new Date(date1);//scheduledate
	var passedDate2 = new Date(date2);//today

	 if (passedDate1 <= passedDate2) {
	  return true;
	}
	else {
	   return false;
	}

		
}

function completeWorkOrder(str)
{
	var diver = document.getElementById("diver").value;
	var today = document.getElementById("datelast").value;
	var schedule = document.getElementById("scheduledate").value;
    //if( parseDate(today) >= parseDate(schedule) )
        if(compareDate(schedule, today))
	{
	
	if(diver.length>2){
		
	var r = confirm("Are you sure you want to Complete this Work Order..?");
	if(r){
		updateWorkOrder(1);
		loadAJAX().onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
			      //searchDistribution(xmlhttp.responseText);
		      if(xmlhttp.responseText=='Y')
		      {
alert("Work Order Completed.");
realClose();
		      }
		    }
		  };
		xmlhttp.open("POST","/btwdive/index.php/customer/completeWorkOrder/"+str,true);
		xmlhttp.send();

		}
	}
	else
	{
alert("Select Assigned Diver");
	}

}
else
{
   alert("Cannot Mark Work Order as Completed as Scheduled Date is ahead of the Present Date");exit;   
}
}
function printWorkOrder(str)
{
	/*loadAJAX().onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
		      //searchDistribution(xmlhttp.responseText);
	      if(xmlhttp.responseText=='Y')
	      {
//alert("Work Order Completed.");
realClose();
	      }
	    }
	  };
	xmlhttp.open("POST","/btwdive/index.php/customer/anode_pdf/"+str,true);
	xmlhttp.send();*/
	window.open("<?php echo base_url();?>/index.php/customer/anode_pdf/"+str);
}
function underconstruction()
{
	alert("Under Construction.");
}
function dialogForComment(str)
{
	var old = document.getElementById("vessel_comment").value;
	var mk;
	var dg;
	var tb;
	var bt;
	mk = document.createElement("div");
	dg = document.createElement("div");
	tb = document.createElement("div");
	bt = document.createElement("div");
	mk.id="hdmk";
	dg.id="cmtbox";
	tb.id="cmtara";
	bt.id="btarea";
	tb.innerHTML='<b>This Text Will Appear On the Invoice</b><textarea id="boxcmt">'+old+'</textarea>';
	bt.innerHTML='<button class="btn" style="margin:3px" id="store">Save</button><button id="outer" style="margin:3px" class="btn">Exit</button>';
	dg.appendChild(tb);
	dg.appendChild(bt);
	document.body.appendChild(mk);
	document.body.appendChild(dg);
	$("#store").click(function(){
		var vesselpk = $("#wovessel").val();
		var commentz = $("#boxcmt").val();
	    $.ajax({url:"/btwdive/index.php/customer/updateVesselComment/",
			type:"post",
			 data: {
				vessel:vesselpk,
				comment:commentz	 		 
			 },
			 success:function(result){

				 //$("#invoicelink").click();
				 }
	  });
	    
		removeDialogBox('hdmk','cmtbox',str);
		
		
	});
	$("#outer").click(function(){
		removeDialogBox('hdmk','cmtbox',str);
	});

}

function removeDialogBox(mask,dialog,str)
{
	 	var elemo = document.getElementById(mask);
	    var elemt = document.getElementById(dialog);
	    elemt.parentNode.removeChild(elemt);
	    elemo.parentNode.removeChild(elemo);
	    if(str!=2){document.getElementById("invoicelink").click();}
	    else{alert("Data Updated");if(!self.close()){location.reload();}}
	    
}
function updateWorkOrder(str)
{
	if(str==2 && $("#invoicemsg").is(":checked"))
	{
		dialogForComment(2);
	} 
	if($(":checkbox").is(":checked"))
	{
		
	var pkw = document.getElementById("workpart").value;
	var nums = pkw.split("|");
	var startdate = document.getElementById("scheduledate").value;
	var wonum = document.getElementById("wonumber").value;
	var cnt = document.getElementById("gounder").value;
	var wclass = 'A';
    var workname = 'Zinc / Anode Change';
	if(isValidDate(startdate))
	{
//get elements
	//update corresponding 
       //tryagain
    for(var i=1;i<nums.length;i++)
    {
    	//alert(nums[i]);
    	var price = document.getElementById("price"+nums[i]).value;
    	var discount = document.getElementById("discount"+nums[i]).value;
    	var disprice = document.getElementById("disprice"+nums[i]).value;
    	var change = document.getElementById("change"+nums[i]).checked;//document.getElementById("myCheck").checked;
    	var need = document.getElementById("need"+nums[i]).checked;
    	var inspect = document.getElementById("inspect"+nums[i]).checked;
    	var type = document.getElementById("type"+nums[i]).value;
    	var description = '';//document.getElementById("description"+nums[i]).value;
    	var comments = document.getElementById("comments").value;
    	var diver = document.getElementById("diver").value;
    	
    	
    	var pkwork = document.getElementById("pkwork").value;
    	var changed = document.getElementById("changed"+nums[i]).value;
    	if(change){var process=3;} else
    	if(need){var process=2;} else
    	if(inspect){var process=1;} else
    	{var process=0;}
    	if(str>=1 && process>0)
    	{
		var lastdates = document.getElementById("datelast").value;
    	}else
        	{
    		var lastdates = document.getElementById("date"+nums[i]).value;
        	}
    	/*if(isValidDate(lastdates))
    	{*/
    //    alert(price+"|"+discount+"|"+disprice+"|"+type+"|"+description+nums[i]);
if(i<cnt){
    	
        $.ajax({url:"/btwdive/index.php/customer/updateWorkOrderParts/",
			type:"post",
			 data: {
				lastdate:lastdates,
				wkprice:price,
				wkdiscount:discount,
				wkdisprice:disprice,
				wkprocess:process,
				wktype:type,
				wkdescription:description,
				wkpk:nums[i]		 		 
			 },
	  });
}
else//add
{
	$.ajax({url:"/btwdive/index.php/customer/addWorkOrderParts/",
		type:"post",
		 data: {
			pkwork:pkwork,
			wkname:workname,
			wkclass:wclass,
			wkprice:price,
			description:description,
			wkdiscount:discount,
			wkdisprice:disprice,
			wkprocess:process,
			wktype:type,
			date:lastdates,
			changes:changed,
			wkpk:nums[i]		 		 
		 },
		 success:function(result){descr=result;}
		 
  });
}
    	  
  
    }
    $.ajax({url:"/btwdive/index.php/customer/updateWorkOrder/",
		type:"post",
		 data: {
			 workpk:pkwork,
			 wonom:wonum,
			 commentspk:comments,
			 date:startdate,
			 divers:diver
		 },

  });
    
   if(str==1)
	   {
	   //location.reload();if($("#checkSurfaceEnvironment-1").prop('checked') == true)
	   }else if(str==2 && $("#invoicemsg").prop('checked') == false)
		   {
		   alert("Anode Work Order Updated Successfully!");
		    realClose();
	   }
   else if(str!=1 && str!=2){ 
	   alert("Anode Work Order Updated Successfully!");
       location.reload();
       }
   if(str==2 && $("#invoicemsg").length==0)
   {
	  alert("Anode Work Order Updated Successfully!");
 location.reload();
   }
   
	}
	else
	{
alert("Schedule Date is not valid"); exit;
	}
	
}
	else
	{
alert("Anode Work not Selected.");
exit;
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
//	document.getElementById(nid).value=disvalue;
	if(parseFloat(disvalue)){document.getElementById(nid).value=disvalue;}
	else{document.getElementById(nid).value='0';}
	
} 
function updateLisprice(thisid)
{
	var curid = thisid.replace("price","discount");
	document.getElementById(curid).focus();
}
/*
 * Save this  as new work order
 */
function updateAnodeWorkOrderFrame()
{
	//var saved = document.getElementById("saved").value;
	if($(".chkbx:checkbox").is(":checked"))
	{ 
		try{
	var pkw         = document.getElementById("workpart").value;
	var nums = pkw.split("|");
	var diver       = document.getElementById("diver").value;
	var startdate   = document.getElementById("scheduledate").value;
	var comments    = document.getElementById("comments").value;
	var workno      = document.getElementById("wonumber").value;
	var customer    = document.getElementById("wocustomer").value;
    var vessel      = document.getElementById("wovessel").value;
    
    var wclass = 'A';
    var workname = 'Zinc / Anode Change';
    var proc;
		} catch(e){alert(e.message);}
		var r = confirm("Create Anode Work Order For  \""+startdate+"\"?");
		if(r){
  //  alert(nums+"|"+diver+"|"+startdate+"|"+comments+"|"+workno+"|"+customer+"|"+vessel+"|"+wclass+"|"+workname);
   
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
				$("#wopk").val(result);
				
				
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
				    	var workpk    = document.getElementById("wopk").value;
				    	var changed   = document.getElementById("changed"+nums[i]).value;
				    	var descr     = '';
				    	var temp      = nums[i];

				        if(change)  {proc=3;} 
				   else if(need)    {proc=2;} 
				   else if(inspect) {proc=1;} 
				   else             {proc=0;}
				        }catch(e){//alert(e.message);
				        	}
//alert(price+"|"+discount+"|"+disprice+"|"+change+"|"+need+"|"+inspect+"|"+type+"|"+andate+"|"+workpk+"|"+changed+"|"+descr+"|"+temp+"|"+proc);
			        	
				    	if(proc!=0)
				    	{
				        
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
				
				}
  });
   
     alert("Anode Work Order Created Successfully!");
		}
	}
	else
	{
		try{
		var totalwork = window.parent.document.getElementById("workordertotal").value;
		var total = parseInt(totalwork);
		total++;
		window.parent.document.getElementById("workordertotal").value=total;
		}
		catch(e){//alert(e.message);
			}
//alert("No Anode Work Order Selected.");
	}
}

$(document).ready(function(){
	$(".textbox.date").click();
});
function isValidDate(s) {//2,0,1,4,-,0,3,-,1,4////12/31/1969--1,2,/,3,1,/,1,9,6,4//2013-12-03
	 var bits = s.split('/');
	  var y = bits[2], m  = bits[0], d = bits[1];
	  
	  var daysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31];

	  
	  if ( (!(y % 4) && y % 100) || !(y % 400)) {
	    daysInMonth[1] = 29;
	  }
	 return d <= daysInMonth[--m];
	// alert(d <= daysInMonth[--m]);
	} 

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
$(document).ready(function(){
	$("#invoicemsg").click(function(){
		var wonum  = $("#wonumcom").val();
if($(this).is(":checked"))
{
	
	$(this).prop("checked",true);
	//alert("check");
	$.ajax({url:"/btwdive/index.php/customer/updateWorkOrderforInvoice/",
		type:"post",
		 data: {
			 wnumber:wonum,
			 status:1
		 },success:function(result){
			 $("#registerkeep").val(1);
		 }
	});
	//function for updating the work order for invoicicng.
	/*
check with work order number,if any work order is completed with same work order,then those are completed.
	*/
	
}
else
{
	 $(this).prop("checked",false);
	// alert("uncheck");
	 $.ajax({url:"/btwdive/index.php/customer/updateWorkOrderforInvoice/",
			type:"post",
			 data: {
				 wnumber:wonum,
				 status:0
			 }
		});
		//reverse the function to completed work order.
		
	 
}
		});
});
/*
function changewoNumber()
{alert("good1");
	var str = document.getElementById("newdate").value;//2014-03-14--031414
    var won = document.getElementById("accountnum").value;
	
	if(isValidDate(str))
	{
var d = str.split("");//2,0,1,4,-,0,3,-,1,4
var datepart = d[5]+""+d[6]+""+d[8]+""+d[9]+""+d[2]+""+d[3];
var wonom = won+" - "+datepart;
//var wonum = "Work Order # : "+won+" - "+datepart;
//alert(wonum);
//window.parent.document.getElementById("number_work").innerHTML=wonum;
document.getElementById("wonumber").value=wonom;
	}
	else
	{
	alert("Invalid Schedule Date");exit;
	}
}*/
function changewoNumber()
{
	var str = document.getElementById("scheduledate").value;//2014-03-14--031414
var won = document.getElementById("accountnum").value;
	
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
function activateWorkOrder(work)
{
	$.ajax({url:"/btwdive/index.php/customer/activateWorkOrder/",
		type:"post",
		 data: {
			 pkwork:work
			 
		 },
		 success:function(result){
			 if(result=='Y')
			 {
				 
				 alert("Work Order "+$("#wonumber").val()+" Activated.");realClose();
			 }

			 }
	});
}
function realClose()
{
	 if($("#registerkeep").val()=='1')
	 {
$("#invoicemsg").click();
//alert("good");
//setTimeout(function(){$("#keepreg").val(2);alert("good");},2000);
setTimeout(function(){
var win=window.open("","_top","","true");
win.realclosefunc();
try {
    win.opener=true;
	}catch(e){
	
	}

},1000);
	 }
	 else
	 {

		 var win=window.open("","_top","","true");
		 win.realclosefunc();
		 try {
		      win.opener=true;
		 	}catch(e){
		 	
		 	}
	 }
	 
}
 window.realclosefunc = window.close;
 window.close = realClose;
</script>
<div id="account">
<?php
$status = 0;
$cmtz = 0;
foreach ( $customers as $customer ) :
    ?>
<div class="name">
		<span>Client Name : <?php echo $customer->F.'&nbsp;'.$customer->L;?></span>
	</div>
	<div class="vessel">
		<span>Vessel Name : <?php echo $customer->V;?></span> <span>Location : <?php echo $customer->O;?></span><span>Slip #: <?php echo $customer->S;?></span>
	</div>
	<h4
		style="float: left; width: 49%; text-align: left; display: inline-block;" id="number_work">Work Order # : <?php  echo $customer->W; ?></h4>
	
<?php
    switch ($customer->T) {
        case 0 :
            echo '<h3 style="float: left; width: 49%; text-align: right; display: inline-block; clear: none">WO Status : In Progress</h3>';
            break;
        case 1 :
            echo '<h3 style="float: left; width: 49%; text-align: right; display: inline-block; clear: none">WO Status : Completed</h3>';
            break;
        case 2 :
            echo '<h3 style="float: left; width: 49%; text-align: right; display: inline-block; clear: none">WO Status : Ready For Invoice</h3>';
            break;
        case 3 :
            echo '<h3 style="float: left; width: 49%; text-align: right; display: inline-block; clear: none">WO Status : Invoiced</h3>';
            break;
        case 4 :
            echo '<h3 style="float: left; width: 49%; text-align: right; display: inline-block; clear: none">WO Status : Void</h3>';
            break;
    }
    $status = $customer->T;
    $pkcustomer = $customer->P; // work history
    $pkvessel = $customer->PKV;
    $wknum = $customer->ACN;
    $wkw = $customer->P;
    $won = $customer->W;
    $cmtz = $customer->COMMENTS;
    $d = date ( "m" ) . date ( "d" ) . date ( "y" );
endforeach
;
?>
<input type="hidden" value="<?php echo $pkwork?>" id="pkwork" /> <input
		type="hidden" value="<?php echo $pkcustomer?>" id="wocustomer" /> <input
		type="hidden" value="<?php echo $pkvessel?>" id="wovessel" /> <input
		type="hidden" value="<?php echo $won?>" id="wonumber" /> <input
		type="hidden" value="<?php echo $wkw?>" id="wonumcom" /> <input
		type="hidden" value="0" id="wopk" />
		<input type="hidden" id="accountnum" value="<?php echo $wknum;?>"/> 
		<input type="hidden" value="<?php echo date("m/d/Y");?>" id="datelast"/>
		<input type="hidden" id="vessel_comment" value="<?php echo $cmtz;?>"/>
		<input type="hidden" id="registerkeep" value="a"/>
		<input type="hidden" id="keepreg" value="a"/>

	<div class="details">


		<!-- Heading & Status-->
		<h3 style="float: none; width: 100%">Schedule Anode Work</h3>

		<!-- table with cleaning details -->
		<div>
			<table style="padding-bottom: 20px;">
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
$comments = '';
$dates = '';
$diverz = '';
$used = '';
$workpartsand = '';
$kount = 1;
foreach ( $anodes as $anode ) :
    echo '
<tr>
<td><input type="text" id="price' .
                                     $anode->P .
                                     '" onblur="updateLisprice(this.id)" value="' .
                                     $anode->LIST_PRICE .
                                     '" class="textbox" style="width:auto;"/></td>
<td><input type="text" id="discount' .
                                     $anode->P .
                                     '" onfocus="updateDisprice(this.id,this.value)" onkeyup="updateDisprice(this.id,this.value)" value="' .
                                     $anode->DISCOUNT .
                                     '" class="textbox" style="width:auto;"/></td>
<td><input type="text" id="disprice' .
                                     $anode->P .
                                     '" value="' .
                                     $anode->DISCOUNT_PRICE .
                                     '" class="textbox" style="width:auto;"/></td>
<td>
<textarea id="type' .
                                     $anode->P .
                                     '">' .
                                     $anode->WORK_TYPE .
                                     '</textarea>
<!--<input type="text" id="type' .
                                     $anode->P .
                                     '" value="' .
                                     $anode->WORK_TYPE .
                                     '" class="textbox" style="width:auto;"/>--></td>
<td><input type="text" id="date' .
                                     $anode->P .
                                     '" value="' .
                                     $anode->CHANGED_DATE .
                                     '"   class="textbox date" style="width:auto;"/></td>';

$anode->VALUE == 3 ? print 
    '<td><input type="checkbox" class="chkbx" name="' . $anode->P . '" checked id="change' . $anode->P . '" value="3" /></td>' : print 
    '<td><input type="checkbox" class="chkbx"  name="' . $anode->P . '"  id="change' . $anode->P . '" value="3" /></td>';
$anode->VALUE == 2 ? print 
    '<td><input type="checkbox" class="chkbx"  name="' . $anode->P . '"  checked id="need' . $anode->P . '" value="2" /></td>' : print 
    '<td><input type="checkbox" class="chkbx"  name="' . $anode->P . '"  id="need' . $anode->P . '" value="2" /></td>';
$anode->VALUE == 1 ? print 
    '<td><input type="checkbox" class="chkbx"  name="' . $anode->P . '"  checked id="inspect' . $anode->P . '" value="1" /></td>' : print 
    '<td><input type="checkbox" class="chkbx"  name="' . $anode->P . '"  id="inspect' . $anode->P . '" value="1" /></td>';

echo '<input type="hidden" id="changed' . $anode->P . '" value="' . $anode->CHANGED . '" /></tr>';
$workparts = $workparts . "|" . $anode->P;
$used = $used."|".$anode->PKW;
$comments = $anode->COMMENTS;
$dates = $anode->SCHEDULE_DATE;
$diverz = $anode->PK_DIVER;
$kount++;
endforeach;
$pkw = explode("|", $used);
if(count($pkw)>1  && $status==0)
{
      foreach($totalanodes as $t)
        {
            if (!in_array($t->PK_VESSEL_ANODE, $pkw))
            {
               echo '<tr>
<td style="width:10%"><input type="text" onblur="updateLisprice(this.id)" name="" id="price'.$t->PK_VESSEL_ANODE.'" value="'.$t->LIST_PRICE.'" class="textbox" style="width:95%;"/></td>
<td style="width:10%"><input type="text" name="" id="discount'.$t->PK_VESSEL_ANODE.'"  onfocus="updateDisprice(this.id,this.value)" onkeyup="updateDisprice(this.id,this.value)"   value="'.$t->DISCOUNT.'" class="textbox" style="width:95%;"/></td>
<td style="width:10%"><input type="text" name="" id="disprice'.$t->PK_VESSEL_ANODE.'"  value="'.$t->DISCOUNT_PRICE.'" class="textbox" style="width:95%;"/></td>
<td>
<textarea id="type'.$t->PK_VESSEL_ANODE.'">'.$t->ANODE_TYPE.'</textarea>
<!--<input type="text" name="" id="type'.$t->PK_VESSEL_ANODE.'"  value="'.$t->ANODE_TYPE.'" class="textbox" style="width:auto;"/>-->
</td>
<td><input type="text" name="" id="date'.$t->PK_VESSEL_ANODE.'" value="'.$t->ADDFIELD1.'" class="textbox date" style="width:auto;"/></td>
<td><input type="checkbox" class="chkbx c" name="work'.$t->PK_VESSEL_ANODE.'" value="3" id="change'.$t->PK_VESSEL_ANODE.'" /></td>
<td><input type="checkbox" class="chkbx c" name="work'.$t->PK_VESSEL_ANODE.'" value="2" id="need'.$t->PK_VESSEL_ANODE.'" /></td>
<td><input type="checkbox" class="chkbx c" name="work'.$t->PK_VESSEL_ANODE.'" value="1" id="inspect'.$t->PK_VESSEL_ANODE.'" />
<input type="hidden" id="changed'.$t->PK_VESSEL_ANODE.'" value="'.$t->SCHEDULE_CHANGE.'" /></td>
</tr>';
               $workparts = $workparts."|".$t->PK_VESSEL_ANODE;
            }
        }
    
}
?>
</table>
			<input type="hidden" id="workpart" value="<?php echo $workparts?>" />
			<input type="hidden" id="gounder" value="<?php echo $kount?>"/>
		</div>

		<!-- notes and comments -->
		<div class="note_comments"
			style="width: 99%; float: left; text-align: center; margin-top: 25px;">
			<!-- notes -->
			<div style="width: 48%; float: left;">
				<h4 style="width: 100%; text-align: center">Notes and Comments For
					Work Order</h4>
				<textarea style="width: 55%; height: 100px" id="comments"><?php echo $comments;?></textarea>
			</div>
			<div style="width: 48%; float: left;">
				<?php if($customer->T==0):?>
<!--   <button class="btn" style="width:auto;">Refresh All Services</button> -->
<?php endif;?>
				<br /> <br /> Schedule Date : <input type="text" name="scheduledate" onchange="changewoNumber()"
					class="textbox" value="<?php echo $dates;?>" id="scheduledate" /><br />
				<br /> Assigned Diver:<select name="diver" class="select" id="diver">
					<option value="">Select Diver</option>
<?php
foreach ( $divers as $diver ) :
    if ($diverz == $diver->PK_DIVER) {
        echo '<option selected value="' . $diver->PK_DIVER . '">' . $diver->DIVER_NAME . '</option>';
    } else {
        echo '<option  value="' . $diver->PK_DIVER . '">' . $diver->DIVER_NAME . '</option>';
    }
endforeach
;
?>
</select>
<?php if ($status>0 && $status<3):?>
<span
					style="background-color: #FFF; width: auto; color: black; margin: 20px; margin-left: 80px;"
					onclick="javascript:document.getElementById('invoicemsg').click()">Check:
					Send For Invoicing All Completed Work Orders <input type="checkbox"
					<?php if($status==2){echo "checked";}?> id="invoicemsg" name=""
					value="" />
				</span>
<?php endif;?>
			</div>
		</div>

		<!-- bottom buttons -->
		<div style="width: 99%; float: left; text-align: center;">
			<?php if($status==0):?>
<a
				href="<?php echo base_url() ?>index.php/customer/customer_workhistory/<?php echo $pkcustomer;?>"
				target="_blank" class="buttonlink"
				style="padding-top: 7px; padding-bottom: 7px;">Work History</a>
			<button class="btn" onclick="voidWorkOrder(<?php echo $pkwork;?>)"
				style="width: auto">Void Work Order</button>
			<button class="btn" onclick="deleteWorkOrder(<?php echo $pkwork;?>)"
				style="width: auto">Delete Work Order</button>
			<button class="btn" onclick="printWorkOrder(<?php echo $pkwork;?>)"
				style="width: auto">Print Work Order</button>
			<button class="btn" onclick="updateWorkOrder()" style="width: auto">Update</button>
			<button class="btn"
				onclick="completeWorkOrder(<?php echo $pkwork;?>)"
				style="width: auto">Work Order Completed</button>
			<button onclick="realClose();" class="btn">Exit</button>
<?php endif;?>
<?php if($status>0 && $status!=4):?>
<a
				href="<?php echo base_url() ?>index.php/customer/customer_workhistory/<?php echo $pkcustomer;?>"
				target="_blank" class="buttonlink"
				style="padding-top: 7px; padding-bottom: 7px;">Work History</a>
			<button class="btn" onclick="voidWorkOrder(<?php echo $pkwork;?>)"
				style="width: auto">Void Work Order</button>
			<button class="btn" onclick="deleteWorkOrder(<?php echo $pkwork;?>)"
				style="width: auto">Delete Work Order</button>
			<button class="btn" onclick="printWorkOrder(<?php echo $pkwork;?>)"
				style="width: auto">Print Work Order</button>
			<button class="btn" onclick="updateWorkOrder(2)">Save</button>
			<button class="btn" onclick="dialogForComment()" style="width: auto">Create
				Invoice</button>
			
			<a
				href="<?php echo base_url() ?>index.php/customer/create_invoice_from_wo/<?php echo $pkcustomer;?>"
				target="_blank" 
				 id="invoicelink"></a>
			<button onclick="realClose();" class="btn">Exit</button>
<?php endif;?>
<?php if($status==4):?>
<a href="<?php echo base_url() ?>index.php/customer/customer_workhistory/<?php echo $pkcustomer;?>" target="_blank" class="buttonlink"  style="padding-top:7px;padding-bottom:7px;">Work History</a>
<button class="btn" style="width:auto;" onclick="activateWorkOrder(<?php echo $pkwork;?>)">Activate</button>
<button class="btn" onclick="printWorkOrder(<?php echo $pkwork;?>)" style="width:auto">Print Work Order</button>
<button onclick="realClose();" class="btn">Exit</button>
<?php endif;?>
		</div>
	</div>
</div>