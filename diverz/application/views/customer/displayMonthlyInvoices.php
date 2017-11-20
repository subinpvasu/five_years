<script type="text/javascript">
$(document).ready(function(){
	$("#listinvoice tr:even").css("background-color", "#ffffff");
	$("#listinvoice tr:odd").css("background-color", "#E5E5E5");
	$("#listinvoice tr:even").css("color", "#000000");
	$("#listinvoice tr:odd").css("color", "#000000");
	
});

function fullMonth()
{
	
	var bsurl = document.getElementById("bsurl").value;
	var from = document.getElementById("from_date").value;
	var to = document.getElementById("to_date").value;
	var locate = bsurl+"index.php/customer/monthly_invoices" + '/'+ from + '/'+ to;
	document.getElementById('pdf_invoice').src = locate;

	
}
function changeLocation(monYear)
{
	//alert(monYear);
	var bsurl = document.getElementById("bsurl").value;
	var locate = bsurl+"index.php/customer/monthwise_monthly_invoices" + '/'+monYear;
    document.getElementById('pdf_invoice').src = locate;

	
}
	
function alertTheresult()
{
	//window.frames[0].document.getElementById('ElementId').style.backgroundColor="#000";
	var l = window.frames[0].document.getElementById('test').value;
	//var l = document.getElementById("test").value;
	alert(l);
}
</script>
<style>

</style>
<body onLoad="fullMonth()">
<input type="hidden" value="<?php echo $from; ?>" id="from_date">
<input type="hidden" value="<?php echo $to; ?>" id="to_date">
<!img src="sadfs" width="1px" height="1px" onerror="changeLocation(-1)"/>
<input type="hidden" id="bsurl" value="<?php echo base_url()?>"/>
<div style="width:20%;float:left;height:1050px;" id="outzoom">
<?php // print_r($invoices);?>
<table id="listinvoice" style="width:100%">
<?php 
$k="";
foreach ($balances as $balance):
if($k != $balance->month ){ 
echo '<tr onclick=changeLocation("'.$balance->month.'")  style="cursor:pointer"><td style="width:80%;">'.$balance->month.'</td></tr>';
$k = $balance->month ;
}
endforeach;

?>

</table>


</div>




<div style="width:79%;float:left;height:1050px;">
<iframe style="width:100%;border:none;overflow:auto;display: block;float:left;height:1050px;" src="" id="pdf_invoice">
  <p>Your browser does not support iframes.</p>
</iframe>
</div>