<script>
$(function() {
	$( "#fromdate" ).datepicker();
	//$( "#fromdate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	});
$(function() {
	$( "#todate" ).datepicker();
	//$( "#todate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	});
function dailyWorkOrder(sbn,smn,sort)
{	
	$("#worktoday").html('<img width="100px" height="100px" src="<?php echo base_url() ?>img/loading_gif.gif" style="position:relative;top:0px;left:0px;">');
	 $(".photos").css('display','none');
	 $(".same").val(1);
	$.ajax({url:"/btwdive/index.php/customer/displayDailyWorkOrder/",
		type:"post",
		 data: {
			 	one:sbn,
			 	two:smn,
			 	srt:sort	 
		 },
		 success:function(result){
			 $("#resets").click();
				$("#worktoday").html(result);
				document.getElementById("totalwork").innerHTML=$("#totalcount").val();
				$(".A").css("background-color", "yellow");
				$(".M").css("background-color", "blue");
				$(".C").css("background-color", "white");
				$("#worktoday tr").css("color", "#000000");
				
				
				//$("#allsel").click();	
				//alert("S"+$("#totalcount").val());
				}
  });
}
function dailyWorkOrderDate(sbn,smn,sdn,sort)
{	$("#worktoday").html('<img width="100px" height="100px" src="<?php echo base_url() ?>img/loading_gif.gif" style="position:relative;top:0px;left:0px;">');
$(".photos").css('display','none');
$(".same").val(1);
	$.ajax({url:"/btwdive/index.php/customer/displayDailyWorkOrderDate/",
		type:"post",
		 data: {
			 	one:sbn,
			 	two:smn,
			 	thr:sdn,
			 	srt:sort	 
		 },
		 success:function(result){
			 $("#resets").click();
				$("#worktoday").html(result);
				document.getElementById("totalwork").innerHTML=$("#totalcount").val();
				$(".A").css("background-color", "yellow");
				$(".M").css("background-color", "blue");
				$(".C").css("background-color", "white");
				$("#worktoday tr").css("color", "#000000");
			//	$("#allsel").click();
			//	alert($("#totalcount").val());
				}
  });
}
$(document).ready(function(){
	$("#resets").click(function(){
$("#allsel").html('Select All');
		});
});
$(document).ready(function(){
    $("#allsel").click(function(){
        
        if($(this).html()=='Select All'){
        $(":checkbox").prop('checked', true);
        if($(":checkbox").is(":checked"))
    	{ 
        $(this).html('Unselect All');
    	}
        else
        {
alert("No Work Order Found");
        }
    }else{
        
        $(':checkbox').prop('checked', false);
        $(this).html('Select All');
    }        
       
    });
    
});
function selectLabel(){
	if($(":checkbox").is("not:checked"))
	{
		$("#allsel").html('Select All');
	}
}
function goBack()
{
window.history.back();
}
//setInterval(function(){selectLabel();},1000);
$(document).ready(function(){
	
	$("#top :radio").click(function(){
		
	    var one = $(this).val();
		var two = $("#two").val();
		$("#one").val(one);
		$("#datadate").val("0");
	//	alert(one+"|"+two);
		dailyWorkOrder(one,two,0);
		});
});

$(document).ready(function(){
    $("#bottom :radio").click(function(){
        
        var two = $(this).val();
        var one = $("#one").val();
        var fr  = $("#fromdate").val();
        var to = $("#todate").val();
        $("#two").val(two);
      //  alert(one+"|"+two);
        if($("#datadate").val()==0){dailyWorkOrder(one,two,0);}
        else{dailyWorkOrderDate(fr,to,two,0);}
        });
	
});

$(document).ready(function(){
	$("#getdata").click(function(){
var to = $("#todate").val();
var fr = $("#fromdate").val();
var tr = $("#two").val();
$("#datadate").val(1);
dailyWorkOrderDate(fr,to,tr,0);
		});
});


$(function () {
	$('.btn.fewprint').click( function(){
		 if($(":checkbox").is(":checked"))
		 	{
	    var chkId = '';
	    var part = 1;
	    
	    var bsurl = document.getElementById("bsurl").value;
	    $('.printcheck:checked').each(function() {
	      chkId += $(this).val() + "^";
	    });
	    chkId =  chkId.slice(0,-1);
	    nums = chkId.split("^");
	    var l = nums.length;
	    
	    var  r=confirm("Are you sure you want to print "+l+" Work Order(s)");
	    if(r){
	        var tmpchk = '';

	               for(var i=0;i<l;i++)
	        {
	tmpchk = tmpchk+"^"+nums[i];
	if(i%50==0 && i>49 )
	{
		window.open(bsurl+"index.php/customer/printDocumentSelected/"+tmpchk+"/"+part);
			part++;
			var z = confirm("Please click OK to print the next part.\n Cancel to exit. ");
			if(z){
				tmpchk='0';
			}
			else
			{
exit;
			}
	}
	}
	             
	    	
	    	window.open(bsurl+"index.php/customer/printDocumentSelected/"+tmpchk+"/"+part);
	    }
		 	}
		 else
		 {

	alert("No Work Order Selected");
		 }

	  });
	});
$(function () {
	$('.btn.allprint').click( function(){
		var tot = parseInt($("#totalwork").html());
		//alert(tot);
		
		var chkId = '';
	    var part = 1;
	    var bsurl = document.getElementById("bsurl").value;
	    $('.printcheck').each(function() {
		      chkId += $(this).val() + "^";
		    });
	    chkId =  chkId.slice(0,-1);
	    nums = chkId.split("^");
	    	    
		if(parseInt(tot)>0)
	 	{
			var r = confirm("Are you sure you want to print "+$("#totalwork").html()+" Work Order(s)?");
		if(r)
		{
			var tmpchk = '';

            for(var i=0;i<nums.length;i++)
     {
            	tmpchk = tmpchk+"^"+nums[i];
            	
if(i%50==0 && i>48 )
{
	
	
	window.open(bsurl+"index.php/customer/printDocumentSelected/"+tmpchk+"/"+part);
		part++;
		var z = confirm("Please click OK to print the next part.\n Cancel to exit. ");
		if(z){
			tmpchk='';
		}
		else
		{
exit;
		}
}
}
    
 	
 	if(part==1){part=0;}
 	window.open(bsurl+"index.php/customer/printDocumentSelected/"+tmpchk+"/"+part);

		
		}
	 	}
		else
		{
alert("No Work Order Found");
		}
	  });
	});
$(document).ready(function(){
	$("#worktoday tr:even").css("background-color", "#ffffff");
	$("#worktoday tr:odd").css("background-color", "#E5E5E5");
	$("#worktoday tr:even").css("color", "#000000");
	$("#worktoday tr:odd").css("color", "#000000");
});
function printDocument()
{
	var datum = $("#loading_image").html();
	$.ajax({url:"/btwdive/index.php/customer/printDocumentNow/",
		type:"post",
		 data: {
			 	data:datum
		 },
		 success:function(result){
			// window.open(bsurl+"index.php/customer/printDocumentSelected");
    		 }
	});
}
/*************************************************************************************************************************/



$(document).ready(function(){
$("#work_sort").click(function(){
		if($("#datadate").val()==0){
			var one = $("#one").val();
	var two = $("#two").val();
	if($("#num_work").val()>0)
	{
			dailyWorkOrder(one,two,1);
	$("#up1").css('display','inline-block');
		$("#num_work").val(0);
	}
	else
	{        	
    dailyWorkOrder(one,two,2);
       $("#down1").css('display','inline-block');
	    $("#num_work").val(1);
	}	
	}
	else
	{
	
		
			var fr  = $("#fromdate").val();
	        var to = $("#todate").val();
			var two = $("#two").val();
			if($("#num_work").val()>0)
			{
				dailyWorkOrderDate(fr,to,two,1);
					$("#up1").css('display','inline-block');
						$("#num_work").val(0);
			}
			else
			{        	
				dailyWorkOrderDate(fr,to,two,2);
		    		    $("#down1").css('display','inline-block');
					    $("#num_work").val(1);
			}	
		        	
	}
        		
});



$("#print_sort").click(function(){

	if($("#datadate").val()==0){
	
	var one = $("#one").val();
	var two = $("#two").val();
	if($("#num_print").val()>0){
	dailyWorkOrder(one,two,3);

	$("#up2").css('display','inline-block');
		
	$("#num_print").val(0);
	}
	else
	{
			dailyWorkOrder(one,two,4);
		
			$("#down2").css('display','inline-block');
						
			$("#num_print").val(1);
	}	

	}
	else
	{
	
		
			var fr  = $("#fromdate").val();
	        var to = $("#todate").val();
			var two = $("#two").val();

			if($("#num_print").val()>0)
			{
				dailyWorkOrderDate(fr,to,two,3);
		
			$("#up2").css('display','inline-block');
			
			$("#num_print").val(0);
			}
			else
			{        	
				dailyWorkOrderDate(fr,to,two,4);
		    
		    $("#down2").css('display','inline-block');
			  $("#num_print").val(1);
			}	
		        		
		        		
		        	
		
	
	}
		
	
});

$("#customer_sort").click(function(){

	if($("#datadate").val()==0){
	
	var one = $("#one").val();
	var two = $("#two").val();
	if($("#num_customer").val()>0)
	{
	dailyWorkOrder(one,two,7);

	$("#up4").css('display','inline-block');
		
	$("#num_customer").val(0);
	}
	else
	{	
		dailyWorkOrder(one,two,8);
	
		$("#down4").css('display','inline-block');
				
		$("#num_customer").val(1);
	}	

	}
	else
	{
	
		
			var fr  = $("#fromdate").val();
	        var to = $("#todate").val();
			var two = $("#two").val();

			if($("#num_customer").val()>0)
			{
				dailyWorkOrderDate(fr,to,two,7);
		
			$("#up4").css('display','inline-block');
			
			$("#num_customer").val(0);
			}
			else
			{        	
				dailyWorkOrderDate(fr,to,two,8);
		    
		    $("#down4").css('display','inline-block');
			  $("#num_customer").val(1);
			}	
		        		
		        		
		        	
		
	
	}
		
});

$("#vessel_sort").click(function(){

	if($("#datadate").val()==0){
	
	var one = $("#one").val();
	var two = $("#two").val();
	if($("#num_vessel").val()>0)
	{
	dailyWorkOrder(one,two,9);

	$("#up5").css('display','inline-block');
		
	$("#num_vessel").val(0);
	}
	else
	{
				dailyWorkOrder(one,two,10);
			
				$("#down5").css('display','inline-block');
								
				$("#num_vessel").val(1);
	}	

	}
	else
	{
	
		
			var fr  = $("#fromdate").val();
	        var to = $("#todate").val();
			var two = $("#two").val();

			if($("#num_vessel").val()>0)
			{
				dailyWorkOrderDate(fr,to,two,9);
		
			$("#up5").css('display','inline-block');
			
			$("#num_vessel").val(0);
			}
			else
			{        	
				dailyWorkOrderDate(fr,to,two,10);
		    
		    $("#down5").css('display','inline-block');
			  $("#num_vessel").val(1);
			}	
		        		
		        		
		        	
		
	
	}
		 
});

$("#type_sort").click(function(){

	if($("#datadate").val()==0){
	
	var one = $("#one").val();
	var two = $("#two").val();
	if($("#num_type").val()>0)
	{
	dailyWorkOrder(one,two,5);

	$("#up3").css('display','inline-block');
		
	$("#num_type").val(0);
	}
	else
	{
		dailyWorkOrder(one,two,6);
	
		$("#down3").css('display','inline-block');
				
		$("#num_type").val(1);
	}	

	}
	else
	{
	
		
			var fr  = $("#fromdate").val();
	        var to = $("#todate").val();
			var two = $("#two").val();

			if($("#num_type").val()>0)
			{
				dailyWorkOrderDate(fr,to,two,5);
		
			$("#up3").css('display','inline-block');
			
			$("#num_type").val(0);
			}
			else
			{        	
				dailyWorkOrderDate(fr,to,two,6);
		    
		    $("#down3").css('display','inline-block');
			  $("#num_type").val(1);
			}	
		        		
		        		
		        	
		
	
	}
		 
});

$("#location_sort").click(function(){

	if($("#datadate").val()==0){
	
	var one = $("#one").val();
	var two = $("#two").val();
	if($("#num_location").val()>0)
	{
			dailyWorkOrder(one,two,11);
		
			$("#up6").css('display','inline-block');
						
			$("#num_location").val(0);
	}
	else
	{
				dailyWorkOrder(one,two,12);
			
				$("#down6").css('display','inline-block');
								
				$("#num_location").val(1);
	}	

}
else
{

	
		var fr  = $("#fromdate").val();
        var to = $("#todate").val();
		var two = $("#two").val();

		if($("#num_location").val()>0)
		{
			dailyWorkOrderDate(fr,to,two,11);
	
		$("#up6").css('display','inline-block');
		
		$("#num_location").val(0);
		}
		else
		{        	
			dailyWorkOrderDate(fr,to,two,12);
	    
	    $("#down6").css('display','inline-block');
		  $("#num_location").val(1);
		}	
	        		
	        		
	        	
	

}
		
});




});
/*************************************************************************************************************************/
function realClose()
{
	 var win=window.open("","_top","","true");
	 win.realclosefunc();
	try {
	      win.opener=true;
    	}catch(e){
		
		}
}
 window.realclosefunc = window.close;
 window.close = realClose;
</script>
<h2 style="text-align: center;">List of Open Work Orders</h2>
<input type="hidden" id="bsurl" value="<?php echo base_url() ?>" />
<img src="asdsa" width="1px" height="1px" onerror="dailyWorkOrder(1,1,3)" />
<input type="hidden" id="one" value="1" />
<input type="hidden" id="two" value="1" />
<input type="hidden" id="datadate" value="0" />
<input type="hidden" id="resets" />
<!-- Download Form -->
<form method="post" id="printfew" action="customer/printDocumentSelected">
<input type="hidden" id="printnumfew" name="printervalue" value=""/>
</form>
<form method="post" id="printall" action="customer/printDocumentSelected">
<input type="hidden" id="printnumall" name="printervalue" value=""/>
</form>




<!-- Select date period -->
<div
	style="width: 100%; float: left; text-align: center; height: 40px; padding-top: 10px; font-weight: bold;"
	id="top">
	<div
		style="width: 20%; float: left; text-align: center; background-color: gray;">
		<input type="radio" name="timeslice" value="1" id="today" checked /><?php echo date("m/d/Y")?></div>
	<div
		style="width: 20%; float: left; text-align: center; background-color: gray;">
		<input type="radio" name="timeslice" value="2" id="tomorrow" /><?php $tomorrow = mktime(0,0,0,date("m"),date("d")+1,date("Y")); echo date("m/d/Y", $tomorrow);?></div>
	<div
		style="width: 20%; float: left; text-align: center; background-color: gray;">
		<input type="radio" name="timeslice" value="3" id="week" />Next 7 Days
	</div>
	<div
		style="width: 20%; float: left; text-align: center; background-color: gray;">
		<input type="radio" name="timeslice" value="4" id="toweek" />Next 15
		Days
	</div>
	<div
		style="width: 20%; float: left; text-align: center; background-color: gray;">
		<input type="radio" name="timeslice" value="5" id="incomplete" />Past
		But Incomplete
	</div>
</div>
<!-- Print status and date filter -->
<div
	style="width: 100%; float: left; text-align: center; height: 50px; padding-top: 10px; font-weight: bold;"
	id="bottom">
	<fieldset
		style="width: 47%; float: left; text-align: center; height: 50px; padding-top: 10px; display: block; margin-top: 2px; border-right: 2px solid white;">
		<legend style="color: white">Print Status</legend>
		<div style="width: 30%; float: left; text-align: center;">
			<input type="radio" name="print" value="1" id="both" checked />Both
		</div>
		<div style="width: 30%; float: left; text-align: center;">
			<input type="radio" name="print" value="2" id="printed" />Printed
		</div>
		<div style="width: 30%; float: left; text-align: center;">
			<input type="radio" name="print" value="3" id="noprint" />Not Printed
		</div>
	</fieldset>

	<div
		style="width: 50%; float: left; text-align: center; height: 45px; margin-top: 10px; padding-top: 19px; background-color: gray;">
		<div style="width: 40%; float: left; text-align: center;">
			Date Range<input type="text" name=""
				value="<?php echo date("m/d/Y")?>" id="fromdate" class="textbox"
				style="width: auto" />
		</div>
		<div style="width: 40%; float: left; text-align: center;">
			To<input type="text" name="" value="<?php echo date("m/d/Y")?>"
				id="todate" class="textbox" style="width: auto" />
		</div>
		<div style="width: 19%; float: left; text-align: center;">
			<button class="btn" style="magin-top: 0%;" id="getdata">Get Data</button>
		</div>
	</div>
</div>
<!-- data display -->
<input type="hidden" class="same" id="num_work" value="1"/>
<input type="hidden" class="same" id="num_print" value="1"/>
<input type="hidden" class="same" id="num_type" value="1"/>
<input type="hidden" class="same" id="num_customer" value="1"/>
<input type="hidden" class="same" id="num_vessel" value="1"/>
<input type="hidden" class="same" id="num_location" value="1"/>
<div
	style="width: 100%; float: left; text-align: center; margin-top: 25px;">
	<table
		style="width: 98%; float: left; text-align: center; padding-left: 0px;">
		<tr>
			<th
				style="width: 12%; float: left; text-align: center; padding: 0px; border-right: 1px solid white; background-color: grey;">Print</th>
			<th
				style="width: 15%; float: left; text-align: center; padding: 0px; border-right: 1px solid white; background-color: grey;cursor: pointer;" id="work_sort">Work
				Order # <img src="<?php echo  base_url()?>img/up.png" style="width:28px;display:none" id="up1" class="photos">
				<img src="<?php echo  base_url()?>img/down.png" style="width:28px;display: none;" id="down1" class="photos"></th>
			<th
				style="width: 12%; float: left; text-align: center; padding: 0px; border-right: 1px solid white; background-color: grey;cursor: pointer;" id="print_sort">Printed
				<img src="<?php echo  base_url()?>img/up.png" style="width:28px;display:none" id="up2" class="photos">
				<img src="<?php echo  base_url()?>img/down.png" style="width:28px;display: none;" id="down2" class="photos"></th>
			<th
				style="width: 15%; float: left; text-align: center; padding: 0px; border-right: 1px solid white; background-color: grey;cursor: pointer;" id="type_sort">Type
				<img src="<?php echo  base_url()?>img/up.png" style="width:28px;display:none" id="up3" class="photos">
				<img src="<?php echo  base_url()?>img/down.png" style="width:28px;display: none;" id="down3" class="photos"></th>
			<th
				style="width: 15%; float: left; text-align: center; padding: 0px; border-right: 1px solid white; background-color: grey;cursor: pointer;" id="customer_sort">Customer
				Name<img src="<?php echo  base_url()?>img/up.png" style="width:28px;display:none" id="up4" class="photos">
				<img src="<?php echo  base_url()?>img/down.png" style="width:28px;display: none;" id="down4" class="photos"></th>
			<th
				style="width: 15%; float: left; text-align: center; padding: 0px; border-right: 1px solid white; background-color: grey;cursor: pointer;" id="vessel_sort">Vessel
				Name<img src="<?php echo  base_url()?>img/up.png" style="width:28px;display:none" id="up5" class="photos">
				<img src="<?php echo  base_url()?>img/down.png" style="width:28px;display: none;" id="down5" class="photos"></th>
			<th
				style="width: 15.5%; float: left; text-align: center; padding: 0px; background-color: grey;cursor: pointer;" id="location_sort">Location
				<img src="<?php echo  base_url()?>img/up.png" style="width:28px;display:none" id="up6" class="photos">
				<img src="<?php echo  base_url()?>img/down.png" style="width:28px;display: none;" id="down6" class="photos"></th>
		</tr>
	</table>
	<div
		style="width: 101.3%; float: left; text-align: center; padding-left: 0px; height: 300px; overflow-y: scroll;"
		id="worktoday"></div>
</div>
<!-- bottom menu -->
<div style="width: 100%; float: left; text-align: center; height: 50px;">
	<button class="btn" id="allsel">Select All</button>
	<button class="btn fewprint" style="width: auto">Print Selected</button>
	<button class="btn allprint">Print All</button>
	<button class="btn" onclick="realClose()">Exit</button>
</div>
<!-- messages -->
<div style="width: 100%; float: left; text-align: left; height: 50px;">
	Total Work Orders Found <span id="totalwork"></span>.
</div>
<a id="loading_image" style="display: block;"></a>
