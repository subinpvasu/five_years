<!--
Project     : BTW Dive
Author      : Subin
Title      : Cleaning work order
Description : Cleaning work order details will be displayed here.
-->
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
.refreshed {
	display:none;
}
</style>
<script>

$(function() {
	$( "#scheduledate" ).datepicker();

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
		xmlhttp.open("POST",base_url+"index.php/customer/voidWorkOrder/"+str,true);
		xmlhttp.send();

		}
}
function deleteWorkOrder(str)
{
	var r = confirm("Are you sure you want to Delete this Work Order..?");
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
		xmlhttp.open("POST",base_url+"index.php/customer/deleteWorkOrder/"+str,true);
		xmlhttp.send();

		}
}
function parseDate(str)
{
	if(isValidDate(str))
	{
    var d = str.split("/");

    return d[6] + d[7] + d[8] ;
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
	var oldpk='';
	$(':checkbox').each(function() {//#process153758
		if($(this).prop('checked'))
		{//alert($(this).attr("name"));exit;
	      oldpk += $(this).attr("name") + "^";

	     /*  var rst = $(this).attr("name");

	      var n = rst.search(/HALF/i);
	      var m = rst.search(/FULL/i);
	      if(n>=0)
	      {
	    	  oldpk = rst.replace('HALF_','');
	      }else if(m>=0)
	      {
	    	  oldpk = rst.replace('FULL_','');
	      } */
		}

	    });
	var diver = document.getElementById("diver").value;
	var today = document.getElementById("datelast").value;
	var schedule = document.getElementById("scheduledate").value;
	 if(compareDate(schedule, today))
	{
	if(diver.length>2){
		updateWorkOrder(1);

	var r = confirm("Are you sure you want to Complete this Work Order..?");
	if(r){
		loadAJAX().onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
			      //searchDistribution(xmlhttp.responseText);
		      if(xmlhttp.responseText=='Y')
		      {
			      alert("Work Order Completed Successfully");
			      //var r=confirm("Schedule Next ");
var customer = document.getElementById("wocustomer").value;
	var newdate = document.getElementById("scheduledate").value;
	newdate = newdate.replace(/\//g,'^');
	//var pkold = oldpk.split("^");
	var fortick = document.getElementById("tickfor").value;
	var n = fortick.search(/Bi-MONTHLY/i);
	if(n>=0)
		{
		window.location="<?php echo base_url()?>index.php/customer/add_new_work_order/"+customer+"/"+newdate+"/"+oldpk;
		   }
	else
	{
		window.location="<?php echo base_url()?>index.php/customer/add_new_work_order/"+customer+"/"+newdate;
	}


	//realClose();
		      }
		    }
		  };
		xmlhttp.open("POST",base_url+"index.php/customer/completeWorkOrder/"+str,true);
		xmlhttp.send();

		}
	}else
	{
alert("Select Assigned Diver"); exit;
	}
	}
    else
    {
       alert("Cannot Mark Work Order as Completed as Scheduled Date is ahead of the Present Date");exit;
    }
}
function printWorkOrder(str)
{
/*	loadAJAX().onreadystatechange=function()
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
	xmlhttp.open("POST",base_url+"index.php/customer/cleaning_pdf/"+str,true);
	xmlhttp.send();*/
	window.open("<?php echo base_url();?>/index.php/customer/cleaning_pdf/"+str);
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
	    $.ajax({url:base_url+"index.php/customer/updateVesselComment/",
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
	var comments = document.getElementById("comments").value;
	var diver = document.getElementById("diver").value;
	var startdate = document.getElementById("scheduledate").value;
	var pkwork = document.getElementById("pkwork").value;
	var wonum = document.getElementById("wonumber").value;
	var cnt = document.getElementById("gounder").value;
	var wclass = 'C';
//	correctDateChecker(startdate);


	if( isValidDate(startdate)){


//get elements
	//update corresponding
       //tryagain
    for(var i=1;i<nums.length;i++)
    {
    	//alert(nums[i]);
    	var price = document.getElementById("price"+nums[i]).value;
    	var discount = document.getElementById("discount"+nums[i]).value;
    	var disprice = document.getElementById("disprice"+nums[i]).value;
    	var proc = document.getElementById("process"+nums[i]).checked;//document.getElementById("myCheck").checked;
    	var type = document.getElementById("type"+nums[i]).value;
    	var description = document.getElementById("description"+nums[i]).value;
    	/**********************************************************/
    	var andate    = '0000-00-00';
    	var workpk    = document.getElementById("wopk").value;
    	var workname  = document.getElementById("wkname"+nums[i]).value;
    	var temp      = nums[i];
    	var changed = '00';
    	/***********************************************************/
    	var lastdates = '0000';
    	if(proc){var process=1;}else{var process=0;}
    //    alert(price+"|"+discount+"|"+disprice+"|"+type+"|"+description+nums[i]);
    	if(i<cnt){
        $.ajax({url:base_url+"index.php/customer/updateWorkOrderParts/",
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
    	$.ajax({url:base_url+"index.php/customer/addWorkOrderParts/",
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
    $.ajax({url:base_url+"index.php/customer/updateWorkOrder/",
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
	   //location.reload();
	   }else if(str==2 && $("#invoicemsg").prop('checked') == false){
		   alert("Cleaning Work Order Updated Successfully!");
		   realClose();}
else if(str!=1 && str!=2){
	   alert("Cleaning Work Order Updated Successfully!");
 location.reload();
 }
     if(str==2 && $("#invoicemsg").length==0)
     {
	  alert("Cleaning Work Order Updated Successfully!");
	  location.reload();
     }


}else
{

alert("Schedule Date is not valid.");
exit;

}

}
	else
	{
alert("Please select a  process");
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
	//document.getElementById(nid).value=disvalue;
	if(parseFloat(disvalue)){document.getElementById(nid).value=disvalue;}
	else{document.getElementById(nid).value='0';}

}
function updateLisprice(thisid)
{
	var curid = thisid.replace("price","discount");
	document.getElementById(curid).focus();
}
/************************************************************************************************/

function changeDateCleaning(dates,days)
{
	dates = dates.replace(/\//g,'^');
	loadAJAX().onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
		      //searchDistribution(xmlhttp.responseText);

	    	  document.getElementById("newdate").value=xmlhttp.responseText;
		    	// alert(xmlhttp.responseText);
	    	  changewoNumber();
	    }
	  };
	xmlhttp.open("POST",base_url+"index.php/customer/changeCleaningDates/"+dates+"/"+days,true);
	xmlhttp.send();

}
function calculateDaysClean(day)
{
	day = day.toUpperCase();
	switch(day)
	{
	case 'MONTHLY ONLY':
		return 30;
		break;
	case 'BI-MONTHLY - FULL CLEAN 2 WK.':
		return 14;
		break;
	case 'BI-MONTHLY (POWER)':
		return 14;
		break;
	case 'BI-MONTHLY (OUT DRIVES)':
		return 14;
		break;
	case 'BI-MONTHLY (POWER/SAIL)':
		return 14;
		break;
	case 'WEEKLY':
		return 7;
		break;
	case 'THREE WEEK':
		return 21;
		break;
	case 'SIX WEEK':
		return 42;
		break;
	case 'TWO MONTHLY':
		return 60;
		break;
	case 'BI MONTHLY (SAIL)':
		return 14;
		break;
	case 'THREE MONTHS':
		return 90;
		break;
default:
	return 30;
	break;
	}
}
$(document).ready(function(){

	var pkw         = document.getElementById("workpart").value;
	var nums = pkw.split("|");
var dayin = document.getElementById("type"+nums[1]).value;

    var days = calculateDaysClean(dayin);
    var startdate   = document.getElementById("scheduledate").value;

     changeDateCleaning(startdate,days);

  // document.getElementById("newdate").value=startingdate;
    //alert(changeDateCleaning(startdate,days));
});
function updateCleanWorkOrderFrame()
{
	if($(":checkbox").is(":checked"))
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
    var chnge  = '------';
    var wclass = 'C';
    var startingdate = document.getElementById("newdate").value;
    var proc;
		}catch(e){alert(e.message);}
   // alert(pkw+"|"+nums+"|"+diver+"|"+startdate+"|"+comments+"|"+workno+"|"+customer+"|"+vessel);
   var r = confirm("Create Cleaning work Order for \""+startingdate+"\" ?");
   if(r){
    $.ajax({url:base_url+"index.php/customer/addWorkOrder/",
		type:"post",
		 data: {
			 wocustomer:customer,
			 wovessel:vessel,
			 wonum:workno,
			 woclass:wclass,
			 date:startingdate,
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
				    	/*var change    = document.getElementById("change"+nums[i]).checked;
				        var need      = document.getElementById("need"+nums[i]).checked;
				    	var inspect   = document.getElementById("inspect"+nums[i]).checked;*/
				    	var process   = document.getElementById("process"+nums[i]).checked;
				    	var type      = document.getElementById("type"+nums[i]).value;
				    	var descr     = document.getElementById("description"+nums[i]).value;
				    	var andate    = '0000-00-00';
				    	var workpk    = document.getElementById("wopk").value;
				    	var workname  = document.getElementById("wkname"+nums[i]).value;
				    	var temp      = nums[i];

				        }catch(e){//alert(e.message);
				        	}
				    	if(process)
				    	{ var proc = 1;
				    //    alert(price+"|"+discount+"|"+disprice+"|"+proc+"|"+type+"|"+descr+"|"+andate+"|"+workpk+"|"+workname+"|"+temp);
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
				    				changes:chnge,
				    				wkpk:temp		//e
				    			 },

				    	  });
				    	}

				    }
		 }


  });
    alert("Cleaning Work Order Created Successfully!");
   }


	}
	else
	{
		try{
		var totalwork = window.parent.document.getElementById("workordertotal").value;
		var total = parseInt(totalwork);
		total++;
		window.parent.document.getElementById("workordertotal").value=total;
		} catch(e){}
alert("Please select a  process");
	}
}
function correctDateChecker(dates)
{

	$.ajax({url:base_url+"index.php/customer/checkCorrectDate/",
		type:"post",
		 data: {
			    date:dates
		 },
		 success:function(result){
			$("#cdc").val(result);
			 }
	});

}
/* function changewoNumber()
{
	 alert("very good");
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
function isValidDate(s) {//12/31/1969
	 var bits = s.split('/');
	  var y = bits[2], m  = bits[0], d = bits[1];

	  var daysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31];


	  if ( (!(y % 4) && y % 100) || !(y % 400)) {
	    daysInMonth[1] = 29;
	  }
	 return d <= daysInMonth[--m];
	}
$(document).ready(function(){
	$("#invoicemsg").click(function(){
		var wonum  = $("#wonumcom").val();
if($(this).is(":checked"))
{

	$(this).prop("checked",true);
	//alert("check");
	$.ajax({url:base_url+"index.php/customer/updateWorkOrderforInvoice/",
		type:"post",
		 data: {
			 wnumber:wonum,
			 status:1
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
	 $.ajax({url:base_url+"index.php/customer/updateWorkOrderforInvoice/",
			type:"post",
			 data: {
				 wnumber:wonum,
				 status:0
			 },success:function(result){
$("#registerkeep").val(1);
				 }
		});
		//reverse the function to completed work order.


}
		});
});

function changewoNumber()
{
	//alert("very good");
	var str = document.getElementById("scheduledate").value;//2014-03-14--031414
var won = document.getElementById("accountnum").value;

	if(isValidDate(str))
	{
var d = str.split("");//2,0,1,4,-,0,3,-,1,4////12/31/1969--1,2,/,3,1,/,1,9,6,4//2013-12-03
var datepart = d[0]+""+d[1]+""+d[3]+""+d[4]+""+d[8]+""+d[9];
var wonom = won+" - "+datepart;
var wonum = "Work Order # : "+won+" - "+datepart;
//alert(wonum);
document.getElementById("number_work").innerHTML=wonum;
document.getElementById("wonumber").value=wonom;
/**************************************/
var pkw         = document.getElementById("workpart").value;
var nums = pkw.split("|");
var dayin = document.getElementById("type"+nums[1]).value;

var days = calculateDaysClean(dayin);
var startdate   = document.getElementById("scheduledate").value;

 changeDateCleaning(startdate,days);
	}
	else
	{
	alert("Invalid Schedule Date");exit;
	}
}
function activateWorkOrder(work)
{
	$.ajax({url:base_url+"index.php/customer/activateWorkOrder/",
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
function changeDateStyle()
{
	if($("#rfstatus").val()==0)
		{
	$(".refreshed").css('display','table-row');
	var nd = $("#datelast").val();
	$("#scheduledate").val(nd);
	changewoNumber();
	//$(".chkr").click();
	$(".refreshed .chkr").click();
	$("#rfmsg").css('display','block');
	//$(".rfnot").css('display','none');
$("#rfstatus").val(1);


/* if($("#sub").val()>0)
{
	if($("#sub").val()==$("#subtotal").val())
	{
		//$(":checkbox").click();
		$(".chkr").click();
		//$(".master").css('display','none');
	}
}
else if($("#supersub").val()>0)
{
	if($("#supersub").val()==$("#subtotal").val())
	{
		//$(":checkbox").click();
		$(".chkr").click();
	//	$(".master").css('display','none');
	}
} */



	}
	//change date for today so wonumber
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
<?php
$status = 0;
$cmtz = 0;
foreach ( $customers as $customer ) :
    ?>

<div id="account">
	<div class="name">
		<span>Client Name : <?php echo $customer->F.'&nbsp;'.$customer->L;?></span>
	</div>
	<div class="vessel">
		<span>Vessel Name : <?php echo $customer->V;?></span> <span>Location : <?php echo $customer->O;?></span><span>Slip #: <?php echo $customer->S;?></span>
	</div>
	<h4
		style="float: left; width: 49%; text-align: left; display: inline-block;" id="number_work">Work Order # : <?php  echo $customer->W; ?></h4>
	<!-- ----------------------------------------------------------------------------------------------- -->
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
        case 5 :
            echo '<h3 style="float: left; width: 49%; text-align: right; display: inline-block; clear: none">WO Status : On Hold</h3>';
            break;
    }

    $status = $customer->T;
    $pkcustomer = $customer->P; // work history
    $pkvessel = $customer->PKV;
    $wknum = $customer->ACN;
    $wkw = $customer->P;
    $cmtz = $customer->COMMENTS;
    $d = date ( "m" ) . date ( "d" ) . date ( "y" );
endforeach
;
?>
<input type="hidden" value="<?php echo $pkwork?>" id="pkwork" /> <input
		type="hidden" value="<?php echo $pkcustomer?>" id="wocustomer" /> <input
		type="hidden" value="<?php echo $pkvessel?>" id="wovessel" /> <input
		type="hidden" value="<?php echo $wknum." - ".$d?>" id="wonumber" />
		<input type="hidden" value="<?php echo $wkw?>" id="wonumcom"/> <input
		type="hidden" value="0" id="wopk" /> <input type="hidden" value=""
		id="cdc" /><input type="hidden" id="newdate" value=""/>
		<input type="hidden" id="accountnum" value="<?php echo $wknum; ?>"/>
		<input type="hidden" value="<?php echo date("m/d/Y");?>" id="datelast"/>
		<input type="hidden" id="vessel_comment" value="<?php echo $cmtz;?>"/>
		<input type="hidden" id="registerkeep" value="a"/>
		<input type="hidden" id="keepreg" value="a"/>

<input type="hidden" id="rfstatus" value="0"/>
	<div class="details">

		<!-- Heading & Status-->
		<h3 style="float: none; width: 100%">Schedule Cleaning Services</h3>


		<!-- table with cleaning details -->
		<div>
		<b id="rfmsg" style="color:red;font-weight: normal;display: none;">Data Refreshed!! Please Select Specific Service to be carried out!</b>
			<table style="margin-bottom: 20px;">
				<tr>
					<th>List Price</th>
					<th>Discount</th>
					<th>Cost</th>
					<th>Process</th>
					<th>Type</th>
					<th>Description</th>
				</tr>
<?php
$workparts = '';
$comments = '';
$dates = '';
$diverz = '';
$used = '';
$kount = 1;
$supersub = 0;
$worktype = '';
$tck = '';
foreach ( $cleanings as $c ) :
if($c->WORK_VALUE>0)
{
    echo '<tr class="master">';
}
else
{
    echo '<tr class="refreshed">';
    $supersub++;
}

    echo '

<td><input class="textbox" style="width:auto;" onblur="updateLisprice(this.id)" type="text" id="price' . $c->PK_WO_PARTS .
                                     '" value="' .
                                     $c->LIST_PRICE .
                                     '" /></td>
<td><input class="textbox" style="width:auto;" onfocus="updateDisprice(this.id,this.value)" onkeyup="updateDisprice(this.id,this.value)" type="text" id="discount' .
                                     $c->PK_WO_PARTS .
                                     '" value="' .
                                     $c->DISCOUNT .
                                     '"/></td>
<td><input class="textbox" style="width:auto;" type="text" id="disprice' .
                                     $c->PK_WO_PARTS .
                                     '" value="' .
                                     $c->DISCOUNT_PRICE .
                                     '"/></td>';
    if(preg_match("/FULL/i",$c->WORK_DESCRIPTION))
    {
        $tck = 'FULL';
    }
   else if(preg_match("/HALF/i",$c->WORK_DESCRIPTION))
    {
        $tck = 'HALF';
    }
    else if(preg_match("/1\\/2/",$c->WORK_DESCRIPTION))
    {
        $tck = 'HALF';
    }
    else
    {
        $tck = '';
    }
$c->WORK_VALUE == 0 ? print '<td><input type="checkbox" class="chkr"  id="process' . $c->PK_WO_PARTS . '" value="' . $c->WORK_VALUE . '"/></td>' : print
    '<td><input type="checkbox" checked id="process' . $c->PK_WO_PARTS . '" value="' . $c->WORK_VALUE . '" name="'.$tck.'_'.$c->PK_WORK.'"/></td>';
echo '<td><input class="textbox" style="width:auto;" type="text" id="type' .
     $c->PK_WO_PARTS .
     '" value="' .
     $c->WORK_TYPE .
     '"/></td>
<td>
<textarea class="textarea" id="description' .
     $c->PK_WO_PARTS .
     '">' .
     $c->WORK_DESCRIPTION .
     '</textarea>
<!--<input class="textbox" style="width:auto;" type="text" id="description' .
     $c->PK_WO_PARTS .
     '" value="' .
     $c->WORK_DESCRIPTION .
     '"/>-->
<input type="hidden" id="wkname' .
     $c->PK_WO_PARTS .
     '" value="' .
     $c->PK_WORK .
     '" /></td>
</tr>
';
$workparts = $workparts . "|" . $c->PK_WO_PARTS;
$comments = $c->COMMENTS;
$dates = $c->SCHEDULE_DATE;
$diverz = $c->PK_DIVER;
$used=$used."|".$c->PK_WORK;
$kount++;
$worktype = $worktype ."|". $c->WORK_TYPE;
endforeach
;
$sub = 0;
$tkc = '';
$pkw = explode("|", $used);
if(count($pkw)>0 && $status==0)
{
    foreach($totalservice as $t):
    if (!in_array($t->PK_VESSEL_SERVICE, $pkw))
    {
        if(preg_match("/FULL/i",$t->DESCRIPTION))
        {
            $tkc = 'FULL';
        }
      else  if(preg_match("/HALF/i",$t->DESCRIPTION))
        {
            $tkc = 'HALF';
        }
      else  if(preg_match("/1\\/2/",$t->DESCRIPTION))
        {
            $tkc = 'HALF';
        }
      else
      {
          $tkc = '';
      }
   echo '
<tr class="refreshed">
<td><input class="textbox" onblur="updateLisprice(this.id)" style="width:auto;" type="text" id="price'.$t->PK_VESSEL_SERVICE.'" value="'.$t->LIST_PRICE.'" /></td>
<td><input class="textbox" style="width:auto;" onfocus="updateDisprice(this.id,this.value)" onkeyup="updateDisprice(this.id,this.value)"  type="text" id="discount'.$t->PK_VESSEL_SERVICE.'" value="'.$t->DISCOUNT.'"/></td>
<td><input class="textbox" style="width:auto;" type="text" id="disprice'.$t->PK_VESSEL_SERVICE.'" value="'.$t->DISCOUNT_PRICE.'"/></td>
<td><input type="checkbox" class="chkr"  id="process'.$t->PK_VESSEL_SERVICE.'" value="1" name="'.$tkc.'_'.$t->PK_VESSEL_SERVICE.'"/></td>
<td><input class="textbox" style="width:auto;" type="text" id="type'.$t->PK_VESSEL_SERVICE.'" value="'.$t->SERVICE_TYPE.'"/></td>
<td>
<textarea class="textarea" id="description'.$t->PK_VESSEL_SERVICE.'">'.$t->DESCRIPTION.'</textarea>
<!--<input class="textbox" style="width:auto;" type="text" id="description'.$t->PK_VESSEL_SERVICE.'" value="'.$t->DESCRIPTION.'"/>-->
<input type="hidden" id="wkname'.$t->PK_VESSEL_SERVICE.'" value="'.$t->SERVICE_TYPE.'" /></td>
</tr>
';
   $workparts = $workparts . "|" . $t->PK_VESSEL_SERVICE;
   $sub++;
   $worktype = $worktype ."|". $t->SERVICE_TYPE;
    }

    endforeach;
    echo '<input type="hidden" id="subtotal" value="'.count($totalservice).'"/>';
}

?>
</table>
<input type="hidden" id="sub" value="<?php echo $sub;?>"/>
<input type="hidden" id="supersub" value="<?php echo $supersub;?>"/>
<input type="hidden" id="tickfor" value="<?php echo $worktype;?>"/>

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
<?php if($status==0):?>
  <button class="btn" style="width:auto;" onclick="changeDateStyle()">Refresh All Services</button>
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
<span style="background-color: #FFF;width: auto;color: black;margin: 20px;margin-left: 80px;" onclick="javascript:document.getElementById('invoicemsg').click()">Check: Send For Invoicing All Completed Work Orders <input type="checkbox" <?php if($status==2){echo "checked";}?> id="invoicemsg" name="" value="" /></span>
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
