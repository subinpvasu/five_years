<div style="width:50%;float:left;text-align: center;">
<p style="border:1px solid white;font-weight:bold;padding:5px 15px;width:20%;float:left;height:20px">Customer Name  </p>
<p style="border:1px solid white;font-weight:bold;padding:5px 15px;margin-left:15px;width:26%;float:left;height:20px">
<?php echo $this->session->userdata('customer'); ?></p>
</div>

<div style="width:50%;float:left;text-align: center;">
<p style="border:1px solid white;font-weight:bold;padding:5px 15px;margin-left:15px;width:20%;float:left;height:20px">Vessel Name  </p>
<p style="border:1px solid white;font-weight:bold;padding:5px 15px;margin-left:15px;width:26%;float:left;height:20px">
<?php echo $this->session->userdata('ves_vessel_name'); ?></p></div>


<ul class="list">
<li><a href="<?php echo base_url();?>index.php/customer/customer_registration/<?php echo $this->session->userdata('customerid');  ?>" style="color:#E6B522;font-weight:bold;text-transform:uppercase;" id="user">Customer</a></li>
<li><a href="<?php echo base_url();?>index.php/customer/customer_vessel/<?php echo $this->session->userdata('customerid'); ?>" style="color:#E6B522;font-weight:bold;text-transform:uppercase;" id="boat">Vessel</a></li>
<li><a href="<?php echo base_url();?>index.php/customer/customer_services/<?php echo $this->session->userdata('customerid'); ?>" style="color:#E6B522;font-weight:bold;text-transform:uppercase;" id="job">Services</a></li>
<li><a href="<?php echo base_url();?>index.php/customer/customer_anodes/<?php echo $this->session->userdata('customerid'); ?>" style="color:#E6B522;font-weight:bold;text-transform:uppercase;" id="stuff">Anodes</a></li>
<li><a href="<?php echo base_url();?>index.php/customer/customer_misc/<?php echo $this->session->userdata('customerid'); ?>" style="color:#E6B522;font-weight:bold;text-transform:uppercase;" id="rest">Misc</a></li>
</ul>
