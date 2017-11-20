<!--
Project     : BTW Dive
Author      : Subin
Title      : PHASE -2 WORK ORDER DISTRIBUTION
Description : Page for LISTING AND ASSIGNING THE WORK ORDERS TO THE DIVERS
-->

<style>
/*
div {
	border:1px solid red;
}
td,th,table,tr {
	border-collapse: collapse;
	border:1px solid green;

}*/
.first  {
	outline:2px solid white;
	outline-bottom:0px;
	border-collapse: collapse;
	}
.second  {
	outline:2px solid white;
	border-collapse: collapse;

}
.const {
	width:14%;
}
.even {
	background-color: #E5E5E5;
	color:black;
}

.odd {
	background-color: #FFFFFF;
	color:black;
}
.redd
{
	background-color: green;
	color:white;
}
.ncon {
	width:7%;
}
</style>
<script>
$(document).ready(function(){
	$("#fromdate").datepicker();
	$("#todate").datepicker();
	$(".divertable tr:even").css("background-color", "#ffffff");
	$(".divertable tr:odd").css("background-color", "#E5E5E5");
	$(".divertable tr:even").css("color", "#000000");
	$(".divertable tr:odd").css("color", "#000000");

	//second stage
try{
	var basen = $("#basin").val();
	var bas = basen.split("_");
	var baso = bas[0];
	var bast = bas[1];
	var basf = bas[2];
	var based = baso.split("^");
	var bases = bast.split("^");
	var basec = basf.split("^");
//for diver access
	document.getElementById("diverwho").value=based[0];

	for(var i=1;i<based.length;i++)
	{
//alert(bas[i]);
document.getElementById(based[i]).checked=true;
	}
	//alert(bases);
	for(var j=1;j<bases.length;j++)
	{
		document.getElementById(bases[j]).checked=true;
	}

	for(var k=1;k<basec.length;k++)
	{
		document.getElementById(basec[k]).checked=true;
	}


	/************************************************************************/
	if(isNaN($("#person").val()))
		{
			 document.getElementById("revert").style.display="none";
$("#personal").html("Assign Work Orders to Divers");
		}
	else
	    {
	    var m = "name"+$("#person").val();
	    var n = document.getElementById(m).innerHTML;
		$("#personal").html("Work Orders Assigned to  "+n);
		$("#revert").css("display","inline-block");
		//here the code to execut when it is assigned to empty.
		}
}
catch(e){}
if($("#basin").val()==$("#diverwho").val()+"__" && $("#diverwho").val()>0)
{
	$(".numer").css("display","none");
}
});
/********************************************************************************/
/********************************************************************************/
/**************************revert to assign work orders ************************/
$(document).ready(function(){
	$("#revert").click(function(){
		var tmp = '';
		var chk = false;
$(".selection").each(function(){
	if($(this).prop("checked"))
	{
		tmp = tmp +"^"+$(this).val();
		chk = true;
	}
});
if(chk)
{
	$.ajax({url:base_url+"index.php/customer/assignWorkDivers/",
		type:"post",
		 data: {
			 work:tmp,
			 diver:0
		 },
		 success:function(result){
			 alert("Work Order(s) Reverted Successfully.");
			 location.reload();
			 }
		});
	//alert(tmp+"|"+$("#divernames").val());
}
else
{
alert("No Work Orders Selected.");
}
});
});
/********************************************************************************/
/********************************************************************************/
function updateDays()
{
	$("#datefrom").val($("#fromdate").val());
	$("#dateto").val($("#todate").val());
	$("#basin").val($("#location").val());
	$("#daybyday").submit();

}
function updateDiver(work,diver)
{
	$("#datefromd").val($("#fromdate").val());
	$("#datetod").val($("#todate").val());
	//var r = confirm("Assign Work Order to"+);*/
	$("#workorder").val(work);
	$("#divername").val(diver);
	$("#diverwork").submit();
}
$(document).ready(function(){
	$(".counter").each(function(){


var k = $(this).attr("id");
var l = k.slice(4);
//******************************************************************//
$.ajax({url:base_url+"index.php/customer/getTotalWorkOrdersAllTime/",
	type:"post",
	 data: {
		 who:l
	 },
	 success:function(result){
		 var m = 'diver'+l;


		 $("#"+m).html(result);
		 }




	});
//*****************************************************************//


		});
});

