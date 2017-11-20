
<script type="text/javascript">
function loadAJAX()
{
	if (window.XMLHttpRequest){
	  xmlhttp=new XMLHttpRequest();
	  }	else {
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  return xmlhttp;
}
$(document).ready(function(){
	$("tr:even").css("background-color", "#ffffff");
	$("tr:odd").css("background-color", "#B7B9B8");
	$("tr:even").css("color", "#000000");
	$("tr:odd").css("color", "#000000");
});

function accountDialogBox(str)
{
	var mask;
	var dialog;
	var rowa;
	var rowb;
	var rowc;
	var rowd;
	var rowe;
	var rowf;
	var rowg;
	var rowh;
	


	mask = document.createElement("div");
	dialog = document.createElement("div");
	rowa = document.createElement("div");
	rowb = document.createElement("div");
	rowc = document.createElement("div");
	rowd = document.createElement("div");
	rowe = document.createElement("div");
	rowf = document.createElement("div");
	rowg = document.createElement("div");
	rowh = document.createElement("div");


	mask.id="maskid";
	dialog.id="dialogid";
	rowa.id="rowa";
	rowb.id="rowb";
	rowc.id="rowc";
	rowd.id="rowd";
	rowe.id="rowe";
	rowf.id="rowf";
	rowg.id="rowg";
	rowh.id="rowh";
    rowg.style.textAlign="center";
	var ledger = str.split("|"); 
	
	rowa.innerHTML='<p><input type="hidden" id="ledgerkey" value="'+ledger[6]+'"/>Invoice No</p><p>'+ledger[0]+'</p>';
	rowb.innerHTML='<p>Invoice Date</p><p>'+ledger[1]+'</p>';
	rowc.innerHTML='<p>Check No</p><p><input type="text" id="checkno" value="'+ledger[2]+'"/></p>';
	rowd.innerHTML='<p>Check Date</p><p><input type="text" id="checkdate" value="'+ledger[3]+'"/></p>';
	rowe.innerHTML='<p>Debit</p><p><input type="text" id="debit" value="'+ledger[4]+'"/></p>';
	rowf.innerHTML='<p>Credit</p><p><input type="text" id="credit" value="'+ledger[5]+'"/></p>';
	rowg.innerHTML='<button style="padding:0px 3px;" id="modify" class="btn">Modify</button> <button  style="padding:0px 3px;" id="removeid" class="btn">Delete</button>  <button  style="padding:0px 3px;" id="cancel" class="btn">Cancel</button>';
	rowh.innerHTML='<p style="text-align:center;"></p>';
	
	document.body.appendChild(mask);
	document.body.appendChild(dialog);
	dialog.appendChild(rowa);
	dialog.appendChild(rowb);
	dialog.appendChild(rowc);
	dialog.appendChild(rowd);
	dialog.appendChild(rowe);
	dialog.appendChild(rowf);
	dialog.appendChild(rowg);
	dialog.appendChild(rowh);
	
	$(document).ready(function() {
	    $("#cancel").click(function() {
	        removeDialogBox('maskid', 'dialogid');
	    });
	});
	$(function() {
		$( "#checkdate" ).datepicker();
		});
	$(document).ready(function() {
	    $("#modify").click(function() {
	    	 
		  	
		  	   $.ajax({url:"/btwdive/index.php/customer/update_ledger_table/",
		  			type:"post",
		  			 data: {
			  		ledgerkey : $('#ledgerkey').val(),
					invoiceno : $('#invoiceno').val(),
					invoicedate : $('#invoicedate').val(),
					checkno : $('#checkno').val(),
					checkdate : $('#checkdate').val(),
					debit : $('#debit').val(),
					credit : $('#credit').val()

			  			 },
		  		success:function(result){
if(result=='Y'){
	window.location.reload();
}
 }});
		  	  
	    });
	});

	$(document).ready(function() {
	    $("#removeid").click(function() {
	    	 
		  	var conf = confirm("Are You Sure");
		  	if(conf==true){
		  	   $.ajax({url:"/btwdive/index.php/customer/remove_ledger_table_row/",
		  			type:"post",
		  			 data: {
			  		ledgerkey : $('#ledgerkey').val()
					
			  			 },
		  		success:function(result){
		  			if(result=='Y'){
			  			alert("Row Deleted Successfully!");
		  				window.location.reload();
		  			}
			  		
 }});
		  	}
		  	  
	    });
	});
}
function getledgerdetails(str)
{
	
	loadAJAX().onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
		      accountDialogBox(xmlhttp.responseText);
	    }
	  };
	xmlhttp.open("POST","/btwdive/index.php/customer/get_ledger_details/"+str,true);
	xmlhttp.send();
}
function removeDialogBox(mask,dialog)
{
	 	var elemo = document.getElementById(mask);
	    var elemt = document.getElementById(dialog);
	    elemt.parentNode.removeChild(elemt);
	    elemo.parentNode.removeChild(elemo);
	    return false;
}

