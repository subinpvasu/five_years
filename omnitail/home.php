<?php
ini_set('max_execution_time', 1200);
include_once './Classes/DatabaseHelper.php';
include_once './Classes/AppConstants.php';
require_once dirname(__FILE__) . '/examples/AdWords/v201605/init.php';
include 'functions.php';
$whosaccount = isset($_REQUEST['whosaccount'])?$_REQUEST['whosaccount']:$master_account;
$objDB = new DbHelper();
$accounts = $objDB->getAllAccounts($whosaccount);
if (! isset($_SESSION['status']) || $_SESSION['status'] != 'loggedin') {
    header('location:index.php');
}

?>
<!DOCTYPE HTML>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Dashboard</title>
<link rel="stylesheet" href="static/css/bootstrap.min.css">
<link rel="stylesheet" href="static/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="static/css/style.css">
<script src="static/js/bootstraps/jquery.js"></script>
<script src="static/js/bootstraps/bootstrap.min.js"></script>
<script src="static/js/dropzone.js"></script>
<link rel="stylesheet" type="text/css" href="static/css/dropzone.css">

<style>
        #menu_div div {float:right;}
        #menu_div div div{
            
            float:left;
            width:auto;
            margin-left: 5px;
        }
        
</style>

</head>
<body>

    <header style ="background-color:white">
      <div class="row fixed-nav-bar">
      <div class="logo col-md-6">
        <img src="static/img/logo.png" style="width:250px;">
      </div>
          <div class="navagation col-md-6" id="menu_div"><div>
          <div>
            <a href="skutools.php"><button class="btn btn-default">SKU Tools</button></a>
        </div>
        <div>
            <a href="account.php"><button class="btn btn-default">Accounts</button></a>
        </div>
          <div>
        <?php if(isset($_SESSION['user_type'])&&$_SESSION['user_type']==1){ ?> 
              <a href="users/users.php"><button class=" btn btn-default">Users</button></a> <?php } ?>
          </div>
          <div>
          <a href="logout.php"><button class=" btn btn-default">Logout</button></a>
          
          </a></div>
              </div></div>
      </div>
    </header>
	<section>
		<div class="container">
			<!-- <h5 class="account">Customers Accounts:</h5> -->
			
			
			<div class="row">
      <div class="col-md-2">
       <h5 class="account" >Customers Accounts : </h5>
      
      </div>
      <div class="col-md-5">
      <form action="home.php" id="change_account" method="get">
      <select  class="form-control account"  name="whosaccount" id="whosaccount" style="margin-top:35px;">
      <?php foreach (get_mcc_accounts() as $account):?>
       <option <?php echo $account->account_number==$whosaccount?'selected':'';?> value="<?php echo $account->account_number;?>"><?php echo ucfirst($account->account_name==''?$account->name:$account->account_name)." (".$account->account_number.")";?></option>
       <?php endforeach;?>
     
      </select>
      </form>
      </div>
   
      
      </div>
			
			
			
			
			<div class="box" style="background-color: white">
        <?php
        if (is_array($accounts)) {
            foreach ($accounts as $account) {
                $accountId = $account['account_number'];
                //$campaigns = $objDB->getCampaignsFromDB($accountId);
               
                $productGroupCount = 0;
                $totalBudget = 0;
              
                ?>
          <div class="inner-box">
					<div class="row">
						<div class="col-md-4 col-sm-4">
							<ul class="account-list" id="account_{{account.customer_id}}">
								<li style="width:45%;">Campaigns:<span><?= $account['campaign_count']; ?></span></li>
								<li style="width:45%;">AdGroups:<span><?=$account['adgroup_count']; ?></span></li>
								
							</ul>
						</div>
						<div class="col-md-8 col-sm-8">
							<div class="row">
								<div class="col-md-2 col-sm-2">
									<button type="button"
										class="btn btn-default discount-btn create_ads"
										data-id="{{account.id}}"
										data-customerid="<?= $account['account_number']; ?>"
										value="<?= $account['account_number']; ?>">Create Ads</button>
								</div>
								<div class="col-md-2 col-sm-2">
									<button type="button"
										class="btn btn-default discount-btn adschedule"
										value="<?= $account['account_number']; ?>">AdSchedule</button>
								</div>
								<div class="col-md-2 col-sm-2">
									<button type="button"
										class="btn btn-default discount-btn addaudience"
										value="<?= $account['account_number']; ?>">Add Audience</button>
								</div>
								<div class="col-md-6 col-sm-6 text-right">
									<div id="customer_{{account.customer_id}}"
										class="customer_id_lable">
										<span class="label label-success"
											style="color: #fff; font-size: 11px;"><?= $account['name']; ?></span>
									</div>
									<div class="customer_id"><?= $account['account_number']; ?>
                        <a class="customer_lable"
											id="customer_id_<?= $account['account_number']; ?><?= $account['account_number']; ?>"
											data-id="{{account.customer_id}}"
											data-name="{{account.label}}"> <i style="color: #8C8C8C;"
											class="fa fa-cog fa-2x faa-spin animated-hover"> </i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
        <?php
            }
        }
        ?>
          <div class="inner-box">
					<center>
						<a href="/accounts">
							<button type="button" class="btn btn-default discount-btn2">Manage
								Your Adword Accounts</button>
						</a>
						<!-- <a href="/label_account">
              <button type="button" class="btn btn-default discount-btn2">Connect Lable Accounts </button>
              </a> -->
					</center>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="container">
			<div class="modal fade" id="myModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content modal-activity-box">
						<div class="modal-body">
							<div class="row">
								<div class="col-md-5">
									<p>
										Campaigns Created:<span class="budget" id="campaign_no_create">0</span>
									</p>
									<p>
										Campaigns Updated:<span class="budget" id="campaign_no_update">0</span>
									</p>
									<p>
										Adgroups Created:<span class="budget" id="adgroup_no_create">0</span>
									</p>
									<p>
										Adgroups Updated:<span class="budget" id="adgroup_no_updated">0</span>
									</p>
									<p>
										Ads Created:<span class="budget" id="ads_no_created">0</span>
									</p>
									<p>
										<span><a href="" id="import_validation">Import validation with
												status</a></span>
								</div>
								<div class="col-md-7">
									<div class="activity-box">
										<div class="activity-content"></div>
										<div class="function-btn">
											<button type="button" class="btn btn-default activity-btn"
												id="start_upload">Start</button>
											<button type="button" class="btn btn-default activity-btn"
												id="revert">Revert</button>
											<!-- <button type="button" class="btn btn-default activity-btn">Pause</button> -->
											<button type="button" class="btn btn-default activity-btn"
												id="enable">Enable</button>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<form class="dropzone" id="upload" action="fileUploader.php"
									method="POST" enctype="multipart/form-data">
									<div class="drag-file fallback" id="bob">
										<h3>Drag And Drop File</h3>
										
										<div class="fallback">
											<input type="hidden" name='id' id="account_id"> <input
												type="hidden" name='customerid' id='account_customerid'> <input
												name="file" type="file">
										</div>
									</div>
									<div style="height: 0px; width: 0px;">
										<input style="height: 0px; width: 0px;" type="hidden"
											name="IHAccountId" id="IHAccountId" value="0" /> <input
											type="hidden" name="location" value="1" />
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="AdModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content modal-activity-box">
						<div class="modal-body">
							<div class="row" style="margin: 10px 0px;">
								<div class="col-md-12">
									<a href="schedule/AdScheduleTestDoc.xlsx"
										style="text-decoration: underline;">Download Sample CSV</a>
								</div>
							</div>
							<div class="row" style="margin: 10px 0px;">
								<div class="col-md-12">
									<a href="javascript:downloadCampaign()"
										style="text-decoration: underline;">Download Campaign List</a>
									<input type="hidden" id="adschedule_account" value="0" />
								</div>
							</div>
							<div class="row" style="margin: 10px 0px;">
								<div class="col-md-12">
									<div class="activity-content"></div>
								</div>
							</div>
                                                    <div class="row" style="margin: 10px 0px;">
								<div class="col-md-12">
                                                                    <div id="schedule_status"></div>
								</div>
							</div>
							<div class="row">
								<form class="dropzone" id="upload" action="fileUploader.php"
									method="POST" enctype="multipart/form-data">
									<div class="drag-file fallback" id="bob">
										<h3>Drag And Drop File</h3>
										
										<div class="fallback">
											<input type="hidden" name='id' id="account_id"> <input
												type="hidden" name='customerid' id='account_customerid'> <input
												name="file" type="file">
										</div>
									</div>
									<div style="height: 0px; width: 0px;">
										<input style="height: 0px; width: 0px;" type="hidden"
											name="IHAccountId" id="IHAccountIdAd" value="0" /> <input
											type="hidden" name="location" value="2" />
									</div>
								</form>
							</div>
							<div class="row">
								<div class="col-md-7"></div>
								<div class="col-md-5">
									<button type="button" class="btn btn-default activity-btn"
										id="upload_start">Start</button>
									<button type="button" class="btn btn-default activity-btn"
										id="close">Close</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="AudienceModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content modal-activity-box">
						<div class="modal-body">
							<div class="row" style="margin: 10px 0px;">
								<div class="col-md-12">
									<a href="javascript:downloadAudience()"
										style="text-decoration: underline;">Download Sample Audience sheet</a>
										<input type="hidden" id="audience_account" value="0" />
								</div>
							</div>
							<div class="row hidden" style="margin: 10px 0px;">
								<div class="col-md-12">
									<a href=""
										style="text-decoration: underline;">Download Campaign List</a>
									
								</div>
							</div>
							<div class="row" style="margin: 10px 0px;">
								<div class="col-md-12">
									<div class="activity-content"></div>
								</div>
							</div>
                                                    <div class="row" style="margin: 10px 0px;">
								<div class="col-md-12">
                                                                    <div id="audience_status"></div>
								</div>
							</div>
							<div class="row">
								<form class="dropzone" id="upload" action="fileUploader.php"
									method="POST" enctype="multipart/form-data">
									<div class="drag-file fallback" id="bob">
										<h3>Drag And Drop File</h3>
										
										<div class="fallback">
											<input type="hidden" name='id' id="account_id"> <input
												type="hidden" name='customerid' id='account_customerid'> <input
												name="file" type="file">
										</div>
									</div>
									<div style="height: 0px; width: 0px;">
										<input style="height: 0px; width: 0px;" type="hidden"
											name="IHAccountId" id="IHAccountIdAud" value="0" /> <input
											type="hidden" name="location" value="3" />
									</div>
								</form>
							</div>
							<div class="row">
								<div class="col-md-7"></div>
								<div class="col-md-5">
									<button type="button" class="btn btn-default activity-btn"
										id="upload_start_aud">Start</button>
									<button type="button" class="btn btn-default activity-btn"
										id="close">Close</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="accountModel" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content modal-activity-box">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"
								aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title"> Label Account</h4>
						</div>
						<div class="modal-body">
							<form id="account_form">
								
								<div class="form-group">
									<label for="customer_id">Customer Id</label> <input type="text"
										class="form-control" id="customer_id_field" disabled> <input
										type="hidden" name="customer_id_field" id="customer_id_field1">
								</div>
								<div class="form-group">
									<label for="cusotomer_lable">Account Name</label> <input
										type="text" class="form-control" id="customer_id_lable1"
										name="customer_id_lable">
								</div>
								<button type="button" class="btn btn-default" id="submit_lable">Submit</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		</div>
	</section>
	<script type="text/javascript">
        