$(document).ready(function(){
	$("#submit").click(function(){

		var tmp = '';
		var chk = false;

$(".selection").each(function(){
	if($(this).prop("checked"))
	{
		tmp = tmp +"^"+$(this).val();
		chk = true;
	}
});

if(chk && $("#divernames").val()!='')
{
	$.ajax({url:base_url+"index.php/customer/assignWorkDivers/",
		type:"post",
		 data: {
			 work:tmp,
			 diver:$("#divernames").val()
		 },
		 success:function(result){
			 alert("Work Order(s) Assigned Successfully.");
			 location.reload();
			 }




		});
	//alert(tmp+"|"+$("#divernames").val());
}
else
{
	if(chk)
	{
alert("Select Diver");
	}
	else
	{
alert("No Work Orders Selected.");
	}
}
});
});

/*
 * new portion
 */

function updateDaysMany()
{
	$("#datefrom").val($("#fromdate").val());
	$("#dateto").val($("#todate").val());
    //locations included.
    var tmp;
   tmp = $("#diverwho").val();


	$(".location").each(function(){
if($(this).prop("checked"))
{
	tmp = tmp + "^" + $(this).val();
}
        });

    //marina included
    var reg = "";
    $(".marina").each(function(){
if($(this).prop("checked"))
{
	reg = reg + "^" + $(this).val();
}
        });
    var cat = "";
    $(".category").each(function(){
if($(this).prop("checked"))
{
	cat = cat + "^" + $(this).val();
}
        });
var cur = tmp + "_" + reg + "_" + cat;
$("#basin").val(cur);
	$("#daybyday").submit();

}

$(document).ready(function(){
    $("#allsel").click(function(){
        if($("#totalcount").val()>0){
        if($(this).html()=='Select All'){
        $(":checkbox.selection").prop('checked', true);
        $(this).html('Unselect All');
    }else{
        $(':checkbox.selection').prop('checked', false);
        $(this).html('Select All');
    }
        }
        else
        {
alert("No Work Orders Found");exit;
        }
    });
});
function newDiverPage(str)
{
	//alert(str);
	var now = $("#fast").val();
	var when = $("#past").val();
//	var tail = $("#basin").val();
	var et="";/*
	if(tail.search("all")<0)
	{
		if(!(tail.search(/(\d+)/)))
		{
			 et = tail.replace(/(\d+)/, str);
			 //alert("1|"+et);
		}
		else
		{
 et = str+tail;
 //alert("2|"+et);
		}
	}
	else
	{
et = tail.replace("all",str);
if(et.length==5)
{
	et = et+"__";
}
//alert("3|"+et);
	}
*/

    et = str+"__";

	window.open("<?php echo base_url()?>index.php/customer/manage_work_orders/"+now+"/"+when+"/"+et);
}
function alertNow(str)
{
	var r = confirm("Click OK to Send Alert Mail");
	if(r)
	{
		$.ajax({url:base_url+"index.php/customer/work_order_email_alert/"+str,
			 success:function(result){
				 alert("Alert Mail Sent.");
				 }

			});
	}
}

