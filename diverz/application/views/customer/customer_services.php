<div class="content">
	<h2>Add New Customer - Services</h2>
	<script>
	$(document).ready(function(){
		$("#job").css("text-decoration", "underline");
	});
$(document).ready(function(){
	$('#hull_clean').change(function(){
		$.ajax({url:"/btwdive/index.php/customer/show_popup",
				
			success:function(result){
		          if(result=='Y' && ($("#hull_clean").val()!='')){optionsDisplayBar($('#hull_clean').val());}
		       }});
	});
});
function updateDiscountBoxes()
{
	var discount = document.getElementById("discount").value;
	var bow	= document.getElementById("bow_list_price").value;
	var aft = document.getElementById("both_list_price").value;
	document.getElementById("bow_discount_price").value=eval(parseFloat(bow)-parseFloat(bow)*parseFloat(discount)/100);
	document.getElementById("both_discount_price").value=eval(parseFloat(aft)-parseFloat(aft)*parseFloat(discount)/100);
}
function optionsDisplayBar(str)
{
	var mask;
	var dialog;
	var summer;
	var winter;
	var yearly;
	var cancel;
	summer = document.createElement('button');
	winter = document.createElement('button');
	yearly = document.createElement('button');
	cancel = document.createElement('button');
	summer.className = 'btn';
	winter.className = 'btn';
	yearly.className = 'btn';
	cancel.className = 'btn';
	summer.id = 'summerid';
	winter.id = 'winterid';
	yearly.id = 'yearlyid';
	cancel.id = 'cancelid';
	summer.innerHTML = 'Summer Schedule';
	winter.innerHTML = 'Winter Schedule';
	yearly.innerHTML = 'Yearly Schedule';
	cancel.innerHTML = 'Cancel';
	summer.setAttribute('onclick','getDetailsFromSummerAjax("'+str+'")');
	winter.setAttribute('onclick','getDetailsFromWinterAjax("'+str+'")');
	yearly.setAttribute('onclick','getDetailsFromYearlyAjax("'+str+'")');
	cancel.setAttribute('onclick','removeDialogBox("maskid","dialogid")');
	mask = document.createElement("div");
	dialog = document.createElement("div");
	mask.id="maskid";
	dialog.id="dialogid";
	document.body.appendChild(mask);
	document.body.appendChild(dialog);
	dialog.appendChild(summer);
	dialog.appendChild(winter);
	dialog.appendChild(yearly);
	dialog.appendChild(cancel);
}
function loadAJAX()
{
	if (window.XMLHttpRequest){
	  xmlhttp=new XMLHttpRequest();
	  }	else {
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  return xmlhttp;
}
function removeDialogBox(mask,dialog)
{
	 	var elemo = document.getElementById(mask);
	    var elemt = document.getElementById(dialog);
	    elemt.parentNode.removeChild(elemt);
	    elemo.parentNode.removeChild(elemo);
	    return false;
}
function getDetailsFromYearlyAjax(str)
{
	loadAJAX().onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	   yearlyServer(xmlhttp.responseText);
	    }
	  };
	xmlhttp.open("POST","/btwdive/index.php/customer/ajaxWinterUpdate/"+str,true);
	xmlhttp.send();
}
function getDetailsFromWinterAjax(str)
{
	loadAJAX().onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
		  winterServer(xmlhttp.responseText);
	    }
	  };
	xmlhttp.open("POST","/btwdive/index.php/customer/ajaxWinterUpdate/"+str,true);
	xmlhttp.send();
}
function getDetailsFromSummerAjax(str)
{
	
		loadAJAX().onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	   summerServer(xmlhttp.responseText);
	    }
	  };
	xmlhttp.open("POST","/btwdive/index.php/customer/ajaxWinterUpdate/"+str,true);
	xmlhttp.send();

}
function summerServer(dataarrayvalues)
{
	var dataarray = dataarrayvalues.split("|");
	document.getElementById("summer").innerHTML=dataarray[0];
	document.getElementById("summer_first_service").innerHTML=dataarray[1];
	document.getElementById("summer_second_service").innerHTML=dataarray[2];
	document.getElementById("summer_first_service_price").value=dataarray[3];
	document.getElementById("summer_second_service_price").value=dataarray[4];
	if(isNaN(document.getElementById("discount").value))
		{
		document.getElementById("summer_first_discount_price").value=dataarray[3];
		document.getElementById("summer_second_discount_price").value=dataarray[4];
		}
		else
		{
			document.getElementById("summer_first_discount_price").value=eval(parseFloat(dataarray[3])-parseFloat(dataarray[3])*parseFloat(document.getElementById("discount").value)/100);
			document.getElementById("summer_second_discount_price").value=eval(parseFloat(dataarray[4])-parseFloat(dataarray[4])*parseFloat(document.getElementById("discount").value)/100);
		}
	/************************************************************************************
	document.getElementById("winter").innerHTML='';
	document.getElementById("winter_first_service").innerHTML='';
	document.getElementById("winter_second_service").innerHTML='';
	document.getElementById("winter_first_service_price").value='';
	document.getElementById("winter_second_service_price").value='';
	document.getElementById("winter_first_discount_price").value='';
	document.getElementById("winter_second_discount_price").value='';
	/*************************************************************************************/
	updateDiscountBoxes();
	removeDialogBox("maskid","dialogid");
}
function winterServer(dataarrayvalues)
{
	var dataarray = dataarrayvalues.split("|");
	document.getElementById("winter").innerHTML=dataarray[0];
	document.getElementById("winter_first_service").innerHTML=dataarray[1];
	document.getElementById("winter_second_service").innerHTML=dataarray[2];
	document.getElementById("winter_first_service_price").value=dataarray[3];
	document.getElementById("winter_second_service_price").value=dataarray[4];
	if(isNaN(document.getElementById("discount").value)){
	document.getElementById("winter_first_discount_price").value=dataarray[3];
	document.getElementById("winter_second_discount_price").value=dataarray[4];
	}
	else
	{
	document.getElementById("winter_first_discount_price").value=eval(parseFloat(dataarray[3])-parseFloat(dataarray[3])*parseFloat(document.getElementById("discount").value)/100);
	document.getElementById("winter_second_discount_price").value=eval(parseFloat(dataarray[4])-parseFloat(dataarray[4])*parseFloat(document.getElementById("discount").value)/100);
	}
	/************************************************************************************
	document.getElementById("summer").innerHTML='';
	document.getElementById("summer_first_service").innerHTML='';
	document.getElementById("summer_second_service").innerHTML='';
	document.getElementById("summer_first_service_price").value='';
	document.getElementById("summer_second_service_price").value='';
	document.getElementById("summer_first_discount_price").value='';
	document.getElementById("summer_second_discount_price").value='';
	/*************************************************************************************/
	updateDiscountBoxes();
	removeDialogBox("maskid","dialogid");
}
function yearlyServer(dataarrayvalues)
{
	var dataarray = dataarrayvalues.split("|");
	document.getElementById("summer").innerHTML=dataarray[0];
	document.getElementById("summer_first_service").innerHTML=dataarray[1];
	document.getElementById("summer_second_service").innerHTML=dataarray[2];
	document.getElementById("summer_first_service_price").value=dataarray[3];
	document.getElementById("summer_second_service_price").value=dataarray[4];
	if(isNaN(document.getElementById("discount").value)){
		document.getElementById("summer_first_discount_price").value=dataarray[3];
		document.getElementById("summer_second_discount_price").value=dataarray[4];
		}
	else
		{
		document.getElementById("summer_first_discount_price").value=eval(parseFloat(dataarray[3])-parseFloat(dataarray[3])*parseFloat(document.getElementById("discount").value)/100);
		document.getElementById("summer_second_discount_price").value=eval(parseFloat(dataarray[4])-parseFloat(dataarray[4])*parseFloat(document.getElementById("discount").value)/100);
		}
	document.getElementById("winter").innerHTML=dataarray[0];
	document.getElementById("winter_first_service").innerHTML=dataarray[1];
	document.getElementById("winter_second_service").innerHTML=dataarray[2];
	document.getElementById("winter_first_service_price").value=dataarray[3];
	document.getElementById("winter_second_service_price").value=dataarray[4];
	if(isNaN(document.getElementById("discount").value)){
		document.getElementById("winter_first_discount_price").value=dataarray[3];
		document.getElementById("winter_second_discount_price").value=dataarray[4];
		}
	else
		{
		document.getElementById("winter_first_discount_price").value=eval(parseFloat(dataarray[3])-parseFloat(dataarray[3])*parseFloat(document.getElementById("discount").value)/100);
		document.getElementById("winter_second_discount_price").value=eval(parseFloat(dataarray[4])-parseFloat(dataarray[4])*parseFloat(document.getElementById("discount").value)/100);
		}
	updateDiscountBoxes();
	removeDialogBox("maskid","dialogid");
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

	background-image: url("<?php echo base_url();?>img/body_bg.jpg");
	top:200px;
	width: auto;
	height: 100px;
	border: 2px solid white;
	position: absolute;
	bottom: 30%;
	
}

