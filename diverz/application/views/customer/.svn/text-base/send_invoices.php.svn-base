<script>
function send_invoice(str)
{
	$("#worktoday").html('<img width="100px" height="100px" src="<?php echo base_url() ?>img/loading_gif.gif" style="position:relative;top:0px;left:0px;">');
		$.ajax({url:"/btwdive/index.php/customer/displaySendInvoice/",
			type:"post",
			 data: {
				 	one:str
				 	
			 },
			 success:function(result){
					$("#worktoday").html(result);
					document.getElementById("totalwork").innerHTML=$("#totalcount").val();
					$("#worktoday tr:even").css("background-color", "#ffffff");
					$("#worktoday tr:odd").css("background-color", "#E5E5E5");
					$("#worktoday tr:even").css("color", "#000000");
					$("#worktoday tr:odd").css("color", "#000000");
					}
	  });
	
}
$(document).ready(function(){
	$("#top :radio").click(function(){
		 var one = $(this).val();
	    send_invoice(one);
		});
});
$(document).ready(function(){
    $("#allsel").click(function(){
        if($("#totalcount").val()>0){
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
alert("No Invoice Found");exit;
        }
    });
});
function delete_invoice(str)
{
		
		$.ajax({url:"/btwdive/index.php/customer/deleteInvoice/",
			type:"post",
			 data: {
				 	one:str
				 	
			 },
			 success:function(result){
				//	alert(result);
					}
	  });
	
}
function void_invoice(str)
{
		
		$.ajax({url:"/btwdive/index.php/customer/voidInvoice/",
			type:"post",
			 data: {
				 	one:str
				 	
			 },
			 success:function(result){
			//		alert(result);
					}
	  });
	
}
$(document).ready(function(){
$("#void").click(function(){
	if($(":checkbox").is(":checked"))
	{ 

	var chkId = '';
    
    $('.printcheck:checked').each(function() {
      chkId += $(this).val() + ",";
    });
    chkId =  chkId.slice(0,-1);
    nums = chkId.split(",");
  
    for(var j=0;j<nums.length;j++)
    {
void_invoice(nums[j]);
    }
    
    alert("Invoices Voided Successfully!");
    location.reload();
	}
	else
	{
alert("No Invoice Selected!");
		}
   });
});
$(document).ready(function(){
	$("#delete").click(function(){
		if($(":checkbox").is(":checked"))
		{ 
		var chkId = '';
	    
	    $('.printcheck:checked').each(function() {
	      chkId += $(this).val() + ",";
	    });
	    chkId =  chkId.slice(0,-1);
	    nums = chkId.split(",");
	    for(var j=0;j<nums.length;j++)
	    {
	delete_invoice(nums[j]);
	    }
	        alert("Invoices Deleted Successfully!");
	        location.reload();
		}else
		{
alert("No Invoice Selected!");
		}
	   });
	  
	});

$(document).ready(function(){
	$("#send").click(function(){
		if($(":checkbox").is(":checked"))
		{ 
			var chkId = '';
		   
		    $('.printcheck:checked').each(function() {
		      chkId += $(this).val() + "^";
		    });
		    chkId =  chkId.slice(0,-1);
		    $.ajax({url:"/btwdive/index.php/customer/sendInvoicesEmail/",
				type:"post",
				 data: {
					 	address:chkId
					 	
				 },
				 success:function(result){
					 if(result.length>=3)
					 {
window.open("<?php echo base_url()?>index.php/customer/send_usmail_instead_bulk/"+result);
alert("Invoice(s) Sent.");
location.reload();
					 }
					 else
					 {
				alert("Total "+result+" Mail Sent!");
				location.reload();
						}
				 }
		  }); 
		}
		else
		{
alert("No Invoice Selected");
		}

		
		});
});
$(document).ready(function(){
	$("#view").click(function(){
		if($(":checkbox").is(":checked"))
		{ 
			var chkId = '';
		    var bsurl = $("#bsurl").val();
		    $('.printcheck:checked').each(function() {
		      chkId += $(this).val() + "^";
		    });
		    chkId =  chkId.slice(0,-1);
		    window.open(bsurl+"index.php/customer/displayAllInvoices/"+chkId);
		 }
		else
		{
alert("No Invoice Selected");
		}

		
		});
});
</script>
<input type="hidden" id="bsurl" value="<?php echo base_url()?>"/>
<img src="asdsa" width="1px" height="1px" onerror="send_invoice(5)"/>
<h2 style="width:100%;text-align: center;">List of Invoices Not Send</h2>
<div style="width:100%;float:left;text-align: center;height:40px;padding-top:10px;font-weight: bold;" id="top">
<div style="width:19%;float:left;text-align: center;"><input type="radio" name="sentstatus" value="1"  id="usmail"  />US Mail</div>
<div style="width:19%;float:left;text-align: center;"><input type="radio" name="sentstatus" value="2"  id="email"/>Email</div>
<div style="width:19%;float:left;text-align: center;"><input type="radio" name="sentstatus" value="3"  id="fax"/>Fax</div>
<div style="width:19%;float:left;text-align: center;"><input type="radio" name="sentstatus" value="4"  id="creditcard"/>Credit Card</div>
<div style="width:19%;float:left;text-align: center;"><input type="radio" name="sentstatus" value="5"  id="notsent" checked/>Invoices Not Sent</div>
</div>
<div style="width:100%;float:left;text-align: center;">
<table style="width:98%;float:left;text-align: center;padding-left:0px;">
<tr style="background-color: grey;">
<th style="width:12%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Select</th>
<th style="width:12%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Invoice Number</th>
<th style="width:12%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Invoice Date</th>
<th style="width:12%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Mode</th>
<th style="width:12%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Customer Name</th>
<th style="width:12%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Vessel Name</th>
<th style="width:12%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Amount</th>
<th style="width:12%;float:left;text-align: center;padding:0px;background-color: grey;">Net</th>
</tr>
</table>
<div style="width:101.3%;float:left;text-align: center;padding-left:0px;height:300px;overflow-y: scroll;" id="worktoday">

</div></div>
<div style="width:100%;float:left;text-align: center;height:50px;">
<button class="btn" id="allsel">Select All</button>
<button class="btn" style="width:auto" id="view">View Invoice</button>
<button class="btn" style="width:auto" id="send">Send Invoice</button>
<button class="btn" style="width:auto" id="delete">Delete Invoice</button>
<button class="btn" style="width:auto" id="void">Void Invoice</button>
<button class="btn" onclick="self.close()">Exit</button>
</div>
<div style="width:100%;float:left;text-align: left;height:50px;">
Total Work Orders Found <span id="totalwork"></span>.
</div>