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


</script>
<?php 

if(($this->session->userdata('return')) && !($this->session->userdata('return_status')))
{
    if((($this->session->userdata('statuswb')!=$this->session->userdata('statusdb')) && $this->session->userdata('statusdb')=='INACTIVE') || $this->session->userdata('brandnew')==true)
    {
     //code for exempt the loor
        echo '<script>routerScript();self.close();</script>';
    }
    else
    {
    echo '<script>alert("Data Updated");self.close();</script>';
    }
}
?>
<img  src="adasdasd" width="1px" height="1px" onerror="routerScript()"/>
<div style="width:100%;margin:0 auto; text-align: center;height:500px;padding-top:100px;display:none;">
<a href="<?php echo base_url().'index.php/customer/customer_misc'?>" class="buttonlink">Back</a>
<a target="_blank" href="<?php echo base_url().'index.php/customer/add_new_work_order/'. $this->session->userdata ( 'customer_number' );?>" id="route"  class="buttonlink">Click here to create work order</a>
<a href="<?php echo base_url().'index.php/customer/customer_session'?>" id="getout" class="buttonlink">Exit</a>

</div>