#summerid,#winterid,#yearlyid,#cancelid {
	margin: 25px 20px;
	height: 50px;
	width: 150px;
	border: 1px solid black;
	padding: 5px;
	cursor: pointer;
}
</style>
	
	<link rel="stylesheet"
		href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	
	

	<script>
	
$(function() {
$( "#datepicker" ).datepicker();
});
$(function() {
	$( "#datepickerlast" ).datepicker();
	//$( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	});


</script>
	
	
	<?php
	
	echo validation_errors ();
	echo form_open ( 'customer/customer_services/'.$this->session->userdata('customerid') );
	/**
	 * *************************************** Update Begins
	 * ***********************************************************
	 */
	
	if (isset ( $customer )) {
		
		$hullcleaning = '';
		$startdate = '';
		$discount = '0';
		$summer = '';
		$summer_first_service = '';
		$summer_first_service_price = '';
		$summer_first_discount_price = '';
		$summer_second_service = '';
		$summer_second_service_price = '';
		$summer_second_discount_price = '';
		$winter = '';
		$winter_first_service = '';
		$winter_first_service_price = '';
		$winter_first_discount_price = '';
		$winter_second_service = '';
		$winter_second_service_price = '';
		$winter_second_discount_price = '';
		$bowe = false;
		$both = false;
		$bow_discount_price = '';
		$both_discount_price = '';
		$dinghy = false;
		$dinghy_list_price = '';
		$dinghy_discount_price = '';
		$enddate = '';
		
		$summer_first = '';
		$summer_second= '';
		$winter_first= '';
		$winter_second= '';
		$bothid= '';
		$bowid= '';
		$dinghyid= '';
		foreach ( $customer as $customers ) :
			
			
			switch ($customers->SERVICE_SEASON) {
				case 'S' :
					$summer = $customers->SERVICE_TYPE;
					if ($customers->FIRST_OR_SECOND == 1) {
						$summer_first_customer = $customers->PK_CUSTOMER;
						$summer_first_vessel = $customers->PK_VESSEL;
						$summer_first = $customers->PK_VESSEL_SERVICE;
						$summer_first_service = $customers->DESCRIPTION;
						$summer_first_service_price = $customers->LIST_PRICE;
						$summer_first_discount_price = $customers->DISCOUNT_PRICE;
					}
					
					if ($customers->FIRST_OR_SECOND == 2) {
						$summer_second_customer = $customers->PK_CUSTOMER;
						$summer_second_vessel = $customers->PK_VESSEL;
						$summer_second = $customers->PK_VESSEL_SERVICE;
						$summer_second_service = $customers->DESCRIPTION;
						$summer_second_service_price = $customers->LIST_PRICE;
						$summer_second_discount_price = $customers->DISCOUNT_PRICE;
					}
					if ($hullcleaning == '') {
						$hullcleaning = $customers->SERVICE_TYPE;
					}
					$service_customer = $customers->PK_CUSTOMER;
					$service_vessel = $customers->PK_VESSEL;
					$startdate = $customers->SD;
					$discount = $customers->DISCOUNT;
					break;
				case 'W' :
					$winter = $customers->SERVICE_TYPE;
					if ($customers->FIRST_OR_SECOND == 1) {
						$winter_first_customer = $customers->PK_CUSTOMER;
						$wunter_first_vessel = $customers->PK_VESSEL;
						$winter_first  = $customers->PK_VESSEL_SERVICE;
						$winter_first_service = $customers->DESCRIPTION;
						$winter_first_service_price = $customers->LIST_PRICE;
						$winter_first_discount_price = $customers->DISCOUNT_PRICE;
					}
					
					if ($customers->FIRST_OR_SECOND == 2) {
						$winter_second_customer = $customers->PK_CUSTOMER;
						$winter_second_vessel = $customers->PK_VESSEL;
						$winter_second  = $customers->PK_VESSEL_SERVICE;
						$winter_second_service = $customers->DESCRIPTION;
						$winter_second_service_price = $customers->LIST_PRICE;
						$winter_second_discount_price = $customers->DISCOUNT_PRICE;
					}
					if ($hullcleaning == '') {
						$hullcleaning = $customers->SERVICE_TYPE;
					}
					$service_customer = $customers->PK_CUSTOMER;
					$service_vessel = $customers->PK_VESSEL;
					$startdate = $customers->SD;
					$discount = $customers->DISCOUNT;
					break;
				
				case 'N' :
					
					switch ($customers->SERVICE_TYPE) {
						case 'BOW' :
							$bow_customer = $customers->PK_CUSTOMER;
							$bow_vessel = $customers->PK_VESSEL;
							$bowid  = $customers->PK_VESSEL_SERVICE;
							$bowe = true;
							$bow_discount_price = $customers->DISCOUNT_PRICE;
							$enddate = $customers->DD;
							$service_customer = $customers->PK_CUSTOMER;
							$service_vessel = $customers->PK_VESSEL;
							break;
						case 'BOW/AFT' :
							$both_customer = $customers->PK_CUSTOMER;
							$both_vessel = $customers->PK_VESSEL;
							$bothid = $customers->PK_VESSEL_SERVICE;
							$both = true;
							$both_discount_price = $customers->DISCOUNT_PRICE;
							$enddate = $customers->DD;
							$service_customer = $customers->PK_CUSTOMER;
							$service_vessel = $customers->PK_VESSEL;
							break;
						case 'DINGHY' :
							$dinghy_customer = $customers->PK_CUSTOMER;
							$dinghy_vessel = $customers->PK_VESSEL;
							$dinghyid = $customers->PK_VESSEL_SERVICE;
							$dinghy = true;
							$dinghy_list_price = $customers->LIST_PRICE;
							$dinghy_discount_price = $customers->DISCOUNT_PRICE;
							$service_customer = $customers->PK_CUSTOMER;
							$service_vessel = $customers->PK_VESSEL;
						default :
							break;
					}
					break;
				default :
					break;
			
			}
		
		endforeach
		;
		
		// exit;
		
		
		echo form_hidden('summer_first',$summer_first);
		echo form_hidden('summer_second',$summer_second);
		echo form_hidden('winter_first',$winter_first);
		echo form_hidden('winter_second',$winter_second);
		echo form_hidden('bowid',$bowid);
		echo form_hidden('bothid',$bothid);
		echo form_hidden('dinghyid',$dinghyid);
		echo form_hidden('customerid',$this->session->userdata('customer_number'));
		echo form_hidden('vesselid',$this->session->userdata('vessel_number'));
		echo form_hidden('serviceid',$this->session->userdata('service_number'));
		
		echo form_label ( 'Select Hull Clean Type', 'hullclean_type' );
		?>

		<select name="hullclean" id="hull_clean" class="select"
		title="<?php echo $hullcleaning;?>">
		<option value=""></option>
 	 	<?php
		
		foreach ( $hullclean as $row ) {
			?>
 	 	<option value="<?php echo urlencode(rawurlencode($row->PK_HC)); ?>"><?php echo $row->SERVICE_NAME; ?></option>
 	 	<?php
			
			
		}
		?>
 	 	</select><br />

<?php
		$dat = array ('name' => 'startdate', 'id' => 'datepicker' );
		echo '<label for="first_name" style="width:9%;float:left;">Starting From</label><span style="color:#E6B522;width:11%;float:left;text-align:left;">*</span>'  . form_input ( $dat, $startdate, 'class="textbox"' ) . br ();
		echo form_label ( 'Discount', 'discount' ) . form_input ( 'discount', $discount, 'id="discount" class="textbox"' ) . br ();
		/*
		 * Summer Schedule and Winter schedule.
		 */
		
		echo heading ( 'Summer Schedule', '3' ) . br ( 3 );
		
		$txt = array ('name' => 'summer' );
		echo form_label ( 'Summer Schedule', 'summer' ) . form_textarea ( $txt, $summer, 'id="summer" class="textarea"' ) . br ();
		echo form_label ( 'First Service', 'summer_first_service' ) . form_textarea ( 'summer_first_service', $summer_first_service, 'id="summer_first_service" class="textarea"' ) . br ();
		echo form_label ( 'Second Service', 'summer_second_service' ) . form_textarea ( 'summer_second_service', $summer_second_service, 'id="summer_second_service" class="textarea"' ) . br ();
		
		echo heading ( 'List Price', '4' ) . br ();
		
		echo form_label ( 'First Service', 'summer_first_service_price' ) . form_input ( 'summer_first_service_price', $summer_first_service_price, 'id="summer_first_service_price" class="textbox"' ) . br ();
		echo form_label ( 'Second Service', 'summer_second_service_price' ) . form_input ( 'summer_second_service_price', $summer_second_service_price, 'id="summer_second_service_price" class="textbox"' ) . br ();
		
		echo heading ( 'Discount Price', '4' ) . br ();
		
		echo form_label ( 'First Service', 'summer_first_discount_price' ) . form_input ( 'summer_first_discount_price', $summer_first_discount_price, 'id="summer_first_discount_price" class="textbox"' ) . br ();
		echo form_label ( 'Second Service', 'summer_second_discount_price' ) . form_input ( 'summer_second_discount_price', $summer_second_discount_price, 'id="summer_second_discount_price" class="textbox"' ) . br ();
		
		echo heading ( 'Winter Schedule', '3' ) . br ();
		
		echo form_label ( 'Winter Schedule', 'winter' ) . form_textarea ( 'winter', $winter, 'id="winter" class="textarea"' ) . br ();
		echo form_label ( 'First Service', 'winter_first_service' ) . form_textarea ( 'winter_first_service', $winter_first_service, 'id="winter_first_service" class="textarea"' ) . br ();
		echo form_label ( 'Second Service', 'winter_second_service' ) . form_textarea ( 'winter_second_service', $winter_second_service, 'id="winter_second_service" class="textarea"' ) . br ();
		
		echo heading ( 'List Price', '4' ) . br ();
		
		echo form_label ( 'First Service', 'winter_first_service_price' ) . form_input ( 'winter_first_service_price', $winter_first_service_price, 'id="winter_first_service_price" class="textbox"' ) . br ();
		echo form_label ( 'Second Service', 'winter_second_service_price' ) . form_input ( 'winter_second_service_price', $winter_second_service_price, 'id="winter_second_service_price" class="textbox"' ) . br ();
		
		echo heading ( 'Discount Price', '4' ) . br ();
		
		echo form_label ( 'First Service', 'winter_first_discount_price' ) . form_input ( 'winter_first_discount_price', $winter_first_discount_price, 'id="winter_first_discount_price" class="textbox"' ) . br ();
		echo form_label ( 'Second Service', 'winter_second_discount_price' ) . form_input ( 'winter_second_discount_price', $winter_second_discount_price, 'id="winter_second_discount_price" class="textbox"' ) . br ();
		
		echo heading ( 'Pressure Washing', '3' ) . br ();
		
		foreach ( $bow as $val ) {
			$bows = $val->VALUE;
		}
		foreach ( $aft as $val ) {
			$afts = $val->VALUE;
		}
		
		echo form_label ( 'Bow', 'bow', array ('class' => 'boldhead' ) ) . form_checkbox ( 'bow', 'bow', $bowe ) . br ();
		echo form_label ( 'List Price', 'bow_list_price' ) . form_input ( 'bow_list_price', $bows, 'id="bow_list_price" class="textbox"' ) . br ();
		echo form_label ( 'Discount Price', 'bow_discount_price' ) . form_input ( 'bow_discount_price', $bow_discount_price, 'id="bow_discount_price" class="textbox"' ) . br ();
		
		echo form_label ( 'Both Bow/ Aft', 'both', array ('class' => 'boldhead' ) ) . form_checkbox ( 'both', 'both', $both ) . br ();
		echo form_label ( 'List Price', 'both_list_price' ) . form_input ( 'both_list_price', $afts, 'id="both_list_price" class="textbox"' ) . br ();
		echo form_label ( 'Discount Price', 'both_discount_price' ) . form_input ( 'both_discount_price', $both_discount_price, 'id="both_discount_price" class="textbox"' ) . br ();
		$dated = array ('name' => 'lastdate', 'id' => 'datepickerlast' );
		echo form_label ( 'Last Cleaned Date', 'last_cleaned_date' ) . form_input ( $dated, $enddate, ' class="textbox" ' ) . br ();
		
		echo heading ( 'Dinghy Schedule', '3' ) . br ();
		
		echo form_label ( 'Dinghy', 'dinghy', array ('class' => 'boldhead' ) ) . form_checkbox ( 'dinghy', 'dinghy', $dinghy ) . br ();
		echo form_label ( 'List Price', 'dinghy_list_price' ) . form_input ( 'dinghy_list_price', $dinghy_list_price, 'id="dinghy_list_price" class="textbox"' ) . br ();
		echo form_label ( 'Discount Price', 'dinghy_discount_price' ) . form_input ( 'dinghy_discount_price', $dinghy_discount_price, 'id="dinghy_discount_price" class="textbox"' ) . br ();
		?>
			<div style="width:100%;float:left;margin-top:15px;text-align:center;padding-left:100px;">
		 	 	<?php
			
		 	 	echo '<a href="'.base_url().'index.php/customer/customer_vessel/'.$this->session->userdata('customerid').'" class="buttonlink">Back</a> <input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Next" class="btn"/> <input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Save" class="btn"/> <a href="'.base_url().'index.php/customer/customer_session/" id="exit" class="buttonlink">Exit</a>';
		 	 	?></div>
			<?php
		//echo form_button ( 'back', 'Back', 'class="btn" style="margin-left:-90px;" disabled' ) . form_button ( 'next', 'Next', 'class="btn" style="margin-left:-90px;" ' ) . form_submit ( 'mysubmit', 'Save', ' class="btn" style="margin-left:-200px;"' ) . form_button ( 'exit', 'Exit', 'class="btn" style="margin-left:-6px;" onclick="redirectPerfect(&apos;index&apos;)"' );
		echo form_close ();
		if(($this->session->userdata('return')) && !($this->session->userdata('return_status')))
		{
		 if(($this->session->userdata('statuswb')!=$this->session->userdata('statusdb')) && $this->session->userdata('statusdb')=='INACTIVE')
	    {
	     //redirect to the work order creattion.  
	     echo '<script>window.location="'.base_url().'index.php/customer/customer_redirect/'.$this->session->userdata('customerid').'";</script>'; 
	    }
	    else
	    {
	    echo '<script>alert("Data Updated");self.close();</script>';
	    }
		}
		/**
	 * *************************************** Update Ends
	 * ***************************************************************
	 */
	} else {
		//echo $this->session->userdata('customer_number')."|".$this->session->userdata('vessel_number')."|".$this->session->userdata('anode_number')."|".$this->session->userdata('service_number');
		echo form_label ( 'Select Hull Clean Type', 'hullclean_type' );
		echo form_hidden('customerid', $this->session->userdata('customer_number'));
		echo form_hidden('vesselid', $this->session->userdata('vessel_number'));
		echo form_hidden('serviceid',$this->session->userdata('service_number'));
		?>

		<select name="hullclean" id="hull_clean" class="select">
		<option value=""></option>
 	 	<?php foreach($hullclean as $row) { 
 	 	if(urlencode(rawurlencode($row->PK_HC)) == $this->session->userdata('hullclean'))
 	 	{
 	 		?>
 	 		<option selected value="<?php echo urlencode(rawurlencode($row->PK_HC)); ?>"><?php echo $row->SERVICE_NAME; ?></option>
 	 		<?php 
 	 	}else {
 	 		?>
 	 	<option value="<?php echo urlencode(rawurlencode($row->PK_HC)); ?>"><?php echo $row->SERVICE_NAME; ?></option>
 	 	<?php } } ?>
 	 	</select><br />

<?php
		echo '<label for="first_name" style="width:9%;float:left;">Starting From</label><span style="color:#E6B522;width:11%;float:left;text-align:left;">*</span>' . form_input ( 'startdate', $this->session->userdata('startdate'), ' id="datepicker" class="textbox"' ) . br ();
		echo form_label ( 'Discount', 'discount' ) . form_input ( 'discount', '0', 'id="discount" class="textbox"' ) . br ();
		/*
		 * Summer Schedule and Winter schedule.
		 */
		echo heading ( 'Summer Schedule', '3' ) . br ( 3 );
		
		echo form_label ( 'Summer Schedule', 'summer' ) . form_textarea ( 'summer', $this->session->userdata('summer'), 'id="summer" class="textarea"' ) . br ();
		echo form_label ( 'First Service', 'summer_first_service' ) . form_textarea ( 'summer_first_service', $this->session->userdata('summer_first_service'), 'id="summer_first_service" class="textarea"' ) . br ();
		echo form_label ( 'Second Service', 'summer_second_service' ) . form_textarea ( 'summer_second_service', $this->session->userdata('summer_second_service'), 'id="summer_second_service" class="textarea"' ) . br ();
		
		echo heading ( 'List Price', '4' ) . br ();
		
		echo form_label ( 'First Service', 'summer_first_service_price' ) . form_input ( 'summer_first_service_price', $this->session->userdata('summer_first_service_price'), 'id="summer_first_service_price" class="textbox"' ) . br ();
		echo form_label ( 'Second Service', 'summer_second_service_price' ) . form_input ( 'summer_second_service_price', $this->session->userdata('summer_second_service_price'), 'id="summer_second_service_price" class="textbox"' ) . br ();
		
		echo heading ( 'Discount Price', '4' ) . br ();
		
		echo form_label ( 'First Service', 'summer_first_discount_price' ) . form_input ( 'summer_first_discount_price', $this->session->userdata('summer_first_discount_price'), 'id="summer_first_discount_price" class="textbox"' ) . br ();
		echo form_label ( 'Second Service', 'summer_second_discount_price' ) . form_input ( 'summer_second_discount_price', $this->session->userdata('summer_second_discount_price'), 'id="summer_second_discount_price" class="textbox"' ) . br ();
		
		echo heading ( 'Winter Schedule', '3' ) . br ();
		
		echo form_label ( 'Winter Schedule', 'winter' ) . form_textarea ( 'winter', $this->session->userdata('winter'), 'id="winter" class="textarea"' ) . br ();
		echo form_label ( 'First Service', 'winter_first_service' ) . form_textarea ( 'winter_first_service', $this->session->userdata('winter_first_service'), 'id="winter_first_service" class="textarea"' ) . br ();
		echo form_label ( 'Second Service', 'winter_second_service' ) . form_textarea ( 'winter_second_service', $this->session->userdata('winter_second_service'), 'id="winter_second_service"  class="textarea"' ) . br ();
		
		echo heading ( 'List Price', '4' ) . br ();
		
		echo form_label ( 'First Service', 'winter_first_service_price' ) . form_input ( 'winter_first_service_price', $this->session->userdata('winter_first_service_price'), 'id="winter_first_service_price" class="textbox"' ) . br ();
		echo form_label ( 'Second Service', 'winter_second_service_price' ) . form_input ( 'winter_second_service_price', $this->session->userdata('winter_second_service_price'), 'id="winter_second_service_price" class="textbox"' ) . br ();
		
		echo heading ( 'Discount Price', '4' ) . br ();
		
		echo form_label ( 'First Service', 'winter_first_discount_price' ) . form_input ( 'winter_first_discount_price', $this->session->userdata('winter_first_discount_price'), 'id="winter_first_discount_price" class="textbox"' ) . br ();
		echo form_label ( 'Second Service', 'winter_second_discount_price' ) . form_input ( 'winter_second_discount_price', $this->session->userdata('winter_second_discount_price'), 'id="winter_second_discount_price" class="textbox"' ) . br ();
		
		echo heading ( 'Pressure Washing', '3' ) . br ();
		
		foreach ( $bow as $val ) {
			$bows = $val->VALUE;
		}
		foreach ( $aft as $val ) {
			$afts = $val->VALUE;
		}
		$this->session->userdata('bow')=='bow'?$bowes = true:$bowes = false;
		$this->session->userdata('both')=='both'?$boths = true:$boths=false;
		$this->session->userdata('dinghy')=='dinghy'?$dinghys= true:$dinghys=false;
		echo form_label ( 'Bow', 'bow', array ('class' => 'boldhead' ) ) . form_checkbox ( 'bow', 'bow',$bowes ) . br ();
		echo form_label ( 'List Price', 'bow_list_price' ) . form_input ( 'bow_list_price', $bows, 'id="bow_list_price" class="textbox"' ) . br ();
		echo form_label ( 'Discount Price', 'bow_discount_price' ) . form_input ( 'bow_discount_price', $this->session->userdata('bow_discount_price'), 'id="bow_discount_price" class="textbox"' ) . br ();
		
		echo form_label ( 'Both Bow/ Aft', 'both', array ('class' => 'boldhead' ) ) . form_checkbox ( 'both', 'both',$boths ) . br ();
		echo form_label ( 'List Price', 'both_list_price' ) . form_input ( 'both_list_price', $afts, 'id="both_list_price" class="textbox"' ) . br ();
		echo form_label ( 'Discount Price', 'both_discount_price' ) . form_input ( 'both_discount_price', $this->session->userdata('both_discount_price'), 'id="both_discount_price" class="textbox"' ) . br ();
		echo form_label ( 'Last Cleaned Date', 'last_cleaned_date' ) . form_input ( 'lastdate', $this->session->userdata('lastdate'), ' id="datepickerlast" class="textbox"' ) . br ();
		
		echo heading ( 'Dinghy Schedule', '3' ) . br ();
		
		echo form_label ( 'Dinghy', 'dinghy', array ('class' => 'boldhead' ) ) . form_checkbox ( 'dinghy', 'dinghy',$dinghys ) . br ();
		echo form_label ( 'List Price', 'dinghy_list_price' ) . form_input ( 'dinghy_list_price', $this->session->userdata('dinghy_list_price'), 'id="dinghy_list_price" class="textbox"' ) . br ();
		echo form_label ( 'Discount Price', 'dinghy_discount_price' ) . form_input ( 'dinghy_discount_price', $this->session->userdata('dinghy_discount_price'), 'id="dinghy_discount_price" class="textbox"' ) . br ();
		?>
			<div style="width:100%;float:left;margin-top:15px;text-align:center;padding-left:100px;">
		 	 	<?php //<a href="'.base_url().'index.php/customer/customer_anodes/'.$this->session->userdata('customerid').'" class="buttonlink">Next</a>
			
		 	 	echo '<a href="'.base_url().'index.php/customer/customer_vessel/'.$this->session->userdata('customerid').'" class="buttonlink">Back</a> 
		 	 	<input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Next" class="btn"/>

		 	 	<input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Save" class="btn"/> <a href="'.base_url().'index.php/customer/customer_session/" id="exit" class="buttonlink">Exit</a>';
		 	 	?></div>
			<?php
		//echo form_button ( 'back', 'Back', 'class="btn" style="margin-left:-90px;" disabled' ) . form_button ( 'next', 'Next', 'class="btn" style="margin-left:-90px;" ' ) . form_submit ( 'mysubmit', 'Save', ' class="btn" style="margin-left:-200px;"' ) . form_button ( 'exit', 'Exit', 'class="btn" style="margin-left:-6px;" onclick="redirectPerfect(&apos;index&apos;)"' );
		echo form_close ();
	}
	?>
</div>