<script src="<?php echo $link; ?>js/jquery.min.js"></script>
<script src="<?php echo $link; ?>js/jquery-1.7.1.min.js"></script>
<?php if($page=="index.php"){ ?><script src="<?php echo $link; ?>js/login.js"></script><?php } ?>
<?php if($page=="account_details.php"){ ?><script src="<?php echo $link; ?>js/account_details.js"></script><?php } ?>
<?php if($page=="customers.php"){ ?><script src="<?php echo $link; ?>js/customers.js"></script><?php } ?>
<?php if($page=="task_manager.php"){ ?><script src="<?php echo $link; ?>task_manager/js/task_manager.js"></script><?php } ?>
<?php if($page=="danger_list.php"){ ?><script src="<?php echo $link; ?>danger/js/danger_list.js"></script><?php } ?>
<?php if($page=="user_manager.php"){ ?><script src="<?php echo $link; ?>user_manager/js/user_manager.js"></script><?php } ?>
<?php if($page=="login_list.php"){ ?><script src="<?php echo $link; ?>statistics/js/login_list.js"></script><?php } ?>
<?php if($page=="customer_report.php"){ ?><script src="<?php echo $link; ?>customer_report/js/customer_report1.js"></script><?php } ?>
<?php if($page=="cr.php" || $page=="cr1.php" || "reports.php" || "budget_order.php" ){ ?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/heatmap.js"></script>
<?php if($page=="cr.php" || $page=="cr1.php"){?> <script src="<?php echo $link; ?>customer_report/js/cr.js"></script> <?php } ?>
<script src="https://code.highcharts.com/modules/exporting.js"></script>




<?php } ?>



<script>
$(document).ready(function(){

	$("#search_term").keyup(function(event){
		if(event.keyCode == 13){
			$("#srchBtn").click();
		}
	});

});
function goToChangeReports(){

var search_term = $("#search_term").val();

window.open('<?php echo SITE_URL ;?>account_details.php?msg=Search&search_term='+search_term,'_self')

}
</script>

