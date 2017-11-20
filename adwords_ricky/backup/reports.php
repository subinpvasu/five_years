<?php
header("Content-type: text/html; charset=utf-8");
include ("header.php");

$type = $_REQUEST['type'];
$id = $_REQUEST['id'];
$param = $_REQUEST['param'];
$order = $_REQUEST['order'];
$cname = $_REQUEST['cname'];

if ($type == '') {
    $type = 'TO';
} else
    if ($type == 'MR') {
        header('Location:customer_report/cr.php?id=' . $id);
    }
if (! $main->IsDuplicateExist('adword_accounts', "ad_account_adword_id='" . $id . "'")) {
    $type = 'NO TYPE';
} else {

    $account = $main->getRow("SELECT ad_account_name,ad_account_adword_id,ad_account_status FROM  adword_accounts where ad_account_adword_id='" . $id . "' ");
    $_SESSION['ad_account_adword_id'] = $account->ad_account_adword_id;
    $_SESSION['ad_report_type'] = $type;
    $_SESSION['ad_account_status'] = $account->ad_account_status;
}

$report = $main->getRow("SELECT `ad_report_type_name`,`report_type_field`,`ad_report_type_file`,`ad_report_type_img`,`ad_report_type_left`,`ad_report_type_right`,`ad_report_type_title` FROM " . DB_DATABASE . ".`adword_report_types` WHERE `report_type_field`='$type'");
$sql = "SELECT `ad_report_type_name`,`report_type_field` FROM " . DB_DATABASE . ".`adword_report_types` where ad_delete_status<>0 order by `ad_delete_status` asc  ";
$res = $main->getResults($sql);

?>


<script>

$(document).ready(function(){
   
 <?php if($type=='DHR'){ ?> avgByDayofWeek();  totalByHourofDay(); <?php  } ?>
  
});



	function getDeviceReport(){
		var devices = $("#devices").val();
		
			$("#campaign").val($("#campaign option:first").val());

		$.post('servicefiles/kd_reports.php',{devices:devices},function(data){
			$("#listitems").html(data['str']);
			 $(document).ready(function(){
				  $("#listitems td").css("text-align","center");
				});
				        $(document).ready(function(){
				  $("#listhead th").css("text-align","center");
				        $("#listhead td").css("text-align","center");
				});

			},'json');	
	}


function createEdit(descid,cnt,type)
{

	try{


		var desc = $("#"+descid).siblings("span").text();
		var old = $("#"+descid).parent("."+cnt).html();
		$("#"+descid).parent("."+cnt).html('<textarea id="description">'+desc+'</textarea><span class="button_bar"><button id="cancel_dialog">Cancel</button><button id="update_dialog">Update</button></span>');

		$("#cancel_dialog").click(function(){

			$("#description").remove();
			$(".button_bar").remove();
			$("."+cnt).html(old);
		});



		$("#update_dialog").click(function(){

		$.ajax({url:"<?php echo SITE_URL;?>ajax_handler.php",
			type:"post",
			 data: {
				 	description:$("#description").val(),
				 	side:cnt,
				 	types:type,
				 	status:100

			 },
			 success:function(result){

		window.location.reload(true);
					}
	  });

			});

	}
	catch(e){alert(e.message)}
}


</script>

<style>
#dialog
	{
	 background-color: grey;
    border: 1px solid black;
    color: white;
    height: 215px;
    left: 33%;
    padding: 5px;
    position: fixed;
    top: 150px;
    width: 500px;
    }
#description {
	border: 1px solid grey;
    color: grey;
    font-family: gibsonregular;
    height: 60px;
    margin: 0 10px 10px;
    width: 475px;
}

