<?php 
include 'functions.php';

if(!isset($_SESSION['status']) || $_SESSION['status']!='loggedin')
{
	header('location:index.php');
}
$whosaccount = isset($_REQUEST['whosaccount'])?$_REQUEST['whosaccount']:$master_account;
?>
<!DOCTYPE HTML>
{% load poll_extras %}
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>SKU Tools</title>

<link rel="stylesheet" href="static/css/bootstrap.min.css">
<link rel="stylesheet" href="static/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="static/css/style.css">
<script src="static/js/bootstraps/jquery.js"></script>
<script src="static/js/bootstraps/bootstrap.min.js"></script>
<script src="static/js/dropzone.js"></script>
<link rel="stylesheet" type="text/css" href="static/css/dropzone.css">
    <script>
    //setTimezone("America/Detroit");


    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    }); 
    $(document).ready(function(){
$("#whosaccount").change(function(){
	$("#change_account").submit();
});
        });

    
    </script>
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
            <a href="home.php"><button class="btn btn-default">Dashboard</button></a>
        </div>
        <div>
            <a href="account.php"><button class="btn btn-default">Accounts</button></a>
        </div>
          <div>
        <?php if($_SESSION['user_type']==1){ ?> 
              <a href="users/users.php"><button class=" btn btn-default">Users</button></a> <?php } ?>
          </div>
          <div>
          <a href="logout.php"><button class=" btn btn-default">Logout</button></a>
          
          </a></div></div>
      </div>
      </div>
    </header>
    <section>
      <div class="container"  >
      <div class="row">
      <div class="col-md-2">
       <h5 class="account" >Connected Accounts : </h5>
      
      </div>
      <div class="col-md-5">
      <form action="account.php" id="change_account" method="get">
      <select  class="form-control account"  name="whosaccount" id="whosaccount" style="margin-top:35px;">
      <?php foreach (get_mcc_accounts() as $account):?>
       <option <?php echo $account->account_number==$whosaccount?'selected':'';?> value="<?php echo $account->account_number;?>"><?php echo ucfirst($account->account_name==''?$account->name:$account->account_name)." (".$account->account_number.")";?></option>
       <?php endforeach;?>
     
      </select>
      </form>
      </div>
      
      
      </div>
       
        <div class="box" style ="background-color:#fff;">
        <!--  {% for account in user.google_accounts_set.all %} -->
         <?php 
if(count(get_account_details($whosaccount))>0){
         foreach(get_account_details($whosaccount) as $account):?>
          <div class="inner-box">
            <div class="row">
              <div class="col-md-6 col-sm-6">
             
                <ul class="account-list">
                  <li style="white-space: nowrap;"><!-- <input type="checkbox" class="active" value="<?php echo $account->account_number;?>"  <?php echo $account->status==1?"checked":"unchecked"; ?> style="margin-right: 10px;"  data-toggle="tooltip" title="Account Status : <?php echo $account->status==1?"Active":"Inactive"; ?>"  data-placement="right"   /> -->Google Account:</li>
                  <li style="white-space: nowrap;"><span><?php echo $account->name.' ('.$account->account_number.')';?></span></li>
                 
                </ul>
                
              </div>
              <div class="col-md-6 col-sm-6">
              
                <button type="button" value="<?php echo $account->account_number;?>" class="btn btn-default discount-btn create_ads">Create Ads</button>
                
                
            
              </div>
              <!-- <div class="customer_id">{{account.customer_id}}
                <a class="customer_lable" id="customer_id_{{account.customer_id}}" data-id="{{account.customer_id}}" data-name="{{account.label}}" >
                  <i style="color: #8C8C8C;" class="fa fa-cog fa-2x faa-spin animated-hover">
                  </i>
                </a>
              </div> -->

            </div>
          </div>
          
          <?php endforeach;
?>
<div class="inner-box">
          <div id="tester"></div>
            <center>
              <a href="#" >
              <button type="button" class="btn btn-default discount-btn2" >Connect New Adword Account Now</button>
              </a>
              <!-- <a href="/label_account">
              <button type="button" class="btn btn-default discount-btn2">Connect Lable Accounts </button>
              </a> -->
            </center>
          </div>
<?php 
}
          else
          {?>
              <div class="inner-box">
              <div class="row">
              <div class="col-md-12 col-sm-12" style="text-align: center;">
             
                              <h3>Please check back after some time.</h3>
                            </div>
                           
                        </div>
       <?php    }?>
          
        </div>
      </div>
    </section>
    
    <div class="modal fade" id="AdModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content modal-activity-box">
						<div class="modal-body">
							<div class="row" style="margin: 10px 0px;">
								<div class="col-md-12">
									<h4>Expanded Text Ads</h4>
								</div>
							</div>
							<div class="row" style="margin: 10px 0px;">
								<div class="col-md-12">
									
									<input type="hidden" id="eta_account" value="0" />
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
											type="hidden" name="location" value="4" />
									</div>
								</form>
							</div>
							<div class="row">
								<div class="col-md-7"></div>
								<div class="col-md-5">
									<button type="button" class="btn btn-default activity-btn"
										id="upload_start" disabled="disabled">Start</button>
									<button type="button" class="btn btn-default activity-btn"
										id="close">Close</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script type="text/javascript">
			Dropzone.options.upload = {
					  init: function() {
					    this.on("success", function(file) { this.removeFile(file);
$("#upload_start").removeAttr("disabled");
					    $(".activity-content").html($(".activity-content").html()+"<br>File is uploaded..."); });
					  }
					};
$(document).ready(function(){
// 	$(".create_ads").click(function(){
// $("#AdModal").modal('show');
// 		});
	$(".create_ads").click(function(){
    	$(".activity-content").html("Please wait till we get last uploaded result...");
    	$("#AdModal").modal('show');
    	$("#eta_account").val($(this).val());
    	$("#IHAccountIdAd").val($(this).val());
    	//$("#upload_start").attr("disabled", true);
        var accountId = $(this).val();
        $.ajax({
        url: 'updateStatus.php?location=4&account='+$(this).val(),
        dataType: 'json',
        processData: false,
        contentType: false,
        type: 'GET',
        success: function(data){
            if(data.isUploadFinished == "1"){
                $(".activity-content").html("Last import of audiences was successfully completed at "+data.uploadFinished);
                $(".activity-content").append("<br><a href='expanded_ads_status.php?account="+accountId+"' >Last uploaded file status</a>");
            }else if(data.isUploadFinished==null){
                $(".activity-content").html("Previous upload is not available.");
            }else{
                $(".activity-content").html("Previous upload is not completed.");
                $(".activity-content").append("<br><a href='expanded_ads_status.php?account="+accountId+"' >Last uploaded file status</a>");
            }
        }
        });
        
        // start adding audience
    	$("#upload_start").click(function(){
    	    var accountId = $("#IHAccountIdAd").val();
            if(accountId == "0"){
                $(".activity-content").html($(".activity-content").html()+"<br>Please select an account first...");
                return false;
            }
            $.ajax({
                url: 'populateETAds.php?accountId='+accountId,
                dataType: 'text',
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data){
                    $(".activity-content").html(data);
                    $(".activity-content").append("<br><a href='expanded_ads_status.php?account="+accountId+"' >Uploaded file status</a>");
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
	
});
			</script>
    
  </body>
</html>

