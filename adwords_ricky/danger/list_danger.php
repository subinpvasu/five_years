<?php
 require_once dirname(__FILE__) . '/includes/includes.php';
	$dates = array();
        
?>
<div class="account-details-div">
    <h3>
        <?php
        $danger->report_date(1);
//        echo 'Comparison Date Range: <b>Sep 1, 2016 - Sep 30, 2016 vs Aug 1, 2016 - Aug 31, 2016</b>';
//        $danger->report_date();
        ?>
    </h3>
    
<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>
     
                <th style='width:14%' align="center">&nbsp;<?php echo ACCOUNT_NAME; ?></th>
		<th style='width:14%' align="left">&nbsp;<?php echo CONVERSION_NOW ; ?></th>
		<th style='width:14%' align="left">&nbsp;<?php echo CONVERSION_LAST_MONTH ; ?></th>
		<th style='width:14%' align="left">&nbsp;<?php echo CONVERSION_CHANGE ; ?></th>	
		<th style='width:14%'><?php echo CPA_NOW ; ?></th>		
		<th style='width:14%'><?php echo CPA_LAST_MONTH ; ?></th>		
		<th style='width:14%'><?php echo CPA_CHANGE ; ?></th>		
	
    </tr>
  </table>
</div>
<div id="listitems" style="margin-bottom:20px;">
<table width="100%"  border="0">



<?php 

$dates = $danger->report_date(100);
$tasks = $danger -> dangerDetails($dates[0],$dates[1],$dates[2],$dates[3],1);
$i = 0;
foreach($tasks as $task){ 

?>
<tr>
    <td><?php echo $task->account_name; ?></td>     
    <td><?php echo $task->conversion_now; ?></td>     
    <td><?php echo $task->conversion_last; ?></td>     
    <td><?php echo $danger->change_percent($task->conversion_now,$task->conversion_last); ?>%</td>     
    <td><?php echo number_format($task->CPA,2); ?></td>     
    <td><?php echo number_format($task->CPA_last,2); ?></td>     
    <td><?php echo $danger->change_percent($task->CPA,$task->CPA_last); ?>%</td>     

    </tr>
	<?php } ?>
</table>
</div>
    
    
    <h3>
         <?php
//        echo $danger->show_header(1);
//         echo 'Comparison Date Range: <b>Jan 1, 2016 - Sep 30, 2016 vs Jan 1, 2015 - Sep 30, 2015</b>';
         $danger->report_date(0);
        ?>
    </h3>
    
<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>
     
                <th style='width:14%' align="center">&nbsp;<?php echo ACCOUNT_NAME; ?></th>
		<th style='width:14%' align="left">&nbsp;<?php echo CONVERSION_NOW ; ?></th>
		<th style='width:14%' align="left">&nbsp;<?php echo CONVERSION_LAST_YEAR ; ?></th>
		<th style='width:14%' align="left">&nbsp;<?php echo CONVERSION_CHANGE ; ?></th>	
		<th style='width:14%'><?php echo CPA_NOW ; ?></th>		
		<th style='width:14%'><?php echo CPA_LAST_YEAR ; ?></th>		
		<th style='width:14%'><?php echo CPA_CHANGE ; ?></th>		
	
    </tr>
  </table>
</div>
<div id="listitems">
<table width="100%"  border="0">



<?php 

$dates = $danger->report_date(100,TRUE);
$tasks = $danger -> dangerDetails($dates[0],$dates[1],$dates[2],$dates[3],1);
$i = 0;
foreach($tasks as $task){ 

?>
<tr>
     
 <td><?php echo $task->account_name; ?></td>     
    <td><?php echo $task->conversion_now; ?></td>     
    <td><?php echo $task->conversion_last; ?></td>     
    <td><?php echo $danger->change_percent($task->conversion_now,$task->conversion_last); ?>%</td>     
    <td><?php echo number_format($task->CPA,2); ?></td>     
    <td><?php echo number_format($task->CPA_last,2); ?></td>     
    <td><?php echo $danger->change_percent($task->CPA,$task->CPA_last); ?>%</td>     
</tr>
	<?php } ?>
</table>
</div>    
</div>