<?php 
echo form_open ( 'customer/customer_session' );
?>
<img src="dsfds" width="1px" height="1px" onerror="javascript:document.getElementById(&quot;exitsubmit&quot;).click()"/>
<?php 
//echo '<h3>Customer Created Successfully!</h3>';
echo '<input type="hidden" name="worker" value="notgood"/>';
echo '<div style="width:100%;margin:0 auto;text-align:center;height:400px;padding-top:100px;visibility:hidden"><input type="submit" id="exitsubmit" name="submit" style="margin-top:250px;height:36px;width:auto;margin:0 auto;" value="Click here to Exit" class="btn"/></div>';
echo form_close();
?>