<!--
Project     : BTW Dive
Author      : Subin
Title      : Customer Anodes
Description : Customer adds anodes to the profile using this page.
-->
<div class="content">
	<h2>Add New Customer - Anodes</h2>
	<script
		src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="<?php echo base_url();?>jquery/calender.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>css/style.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>css/calender.css" />

	<script>
	$(document).ready(function(){
		$("#stuff").css("text-decoration", "underline");
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
function onscreenSearch(str)
{
	document.getElementById("screen").style.display='block';
	if(str.length<=0){str = 'ZINC';}
	loadAJAX().onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
		      searchDistribution(xmlhttp.responseText);
	    }
	  };
	xmlhttp.open("POST",base_url+"index.php/customer/screenSearchResults/"+str,true);
	xmlhttp.send();

}
function searchDistribution(str)
{
	var line = "";
	var first = str.split("!");
	for(var i=0;i<first.length;i++)
	{
	var second = first[i].split("|");
	line = line + '<span id="" style="width:700px;height:auto;display:block;"><input id="'+second[0]+'" onclick="showDetailBox(this.id,this.value)" type="checkbox" name[]="anodes_added" style="width:10px;" value="'+second[0]+'"/>'+second[1]+'</span>';

	}
	document.getElementById("screen").innerHTML=line;

	//alert("good"+str);
}
function showDetailBox(str)
{
	if(document.getElementById(str).checked==true)
	{
		loadAJAX().onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
			    anodeDistribution(xmlhttp.responseText);
		    }
		  };
		xmlhttp.open("POST",base_url+"index.php/customer/getAnodeDetails/"+str,true);
		xmlhttp.send();
	}
}
function anodeDistribution(str)
{

	var anode = str.split("|");
	str = encodeURI(str);

try
{
var a = anode[1];
var b = anode[2];
//alert(a+"|"+b);
}
catch(e){}


	var dis   = document.getElementById("anode_discount").value;
	var disprice = eval(parseFloat(anode[3])-parseFloat(anode[3])*parseFloat(dis)/100);
	if(!isNaN(dis)){
	var boxTable = '<table><tr><td colspan="3" style="text-align:center;">Add Anode Types to Vessel</td></tr><tr><td>Anode Type</td><td colspan="2">         <input id="anodetype" type="text" class="textbox" value=""/></td></tr>		<tr><td>Description</td><td colspan="2">        <input id="description" type="text" class="textbox" value=""/></td></tr>		<tr><td>Schedule Change</td><td colspan="2">    <input id="schedule" type="text" class="textbox" value="'+anode[4]+' Months"/></td></tr>		<tr><td>No of Anodes</td><td colspan="2">       <input id="numanodes" type="text" class="textbox" value="1"/></td></tr>		<tr><td>List Price</td><td colspan="2">         <input id="listprice" type="text" class="textbox" value="'+anode[3]+'"/></td></tr>		<tr><td>Discount %</td><td colspan="2">         <input id="discount" type="text" class="textbox" value="'+dis+'" onchange="updatePriceDiscount(this.value)" readonly="readonly"  onkeyup="updatePriceDiscount(this.value)"/></td></tr>		<tr><td>Discount Price</td><td colspan="2">     <input id="disprice" type="text" class="textbox" value="'+eval((disprice).toFixed(2))+'"/></td></tr>		<tr><td>Anode Last Replaced</td><td colspan="2">         <input  type="text" class="textbox" id="datepickeranode"  name="anodelast" /></td></tr>	</table>';



	boxTable = boxTable + '<button class="btn" id="add" onclick="addAnode(&quot;'+str+'&quot;,'+anode[0]+')">Add</button><button class="btn"  onclick="donotaddAnode('+anode[0]+')">Do Not Add</button>';

	var anDialog;
	var anMask;
	anMask = document.createElement("div");
	anDialog = document.createElement("div");
	anMask.id="maskid";
	anDialog.id="dialogid";
	document.body.appendChild(anMask);
	document.body.appendChild(anDialog);
	anDialog.innerHTML=boxTable;

	document.getElementById("anodetype").value=a;
	document.getElementById("description").value=b;
	$(function() {
		$( "#datepickeranode" ).datepicker();
		});


}
}
function updatePriceDiscount(discount)
{
	if(isNaN(discount))
	{
try{
	exit;
}
catch(e)
{

}
	}
	else
	{
var prc = document.getElementById("listprice").value;
var dcp = parseFloat(prc)-(parseFloat(discount)*parseFloat(prc)/100);
document.getElementById("disprice").value=dcp;
	}
}
function donotaddAnode(anode)
{
	removeDialogBox("maskid","dialogid");
	document.getElementById(anode).checked=false;
	document.getElementById("screen").style.display='none';
}
function removeDialogBox(mask,dialog)
{
	 	var elemo = document.getElementById(mask);
	    var elemt = document.getElementById(dialog);
	    elemt.parentNode.removeChild(elemt);
	    elemo.parentNode.removeChild(elemo);
	    return false;
}
function addAnode(anode,anodeid)
{
	anode = decodeURI(anode);
	var dis   = document.getElementById("anode_discount").value;
	var last = document.getElementById("addedanodes").innerHTML;
	try{	var anodedate = document.getElementById("datepickeranode").value; }catch(e){}
	var ftype=document.getElementById("anodetype").value;
	var	fdescription=document.getElementById("description").value;
	var fdiscount=document.getElementById("discount").value;
	var fdiscount_price=document.getElementById("disprice").value;
	var flist_price=document.getElementById("listprice").value;
	var fschedule=document.getElementById("schedule").value;
	var total_anode = document.getElementById("numanodes").value;
	last = last.replace("</tbody></table>","");
	var arraydata = anode.split("|");
	var disprice = eval(parseFloat(arraydata[3])-parseFloat(arraydata[3])*parseFloat(dis)/100);
	var row = '<tr ondblclick="editAnode(&quot;'+anodeid+'&quot;)"><td><input type="checkbox" name="listed_anodes[]" value="'+anodeid+'|'+anodedate+'"  checked style="width:10px;"/>'+arraydata[1]+'</td><td>'+arraydata[3]+'</td><td>'+eval((disprice).toFixed(2))+'</td></tr>';
	last = last + row + '</table>';



	$(document).ready(function(){

		    var newanodeid = $("#vessel_anode_id").val();


		   $.ajax({url:base_url+"index.php/customer/updateAnodeTable/",
				type:"post",
				 data: {
					 customer:$("#ses_customer").val(),
					 vessel:$("#ses_vessel").val(),
					 anodes : newanodeid,
					 type:ftype,
					 description:fdescription,
					 discount:fdiscount,
					 discount_price:fdiscount_price,
					 list_price:flist_price,
					 schedule:fschedule,
					 lastdate:anodedate,
					 total:total_anode
				 },


			success:function(result){
				$("#vessel_anode_id").val(result);
				window.location.reload();
				}

		  });

		});


	document.getElementById("addedanodes").innerHTML=last;
	removeDialogBox("maskid","dialogid");
	document.getElementById(anodeid).checked=false;
	document.getElementById("screen").style.display='none';
}
function editAnodeFromVessel(str)
{
	loadAJAX().onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
		  editAddedAnode(xmlhttp.responseText);
	    }
	  };
	xmlhttp.open("POST",base_url+"index.php/customer/getAnodeDetailsFromVessel/"+str,true);
	xmlhttp.send();

}
function editAnode(str)
{

		loadAJAX().onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
			  editAddedAnode(xmlhttp.responseText);
		    }
		  };
		xmlhttp.open("POST",base_url+"index.php/customer/getAnodeDetails/"+str,true);
		xmlhttp.send();


}
function editAddedAnode(str)
{

	var anode = str.split("|");
	try
	{
var a = anode[1];
var b = anode[2];
	}
	catch(e){}
	if(anode.length>5)
	{
		var boxTable = '<table ><tr><td colspan="3" style="text-align:center;">Add Anode Types to Vessel</td></tr>			<tr><td>Anode Type</td><td colspan="2"><input type="text" class="textbox" id="anodetype" value=""/></td></tr>			<tr><td>Description</td><td colspan="2"><input type="text" class="textbox" id="description" value=""/></td></tr>			<tr><td>Schedule Change</td><td colspan="2"><input type="text" class="textbox" id="schedule" value="'+anode[4]+' Months"/></td></tr>			<tr><td>No of Anodes</td><td colspan="2"><input id="anodenum" type="text" class="textbox" id="" value="1"/></td></tr>			<tr><td>List Price</td><td colspan="2"><input type="text" class="textbox" id="listprice" value="'+anode[3]+'"/></td></tr>			<tr><td>Discount %</td><td colspan="2"><input type="text" class="textbox" id="discount" value="'+anode[6]+'" disabled/></td></tr>			<tr><td>Discount Price</td><td colspan="2"><input type="text" class="textbox" id="disprice" value="'+anode[5]+'"/></td></tr>			<tr><td>Anode Last</td><td colspan="2"><input type="text" class="textbox" id="datepickeranode" value="'+anode[7]+'" /></td></tr>	</table><button class="btn"  onclick="modifyAnode('+anode[0]+')">Modify</button><button class="btn"  onclick="donotaddAnode('+anode[0]+')">Cancel</button>';

	}
	else
	{
	var dis   = document.getElementById("anode_discount").value;
	var disprice = eval(parseFloat(anode[3])-parseFloat(anode[3])*parseFloat(dis)/100);
	var boxTable = '<table><tr><td colspan="3" style="text-align:center;">Add Anode Types to Vessel</td></tr>		<tr><td>Anode Type</td><td colspan="2"><input type="text" class="textbox" id="anodetype" value=""/></td></tr>		<tr><td>Description</td><td colspan="2"><input type="text" class="textbox" id="description" value=""/></td></tr>		<tr><td>Schedule Change</td><td colspan="2"><input type="text" class="textbox" id="schedule" value="'+anode[4]+' Months"/> </td></tr>		<tr><td>No of Anodes</td><td colspan="2"><input type="text" id="anodenum"  class="textbox" value="1"/></td></tr>		<tr><td>List Price</td><td colspan="2"><input type="text" class="textbox" id="listprice" value="'+anode[3]+'"/></td></tr>		<tr><td>Discount %</td><td colspan="2"><input type="text" class="textbox" value="'+dis+'" id="discount" disabled/></td></tr>		<tr><td>Discount Price</td><td colspan="2"><input type="text" class="textbox" id="disprice" value="'+eval((disprice).toFixed(2))+'"/></td></tr>		<tr><td>Anode Last</td><td colspan="2"><input type="text" class="textbox" id="datepickeranode" /></td></tr>	</table><button onclick="modifyAnode('+anode[0]+')" class="btn" >Modify</button><button class="btn"  onclick="donotaddAnode('+anode[0]+')">Cancel</button>';


	}
/*

	var anode = str.split("|");
	if(anode.length>5)
	{
		var boxTable = '<table><tr><td colspan="3" style="text-align:center;">Add Anode Types to Vessel</td></tr><tr><td>Anode Type</td><td colspan="2"><input type="text" id="anodename" value="'+anode[1]+'" /></td></tr><tr><td>Description</td><td colspan="2"><textarea id="anodedescription">'+anode[2]+'</textarea></td></tr><tr><td>Schedule Change</td><td><input type="text" id="anodeschedule" value="'+anode[4]+' Months" /></td><td></td></tr><tr><td>No of Anodes</td><td>1</td><td></td></tr><tr><td>List Price</td><td><input type="text" id="anodeprice" value="'+anode[3]+'" /></td><td></td></tr><tr><td>Discount %</td><td><input type="text" id="discount" value="'+anode[6]+'" /></td><td></td></tr><tr><td>Discount Price</td><td><input type="text" id="discountprice" value="'+anode[5]+'" /></td><td></td></tr><tr><td>Anode Last</td><td><input type="text" id="datepickeranode" value="'+anode[7]+'" /></td><td></td></tr>	</table><button onclick="modifyAnode()">Modify</button><button onclick="donotaddAnode('+anode[0]+')">Cancel</button>';


	}
	else
	{
	var dis   = document.getElementById("anode_discount").value;
	var disprice = eval(parseFloat(anode[3])-parseFloat(anode[3])*parseFloat(dis)/100);
	var boxTable = '<table><tr><td colspan="3" style="text-align:center;">Add Anode Types to Vessel</td></tr><tr><td>Anode Type</td><td colspan="2"><input type="text" id="anodename" value="'+anode[1]+'" /></td></tr><tr><td>Description</td><td colspan="2"><textarea id="anodedescription">'+anode[2]+'</textarea></td></tr><tr><td>Schedule Change</td><td><input type="text" id="anodeschedule" value="'+anode[4]+' Months" /></td><td></td></tr><tr><td>No of Anodes</td><td>1</td><td></td></tr><tr><td>List Price</td><td><input type="text" id="anodeprice" value="'+anode[3]+'" /></td><td></td></tr><tr><td>Discount %</td><td><input type="text" id="discount" value="'+dis+'" /></td><td></td></tr><tr><td>Discount Price</td><td><input type="text" id="discountprice" value="'+eval((disprice).toFixed(2))+'" /></td><td></td></tr><tr><td>Anode Last</td><td><input type="text" id="datepickeranode" /></td><td></td></tr>	</table><button onclick="modifyAnode()">Modify</button><button onclick="donotaddAnode('+anode[0]+')">Cancel</button>';


	}
	*/

	var anDialog;
	var anMask;
	anMask = document.createElement("div");
	anDialog = document.createElement("div");
	anMask.id="maskid";
	anDialog.id="dialogid";
	document.body.appendChild(anMask);
	document.body.appendChild(anDialog);
	anDialog.innerHTML=boxTable;

	document.getElementById("anodetype").value=a;
	document.getElementById("description").value=b;

	$(function() {
		$( "#datepickeranode" ).datepicker();
		});
}
function modifyAnode(str)
{
	try
	{
		var date = document.getElementById("datepickeranode").value;
		}catch(e){}


	var   ftype=document.getElementById("anodetype").value;
	var	 fdescription=document.getElementById("description").value;
		var fdiscount=document.getElementById("discount").value;
		  var fdiscount_price=document.getElementById("disprice").value;
		 var flist_price=document.getElementById("listprice").value;
		 var fschedule=document.getElementById("schedule").value;
		 var totalanode = document.getElementById("anodenum").value;


	 $.ajax({url:base_url+"index.php/customer/updateAnodeTableEdited/",
			type:"post",
			 data: {

				 customer:$("#ses_customer").val(),
				 vessel:$("#ses_vessel").val(),
				 type:ftype,
				 description:fdescription,
				 discount:fdiscount,
				 discount_price:fdiscount_price,
				 list_price:flist_price,
				 schedule:fschedule,
				 anodes : str,
				 lastdate:date,
				 total:totalanode

			 },


		success:function(result){
			if(totalanode>1){
			$("#vessel_anode_id").val(result);
			window.location.reload();
			}else
		if(result=='Y'){	alert("Updated Successfully!");window.location.reload();}

			}
	 });

//}
	/*
anodename
	anodedescription
	anodeschedule
	anodenumber
	anodeprice


	*/
	//alert("Good"+date+"---"+str);//it's working,then update db.
}