$(document).ready(function(){
$("#superwork").click(function(){

var board;
var screen;


board = document.createElement("div");
screen = document.createElement("div");
bottom = document.createElement("div");

board.id="boardid";
screen.id="screenid";
bottom.id="bottomid";

board.innerHTML='<img src="sdfds" onerror="loadHoldWorkOrders()" width="1px" height="1px"/>';
bottom.innerHTML='<button class="btn" style="width:auto;" id="chooseall">SELECT ALL</button>   <button class="btn" style="width:auto;" id="choose">RELEASE SELECTED WORK ORDERS</button> <button class="btn" style="width:auto;" id="move_to_collections">MOVE TO COLLECTIONS</button>   <button class="btn" id="outerpass">EXIT</button>';
board.appendChild(screen);
board.appendChild(bottom);
document.body.appendChild(board);


$("#outerpass").click(function(){
	var elemt = document.getElementById("boardid");
    elemt.parentNode.removeChild(elemt);
    return false;
});

$("#chooseall").click(function(){
	if($(".holdon").length>0){
	 if($(this).html()=='SELECT ALL'){
	        $(".holdon").prop('checked', true);
	        $(this).html('UNSELECT ALL');
	    }else{
	        $('.holdon').prop('checked', false);
	        $(this).html('SELECT ALL');
	    }
	}
});


$("#move_to_collections").click(function(){
	
	var tmp=0;

	$(".holdon").each(function(){
		if($(this).prop("checked"))
		{
		tmp = tmp +"|"+ $(this).val();
		}
	});

	if(tmp.length>1)
	{
		var r = confirm("Are you sure you want to move this Work Order(s) to collection..?");
		if(r){
			$.ajax({url:base_url+"index.php/customer/changeOnholdtocollection/",
			type:"post",
			 data: {
				 workorder:tmp
				   },
			 success:function(result)
				 {
					alert("Work Order(s) moved to collection.");
					$("#outerpass").click();
					$("#superwork").click();
				 }
			});
		}
	}
	else
	{
		alert("No Work Orders Selected.");
	}

});

$("#choose").click(function(){

	var tmp=0;

	$(".holdon").each(function(){
		if($(this).prop("checked"))
		{
		tmp = tmp +"|"+ $(this).val();
		}
	});

	if(tmp.length>1)
	{
		$.ajax({url:base_url+"index.php/customer/releaseWorkOrders/",
		type:"post",
		 data: {
			 workorder:tmp
			   },
		 success:function(result)
			 {
				alert(result);
				$("#outerpass").click();
				$("#superwork").click();
			 }
		});
	}
	else
	{
	alert("No Work Orders Selected.");
	}

});

});
});
function loadHoldWorkOrders()
{
	$.ajax({url:base_url+"index.php/customer/displayOnholdWorkOrders/",
		 success:function(result){
			 $("#screenid").html(result);
			 $(".holdtable tr:even").css("background-color", "#ffffff");
			 $(".holdtable tr:odd").css("background-color", "#E5E5E5");
			 $(".holdtable tr").css("color","#000000");
			 }

		});
}

</script>
<style>
#boardid
{
	background-color: black;

    height: 100%;
    left: 0px;
	top:0px;
    position: fixed;
    width: 100%;

}
#screenid
{
	 background-color: black;
    height: 500px;
    left: 13%;
    position: absolute;
    width: 1000px;
	overflow: auto;
	text-align: center;
}
#bottomid
{
	 background-color: black;
    height: 50px;
    left: 13%;
	text-align:center;
    position: absolute;
    width: 1000px;

	top:500px;

}

</style>

<h2 style="width:100%;text-align:center;" id="personal">Assign Work Orders to Divers</h2>
<form id="diverwork" method="post">
<input type="hidden" name="orders" value="yes"/>
<input type="hidden" name="workorder" value="" id="workorder"/><input type="hidden" name="diver" value="" id="divername"/>
<input type="hidden" name="fromdated" value="<?php echo $then;?>" id="datefromd"/><input type="hidden" name="todated" value="<?php echo $now;?>" id="datetod"/>
</form>
<form id="daybyday" method="post">
<input type="hidden" name="days" value="yes"/>
<input type="hidden" name="fromdate" value="<?php echo $then;?>" id="datefrom"/>
<input type="hidden" name="todate" value="<?php echo $now;?>" id="dateto"/>
<input type="hidden" name="basin" value="<?php echo urldecode($basin);?>" id="basin"/>
</form>
<input type="hidden" id="totalcount" value="<?php echo count($work_orders);?>"/>
<input type="hidden" id="diverwho" value=""/>
<input type="hidden" id="past" value="<?php echo $past;?>"/>
<input type="hidden" id="fast" value="<?php echo $fast;?>"/>
<input type="hidden" id="person" value="<?php echo $person;?>"/>
<!-- Main -->
<div style="width:100%;float:left;">
<div style="width: 20%; float: left; text-align: center; height: 45px;  padding-top: 19px; display: block;float: left;">
		<div style="width: 61%; float: left; text-align: center;">
			Date Range<input type="text" style="width: 50%" class="textbox" id="fromdate" value="<?php echo $then;?>" name="" onchange="updateDaysMany()">
		</div>
		<div style="width: 38%; float: left; text-align: center;">
			<b>-- </b><input type="text" style="width:75%" class="textbox" id="todate" value="<?php echo $now;?>" name="" onchange="updateDaysMany()">
		</div>

	</div>

