<!--
Project     : BTW Dive
Author      : Subin
Title      : Create invoice from work order
Description : Creates invoices from the listed work orders.
-->
<style>
#maskerid {

	width: 100%;
	height: 100%;
	opacity: 0.9;
	background-color: black;
	top: 0px;
	bottom: 0px;
left:0px;
	position: fixed;
}

#dialogerid {
	margin: 0 auto;

	position: absolute;
	bottom: 30%;
	left: 30%;
}
#dialogerid {
	margin-top: 10px;
	top: 5px;
	width: 800px;
	height: 435px;
	left: 20%;
}
#progressbar {
	margin-top:35%;
}
</style>
<script>
$(document).ready(function(){
	$( "#fromdate" ).datepicker();
	$("#todate").datepicker();
});

function changeWindowStatus(str)
{
	
	var flag=0;
	$(document).ready(function(){
$("#"+str).val(0);
var n=parseInt($("#now").val());
var m=parseInt($("#margin").val());
$("#now").val(n+m);
$( "#progressbar" ).progressbar({

	value:n+m

	});

	if((100-(parseInt($("#now").val())))<8){
	$(".tstcls").each(function(){
		if($(this).val()>0)
		{
flag++;
		}


		});
	if(flag==0)
	{
		 $( "#progressbar" ).progressbar({

				value:100

				});
		 $("#clkit").html("INVOICING COMPLETED.");
		alert("Invoice(s) Created Successfully.");
		location.reload(true);
	}
	else
	{
//alert("not completed");
	}
	}

		});
}
$(document).ready(function(){
	$("#clicker").click(function(){

		var dialoger;
		var masker;
		var pro;
		var clk;
		clk = document.createElement("div");
		pro = document.createElement("div");
		dialoger = document.createElement("div");
		masker = document.createElement("div");
		masker.id="maskerid";
		dialoger.id="dialogerid";
		pro.id="progressbar";
		clk.id="clkit";
		clk.innerHTML='INVOICING IN PROGRESS.....';

		document.getElementById("worktoday").appendChild(masker);
		document.getElementById("worktoday").appendChild(dialoger);
		dialoger.appendChild(pro);
		dialoger.appendChild(clk);




	//	$("#clkit").click(function() {
		//	for( var i=0;i<=65;i+=5)
			//{
		//	alert("OK"+i);

			//}
		//	});


	});

	});

