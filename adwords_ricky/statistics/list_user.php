<?php
 require_once dirname(__FILE__) . '/includes/includes.php';
	$dates = array();
        $user = $_REQUEST['user'];
        
?>
<div class="account-details-div">
    <h3>
        <?php
//        $danger->report_date(1);
//        echo 'Comparison Date Range: <b>Sep 1, 2016 - Sep 30, 2016 vs Aug 1, 2016 - Aug 31, 2016</b>';
//        $danger->report_date();
        ?>
    </h3>
    
<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>
     
                <th style='width:14%' align="center">&nbsp;<?php echo SL_NO; ?></th>
		<th style='width:14%' align="left">&nbsp;<?php echo ACCOUNT_NAME ; ?></th>
		<th style='width:14%' align="left">&nbsp;<?php echo LOGIN_TIME ; ?></th>
		<th style='width:14%' align="left">&nbsp;<?php echo LOGOUT_TIME ; ?></th>	
		
		
	
    </tr>
  </table>
</div>
<div id="listitems" style="margin-bottom:20px;">
<table width="100%"  border="0">



<?php 
$states = $statistics->user_statistics($user);

$i = 1;
foreach($states as $state){ 

?>
<tr>
    <td align="center"><?php echo $i; ?></td>     
    <td><?php echo $state->ad_person_name; ?></td>     
    <td><?php echo date('d/m/Y H:i:s',strtotime($state->login_time)); ?></td>     
    <td><?php echo $state->logout_time !='0000-00-00 00:00:00'?date('d/m/Y H:i:s',strtotime($state->logout_time)):'---'; ?></td>     
      
    
    
    </tr>
	<?php
        
        $i++;
} ?>
</table>
</div>
    
    
 
</div>