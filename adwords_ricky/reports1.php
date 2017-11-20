<?php
include("header.php");
$type = $_REQUEST['type'] ;
$id   = $_REQUEST['id'] ;


if($type==''){$type='TO';}
else if($type=='MR'){header('Location:customer_report/customer_report.php?id='.$id);}
if(!$main->IsDuplicateExist('adword_accounts',"ad_account_adword_id='".$id."' and `ad_account_status`=1")){
	$type = 'NO TYPE';
}
else{

	$account = $main -> getRow("SELECT ad_account_name,ad_account_adword_id FROM adword_accounts where ad_account_adword_id='".$id."' ");
	$_SESSION['ad_account_adword_id'] = $account->ad_account_adword_id;
	$_SESSION['ad_report_type'] = $type;
}

$report = $main -> getRow("SELECT `ad_report_type_name`,`report_type_field`,`ad_report_type_file`,`ad_report_type_img`,`ad_report_type_left`,`ad_report_type_right`,`ad_report_type_title` FROM `adword_report_types` WHERE `report_type_field`='$type'");
$sql = "SELECT `ad_report_type_name`,`report_type_field` FROM `adword_report_types` where ad_delete_status<>0 order by `ad_delete_status` asc  "; 
$res = $main -> getResults($sql);
?>
<script>
function getDeviceReport(){
	var devices = $("#devices").val();
	if(devices=='Select'){alert('Select a device'); }	
	else {
	$.post('servicefiles/kd_reports.php',{devices:devices},function(data){			
		$("#listitems").html(data['str']);			
		},'json');	}
}

</script>
<div class="report-container">
	<div class="page-header"><h1><?php echo $account->ad_account_name; ?> (<?php echo $account->ad_account_adword_id; ?>)</h1></div>
	<div class="report-div">
		<div class="report-div-one">
			<div class="report-details1">
				<?php echo $report->ad_report_type_name; ?> &nbsp;<span class="txtcolor2"><?php echo trim($report -> ad_report_type_title); ?></span> </b>	
			</div>		
			<div class="report-details2">
				<form action='reports.php' method ='get' class='reportForm'>
					<input type='hidden' name='id' value='<?php echo $id; ?>' />
					<div><span class="txtcolor2">Select</span> Report Type&nbsp;:&nbsp;	</div>
					<div><select name='type'>
						<option>--Select--</option>
						<?php
						foreach($res as $key=>$val){
						?>
						<option value='<?php echo $val->report_type_field ; ?>' <?php if($val->report_type_field==$type) echo "Selected"; ?>><?php echo $val->ad_report_type_name ; ?></option>
						<?php 
						}
						?>
					</select></div>
					<div><input type="image" src="img/go.png" alt="GO" class="submit_button" /></div>
				</form>
				
			</div>	
		</div>
		<div class="report-div-two">
			<div class="report-details-1">
				<div class="report-details-1-1"><img src="img/<?php echo $report -> ad_report_type_img; ?>"></div>
				<div class="report-details-1-2"><?php echo trim($report -> ad_report_type_left); ?></div>
			</div>
			<div class="report-details-2">
				<?php echo trim($report -> ad_report_type_right); ?>
			</div>		
		</div>
		<div class="account-details-div">
		
		<?php 
		
		if($type=='CBR') { include_once('keywordCtrReport1.php'); }
		elseif($type=='KD') { include_once('kd_reports1.php'); }
		elseif($type=='WA') { include_once('wa_reports1.php'); }
		elseif($type=='ALR') { include_once('alr_reports1.php'); }
		
		else{
		
		include_once($report -> ad_report_type_file);

		}
		?>
		</div>
	</div>
</div>
<?php include("footer.php"); ?>