$(document).ready(function(){
$("#worktoday tr:even").css("background-color", "#ffffff");
$("#worktoday tr:odd").css("background-color", "#E5E5E5");
$("#worktoday tr:even").css("color", "#000000");
$("#worktoday tr:odd").css("color", "#000000");
});
$(document).ready(function(){
	$("#invoice_createer").click(function(){

		$("#clicker").click();
		$( "#progressbar" ).progressbar({

			value:false

			});
		for(var i=0;i<3;i++){
		var k = confirm("Are You Sure?");
		if(k)
		{
			var input = document.createElement("input");
			input.setAttribute("type", "hidden");
			input.setAttribute("id","win1214");
			input.setAttribute("value", "1");
			input.setAttribute("class","tstcls");
			document.body.appendChild(input);
			window.open("<?php echo base_url()?>index.php/customer/credit_payment_details/1214");//add flag and check the function.

		}
		//$("#now").val(i/10*100);
		var lm=((i+1)/6*100);
		$("#now").val(lm);
		var m=parseInt($("#now").val());
		$( "#progressbar" ).progressbar({

			value:m

			});

		}
		$("#margin").val(100/(2*i));

		});
});
$(document).ready(function(){
$("#invoice_create").click( function(){

	var cnd = $("#cound").val();
	 if($(":checkbox").is(":checked") && cnd>0)
	 	{
                    $("#clicker").click();
    var chkId = '';
    var crdId = '';
    //var creId = '';
    var flag=0;
    $('.printcheck:checked').each(function() {

        var str = $("#"+($(this).val()+"dm")).html();
        if(/credit/i.test(str))
        {
            //crdId += $(this).val() + ",";
            //alert($("#"+($(this).val()+"dm")).attr("name"));
            crdId += $("#"+($(this).val()+"dm")).attr("name") + ",";
            //creId += $(this).val() + ",";
        }

      chkId += $(this).val() + ",";

    });
    chkId =  chkId.slice(0,-1);



	$( "#progressbar" ).progressbar({

		value:10

		});

    $.ajax({url:base_url+"index.php/customer/createInvoiceWork/",
		type:"post",
		 data: {
			 	pkwo:chkId
		 },
		success:function(result){
			//alert(result);

			   if(crdId.length>0)
			    {
			var credit = crdId.split(",");
			//credit = $.unique( credit );//$.unique(
			//alert($.unique( credit ));

			var sorted_arr = credit.sort();
			var results = [];
			for (var i = 0; i < credit.length ; i++) {
			    if (sorted_arr[i+1] != sorted_arr[i]) {
			        results.push(sorted_arr[i]);
			    }
			}

			for(var i=1;i<results.length;i++)
			{
				var r = confirm($("#"+(results[i])+"fn").text()+" Billed By Credit Card.Do You want to Process Payment?");
				if(r)
				{
					var input = document.createElement("input");
					input.setAttribute("type", "hidden");
					input.setAttribute("id", results[i]);
					input.setAttribute("value", "1");
					input.setAttribute("class","tstcls");
					document.body.appendChild(input);
			//alert("new Page");//http://localhost/btwdive/index.php/customer/credit_payment_details/2040
			window.open("<?php echo base_url()?>index.php/customer/credit_payment_details/"+results[i]+"/"+results[i]);//add flag and check the function.

			$("#margin").val(100/(2*(results.length-1)));
			//var lm=((i/(2*(results.length-1)))*100);
			var lm = parseInt($("#now").val())+parseInt($("#margin").val());
			$("#now").val(lm);
			var m=parseInt($("#now").val());
			$( "#progressbar" ).progressbar({

				value:m

				});

			}
				else
				{
					$("#margin").val(100/(2*(results.length-1)));
				var lm = parseInt($("#now").val())+2*(parseInt($("#margin").val()));
					$("#now").val(lm);
					var m=parseInt($("#now").val());
					$( "#progressbar" ).progressbar({

						value:m

						});

					if((100-(parseInt($("#now").val())))<8){
						$(".tstcls").each(function(){
							if($(this).val()>0)
							{
					flag++;
							}


							});
						if(flag==0)
						{
							 $( "#progressbar" ).progressbar({

									value:100

									});
							 $("#clkit").html("INVOICING COMPLETED.");
							alert("Invoice(s) Created Successfully.");
							location.reload(true);
						}
						else
						{
					//alert("not completed");
						}
						}
			//alert("same page");
				}


			}
			$("#margin").val(100/(2*(i-1)));

			    }
///////////////////////////
			   else
			   {
			   $( "#progressbar" ).progressbar({

					value:100


					});
			   $("#clkit").html("INVOICING COMPLETED.");
			   alert("Invoice(s) Created Successfully.");
				location.reload(true);
			   }
				}
    });



	 	}
	 else
	 {
		 if(cnd>0){
alert("No Work Order Selected.");
		 }
		 else
		 {
			 alert("No Work Order Found.");
		 }
	 }

});
});

function diverSort()
{
	if(($("#fromdate").val()=='' || $("#todate").val()=='') && $("#diver").val()!='')
	{
	$("#id_diver").val($("#diver").val());
	$("#sortdiver").submit();
	}
	else
	{
		if($("#fromdate").val()!='' && $("#todate").val()!='' && $("#diver").val()!='')
		{
		$("#who").val($("#diver").val());
		 $("#start").val($("#fromdate").val());
		 $("#end").val($("#todate").val());
		 $("#dual").submit();
		}


	}
}
function dateSort()
{
	if($("#fromdate").val()!='' && $("#todate").val()!='' && $("#diver").val()=='')
	{
	$("#datefrom").val($("#fromdate").val());
	$("#dateto").val($("#todate").val());
	$("#sortdate").submit();
	}
	else
	{
		if($("#fromdate").val()!='' && $("#todate").val()!='' && $("#diver").val()!='')
		{
		$("#who").val($("#diver").val());
		 $("#start").val($("#fromdate").val());
		 $("#end").val($("#todate").val());
		 $("#dual").submit();
		}
	}
}
$(document).ready(function(){
	if(!isNaN($("#master").val()))
	{
$("#super").css("display","none");
	}
});

