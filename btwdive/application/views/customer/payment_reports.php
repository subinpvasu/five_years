<!--
Project     : BTW Dive
Author      : Subin
Title      : Payment Reports
Description : Payment reports displays here
-->
<?php
ini_set('memory_limit', '-1');
?>
<script>
function getPayment(sbn)

{
	$.ajax({url:base_url+"index.php/customer/getPaymentList/",
		type:"post",
		data:{
qry:sbn
			},
success:function(result){
	//alert(result);
	var tbl = '<table id="datum" style="width:98%;text-align:left;float:left;">';
	var trl='';
	var smn = result.split("!");

	for(var i=1;i<smn.length;i++)
	{
	    var str = smn[i].split("|");

		 trl = trl+'<tr style="cursor: pointer;" onclick="listInvoice('+"'"+str[0].trim()+"'"+');"><td style="width:25%;float:left;border-right:1px solid black;"> '+str[1].trim()+'</td><td style="width:25%;float:left;border-right:1px solid black;">'+str[2]+'</td><td style="width:25%;float:left;border-right:1px solid black;">'+str[3]+'</td><td style="width:23%;float:left;;">'+str[4]+'</td></tr>';
	}
	tbl = tbl+trl+'</table>';
	$("#resultant").html(tbl);
    $("#resultant tr").css("color", "#000000");
	$("#resultant tr:even").css("background-color", "white");
	$("#resultant tr:odd").css("background-color", "white");

	}

		});
}
function listInvoice(accno)
{
	//---------
	$.ajax({url:base_url+"index.php/customer/getPaymentInvoiceList/",
		type:"post",
		data:{
qry:accno
			},
success:function(result){
	//alert(result);
	var tbl2 = '<table id="datum2" style="width:98%;text-align:left;float:left;">';
	var trl='';
	var smn = result.split("!");
var bal=0;
	for(var i=1;i<smn.length;i++)
	{
	    var str = smn[i].split("|");
         bal=parseFloat(bal)+(parseFloat(str[4])-parseFloat(str[5]));
         bal = parseFloat(bal);
         if(bal=='-4.973799150320701e-14'){bal=0;}


	    //index.php/customer/credit_payment_details/
		 trl = trl+'<tr style="cursor: pointer;" onclick="document.getElementById(&quot;'+str[0].trim()+'&quot;).click()">\n\
              <td style="width:15%;float:left;border-right:1px solid black;"> '+str[0].trim()+'</td><td style="width:15%;float:left;border-right:1px solid black;">'+str[1]+'</td><td style="width:15%;float:left;border-right:1px solid black;">'+str[2]+' '+str[3]+'</td><td style="width:15%;float:left;border-right:1px solid black;">'+str[4]+'</td><td style="width:20%;float:left;border-right:1px solid black;">'+str[5]+'</td><td style="width:18%;float:left;">'+bal.toFixed(2)+'</td></tr>'+'<a target="_blank" href="<?php echo base_url(); ?>index.php/customer/payment_details/'+str[0].trim()+'/'+accno+'/" id="'+str[0].trim()+'"></a>';
	}
	tbl2 = tbl2+trl+'</table>';
	$("#resultant2").html(tbl2);
	$("#resultant2 tr").css("color", "#000000");
	$("#resultant2 tr:even").css("background-color", "white");
	$("#resultant2 tr:odd").css("background-color", "white");
	//alert(bal);
	$("#totalbalance").val(bal.toFixed(2));
}


		});





   // document.getElementById('invoice_result').innerHTML=name;
}
</script>
<style>
body
{
    counter-reset: Serial;
}


tr td:first-child:before
{

}
</style>
<body onLoad="document.getElementById('cname').focus();">
<h2 style="width:100%;text-align: center;">Form To Search Payment</h2>
<div style="float:left;">
<b style="display:block;">Enter Customer Name</b>
<input type="text" class="textbox" onKeyup="getPayment(this.value)"  id="cname">
</div>

<div style="width:100%;float:left;">
<table style="width:98%;float:left;text-align: center;padding-left:0px;">
<tr style="background-color: grey;">
<th style="width:25%;float:left;text-align: center;border-right:1px solid white;background-color: grey;">Account NO</th>
<th style="width:25%;float:left;text-align: center;border-right:1px solid white;background-color: grey;">First Name\Last Name</th>
<th style="width:25%;float:left;text-align: center;border-right:1px solid white;background-color: grey;">Vessel Name</th>
<th style="width:23%;float:left;text-align: center;background-color: grey;">Location</th>
</tr>
</table>

<div style="width: 101.3%;background-color:black;color:white; float: left;padding-left: 0px; height: 200px; overflow-y: scroll" id="resultant"></div>
</div>

<div style="width:100%;float:left;">
<h3 style="width:100%;text-align: left;">List Of Invoices</h3>
<table style="width:98%;float:left;text-align: center;padding-left:0px;">
<tr style="background-color: grey;">
<th style="width:15%;float:left;text-align: center;border-right:1px solid white;background-color: grey;">Invoice No</th>
<th style="width:15%;float:left;text-align: center;border-right:1px solid white;background-color: grey;">Date</th>
<th style="width:15%;float:left;text-align: center;border-right:1px solid white;background-color: grey;">Customer Name</th>
<th style="width:15%;float:left;text-align: center;border-right:1px solid white;background-color: grey;">Invoiced</th>
<th style="width:20%;float:left;text-align: center;border-right:1px solid white;background-color: grey;">Received</th>
<th style="width:18%;float:left;text-align: center;background-color: grey;">Balance</th>
</tr>
</table>

<div style="width: 101.3%;background-color:black;color:white; float: left;padding-left: 0px; height: 200px; overflow-y: scroll" id="resultant2"></div>
</div>

<div style="width:100%;">
    <table style="width:100%;">
        <tr><td width="50%">&nbsp;</td>
            <td width="30%">Total Balance  <input type="text" style="width: 150px" class="textbox"  id="totalbalance"></td>
            <td width="20%"><button class="btn" onclick="self.close()">EXIT</button></td>
            </tr></table>
<br>
</div>
</body>


