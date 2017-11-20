<!--
Project     : BTW Dive
Author      : Subin
Title      : Customer Vessel
Description : Vessel details are added to the profilefrom here.
-->
<script>
$(document).ready(function(){
	$("#boat").css("text-decoration", "underline");
});
</script>
<div class="content">
	<h2>Add New Customer - Vessels</h2>
<?php
echo validation_errors ();
echo form_open ( 'customer/customer_vessel/'.$this->session->userdata('customerid') );
/**
 * ***************************************** Update begins
 * ***********************************
 */
if (isset ( $customer )) {
	foreach ( $customer as $customers ) :
		echo '<label for="first_name" style="width:6%;float:left;">Location</label><span style="color:#E6B522;width:14%;float:left;text-align:left;">*</span>';
		?><select name="location" class="select">
		<option value="">Select Location</option>
	 	<?php
		
		foreach ( $options as $row ) {
			if (strtoupper ( $customers->LOCATION ) == $row->OPTIONS) {
				?>
	 	<option selected value="<?php echo $row->OPTIONS; ?>"><?php echo $row->OPTIONS; ?></option>
	 	<?php

			} else {
				?>
	 	<option value="<?php echo $row->OPTIONS; ?>"><?php echo $row->OPTIONS; ?></option>
	 	<?php }} ?>
	 	</select><br /><?php
		echo form_label ( 'Vessel Type', 'vessel_type' );
		?><select name="type" class="select">
		<option>Select Type</option>
	 	<?php

		foreach ( $types as $col ) {
			if ($col->OPTIONS == strtoupper ( $customers->VESSEL_TYPE )) {
				?>
	 	<option selected value="<?php echo $col->OPTIONS; ?>"><?php echo $col->OPTIONS; ?></option>
	 	<?php }else{ ?>
	 	<option value="<?php echo $col->OPTIONS; ?>"><?php echo $col->OPTIONS; ?></option>
	 	<?php }} ?>

	 	</select><br />

	<?php
	echo br();
		echo form_hidden('vesselid', $customers->PK_VESSEL);
		echo form_hidden('customerid', $this->session->userdata('customerid'));
		echo form_label ( 'Slip', 'slip' ) . form_input ( 'slip', $customers->SLIP, 'class="textbox"' ) . br ();
		echo form_label ( 'C.F No.', 'cfno' ) . form_input ( 'cfno', $customers->VESSEL_CF, 'class="textbox"' ) . br ();
		echo form_label ( 'Make', 'make' ) . form_input ( 'make', $customers->VESSEL_MAKE, 'class="textbox"' ) . br ();
		echo form_label ( 'Model', 'model' ) . form_input ( 'model', $customers->VESSEL_MODEL, 'class="textbox"' ) . br ();
		echo form_label ( 'Length', 'length' ) . form_input ( 'length', $customers->VESSEL_LENGTH, 'class="textbox"' ) . br ();
		echo form_label ( 'Vessel Name', 'vessel_name' ) . form_input ( 'vessel_name', $customers->VESSEL_NAME, 'class="textbox"' ) . br ();
		echo form_label ( 'Tender/Dinghy', 'tender_dinghy' ) . form_input ( 'tender_dinghy', $customers->VESSEL_TENDER, 'class="textbox"' ) . br ();
		echo form_label ( 'Vessel Description', 'vessel_description' ) . form_textarea ( 'vessel_description', $customers->VESSEL_DESC, 'class="textarea"' ) . br ();
		echo form_label ( 'Paint Cycle', 'paint_cycle' );

		/* foreach ($paint as $p):
		if ($this->session->userdata('ves_paint_cycle')== $p->VALUE) {
		    echo '<span>' . form_radio ( 'paint_cycle', $p->VALUE, true ). explode("(",$p->OPTIONS)[0] .'</span>';
		} else {
		    echo '<span>' . form_radio ( 'paint_cycle', $p->VALUE ). explode("(",$p->OPTIONS)[0] . '</span>';
		}
		endforeach; */

		foreach ($paint as $p):
		if ($customers->PAINT_CYCLE == $p->VALUE) {
		    echo '<span>' . form_radio ( 'paint_cycle', $p->VALUE, true ). current(explode("(",$p->OPTIONS)) .'</span>';
		} else {
		    echo '<span>' . form_radio ( 'paint_cycle', $p->VALUE ). current(explode("(",$p->OPTIONS)) . '</span>';
		}
		endforeach;


		/* if ($customers->PAINT_CYCLE == 1) {
			echo '<span>' . form_radio ( 'paint_cycle', '1', true ) . 'Excellent</span>';
		} else {
			echo '<span>' . form_radio ( 'paint_cycle', '1' ) . 'Excellent</span>';
		}
		if ($customers->PAINT_CYCLE == 2) {
			echo '<span>' . form_radio ( 'paint_cycle', '2', true ) . 'Good</span>';
		} else {
			echo '<span>' . form_radio ( 'paint_cycle', '2' ) . 'Good</span>';
		}
		if ($customers->PAINT_CYCLE == 3) {
			echo '<span>' . form_radio ( 'paint_cycle', '3', true ) . 'Fair</span>';
		} else {
			echo '<span>' . form_radio ( 'paint_cycle', '3' ) . 'Fair</span>';
		}
		if ($customers->PAINT_CYCLE == 4) {
			echo '<span>' . form_radio ( 'paint_cycle', '4', true ) . 'Poor</span>';
		} else {
			echo '<span>' . form_radio ( 'paint_cycle', '4' ) . 'Poor</span>';
		} */

		/*
		 * for selecting type
		 */

	 	/*
	 	 * radio for choosing paint cycle.
	 	 */
	?>
	<div style="width:100%;float:left;margin-top:15px;text-align:center;padding-left:100px;">
 	 	<?php

 	 	echo '<a href="'.base_url().'index.php/customer/customer_registration/'.$this->session->userdata('customerid').'" class="buttonlink">Back</a> <input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Next" class="btn"/> <input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Save" class="btn"/> <a href="'.base_url().'index.php/customer/customer_session/" id="exit" class="buttonlink">Exit</a>';
 	 	?></div>
	<?php
		//echo form_button ( 'back', 'Back', 'class="btn" style="margin-left:-90px;" disabled' ) . form_button ( 'next', 'Next', 'class="btn" style="margin-left:-90px;" ' ) . form_submit ( 'mysubmit', 'Save', ' class="btn" style="margin-left:-200px;"' ) . form_button ( 'exit', 'Exit', 'class="btn" style="margin-left:-6px;" onclick="redirectPerfect(&apos;index&apos;)"' );
		echo form_close ();

	endforeach
	;
	if(($this->session->userdata('return')) && !($this->session->userdata('return_status')))
	{
	     if (($this->session->userdata('statuswb')=='ACTIVE') && $this->session->userdata('open'))
	    {
	     //redirect to the work order creattion.
	     echo '<script>alert("Data Updated");window.location="'.base_url().'index.php/customer/customer_redirect/'.$this->session->userdata('customerid').'";</script>';
	    }
	    else
	    {
	    echo '<script>alert("Data Updated");document.getElementById("exit").click();</script>';
	    }
	}
} else {
	/**
	 * ***************************************** Update ends
	 * ***********************************
	 */
	//echo $this->session->userdata('customer_number')."|".$this->session->userdata('vessel_number')."|".$this->session->userdata('anode_number');

	echo form_hidden('customerid', $this->session->userdata('customer_number'));
	echo form_hidden('vesselid', $this->session->userdata('vessel_number'));
	/*
	 * put vessel key here and update anodes while each step takes place and then to leave arif for testing.on 12.00noon
	 */
	echo '<label for="first_name" style="width:6%;float:left;">Location</label><span style="color:#E6B522;width:14%;float:left;text-align:left;">*</span>';
	?><select name="location" class="select">
		<option value="">Select Location</option>
 	<?php foreach($options as $row) {
if($row->OPTIONS == $this->session->userdata('ves_location')){
	?>
	<option selected value="<?php echo $row->OPTIONS?>"><?php echo $row->OPTIONS?></option>
	<?php
}else{
 		?>
 	<option value="<?php echo $row->OPTIONS?>"><?php echo $row->OPTIONS?></option>
 	<?php }} ?>
 	</select><br /><?php
	echo form_label ( 'Vessel Type', 'vessel_type' );
	?><select name="type" class="select">
		<option>Select Type</option>
 	<?php foreach($types as $col) {
 	if($col->OPTIONS == $this->session->userdata('ves_type')){
 		?>
 		<option selected value="<?php echo $col->OPTIONS?>"><?php echo $col->OPTIONS?></option>
 		<?php
 	}else{
 		?>
 	<option value="<?php echo $col->OPTIONS?>"><?php echo $col->OPTIONS?></option>
 	<?php }} ?>

 	</select><br />

<?php
	echo form_label ( 'Slip', 'slip' ) . form_input ( 'slip', $this->session->userdata('ves_slip'), 'class="textbox"' ) . br ();
	echo form_label ( 'C.F No.', 'cfno' ) . form_input ( 'cfno',  $this->session->userdata('ves_cfno'), 'class="textbox"' ) . br ();
	echo form_label ( 'Make', 'make' ) . form_input ( 'make',  $this->session->userdata('ves_make'), 'class="textbox"' ) . br ();
	echo form_label ( 'Model', 'model' ) . form_input ( 'model',  $this->session->userdata('ves_model'), 'class="textbox"' ) . br ();
	echo form_label ( 'Length', 'length' ) . form_input ( 'length',  $this->session->userdata('ves_length'), 'class="textbox"' ) . br ();
	echo form_label ( 'Vessel Name', 'vessel_name' ) . form_input ( 'vessel_name',  $this->session->userdata('ves_vessel_name'), 'class="textbox"' ) . br ();
	echo form_label ( 'Tender/Dinghy', 'tender_dinghy' ) . form_input ( 'tender_dinghy',  $this->session->userdata('ves_tender_dinghy'), 'class="textbox"' ) . br ();
	echo form_label ( 'Vessel Description', 'vessel_description' ) . form_textarea ( 'vessel_description',  $this->session->userdata('ves_vessel_description'), 'class="textarea"' ) . br ();
	echo form_label ( 'Paint Cycle', 'paint_cycle' ) ;
	/*
	 *
	 * explode($p->options,"(");
	 */
foreach ($paint as $p):

if ($this->session->userdata('ves_paint_cycle')== $p->VALUE) {



    echo '<span>' . form_radio ( 'paint_cycle', $p->VALUE, true ). current(explode("(",$p->OPTIONS)) .'</span>';
} else {
    echo '<span>' . form_radio ( 'paint_cycle', $p->VALUE ). current(explode("(",$p->OPTIONS)) . '</span>';
}


endforeach;


	/*
	if ($this->session->userdata('ves_paint_cycle')== 1) {
		echo '<span>' . form_radio ( 'paint_cycle', 1, true ) . 'Excellent</span>';
	} else {
		echo '<span>' . form_radio ( 'paint_cycle', 1 ) . 'Excellent</span>';
	}
	if ($this->session->userdata('ves_paint_cycle') == 2) {
		echo '<span>' . form_radio ( 'paint_cycle', 2, true ) . 'Good</span>';
	} else {
		echo '<span>' . form_radio ( 'paint_cycle', 2 ) . 'Good</span>';
	}
	if ($this->session->userdata('ves_paint_cycle') == 3) {
		echo '<span>' . form_radio ( 'paint_cycle', 3, true ) . 'Fair</span>';
	} else {
		echo '<span>' . form_radio ( 'paint_cycle', 3 ) . 'Fair</span>';
	}
	if ($this->session->userdata('ves_paint_cycle') == 4) {
		echo '<span>' . form_radio ( 'paint_cycle', 4, true ) . 'Poor</span>';
	} else {
		echo '<span>' . form_radio ( 'paint_cycle', 4 ) . 'Poor</span>';
	}

	/*
	 * for selecting type
	 */

 	/*
 	 * radio for choosing paint cycle.
 	 */

?>
	<div style="width:100%;float:left;margin-top:15px;text-align:center;padding-left:100px;">
 	 	<?php //<a href="'.base_url().'index.php/customer/customer_services/'.$this->session->userdata('customerid').'" class="buttonlink">Next</a>

 	 	echo '<a href="'.base_url().'index.php/customer/customer_registration/'.$this->session->userdata('customerid').'" class="buttonlink">Back</a>

	<input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Next" class="btn"/>
 	 	<input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Save" class="btn"/> <a href="'.base_url().'index.php/customer/customer_session/" id="exit" class="buttonlink">Exit</a>';
 	 	?></div>
	<?php

//echo form_button ( 'back', 'Back', 'class="btn" style="margin-left:-90px;" disabled' ) . form_button ( 'next', 'Next', 'class="btn" style="margin-left:-90px;" ' ) . form_submit ( 'mysubmit', 'Save', ' class="btn" style="margin-left:-200px;"' ) . form_button ( 'exit', 'Exit', 'class="btn" style="margin-left:-6px;" onclick="redirectPerfect(&apos;index&apos;)"' );
	echo form_close ();
}
?></div>