$(document).ready(function(){
	$("#selection").click(function(){
if($("#cound").val()>0)
{
    if($(this).html()=='Select All'){
        $(":checkbox").prop('checked', true);
        $(this).html('Unselect All');
    }else{
        $(':checkbox').prop('checked', false);
        $(this).html('Select All');
    }
}
else
{
	alert("No Work Order Found.");
}

		});
});


</script>

<form id="sortdiver" method="post">
<input type="hidden" name="diving" value="yes"/>
<input type="hidden" name="id_diver" value="" id="id_diver"/>
</form>

<form id="sortdate" method="post">
<input type="hidden" name="daterange" value="yes"/>
<input type="hidden" name="datefrom" value="" id="datefrom"/>
<input type="hidden" name="dateto" value="" id="dateto"/>
</form>

<form id="dual" method="post">
<input type="hidden" name="dual" value="yes"/>
<input type="hidden" name="start" value="" id="start"/>
<input type="hidden" name="end" value="" id="end"/>
<input type="hidden" name="who" value="" id="who"/>

</form>

<input type="hidden" id="margin" value="0"/>
<input type="hidden" id="now" value="0"/>
<input type="hidden" id="clicker"/>
<input type="hidden" id="bsurl" value="<?php echo base_url() ?>" />
<input type="hidden" id="one" value="1"/>
<input type="hidden" id="two" value="1"/>
<input type="hidden" id="datadate" value="0"/>
<input type="hidden" id="master" value="<?php echo $user;?>"/>

<h2 style="width:100%;text-align: center;">The Following Completed order  have not been Invoiced.Check the Work Orders you want to Invoice and click Create Invoices</h2>

<div style="width:100%;float:left;margin:0 auto;">







<div style="width:100%;margin:0 auto;text-align: center;margin-bottom: 15px;display:block;" id="super">

<fieldset style="width:40%;display: inline;border: 1px solid white;height:48px">
<legend style="font-weight: bold;color: white;">Date Range</legend>
<?php
if($user=='date')
{
    ?>
    <b>Form</b> <input type="text" class="textbox" id="fromdate" value="<?php echo $diver;?>" style="display: inline;width:35%;margin-top:-1px" onchange="dateSort()"/>
<b>To</b> <input type="text" class="textbox" id="todate" value="<?php echo $date;?>"  style="display: inline;width:35%;" onchange="dateSort()"/>
    <?php
}else if($user=='dual') {

?>
<b>Form</b> <input type="text" class="textbox" id="fromdate" value="<?php echo $date;?>" style="display: inline;width:35%;margin-top:-1px" onchange="dateSort()"/>
<b>To</b> <input type="text" class="textbox" id="todate" value="<?php echo $dual;?>"  style="display: inline;width:35%;" onchange="dateSort()"/>
<?php }

else  {

    ?>
<b>Form</b> <input type="text" class="textbox" id="fromdate" value="" style="display: inline;width:35%;margin-top:-1px" onchange="dateSort()"/>
<b>To</b> <input type="text" class="textbox" id="todate" value=""  style="display: inline;width:35%;" onchange="dateSort()"/>
<?php }?>

</fieldset>


<fieldset style="width:40%;margin:0 auto;display: inline;border: 1px solid white;height:48px;">
<legend style="font-weight: bold;color: white;">Diver</legend>

<select id="diver" onchange="diverSort()" class="select" style="padding-top:0px;">
<option value="all">All Divers</option>
<?php
foreach($alldivers as $ad):
if($diver==$ad->PK_DIVER && $user=='diver')
{
    echo '<option selected value="'.$ad->PK_DIVER.'">'.$ad->DIVER_NAME.'</option>';
}
else if($diver==$ad->PK_DIVER && $user=='dual') {
    echo '<option selected value="'.$ad->PK_DIVER.'">'.$ad->DIVER_NAME.'</option>';
}
else
{
    echo '<option value="'.$ad->PK_DIVER.'">'.$ad->DIVER_NAME.'</option>';
}

endforeach;
?>
</select>

</fieldset>



</div>