#foot {
	text-align: right;
}
.button_bar
{
	display: block;
    float: left;
    text-align: right;
    width: 490px;
}
</style>
<div class="report-container">
	<div class="page-header">
		<h1><a href="account_details.php?msg=Search&search_term=<?php echo $account->ad_account_adword_id; ?>" style="text-decoration: none;color:#686868;"><?php echo $account->ad_account_name; ?> (<?php echo $account->ad_account_adword_id; ?>)</a></h1>
	</div>
	<div class="report-div">
		<div class="report-div-one">
			<div class="report-details1">
				<?php echo $report->ad_report_type_name; ?> &nbsp;<span
					class="txtcolor2"><?php echo trim($report -> ad_report_type_title); ?></span>
				</b>
			</div>
			<div class="report-details2">
				<form action='reports.php' method='get' class='reportForm'>
					<input type='hidden' name='id' value='<?php echo $id; ?>' />
					<input type='hidden' name='cname' id="cname" value='' />
					<input type='hidden' name='domainame' id="domainame" value='' />
					<div>
						<span class="txtcolor2">Select</span> Report Type&nbsp;:&nbsp;
					</div>
					<div>
						<select name='type'>
							<option>--Select--</option>
						<?php
    foreach ($res as $key => $val) {
        ?>
						<option value='<?php echo $val->report_type_field ; ?>'
								<?php if($val->report_type_field==$type) echo "Selected"; ?>><?php echo $val->ad_report_type_name ; ?></option>
						<?php
    }
    ?>
					</select>
					</div>
					<div>
						<input  type="image" src="img/go.png" alt="GO" class="submit_button" id="go_submit"/>
					</div>
				</form>

			</div>
		</div>
		<div class="report-div-two" style="position:relative">
		<!--
		<?php
		echo $_SESSION['user_type']."<br/>";
		print_r($report);?> -->
			<div class="report-details-1">
				<div class="report-details-1-1">
					<img src="img/<?php echo $report -> ad_report_type_img; ?>">
				</div>
				<div class="report-details-1-2 1">

				<span><?php echo trim(urldecode($report -> ad_report_type_left)); ?></span>

				<?php if($_SESSION['user_type']==20){?>		<a
					style="" id="desc_one"
					onclick="createEdit(this.id,1,'<?php echo $report->report_type_field;?>')" href="#"><i class="fa fa-pencil-square-o"></i>
</a><?php }?>
				</div>

			</div>
			<div class="report-details-2 2">
			<span><?php echo trim(urldecode($report -> ad_report_type_right)); ?></span>

				<?php if($_SESSION['user_type']==20){?><a
				style="" id="desc_two"
				onclick="createEdit(this.id,2,'<?php echo $report->report_type_field;?>')" href="#"><i class="fa fa-pencil-square-o"></i>
</a><?php }?>
			</div>

		</div>
		<div class="account-details-div">

		<?php

if ($type == 'CBR') {
    include_once ('keywordCtrReport1.php');
} elseif ($type == 'KD') {
    include_once ('kd_reports1.php');
} elseif ($type == 'WA') {
    include_once ('wa_reports1.php');
} elseif ($type == 'ALR') {
    include_once ('alr_reports1.php');

} // elseif($type=='ETC') { include_once('Conversion8020Report_new.php'); }

else {

    include_once ($report->ad_report_type_file);
    echo "<!--".$report->ad_report_type_file."-->";

		}

		echo '<script>
    $(document).ready(function(){
  $("#listitems td").css("text-align","center");
});
        $(document).ready(function(){
  $("#listhead th").css("text-align","center");
        $("#listhead td").css("text-align","center");
});
    </script>';
		?>
		</div>
	</div>
</div>
<?php include("footer.php"); ?>
<script type="text/javascript" src="./js/latest.js"></script>
<script type="text/javascript" src="./js/tablesorter.js"></script>
<style>
.headerSortUp
	{
background-image: url("./images/downn.png");
		 background-position: center top;
    background-repeat: no-repeat;
    background-size: 20px 10px;
border-top:2px solid #fc1f91 !important;
cursor: pointer;
    }
.headerSortDown
	{
background-image: url("./images/up.png");
		 	 background-position: center bottom;
    background-repeat: no-repeat;
    background-size: 20px 10px;
cursor: pointer;
		border-bottom:2px solid #fc1f91 !important;
	}
</style>
<script>
$(document).ready(function() {//,[2,0]
    // call the tablesorter plugin
    $("table").tablesorter({
        // sort on the first column and third column, order asc
        sortList: [[0,0]]
   	
    
    });



});
$(document).ready(function(){
	$("#campaign").change(function(){

		var cname = $(this).val();
		$("#cname").val(cname);
	$("#go_submit").click();


	});
	
	
	$("#domain").change(function(){

		var cname = $("#campaign").val();
		$("#cname").val(cname);
		var domain = $(this).val();
		$("#domainame").val(domain);
	$("#go_submit").click();


	});

	});
</script>