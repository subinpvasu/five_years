<!--
Project     : BTW Dive
Author      : Subin
Title      : Customer Registration
Description : Customer Registraation page allows to register the customer.
-->
<!-- Update Start -->
<script>
$(document).ready(function(){
		$("#addbill").click(function(){
			if( $(this).is(':checked') ) {document.getElementById("billing_section").style.display='block';}else{document.getElementById("billing_section").style.display='none';}
		});
});

$(document).ready(function(){
	$("#user").css("text-decoration", "underline");
});

$(document).ready(function(){

	$("#bill_mode").click(function(){
	if($(this).val()=='Email' || $(this).val()=='Credit Card & Email' || $(this).val()=='Us Mail & Email')
	{
		//alert("email");
		$("#emailcc").css("display","block");
	}
	else
	{
		$("#emailcc").css("display","none");
	}
	});
});
$(document).ready(function(){

	if($("#bill_mode").val()=='Email'|| $("#bill_mode").val()=='Credit Card & Email' || $("#bill_mode").val()=='Us Mail & Email')
	{
		//alert("email");
		$("#emailcc").css("display","block");
	}
	else
	{
		$("#emailcc").css("display","none");
	}

});
</script>
<div class="content">
	<h2>Add New Customer - Registration</h2>
<?php
if (isset($customer)) {

    foreach ($customer as $customers) :
        echo validation_errors();
        echo form_open('customer/customer_registration/' . $customers->CUSTOMER_ID);
        echo form_hidden('customerid', $this->session->userdata('customerid'));
        echo form_label('Account No', 'account_no') . form_input('account_no', $customers->ACCOUNT_NO, ' class="textbox"  disabled') . br();
        echo form_label('Customer Code', 'customer_code') . form_input('customer_code', $customers->CUSTOMER_ID, ' class="textbox" disabled ') . br();
        echo '<label for="first_name" style="width:7%;float:left;">First Name</label><span style="color:#E6B522;width:13%;float:left;text-align:left;">*</span>' . form_input('first_name', $customers->FIRST_NAME, ' class="textbox" ') . br();
        echo form_label('Middle Name', 'middle_name') . form_input('middle_name', $customers->MIDDLE_NAME, ' class="textbox" ') . br();
        echo '<label for="last_name" style="width:7%;float:left;">Last Name</label><span style="color:#E6B522;width:13%;float:left;text-align:left;">*</span>' . form_input('last_name', $customers->LAST_NAME, ' class="textbox" ') . br();
        echo form_label('Address', 'address') . form_input('address', $customers->ADDRESS, ' class="textbox" ') . br();
        echo form_label('Address1', 'address1') . form_input('address1', $customers->ADDRESS1, ' class="textbox" ') . br();
        echo form_label('City', 'city') . form_input('city', $customers->CITY, ' class="textbox" ') . br();
        echo form_label('State', 'state') . form_input('state', $customers->STATE, ' class="textbox" ') . br();
        echo form_label('Zip', 'zip') . form_input('zip', $customers->ZIPCODE, ' class="textbox" ') . br();
        echo form_label('Country', 'country') . form_input('country', $customers->COUNTRY, ' class="textbox" ') . br();
        echo form_label('Email', 'email') . form_input('email', $customers->EMAIL, ' class="textbox" ') . br();
        echo form_label('Home Phone', 'home_phone') . form_input('home_phone', $customers->HOME_PHONE, ' class="textbox" ') . br();
        echo form_label('Cell', 'cell') . form_input('cell', $customers->CELL_PHONE, ' class="textbox" ') . br();
        echo form_label('Office Phone', 'office_phone') . form_input('office_phone', $customers->OFFICE_PHONE, ' class="textbox" ') . br();
        echo form_label('Fax', 'fax') . form_input('fax', $customers->FAX_NO, ' class="textbox" ') . br();
        echo form_label('Contact', 'contact') . form_input('contact', $customers->CONTACT, ' class="textbox" ') . br();
        echo form_label('Bill Mode', 'bill_mode');
        ?>
<select name="bill_mode" class="select" id="bill_mode">
 		<?php

        foreach ($bill as $row) {
            if (ucwords(strtolower($row->OPTIONS)) === $customers->DELIVERY_MODE) {
                ?>
 			 	 	<option selected
			value="<?php echo ucwords(strtolower($row->OPTIONS)); ?>"><?php echo $row->OPTIONS; ?></option>
 			 	 	<?php
            } else {
                ?>
 	 	<option value="<?php echo ucwords(strtolower($row->OPTIONS)); ?>"><?php echo $row->OPTIONS; ?></option>
 	 	<?php } }?>
 	 	</select><br />

 	 	<?php
//
        echo '<div style="border:0px;width:100%;height:150px;position:relative;float:left;clear:left;display:none;" id="emailcc">';
        echo form_label("CC Email") . form_textarea('emailcc', $customers->ADDFIELD1, 'placeholder="CC Email IDs seperated by comma." class="textarea" ') . br();
        echo form_label("BCC Email") . form_textarea('emailbcc', $customers->ADDFIELD2, 'placeholder="BCC Email IDs seperated by comma." class="textarea" ');

        echo '</div>';

        echo form_label('Bill To', 'bill_to') . form_input('bill_to', $customers->BILL_TO, ' class="textbox" ') . br();

        echo heading('Billing Address', 3) . br();

        echo form_label('Address', 'bill_address') . form_input('bill_address', $customers->BILL_ADDRESS, ' class="textbox" ') . br();
        echo form_label('Address1', 'bill_address1') . form_input('bill_address1', $customers->BILL_ADDRESS1, ' class="textbox" ') . br();
        echo form_label('City', 'bill_city') . form_input('bill_city', $customers->BILL_CITY, ' class="textbox" ') . br();
        echo form_label('State', 'bill_state') . form_input('bill_state', $customers->BILL_STATE, ' class="textbox" ') . br();
        echo form_label('Zip', 'bill_zip') . form_input('bill_zip', $customers->BILL_ZIPCODE, ' class="textbox" ') . br();
        echo form_label('Country', 'bill_country') . form_input('bill_country', $customers->BILL_COUNTRY, ' class="textbox" ') . br();
        echo heading('Referred By', 3) . br();
        echo form_label('Contact', 'referred_contact') . form_input('referred_contact', $customers->ALT_CONTACT, ' class="textbox" ') . br();
        echo form_label('Home Phone', 'referred_home_phone') . form_input('referred_home_phone', $customers->ALT_HOME_PHONE, ' class="textbox" ') . br();
        echo form_label('Cell', 'referred_cell') . form_input('referred_cell', $customers->ALT_CELL_PHONE, ' class="textbox" ') . br();
        echo form_label('Office Phone', 'referred_office_phone') . form_input('referred_office_phone', $customers->ALT_OFFICE_PHONE, ' class="textbox" ') . br();
        echo form_label('Fax', 'referred_fax') . form_input(array(
            'class' => 'textbox',
            'name' => 'referred_fax',
            'value' => $customers->ALT_FAX_NO,
            ' class="textbox" '
        )) . br();
        echo form_label('Status', 'status');
        if ($customers->STATUS == 'ACTIVE') {
            echo '<span>' . form_radio('status', 'ACTIVE', true) . 'Active</span>';
        } else {
            echo '<span>' . form_radio('status', 'ACTIVE') . 'Active</span>';
        }
        if ($customers->STATUS == 'INACTIVE') {
            echo '<span>' . form_radio('status', 'INACTIVE', true) . 'Inactive</span>';
        } else {
            echo '<span>' . form_radio('status', 'INACTIVE') . 'Inactive</span>';
        }
        echo br();
        echo form_label('Payment Terms', 'payment_terms');
        ?><select name="payment_terms" class="select">

 	 	<?php

foreach ($terms as $row) {
            if ($row->OPTIONS == $customers->TERMS) {
                ?>
 	 		<option selected value="<?=$row->OPTIONS?>"><?=$row->OPTIONS?></option>
 	 			<?php
            } else {
                ?>
 	 	<option value="<?=$row->OPTIONS?>"><?=$row->OPTIONS?></option>
 	 	<?php } }?>
 	 	</select><br />
	<div
		style="width: 100%; float: left; margin-top: 15px; text-align: center; padding-left: 100px;">
 	 	<?php

        echo '<a href="#" class="buttonlink" style="visibility:hidden">Back</a> <input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Next" class="btn"/> <input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Save" class="btn"/> <a href="' . base_url() . 'index.php/customer/customer_session/" id="exit" class="buttonlink">Exit</a>';
        ?></div><?php

        echo form_close();
    endforeach
    ;
    if (($this->session->userdata('return')) && ! ($this->session->userdata('return_status'))) {
        echo '<script>self.close();</script>';
    }
    ?>



<!-- Update end -->

<?php
} else {
    echo validation_errors();
    echo form_open('customer/customer_registration');

    // echo $this->session->userdata('customer_number')."|".$this->session->userdata('vessel_number')."|".$this->session->userdata('anode_number');
    echo form_label('Account No', 'account_no') . form_input('account_no', $this->session->userdata('account_no'), ' class="textbox" disabled ') . br();
    echo form_label('Customer Code', 'customer_code') . form_input('customer_code', $this->session->userdata('customer_number'), ' class="textbox" disabled ') . br();
	echo form_hidden('customerid', $this->session->userdata('customer_number'));echo br();
    // echo form_error('first_name');
    echo '<label for="first_name" style="width:7%;float:left;">First Name</label><span style="color:#E6B522;width:13%;float:left;text-align:left;">*</span>' . form_input('first_name', $this->session->userdata('first'), ' class="textbox" ') . br();
    echo form_label('Middle Name', 'middle_name') . form_input('middle_name', $this->session->userdata('middle_name'), ' class="textbox" ') . br();
    echo '<label for="last_name" style="width:7%;float:left;">Last Name</label><span style="color:#E6B522;width:13%;float:left;text-align:left;">*</span>' . form_input('last_name', $this->session->userdata('last_name'), ' class="textbox" ') . br();
    echo form_label('Address', 'address') . form_input('address', $this->session->userdata('address'), ' class="textbox" ') . br();
    echo form_label('Address1', 'address1') . form_input('address1', $this->session->userdata('address1'), ' class="textbox" ') . br();
    echo form_label('City', 'city') . form_input('city', $this->session->userdata('city'), ' class="textbox" ') . br();
    echo form_label('State', 'state') . form_input('state', $this->session->userdata('state'), ' class="textbox" ') . br();
    echo form_label('Zip', 'zip') . form_input('zip', $this->session->userdata('zip'), ' class="textbox" ') . br();
    echo form_label('Country', 'country') . form_input('country', $this->session->userdata('country'), ' class="textbox" ') . br();
    echo form_label('Email', 'email') . form_input('email', $this->session->userdata('email'), ' class="textbox" ') . br();
    echo form_label('Home Phone', 'home_phone') . form_input('home_phone', $this->session->userdata('home_phone'), ' class="textbox" ') . br();
    echo form_label('Cell', 'cell') . form_input('cell', $this->session->userdata('cell'), ' class="textbox" ') . br();
    echo form_label('Office Phone', 'office_phone') . form_input('office_phone', $this->session->userdata('office_phone'), ' class="textbox" ') . br();
    echo form_label('Fax', 'fax') . form_input('fax', $this->session->userdata('fax'), ' class="textbox" ') . br();
    echo form_label('Contact', 'contact') . form_input('contact', $this->session->userdata('contact'), ' class="textbox" ') . br();
    echo form_label('Bill Mode', 'bill_mode');

    ?><select name="bill_mode" class="select" id="bill_mode">

	<?php

    foreach ($bill as $row) {
        if (ucwords(strtolower($row->OPTIONS)) == $this->session->userdata('bill_mode')) {
            ?>
 			 	 	<option selected
			value="<?php echo ucwords(strtolower($row->OPTIONS)); ?>"><?php echo $row->OPTIONS; ?></option>
 			 	 	<?php
        } else {
            ?>
 	 	<option value="<?php echo ucwords(strtolower($row->OPTIONS)); ?>"><?php echo $row->OPTIONS; ?></option>
 	 	<?php } }?>


 	 	</select><br /><?php

    echo '<div style="border:0px;width:100%;height:150px;position:relative;float:left;clear:left;display:none;" id="emailcc">';
    echo form_label("CC Email") . form_textarea('emailcc', $this->session->userdata('emailcc'), 'placeholder="CC Email IDs seperated by comma." class="textarea" ') . br();
    echo form_label("BCC Email") . form_textarea('emailbcc', $this->session->userdata('emailbcc'), 'placeholder="BCC Email IDs seperated by comma." class="textarea" ');

    echo '</div>';

    echo form_label('Bill To', 'bill_to') . form_input('bill_to', $this->session->userdata('bill_to'), ' class="textbox" ') . br();

    echo '<span style="width:400px;display:block;float:left;clear:left;"><input type="checkbox" id="addbill" name="billing"  />If Billing Address Different Click here </span>';
    echo '<div style="border:0px;width:100%;height:210px;position:relative;float:left;clear:left;display:none;" id="billing_section">';

    echo heading('Billing Address', 3) . br();

    echo form_label('Address', 'bill_address') . form_input('bill_address', $this->session->userdata('bill_address'), ' class="textbox" ') . br();
    echo form_label('Address1', 'bill_address1') . form_input('bill_address1', $this->session->userdata('bill_address1'), ' class="textbox" ') . br();
    echo form_label('City', 'bill_city') . form_input('bill_city', $this->session->userdata('bill_city'), ' class="textbox" ') . br();
    echo form_label('State', 'bill_state') . form_input('bill_state', $this->session->userdata('bill_state'), ' class="textbox" ') . br();
    echo form_label('Zip', 'bill_zip') . form_input('bill_zip', $this->session->userdata('bill_zip'), ' class="textbox" ') . br();
    echo form_label('Country', 'bill_country') . form_input('bill_country', $this->session->userdata('bill_country'), ' class="textbox" ') . br();

    echo '</div>';
    echo heading('Referred By', 3) . br();
    echo form_label('Contact', 'referred_contact') . form_input('referred_contact', $this->session->userdata('referred_contact'), ' class="textbox" ') . br();
    echo form_label('Home Phone', 'referred_home_phone') . form_input('referred_home_phone', $this->session->userdata('referred_home_phone'), ' class="textbox" ') . br();
    echo form_label('Cell', 'referred_cell') . form_input('referred_cell', $this->session->userdata('referred_cell'), ' class="textbox" ') . br();
    echo form_label('Office Phone', 'referred_office_phone') . form_input('referred_office_phone', $this->session->userdata('referred_office_phone'), ' class="textbox" ') . br();
    echo form_label('Fax', 'referred_fax') . form_input(array(
        'class' => 'textbox',
        'name' => 'referred_fax',
        'value' => $this->session->userdata('referred_fax')
    )) . br();
    echo form_label('Status', 'status');
    /*
     * if ($this->session->userdata('status') == 'ACTIVE') {
     * echo '<span>' . form_radio ( 'status', 'ACTIVE', true ) . 'Active</span>';
     * } else {
     * echo '<span>' . form_radio ( 'status', 'ACTIVE' ) . 'Active</span>';
     * }
     */
    echo '<span>' . form_radio('status', 'ACTIVE', true) . 'Active</span>';
    if ($this->session->userdata('status') == 'INACTIVE') {
        echo '<span>' . form_radio('status', 'INACTIVE', true) . 'Inactive</span>';
    } else {
        echo '<span>' . form_radio('status', 'INACTIVE') . 'Inactive</span>';
    }
    echo br();
    echo form_label('Payment Terms', 'payment_terms');
    ?><select name="payment_terms" class="select">


 	 	<?php

foreach ($terms as $row) {
        if ($row->OPTIONS == $this->session->userdata('payment')) {
            ?>
 	 	<option selected value="<?php echo $row->OPTIONS?>"><?php echo $row->OPTIONS?></option>
 	 	<?php
        } else {
            ?>
 	 	<option value="<?php echo $row->OPTIONS?>"><?php echo $row->OPTIONS?></option>
 	 	<?php }} ?>


 	 	</select><br />
	<div
		style="width: 100%; float: left; margin-top: 15px; text-align: center; padding-left: 100px;">
 	 	<?php
// <a href="'.base_url().'index.php/customer/customer_vessel/" class="buttonlink">Next</a>

    echo '<a href="#" class="buttonlink" style="visibility:hidden">Back</a>

<input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Next" class="btn"/>
 	 	<input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Save" class="btn"/> <a href="' . base_url() . 'index.php/customer/customer_session/" id="exit" class="buttonlink">Exit</a>';
    ?></div><?php

    echo form_close();
}
?>
 </div><?php ///echo "<p style='color:red;'>here".$this->session->userdata('tester');?>