<!-- 	<div style="width: 20%; float: left; text-align: center; height: 45px;  padding-top: 19px; display: inline-block;float: left;">
	Location <select class="select" style="width:60%;" onchange="updateDays()" id="location">
	<option value="all">All Location</option>

	<?php
	foreach($location as $l):
	if(urldecode($basin)==$l->OPTIONS)
	{
	    echo '<option selected value="'.$l->OPTIONS.'">'.$l->OPTIONS.'</option>';
	}
	else
	{
	echo '<option value="'.$l->OPTIONS.'">'.$l->OPTIONS.'</option>';
	}
	endforeach;
	?>

	</select>

	</div> -->

	<div style="width:59%;float: left;margin-top:40px;font-weight: bold;">Work Orders : <?php echo count($work_orders);?></div>

<!-- Left -->
<div style="width:20%;float:left;display: block;clear: left;">
<table style="width:100%;" class="divertable">
<?php
//print_r($divers);
//echo $divers[0]->PK_DIVER;
foreach($divers as $di):
echo '<input type="hidden" id="dv'.$di->PK_DIVER.'" value="'.$di->T.'"/>';
endforeach;

    foreach($alldivers as $ad):
    echo '<tr><td style="width:60%;cursor:pointer;text-decoration:underline" class="counter"  id="name'.$ad->PK_DIVER.'" onclick="newDiverPage('.$ad->PK_DIVER.')">'.$ad->DIVER_NAME.'</td><td class="numer" id="diver'.$ad->PK_DIVER.'">0</td><td><button onclick="alertNow('.$ad->PK_DIVER.')" class="btn">Alert Now</button></td></tr>';
    endforeach;
?>
</table>
<hr style="border:1px dashed white"/>
<button id="superwork" class="btn" style="width:100%;text-transform: uppercase;">Work orders on hold</button>
<a href="<?=base_url()?>index.php/customer/collections">
<button id="onhold_collections" class="btn" style="width:100%;text-transform: uppercase;">Collections</button>
</a>
<hr style="border:1px dashed white"/>
<b>Category</b>
<ul style="list-style-type: none;">
<li><input type="checkbox" value="category1" class="category" id="category1" name="x" onclick="updateDaysMany()"/>Cleaning Work Orders</li>
<li><input type="checkbox" value="category2" class="category" id="category2" name="y" onclick="updateDaysMany()"/>Anode Work Orders</li>
<li><input type="checkbox" value="category3" class="category" id="category3" name="z" onclick="updateDaysMany()"/>Mechanical Work Orders</li>
</ul>

<hr style="border:1px dashed white"/>
<b>Locations</b>

<ul style="list-style-type: none;">
<?php
foreach($location as $l):
	if(urldecode($basin)==$l->OPTIONS)
	{
	    echo '<li><input type="checkbox" id="'.$l->OPTIONS.'" onclick="updateDaysMany()" class="location" name="locations[]" value="'.$l->OPTIONS.'"  />'.$l->OPTIONS.'</li>';

	}
	else
	{
	      echo '<li><input type="checkbox" id="'.$l->OPTIONS.'" onclick="updateDaysMany()" class="location" name="locations[]" value="'.$l->OPTIONS.'"  />'.$l->OPTIONS.'</li>';
	}
	endforeach;

?>
</ul>

<hr style="border:1px dashed white"/>
<b>Geographic Locations</b>
<ul style="list-style-type: none;">
<li><input type="checkbox" value="marina1" class="marina" id="marina1" name="x" onclick="updateDaysMany()"/>(V/H) Ventura</li>
<li><input type="checkbox" value="marina2" class="marina" id="marina2" name="y" onclick="updateDaysMany()"/>(N/B) NewportBeach</li>
<li><input type="checkbox" value="marina3" class="marina" id="marina3" name="z" onclick="updateDaysMany()"/>(MDR) Marina Del Rey</li>
<li><input type="checkbox" value="marina4" class="marina" id="marina4" name="w" onclick="updateDaysMany()"/>(W/V) Westlake village</li>
</ul>
</div>