function dialogAnodeBox(data)
{
	var mask;
	var dialog;
	mask = document.createElement("div");
	dialog = document.createElement("div");
	mask.id = "maskid";
	dialog.id = "dialogid";
	dialog.innerHTML=data;
	document.body.appendChild(mask);
	document.body.appendChild(dialog);
}


function validatefields(){
    var valid = false; //set to true if all inputs validated
    $("").each(function(index) {
        //some validation
        //if valid:
        valid = true;
     });
     return valid; //if this returns false, the script will stop, else it will submit
 }
$(document).ready(function(){
	  $("tr").click(function(){
	   var anode = $(this).attr('id');
	   if(isNaN(anode)){return false;}else{
	   $.ajax({url:base_url+"index.php/customer/getPrimaryKeyAnode/",
			type:"post",
			 data: {anodes : anode},
		success:function(result){
			alert(result); }});
	   }
	  });
	});



function removeAnodeAdded(str)
{
	var r = confirm("Are you sure want to remove this anode?");
	if(r){
	loadAJAX().onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
		     // searchDistribution(xmlhttp.responseText);
		     if(xmlhttp.responseText=='Y'){
			     alert("Anode Removed.");
		     window.location.reload();
		     }
	    }
	  };
	xmlhttp.open("POST",base_url+"index.php/customer/remove_anode_added/"+str,true);
	xmlhttp.send();
	}
}

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
	text-align: center;
	background-image: url("<?php echo base_url();?>img/body_bg.jpg");
	width: auto;
	height: 320px;
	color: white;
	border: 2px solid white;
	position: absolute;
	bottom: 30%;
	left: 30%;
}

