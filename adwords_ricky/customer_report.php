<?php
require_once dirname(__FILE__) . '/includes/includes.php';
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
$type = $_REQUEST['type'] ;
$id   = $_REQUEST['id'] ;




$report = $main -> getRow("SELECT `ad_report_type_name`,`report_type_field`,`ad_report_type_file`,`ad_report_type_img`,`ad_report_type_left`,`ad_report_type_right`,`ad_report_type_title` FROM `adword_report_types` WHERE `report_type_field`='$type'");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Push Customer Report Summery</title>

<link rel="stylesheet" type="text/css" href="css/ricky.css">
<script src="js/jquery.min.js"></script>
<!-- <script src="js/jquery-1.9.0.min.js"></script> -->
<script src="js/jquery-1.7.1.min.js"></script>
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

window.open('account_details.php?msg=Search&search_term='+search_term,'_self')

}

function getDeviceReport(){

	var devices = $("#devices").val();
	if(devices=='Select'){alert('Select a device'); }
	
	else {
	
	
	$.post('servicefiles/kd_reports.php',{devices:devices},function(data){
			
		$("#listitems").html(data['str']);
			
		},'json');
	
	
	}

}




</script>
</head>
<body>

<div class="master">


<header>

<div class="first_one">

  <div style="
    float: left;
"><input type="text" class="ext textbox" placeholder="Search accounts" id="search_term"></div>
<div style="
    float: left;
"><img src="img/search_img.png" onclick="goToChangeReports()" id="srchBtn" style="cursor:pointer;"></div>


</div>

<div class="second_one">

<ul>
<li><img src="img/logout_li.png" style="margin-top:1px;vertical-align: middle;"><a href="logout.php">Logout</a></li>
<!--li><img src="img/report_li.png" style="margin-top:1px;vertical-align: middle;"><a href="">Acount&nbsp;Reports</a></li-->
<li><img src="img/details_li.png" style="margin-top:1px;vertical-align: middle;"><a href="account_details.php">Account&nbsp;Details</a></li>
<li><img src="img/home_li.png" style="margin-top:1px;vertical-align: middle;"><a href="account_details.php">Home</a></li>



</ul>


</div>

</header>
<div class="logo">
<img src="img/logo.png"/>

<div class="account_name"><?php echo $account->ad_account_name; ?> (<?php echo $account->ad_account_adword_id; ?>) &nbsp;   <!--a href="#">Change Account</a--></div>
</div>

<div class="adsharegap">
<div class="ap_left">
<b><?php echo $report->ad_report_type_name; ?> &nbsp;<span class="txtcolor2"><?php echo trim($report -> ad_report_type_title); ?></span> </b>&nbsp;
</div>
<?php 

$sql = "SELECT `ad_report_type_name`,`report_type_field` FROM `adword_report_types` where ad_delete_status<>0 order by `ad_delete_status` asc  "; 

$res = $main -> getResults($sql);
?>
<div class="ap_right">
<div class="right_sub_div" style="width:25%">
<form action='reports.php' method ='get' class='reportForm'>
<input type='hidden' name='id' value='<?php echo $id; ?>' />
<span class="txtcolor2">Select</span> Report Type :</div>
<div class="selection_ext" style="float:left;">
<select name='type'>
<option>--Select--</option>
<?php
foreach($res as $key=>$val){
?>
<option value='<?php echo $val->report_type_field ; ?>' <?php if($val->report_type_field==$type) echo "Selected"; ?>><?php echo $val->ad_report_type_name ; ?></option>
<?php 
}
?>
</select>

</div>
<div style="
    float: left;
    width: 10%;
    overflow: hidden;
    margin-top: 11px;
    margin-left: 1%;
"><input type="image" src="img/go.png" alt="GO" class="submit_button"></div>
</form>
</div>

</div>
<!--div class="ad_potential">
<div class="adp_left">
<img src="img/<?php echo $report -> ad_report_type_img; ?>">
<?php echo trim($report -> ad_report_type_left); ?>
</div>
<div class="adp_right">
<?php echo trim($report -> ad_report_type_right); ?>
</div-->

</div>
<?php include_once($report -> ad_report_type_file); ?>






<footer>


<table style="">
<tr><td><b>Industry <span>Articles</span></b></td><td><b>Push <span>Tools</span></b></td><td style="width:500px;"></td></tr>
<tr><td colspan="3"><hr style="border:2px solid;"/></td></tr>
<tr><td><span>+</span>Link</td><td><span>+</span>Push</td><td></td></tr>
<tr><td><span>+</span>Link</td><td><span>+</span>Push</td><td><img src="img/partner_logo.png"/></td></tr>
<tr><td><span>+</span>Link</td><td><span>+</span>Push</td><td></td></tr>
<tr><td><span>+</span>Link</td><td><span>+</span>Push</td><td></td></tr>
<tr><td><span>+</span>Link</td><td><span>+</span>Push</td><td></td></tr>
<tr><td><span>+</span>Link</td><td><span>+</span>Push</td><td></td></tr>
</table>




</footer>


</div>

</body>
</html>