<!-- Right -->
<table style="width:77.7%;text-align: left;border-collapse: collapse;">
 <tr style="text-align: center;">

<th style="background-color: black;color:white;width:14%;border:1px solid white;">Boat Name</th>
<th style="background-color: black;color:white;width:14%;border:1px solid white;">Boat Slip</th>
<th style="background-color: black;color:white;width:7%;border:1px solid white;">Customer Code</th>
<th style="background-color: black;color:white;width:14%;border:1px solid white;">Boat Size/Type</th>
<th style="background-color: black;color:white;width:14%;border:1px solid white;">Schedule Date</th>
<th style="background-color: black;color:white;width:21%;border:1px solid white;">Customer Name</th>
<th style="background-color: black;color:transparent;border:1px solid white;">Diver</th></tr></table>
<div style="width:79%;float:left;height:600px;overflow-y:scroll;">



<?php
echo '<table style="width:100%;text-align: left;border-collapse: collapse;">';
$k=0;
foreach($work_orders as $w):
switch ($w->WO_CLASS)
{
    case 'A':
        $t= 'anode_work_order';
        break;
    case 'C':
        $t= 'cleaning_work_order';
        break;
    case 'M':
        $t= 'mechanical_work_order';
        break;
    default:break;
}
if($k%2==0)
{
    $cls = 'even';
}
else
{
    $cls = 'odd';
}
if($w->INVOICE_SUB==1)
{
    $cls = 'redd';
}
echo '<tr class="'.$cls.'">

<td class="const" style="border:1px solid black;border-top:1px solid black;">'.$w->VESSEL_NAME.'</td>
<td class="const" style="border:1px solid black;">'.$w->LOCATION.'&nbsp;'.$w->SLIP.'</td>
<td class="ncon" style="border:1px solid black;">'.$w->ACCOUNT_NO.'</td>
<td class="const" style="border:1px solid black;">'.$w->VESSEL_LENGTH.'/'.$w->VESSEL_TYPE.'</td>
<td class="const" style="border:1px solid black;">'.$w->SCHEDULE_DATE.'</td>
<td  style="border:1px solid black;border-right:1px solid black;width:21%;">'.$w->FIRST_NAME.'&nbsp;'.$w->LAST_NAME.'</td>
<td  rowspan="2"  style="border-top:1px solid black;border-bottom:1px solid black;border-right:1px solid black;text-align:center"><input type="checkbox" value="'.$w->PK_WO.'" class="selection"/></td>
</tr><tr style="cursor:pointer;" onclick="window.open(&quot;'.base_url().'index.php/customer/'.$t.'/'.$w->PK_WO.'&quot;)"  class="'.$cls.'">
<td class="const" colspan="6" style="border:1px solid black;height:25px;text-align:left;" title="Click to view Work Order Details....">

<b style="display:block;width:100%;margin:0px auto;text-align:center;">'.$w->WORK_NAME.'</b>
<b style="font-weight:normal;;">
Service Notes: </b>'.$w->COMMENTS.'</td></tr><tr><td colspan="7" style="border:transparent;height:3px;"></td></tr>';
$k++;
endforeach;
if($k==0)
{
   echo '<tr><td colspan="8" style="text-align:center;"><h2>No Work Orders Found.</h2></td></tr>';
}
?>
</table>
</div>
<div style="width:100%;text-align: center;float: left;">
<button class="btn" id="allsel">Select All</button>
<select class="select" name="divername" id="divernames"><option value="">Select Diver</option>
<?php
foreach($alldivers as $dv):
echo '<option value="'.$dv->PK_DIVER.'">'.$dv->DIVER_NAME.'</option>';
endforeach;
?></select>
<button class="btn" id="submit" style="width:auto;" >Assign Work Orders</button>
<button class="btn" id="revert" style="width:auto;display:none" >Revert Work Orders</button>
<button class="btn" onclick="self.close()" >Exit</button></div>
</div>
<div id="dialog" title="Confirmation Required">
  Are you sure about this?
</div>​