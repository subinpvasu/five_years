<?php
 require_once dirname(__FILE__) . '/includes/includes.php';
	$dates = array();
        
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
		<th style='width:14%' align="left">&nbsp;<?php echo LAST_LOGIN ; ?></th>
		<th style='width:14%' align="left">&nbsp;<?php echo TOTAL_LOGIN_THIRTY ; ?></th>	
		<th style='width:14%'><?php echo TOTAL_LOGIN_SIXTY ; ?></th>		
		<th style='width:14%'><?php echo DETAILS ; ?></th>		
		
	
    </tr>
  </table>
</div>
<div id="listitems" style="margin-bottom:20px;">
<table width="100%"  border="0">



<?php 
$states = $statistics->login_statistics($statistics->prepare_dates(1),$statistics->prepare_dates(0));

$i = 1;
foreach($states as $state){ 

?>
<tr>
    <td align="center"><?php echo $i; ?></td>     
    <td><?php echo $state->ad_person_name; ?></td>     
    <td><?php echo date('d/m/Y H:i:s',strtotime($state->last_login)); ?></td>     
    <td><?php echo $state->thirty; ?></td>     
    <td><?php echo $state->sixty; ?></td>     
    <td>
        
        <a href="javascript:listUser(<?php echo $state->user_id; ?>)">View</a>
    
    </td>     
    
    
    </tr>
	<?php
        
        $i++;
} ?>
</table>
</div>
    
    
 
</div>