#dialogid table {
	background-image: url("<?php echo base_url();?>img/body_bg.jpg");
	color: white;
	border-collapse: collapse;
	border: none;
}

table {
	white-space: nowrap;
	color: white;
	width: 800px;
}

table th {
	border: 1px solid black;
	width: auto;
	white-space: nowrap;
}

#screen {
	background-image: url("<?php echo base_url();?>img/body_bg.jpg");
	color: white;
}

#screen span {
	color: white;
}

#addedanodes table {
	background-image: url("<?php echo base_url();?>img/body_bg.jpg");
	color: white;
}

#addedanodes table th {
	background-color: grey;
}
</style>
	<input type="hidden" id="ses_customer" value="<?php echo $ses_customer;?>"/>
	<input type="hidden" id="ses_vessel" value="<?php echo $ses_vessel;?>"/>
<?php
echo validation_errors();
echo form_open('customer/customer_anodes/' . $this->session->userdata('customerid'));

/*
 * enter the desired discount rate for the anodes and then search and add to the
 * list. '.getPrimaryKeyAnodes($customers->ANODE_TYPE,
 * $customers->DESCRIPTION).'
 */

if (isset($customer)) {

    $discount = 0.00;
    $row = '';
    $type_description = '';
    foreach ($customer as $customers) :
        $discount = $customers->DISCOUNT;
        if ($customers->ANODE_TYPE == '') {
            $type_description = $customers->DESCRIPTION;
        } else {
            $type_description = $customers->ANODE_TYPE;
        }
        $row = $row . '<tr style="cursor:pointer;" ><td><input type="checkbox" name="listed_anodes[]" value="' . $customers->PK_VESSEL_ANODE . '"  checked style="width:10px;" onclick="removeAnodeAdded(' . $customers->PK_VESSEL_ANODE . ')"/></td><td onclick="editAnodeFromVessel(' . $customers->PK_VESSEL_ANODE . ')">' . $type_description . '</td><td onclick="editAnodeFromVessel(' . $customers->PK_VESSEL_ANODE . ')">' . $customers->LIST_PRICE . '</td><td onclick="editAnodeFromVessel(' . $customers->PK_VESSEL_ANODE . ')">' . $customers->DISCOUNT_PRICE . '</td></tr>';
    endforeach
    ;
    echo '<input type="hidden" name="vessel_anode_id" id="vessel_anode_id" value="' . $this->session->userdata('anode_number') . '"/>';
    echo form_label('Discount %', 'discount') . form_input('discount', $discount, 'id="anode_discount" class="textbox"') . br();
    echo form_label('Search Anodes to be Added', 'add_anodes') . form_input('anodes', '', 'id="anodes" class="textbox" onkeyup="onscreenSearch(this.value)" onfocus="onscreenSearch(this.value)"') . br();
    echo '<div id="screen" style="border:1px solid ;width:717px;right:1px;height:200px;overflow:auto;color:white;position:absolute;top:20px;display:none;"></div>';
    echo '<div id="addedanodes" style="width:850px;height:400px;overflow:auto;margin-top:50px;">
	<table >
	<tr><th></th><th>Services</th><th>List Price</th><th>Discount Price</th></tr>
	' . $row . '
	</table>

	</div>';
    ?>
		<div
		style="width: 100%; float: left; margin-top: 15px; text-align: center; padding-left: 100px;">
	 	 	<?php

    echo '<a href="' . base_url() . 'index.php/customer/customer_services/' . $this->session->userdata('customerid') . '" class="buttonlink">Back</a> <a href="' . base_url() . 'index.php/customer/customer_misc/' . $this->session->userdata('customerid') . '" class="buttonlink">Next</a> <input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Save" class="btn"/> <a href="' . base_url() . 'index.php/customer/customer_session/" id="exit" class="buttonlink">Exit</a>';
    ?></div>
		<?php
    // echo form_button ( 'back', 'Back', 'class="btn" style="margin-left:-90px;"
    // disabled' ) . form_button ( 'next', 'Next', 'class="btn"
    // style="margin-left:-90px;" ' ) . form_submit ( 'mysubmit', 'Save', '
    // class="btn" style="margin-left:-200px;"' ) . form_button ( 'exit', 'Exit',
    // 'class="btn" style="margin-left:-6px;"
    // onclick="redirectPerfect(&apos;index&apos;)"' );
    echo form_close();

    if (($this->session->userdata('return')) && ! ($this->session->userdata('return_status'))) {
        if (($this->session->userdata('statuswb')=='ACTIVE')  && $this->session->userdata('open')) {
            // redirect to the work order creattion.
            echo '<script>alert("Data Updated");window.location="' . base_url() . 'index.php/customer/customer_redirect/' . $this->session->userdata('customerid') . '";</script>';
        } else {
            echo '<script>alert("Data Updated");document.getElementById("exit").click();</script>';
        }
    }
} else
    if (isset($session_customer)) {
        $discount = 0.00;
        $row = '';
        $type_description = '';
        foreach ($session_customer as $customers) :
            $discount = $customers->DISCOUNT;
            if ($customers->ANODE_TYPE == '') {
                $type_description = $customers->DESCRIPTION;
            } else {
                $type_description = $customers->ANODE_TYPE;
            }
            $row = $row . '<tr style="cursor:pointer;" ><td><input type="checkbox" name="listed_anodes[]" value="' . $customers->PK_VESSEL_ANODE . '"  checked style="width:10px;" onclick="removeAnodeAdded(' . $customers->PK_VESSEL_ANODE . ')"/></td><td onclick="editAnodeFromVessel(' . $customers->PK_VESSEL_ANODE . ')">' . $type_description . '</td><td onclick="editAnodeFromVessel(' . $customers->PK_VESSEL_ANODE . ')">' . $customers->LIST_PRICE . '</td><td onclick="editAnodeFromVessel(' . $customers->PK_VESSEL_ANODE . ')">' . $customers->DISCOUNT_PRICE . '</td></tr>';
        endforeach
        ;
        // echo
        // $this->session->userdata('customer_number')."|".$this->session->userdata('vessel_number')."|".$this->session->userdata('anode_number');
        $anode_number = $this->session->userdata('anode_number');
        echo '<input type="hidden" name="vessel_anode_id" id="vessel_anode_id" value="' . $anode_number . '"/>';
        echo form_label('Discount %', 'discount') . form_input('discount', $discount, 'id="anode_discount" class="textbox"') . br();
        echo form_label('Search Anodes to be Added', 'add_anodes') . form_input('anodes', '', 'id="anodes" class="textbox" onkeyup="onscreenSearch(this.value)" onfocus="onscreenSearch(this.value)"') . br();
        echo '<div id="screen" style="border:1px solid ;width:717px;right:1px;height:200px;overflow:auto;background-color:white;color:black;position:absolute;top:20px;display:none;"></div>';
        echo '<div id="addedanodes" style="width:850px;height:400px;overflow:auto;margin-top:50px;">
		<table >
		<tr><th></th><th>Services</th><th>List Price</th><th>Discount Price</th></tr>
		' . $row . '
		</table>

		</div>';
        ?>
				<div
		style="width: 100%; float: left; margin-top: 15px; text-align: center; padding-left: 100px;">
			 	 	<?php

        echo '<a href="' . base_url() . 'index.php/customer/customer_services/' . $this->session->userdata('customerid') . '" class="buttonlink">Back</a> <input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Next" class="btn"/> <input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Save" class="btn"/> <a href="' . base_url() . 'index.php/customer/customer_session/" id="exit" class="buttonlink">Exit</a>';
        ?></div>
				<?php
        // echo form_button ( 'back', 'Back', 'class="btn" style="margin-left:-90px;"
        // disabled' ) . form_button ( 'next', 'Next', 'class="btn"
        // style="margin-left:-90px;" ' ) . form_submit ( 'mysubmit', 'Save', '
        // class="btn" style="margin-left:-200px;"' ) . form_button ( 'exit', 'Exit',
        // 'class="btn" style="margin-left:-6px;"
        // onclick="redirectPerfect(&apos;index&apos;)"' );
        echo form_close();
    }

    else {

        // echo
        // "--".$this->session->userdata('customer_number')."|".$this->session->userdata('vessel_number')."|".$this->session->userdata('anode_number');
        $anode_number = $this->session->userdata('anode_number');
        echo '<input type="hidden" name="vessel_anode_id" id="vessel_anode_id" value="' . $anode_number . '"/>';
        echo form_label('Discount %', 'discount') . form_input('discount', '0', 'id="anode_discount" class="textbox"') . br();
        echo form_label('Search Anodes to be Added', 'add_anodes') . form_input('anodes', '', 'id="anodes" class="textbox" onkeyup="onscreenSearch(this.value)" onfocus="onscreenSearch(this.value)"') . br();
        echo '<div id="screen" style="border:1px solid ;width:700px;right:1px;height:200px;overflow:auto;background-color:white;color:black;position:absolute;top:20px;display:none;"></div>';
        echo '<div id="addedanodes" style="width:auto;height:350px;overflow:auto;margin-top:50px;">
<table >
<tr><th>Services</th><th>List Price</th><th>Discount Price</th></tr>
<tr><td></td><td></td><td></td></tr>
</table>

</div>';
        // '.$this->session->userdata('customer_number')."|".$this->session->userdata('vessel_number')."|".$this->session->userdata('anode_number').'
        ?>
		<div
		style="width: 100%; float: left; margin-top: 15px; text-align: center; padding-left: 100px;">
	 	 	<?php
        // <a
        // href="'.base_url().'index.php/customer/customer_misc/'.$this->session->userdata('customerid').'"
        // class="buttonlink">Next</a>

        echo '<a href="' . base_url() . 'index.php/customer/customer_services/' . $this->session->userdata('customerid') . '" class="buttonlink">Back</a>
	 	 	 <input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Next" class="btn"/>

	 	 	<input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Save" class="btn"/> <a href="' . base_url() . 'index.php/customer/customer_session/" id="exit" class="buttonlink">Exit</a>';
        ?></div>
		<?php
        // echo form_button ( 'back', 'Back', 'class="btn" style="margin-left:-90px;"
        // disabled' ) . form_button ( 'next', 'Next', 'class="btn"
        // style="margin-left:-90px;" ' ) . form_submit ( 'mysubmit', 'Save', '
        // class="btn" style="margin-left:-200px;"' ) . form_button ( 'exit', 'Exit',
        // 'class="btn" style="margin-left:-6px;"
        // onclick="redirectPerfect(&apos;index&apos;)"' );
        echo form_close();
    }
/*
 * search anodes available for the discount rate search by
 */

?>
 	  </div>