<table style="width:98%;float:left;text-align: center;padding-left:0px;">
<tr>
<th style="width:12%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Work Order No.</th>
<th style="width:8%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Type</th>
<th style="width:8%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Schedule Date</th>
<th style="width:15%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Client Name</th>
<th style="width:15%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Vessel Name</th>
<th style="width:15%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Mode</th>
<th style="width:13.1%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Diver</th>
<th style="width:13.3%;float:left;text-align: center;padding:0px;background-color: grey;">Process</th>
</tr>
</table>
<div style="width:101.3%;float:left;text-align: center;padding-left:0px;height:400px;overflow-y: scroll;" id="worktoday">
<?php
$temp  = '<table style="width:98%;float:left;text-align: center;padding-left:0px;">';
$count = 0;
foreach ($invoices as $invoice):
$temp = $temp .'<tr style="cursor:pointer" >
<a href="' . base_url () .'index.php/customer/completed_work_order/' . $invoice->PK_WO . '" target="_blank" id="' . $invoice->PK_WO . '"></a>
<td onclick="document.getElementById(&quot;' . $invoice->PK_WO . '&quot;).click();" style="width:12%;float:left;text-align: center;padding:0px;border-right:1px solid black;">'.$invoice->WO_NUMBER.'&nbsp;</td>';
switch ($invoice->WO_CLASS) {
            case 'A' :
                $temp = $temp . '<td style="width:8%;float:left;text-align: center;padding:0px;border-right:1px solid black;">Anode</td>';
                break;
            case 'C' :
                $temp = $temp . '<td style="width:8%;float:left;text-align: center;padding:0px;border-right:1px solid black;">Clean</td>';
                break;
            case 'M' :
                $temp = $temp . '<td style="width:8%;float:left;text-align: center;padding:0px;border-right:1px solid black;">Mech</td>';
                break;
            default :
                break;
        }

$temp = $temp.'<td onclick="document.getElementById(&quot;' . $invoice->PK_WO . '&quot;).click();" style="width:8%;float:left;text-align: center;padding:0px;border-right:1px solid black;">'.$invoice->SCHEDULE_DATE.'&nbsp;</td>
<td onclick="document.getElementById(&quot;' . $invoice->PK_WO . '&quot;).click();" style="width:15%;float:left;text-align: center;padding:0px;border-right:1px solid black;" id="'.$invoice->PK_CUSTOMER.'fn">'.$invoice->FIRST_NAME.'&nbsp;'.$invoice->LAST_NAME.'&nbsp;</td>
<td onclick="document.getElementById(&quot;' . $invoice->PK_WO . '&quot;).click();" style="width:15%;float:left;text-align: center;padding:0px;border-right:1px solid black;">'.$invoice->VESSEL_NAME.'&nbsp;</td>
<td onclick="document.getElementById(&quot;' . $invoice->PK_WO . '&quot;).click();" style="width:15%;float:left;text-align: center;padding:0px;border-right:1px solid black;" name="'.$invoice->PK_CUSTOMER.'" id="'.$invoice->PK_WO.'dm">'.$invoice->DELIVERY_MODE.'&nbsp;</td>

<td onclick="document.getElementById(&quot;' . $invoice->PK_WO . '&quot;).click();" style="width:13.2%;float:left;text-align: center;padding:0px;border-right:1px solid black;">'.$invoice->DIVER_NAME.'&nbsp;</td>

<td style="width:11%;float:left;text-align: center;padding:0px;z-index:-1;"><input type="checkbox"  style="width:100%;" value="'.$invoice->PK_WO.'" id="'.$invoice->PK_WO.'" class="printcheck"/></td></tr>';
endforeach;
$count = count($invoices);
if($count==0)
{
    $temp = '<tr><td colspan="7" style="text-align:center">No Work Orders Found.</td></tr>';
}
$temp = $temp.'</table>';
echo $temp;
?>
</div></div>

<div style="width:100%;float:left;text-align: center;height:50px;">
<button id="selection" class="btn">Select All</button>
<button class="btn" id="invoice_create" style="width:auto;" >Create Invoices</button>
<button class="btn" onclick="self.close();" >Exit</button>
</div>
<div style="width:100%;float:left;text-align: left;height:50px;">
Total Work Orders Found <?php echo $count;?>.
<input type="hidden" id="cound" value="<?php echo $count;?>"/>
</div>