<script type="text/javascript">
$(document).ready(function(){
	$("#listinvoice tr:even").css("background-color", "#ffffff");
	$("#listinvoice tr:odd").css("background-color", "#E5E5E5");
	$("#listinvoice tr:even").css("color", "#000000");
	$("#listinvoice tr:odd").css("color", "#000000");
	
});

function changeLocation(str)
{
	if(str>0)
	{
	var bsurl = document.getElementById("bsurl").value;
	var locate = bsurl+"index.php/customer/invoice_pdf/"+str;
	document.getElementById('pdf_invoice').src = locate;

	}
	else
	{
		$("#listinvoice tr:first").click();
		/*var newstr = $("#listinvoice li:first").val();
		var bsurl = document.getElementById("bsurl").value;
		var locate = bsurl+"index.php/customer/invoice_pdf/"+newstr;
		document.getElementById('pdf_invoice').src = locate;*/
	}
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

<img src="sadfs" width="1px" height="1px" onerror="changeLocation(-1)"/>
<input type="hidden" id="bsurl" value="<?php echo base_url()?>"/>
<div style="width:20%;float:left;height:1050px;" id="outzoom">
<?php // print_r($invoices);?>
<table id="listinvoice" style="width:100%">
<?php foreach ($invoices as $invoice):

echo '<tr onclick="changeLocation('.$invoice.')" style="cursor:pointer"><td style="width:80%;">Invoice_'.$invoice.'</td></tr>';
endforeach;

?>

</table>


</div>




<div style="width:79%;float:left;height:1050px;">
<iframe style="width:100%;border:none;overflow:auto;display: block;float:left;height:1050px;" src="" id="pdf_invoice">
  <p>Your browser does not support iframes.</p>
</iframe>
</div>
<div style="width:100%;float:left;text-align: center;"><button  onclick="self.close()" class="btn">Exit</button></div>
