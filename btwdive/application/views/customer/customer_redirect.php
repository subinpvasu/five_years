<!--
Project     : BTW Dive
Author      : Subin
Title      : Customer Redirect
Description : Redirect the customer profile page after completion of the profile creation.
-->
<script>
function underConstruction()
{
	alert("Under Construction!");
}
function routerScript()
{
	document.getElementById('route').click();
	document.getElementById('getout').click();
}
function restOptions()
{
	var r = confirm("Do you wish to create work order for this customer?");
    if(r)
    {
    	 routerScript();
    }
    else
    {
        try
        {
    	document.getElementById('getout').click();
        }
        catch(e){alert(e.getMessage);}

    }
}

</script>

<!-- <img  src="adasdasd" width="1px" height="1px" onerror="routerScript()"/> -->
<div style="width:100%;margin:0 auto; text-align: center;height:500px;padding-top:100px;display:none;">
<a href="<?php echo base_url().'index.php/customer/customer_misc'?>" class="buttonlink">Back</a>
<a target="_blank" href="<?php echo base_url().'index.php/customer/add_new_work_order/'. $this->session->userdata ( 'customer_number' );?>" id="route"  class="buttonlink">Click here to create work order</a>
<a  id="getout" href="<?php echo base_url().'index.php/customer/customer_session';?>" class="buttonlink">Exit</a>

</div>
<?php

if(($this->session->userdata('return')) && !($this->session->userdata('return_status')))
{
    if(($this->session->userdata('statuswb')=='ACTIVE' && $this->session->userdata('open')))
    {
     //code for exempt the loor
        echo '<script>
       restOptions();

       </script>';
    }
    else
    {
     echo '<script>
       try
        {
    	document.getElementById("getout").click();
        }
        catch(e){alert(e.getMessage);}

       </script>';
    }
}
?>