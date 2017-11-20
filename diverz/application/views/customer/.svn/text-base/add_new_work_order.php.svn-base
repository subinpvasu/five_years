<script>
$(function() {
	$( "#scheduledate" ).datepicker();
	});
function displayPage(str)
{
	switch(parseInt(str))
	{
	case 1:
		document.getElementById("clean").style.display='block';
		document.getElementById("anode").style.display='none';
		document.getElementById("mech").style.display='none';
		document.getElementById("india").style.display='none';
		document.getElementById("indim").style.display='none';
		document.getElementById("indic").style.display='block';
		break;
	case 2:
		document.getElementById("anode").style.display='block';
		document.getElementById("clean").style.display='none';
		document.getElementById("mech").style.display='none';
		document.getElementById("indic").style.display='none';
		document.getElementById("indim").style.display='none';
		document.getElementById("india").style.display='block';
		
		break;
	case 3:
		document.getElementById("mech").style.display='block';
		document.getElementById("clean").style.display='none';
		document.getElementById("anode").style.display='none';
		document.getElementById("india").style.display='none';
		document.getElementById("indic").style.display='none';
		document.getElementById("indim").style.display='block';
		break;
		default:
			break;
	}
	
}
$(document).ready(function(){
    $("#newworkorder").click(function(){
    	$('#clean').contents().find('#saveCleanedFrame').click();
    	setTimeout(function(){},2000);
    	$('#anode').contents().find('#saveAnodeFrame').click();
    	setTimeout(function(){},2000);
    	$('#mech').contents().find('#saveMechFrame').click();
    	if($("#workordertotal").val()==3){alert("No Process Selected");
    	$("#workordertotal").val("0");}
    	else{alert("Work Order Created Successfully!");getout();
    	}
        });
});

function getout()
{
	document.getElementById("out").click();
}
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
<?php  foreach ($customers as $customer):?>
<div id="account" >
<a onclick="self.close();" id="clslink"></a>
<input type="hidden" id="workordertotal" value="0"/>
<div class="name"><span>Client Name : <?php echo $customer->F.'&nbsp;'.$customer->L;?></span></div>
<div class="vessel"><span>Vessel Name : <?php echo $customer->V;?></span>
<span>Location : <?php echo $customer->O;?></span><span>Slip #: <?php echo $customer->S;?></span></div>
<h4 style="float:left;width:49%;text-align: left;display:inline-block;cursor: " id="number_work">Work Order # : <?php  $d = date("m",strtotime($newdate)).date("d",strtotime($newdate)).date("y",strtotime($newdate)); echo $customer->A." - ".$d;?></h4>
<?php 
echo '<input type="hidden" name="wonumber" id="wonumber" value="'.$customer->A." - ".$d.'"/>
<input type="hidden" id="accountno" value="'.$customer->A.'"/>
<input type="hidden" id="wocustomer" value="'.$customer->P.'"/><input type="hidden" id="wovessel" value="'.$customer->PV.'"/>'; ?>
<input type="hidden" id="schedule" value="<?php echo $newdate;?>"/>
<?php 
$pkcustomer = $customer->P;
endforeach; ?>
<div class="details" style="height:auto">
<div id="toplink" style="width:100%;float:left;text-align: left;">
<a href="javascript:displayPage(1)" style="color: white; font-weight: bold; text-transform: uppercase; text-decoration: none;padding:0px 15px;">Cleaning<img width="20px" height="20px" style="position:absolute;display:block;margin-top: -10px; padding-left: 50px;border:none;" id="indic" src="<?php echo base_url();?>img/arrowup.png"></a>
<a href="javascript:displayPage(2)" style="color: white; font-weight: bold; text-transform: uppercase; text-decoration: none;padding:0px 15px;">Anodes<img width="20px" height="20px" style="position:absolute;display:none;margin-top: -10px; padding-left: 150px;border:none;" id="india" src="<?php echo base_url();?>img/arrowup.png"></a>
<a href="javascript:displayPage(3)" style="color: white; font-weight: bold; text-transform: uppercase; text-decoration: none;padding:0px 15px;">Mechanical<img width="20px" height="20px" style="position:absolute;display:none;margin-top: -10px; padding-left: 250px;border:none;" id="indim" src="<?php echo base_url();?>img/arrowup.png"></a>
</div>
<div style="width:100%;overflow:auto;">
<iframe style="width:100%;border:none;overflow:auto;display: block;float:left;height:500px;" src="<?php echo base_url();?>index.php/customer/cleaning_frame/<?php echo $pkcustomer;?>/<?php echo $oldpk;?>" id="clean">
  <p>Your browser does not support iframes.</p>
</iframe>
<iframe style="width:100%;border:none;overflow:auto;display:none;float:left;height:500px;"   src="<?php echo base_url();?>index.php/customer/anode_frame/<?php echo $pkcustomer;?>" id="anode">
  <p>Your browser does not support iframes.</p>
</iframe>
<iframe style="width:100%;border:none;overflow:auto;display:none;float:left;height:500px;"   src="<?php echo base_url();?>index.php/customer/mechanical_frame/<?php echo $pkcustomer;?>" id="mech">
  <p>Your browser does not support iframes.</p>
</iframe>
</div>
<div style="width:100%;float:left;text-align: center;">
<a href="<?php echo base_url() ?>index.php/customer/customer_workhistory/<?php echo $pkcustomer;?>" target="_blank" class="buttonlink" style="padding-top:7px;padding-bottom:7px;">Work History</a>
<button class="btn" id="newworkorder">Save</button>
<button class="btn" id="out" onclick="realClose();">Exit</button>
</div>
</div>
</div>