$(document).ready(function() {
    $("tr").click(function(event) {
        if($(this).attr('id')>0){
        getledgerdetails($(this).attr('id'));
        }
    });
});
</script>
<style type="text/css">
#maskid {
	width: 100%;
	height: 100%;
	opacity: 0.9;
	background-color: black;
	top: 0px;
	bottom: 0px;
	position: fixed;
}

#dialogid {
	margin: 0 auto;
	background-color: white;
	background-image:url(./../../../img/body_bg.jpg);
	margin-top: 2%;
	width: 40%;
	height: 300px;
	color: white;
	border: 2px solid white;
	position: absolute;
	top:20%;
	bottom: 30%;
	left: 30%;
	padding: 2%;
}
#dialogid div {
	height:40px;
	width:100%;
	float:left;
}
#dialogid div p {
	
	width:50%;
	float:left;
}



</style>
<?php  foreach ($customers as $customer):?>
<div id="account">
<div class="name"><span>Client Name : <?php echo $customer->firstname;?></span></div>
<div class="vessel"><span>Vessel Name : <?php echo $customer->vesselname;?></span><span>Location : <?php echo $customer->location;?></span><span>Slip #: <?php echo $customer->slip;?></span></div>
<div class="info"><span style="color:white;text-align: center;width:100%;font-style: italic;">To Edit/Modify a Payment, Click on the Row you want to edit</span></div>
<?php endforeach; ?>
<div class="details" style="width:100%;">
<table style="width:100%;">
<tr>
<th style="width:11%;">Invoice Date</th>
<th style="width:11%;">Invoice No</th>
<th style="width:11%;">Sent On</th>
<th style="width:11%;">Check No</th>
<th style="width:11%;">Check Date</th>
<th style="width:11%;">Debit</th>
<th style="width:11%;">Credit</th>
<th style="width:11%;">Balance</th>
<th style="width:12%;">Notes</th>
</tr></table></div>
<div class="details" style="height:400px;overflow-y:scroll;width:101.5%;;">
<table  style="width:100%;white-space: normal">
<?php 

$balance = 0; 
foreach ($invoices as $invoice):
//style="cursor:pointer;" id="'.$invoice->ledgerid.'" value="'.$invoice->ledgerid.'"
$balance +=$invoice->debit-$invoice->credit;

echo '<tr style="cursor:pointer;" id="'.$invoice->ledgerid.'" value="'.$invoice->ledgerid.'">
<td style="width:11%">'.$invoice->transaction_date.'</td>
<td style="width:11%">'.$invoice->invoice_no.'</td>
<td style="width:11%">'.$invoice->invoice_date.'</td>
<td style="width:11%">'.$invoice->checkno.'</td>
<td style="width:11%">'.$invoice->check_date.'</td>
<td style="width:11%">'.$invoice->debit.'</td>
<td style="width:11%">'.$invoice->credit.'</td>
<td style="width:11%">'.round($balance,2).'</td>
<td style="width:12%">'.$invoice->notes.'</td>
</tr>';
endforeach;?>
</table>
</div>
<div class="exit"><button onclick="self.close();" class="btn" style="margin-top:0.1px;">Exit</button></div>



</div>