//         var myDropzone = new Dropzone("#upload");
//         myDropzone.

	 $(document).ready(function(){
		 $("#whosaccount").change(function(){
		 	$("#change_account").submit();
		 });
	 });
	Dropzone.options.upload = {
			  init: function() {
			    this.on("success", function(file) { this.removeFile(file);$(".activity-content").html($(".activity-content").html()+"<br>File is uploaded..."); });
			  }
			};
	
function downloadCampaign()
    {
       var account = document.getElementById("adschedule_account").value;
       window.open('omnitail/cron/downloadCampaignsCsv.php?master=<?php echo $whosaccount;?>&account='+account,"_blank");
    }
function downloadAudience()
{
	var account = document.getElementById("audience_account").value;
    window.open('audience_sample.php?accountid='+account,"_blank");
}
    $( "#enable" ).click(function ( e ) {
        var accountId = $("#IHAccountId").val();
        if(accountId == "0"){
            $(".activity-content").html($(".activity-content").html()+"<br>Please select an account first...");
            return false;
        }
        $(".activity-content").html("Please wait while enabling ads...");
        $("#start_upload").attr("disabled", true);
        $("#revert").attr("disabled", true);
        $("#enable").attr("disabled", true);
        $.ajax({
            url: 'activateShoppingCampaign.php?status=activate&accountId='+accountId,
            dataType: 'text',
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){
                $(".activity-content").html(data);
                $("#start_upload").attr("disabled", false);
                $("#revert").attr("disabled", false);
                $("#enable").attr("disabled", false);
            }
        });
    });
    $(".create_ads").click(function(){
        $("#campaign_no_create").html("0");
        $("#campaign_no_update").html("0");
        $("#adgroup_no_create").html("0");
        $("#adgroup_no_updated").html("0");
        $("#ads_no_created").html("0");
        $("#IHAccountId").val($(this).data('customerid'));
        $(".activity-content").html("Please wait...");
        $("#start_upload").attr("disabled", true);
        $("#revert").attr("disabled", true);
        $("#enable").attr("disabled", true);
        var accountId = $(this).val();
        $.ajax({
            url: 'updateStatus.php?account='+accountId,
            dataType: 'json',
            processData: false,
            contentType: false,
            type: 'GET',
            success: function(data){
                if(data.errorStatus == "0"){
                    $(".activity-content").html(data.errorMessage);
                    $("#import_validation").attr("href","#");
                }else{
                    $("#campaign_no_create").html(data.campaignCreated);
                    $("#campaign_no_update").html(data.campaignUpdated);
                    $("#adgroup_no_create").html(data.adgroupCreated);
                    $("#adgroup_no_updated").html(data.adgroupUpdated);
                    $("#ads_no_created").html(data.productGroupCount);
                    $("#import_validation").attr("href","statusFile.php?account="+accountId);
                    $("#import_validation").html("Import validation with status on "+data.uploadFinished);
                    if(data.isUploadFinished == "1"){
                        $(".activity-content").html("Previous upload is processed completely.");
                        $("#start_upload").attr("disabled", false);
                        $("#revert").attr("disabled", false);
                        $("#enable").attr("disabled", false);
                    }else{
                        $(".activity-content").html("Previous upload is not completed. Download current status from the provided link.");
                        $("#start_upload").attr("disabled", false);
                        $("#revert").attr("disabled", false);
                        $("#enable").attr("disabled", false);
                    }
                }
                
            }
        });
        $("#myModal").modal('show');
    });


    
    //schedule modal loading
    $(".adschedule").click(function(){
    	$(".activity-content").html("Please wait till we get last uploaded result...");
    	$("#AdModal").modal('show');
    	$("#adschedule_account").val($(this).val());
    	$("#IHAccountIdAd").val($(this).val());
    	//$("#upload_start").attr("disabled", true);
        var accountId = $(this).val();
        $.ajax({
        url: 'updateStatus.php?location=2&account='+$(this).val(),
        dataType: 'json',
        processData: false,
        contentType: false,
        type: 'GET',
        success: function(data){
            if(data.isUploadFinished == "1"){
                $(".activity-content").html("Last import of schedules was successfully completed at "+data.uploadFinished);
                $(".activity-content").append("<br><a href='adSchedulingStatusFile.php?account="+accountId+"' >Last uploaded schedule status</a>");
            }else if(data.isUploadFinished==null){
                $(".activity-content").html("Previous upload is not available.");
            }else{
                $(".activity-content").html("Previous upload is not completed.");
                $(".activity-content").append("<br><a href='adSchedulingStatusFile.php?account="+accountId+"' >Last uploaded schedule status</a>");
            }
        }
        });
        
        // start ads scheduling
    	$("#upload_start").click(function(){
    	    var accountId = $("#IHAccountIdAd").val();
            if(accountId == "0"){
                $(".activity-content").html($(".activity-content").html()+"<br>Please select an account first...");
                return false;
            }
            $.ajax({
                url: 'populateAdSchedule.php?accountId='+accountId,
                dataType: 'text',
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data){
                    $(".activity-content").html(data);
                    $(".activity-content").append("<br><a href='adSchedulingStatusFile.php?account="+accountId+"' >Uploaded schedule status</a>");
                },
                error: function (request, status, error) {
                    $(".activity-content").append("<br>"+request.responseText);
                }
            });
        	});
        });
    $("#close").click(function(){
$("#AdModal").modal('hide');
        });
    //schedule modal ends
    $( "#start_upload" ).click(function ( e ) {
        var accountId = $("#IHAccountId").val();
        if(accountId == "0"){
            $(".activity-content").html($(".activity-content").html()+"<br>Please select an account first...");
            return false;
        }
//        myDropzone.processQueue();
        $(".activity-content").html(" Started ...");
        $("#start_upload").attr("disabled", true);
        $("#revert").attr("disabled", true);
        $("#enable").attr("disabled", true);
        $.ajax({
            url: 'populateRows.php?accountId='+accountId,
            dataType: 'text',
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){
                $(".activity-content").html($(".activity-content").html()+"<br>"+data);
                $("#start_upload").attr("disabled", false);
                $("#revert").attr("disabled", false);
                $("#enable").attr("disabled", false);
            }
        });
    });

    //audience modal loading
    $(".addaudience").click(function(){
    	$(".activity-content").html("Please wait till we get last uploaded result...");
    	$("#AudienceModal").modal('show');
    	$("#audience_account").val($(this).val());
    	$("#IHAccountIdAud").val($(this).val());
    	//$("#upload_start").attr("disabled", true);
        var accountId = $(this).val();
        $.ajax({
        url: 'updateStatus.php?location=3&account='+$(this).val(),
        dataType: 'json',
        processData: false,
        contentType: false,
        type: 'GET',
        success: function(data){
            if(data.isUploadFinished == "1"){
                $(".activity-content").html("Last import of audiences was successfully completed at "+data.uploadFinished);
                $(".activity-content").append("<br><a href='audienceStatusFile.php?account="+accountId+"' >Last uploaded schedule status</a>");
            }else if(data.isUploadFinished==null){
                $(".activity-content").html("Previous upload is not available.");
            }else{
                $(".activity-content").html("Previous upload is not completed.");
                $(".activity-content").append("<br><a href='audienceStatusFile.php?account="+accountId+"' >Last uploaded schedule status</a>");
            }
        }
        });
        
        // start adding audience
    	$("#upload_start_aud").click(function(){
    	    var accountId = $("#IHAccountIdAud").val();
            if(accountId == "0"){
                $(".activity-content").html($(".activity-content").html()+"<br>Please select an account first...");
                return false;
            }
            $.ajax({
                url: 'populateAddAudience.php?accountId='+accountId,
                dataType: 'text',
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data){
                    $(".activity-content").html(data);
                    $(".activity-content").append("<br><a href='adSchedulingStatusFile.php?account="+accountId+"' >Uploaded schedule status</a>");
                },
                error: function (request, status, error) {
                    $(".activity-content").append("<br>"+request.responseText);
                }
            });
        	});
        });
    $("#close").click(function(){
$("#AudienceModal").modal('hide');
        });
    //audience modal ends
    </script>
</body>
</html>
