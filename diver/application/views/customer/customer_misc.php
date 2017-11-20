<div class="content">
	<h2>Add New Customer - Miscellaneous</h2>
	<script>
	$(document).ready(function(){
		$("#rest").css("text-decoration", "underline");
	});
	</script>
<?php
echo validation_errors ();
echo form_open ( 'customer/customer_misc/' . $this->session->userdata ( 'customerid' ) );
if (isset ( $customer )) {
    echo form_hidden ( 'vesselid', $this->session->userdata ( 'vessel_number' ) );
    
    foreach ( $customer as $customers ) :
        ?><h4 style="width: auto; display: block;">The Following comments will
		be printed on the WORK ORDERS for the divers</h4><?php
        echo br ();
        echo form_label ( 'Cleaning Instructions', 'cleaning_instructions' ) .
                                         form_textarea ( 'cleaning_instructions', $customers->CLEANING, 'class="textarea"' ) .
                                         br ();
echo form_label ( 'Anode Instructions', 'anode_instructions' ) .
         form_textarea ( 'anode_instructions', $customers->BILLING, 'class="textarea"' ) .
         br ();
echo form_label ( 'Mechanical Instructions', 'mechanical_instructions' ) .
 form_textarea ( 'mechanical_instructions', $customers->SPECIAL, 'class="textarea"' ) .
 br ();
echo form_label('Notes').form_textarea('notes',$customers->ADDFIELD2,'style="width:64%;height:238px;border:1px solid grey;border-left:4px solid grey;"').br();
?><h4 style="width: auto;">The Following comments will be printed on
		the INVOICES for the client</h4><?php
echo br ();
echo form_label ( 'Comments', 'comments' ) . form_textarea ( 'comments', $customers->COMMENTS, 'class="textarea"' ) . br ();

?>
			<div
		style="width: 100%; float: left; margin-top: 15px; text-align: center; padding-left: 100px;">
		 	 	<?php

echo '<a href="#" class="buttonlink" style="visibility:hidden">Next</a><a href="' .
 base_url () .
 'index.php/customer/customer_anodes/' .
 $this->session->userdata ( 'customerid' ) .
 '" class="buttonlink">Back</a>  <input type="submit" name="submit"  style="margin-top:5px;height:36px;" value="Save" class="btn"/> <a href="' .
 base_url () .
 'index.php/customer/customer_session/" id="exit" class="buttonlink">Exit</a>';
?></div>
			<?php
echo form_close ();
endforeach
;
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
} else { // echo
         // $this->session->userdata('customer_number')."|".$this->session->userdata('vessel_number')."|".$this->session->userdata('anode_number');
?><h4 style="width: auto;">The Following comments will be printed on
		the WORK ORDERS for the divers</h4><?php
echo form_hidden ( 'customerid', $this->session->userdata ( 'customer_number' ) );
echo form_hidden ( 'vesselid', $this->session->userdata ( 'vessel_number' ) );
echo br ();
echo form_label ( 'Cleaning Instructions', 'cleaning_instructions' ) .
 form_textarea ( 'cleaning_instructions', $this->session->userdata ( 'cleaning_instructions' ), 'class="textarea"' ) .
 br ();
echo form_label ( 'Anode Instructions', 'anode_instructions' ) .
 form_textarea ( 'anode_instructions', $this->session->userdata ( 'anode_instructions' ), 'class="textarea"' ) .
 br ();
echo form_label ( 'Mechanical Instructions', 'mechanical_instructions' ) .
 form_textarea ( 'mechanical_instructions', $this->session->userdata ( 'mechanical_instructions' ), 'class="textarea"' ) .
 br ();
echo form_label('Notes').form_textarea('notes',$this->session->userdata('notes'),'style="width:64%;height:238px;border:1px solid grey;border-left:4px solid grey;"').br();
?><h4 style="width: auto;">The Following comments will be printed on
		the INVOICES for the client</h4><?php
echo br ();
echo form_label ( 'Comments', 'comments' ) . form_textarea ( 
'comments', 
$this->session->userdata ( 'comments' ), 
'class="textarea"' ) . br ();

?>
		<div
		style="width: 100%; float: left; margin-top: 15px; text-align: center; padding-left: 100px;">
	 	 	<?php

echo '<a href="' .
 base_url () .
 'index.php/customer/customer_session/" class="buttonlink" style="visibility:hidden">Next</a><a href="' .
 base_url () .
 'index.php/customer/customer_anodes/' .
 $this->session->userdata ( 'customerid' ) .
 '" class="buttonlink">Back</a>  <input type="submit" name="submit" style="margin-top:5px;height:36px;" value="Save" class="btn"/> <a href="' .
 base_url () .
 'index.php/customer/customer_session/" id="exit" class="buttonlink">Exit</a>';
?></div>
		<?php
echo form_close ();

}

?>
</div>