<?php 
include_once './Classes/DatabaseHelper.php';
include_once './Classes/AppConstants.php';
include_once './shoppingCampaignHelper.php';
require_once dirname(__FILE__) .'/examples/AdWords/v201509/init.php';
if(!isset($_SESSION)){
    session_start();
}
$objDB = new DbHelper();
$objAdsHelper = new shoppingCampaignHelper(array());
$accounts = $objDB->getAllAccounts();
if(!isset($_SESSION['status']) || $_SESSION['status']!='loggedin')
{
	header('location:index.php');
}
?>
<!DOCTYPE HTML>
{% load poll_extras %}
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
  </head>
  <body>
    <header style ="background-color:white">
      <div class="row ">
      <div class="logo col-md-6">
        <img src="static/img/logo.png" style="width:250px;">
      </div>
      <div class="navagation col-md-6">
        <div class="col-md-10">
          <a href="account.php"><button class="pull-right btn btn-default">Accounts</button></a>
        </div>
          <a type="button" class="btn btn-default"  href="logout.php" class="logout">Logout</a>
      </div>
      </div>
    </header>
    <section>
      <div class="container" >
        <h5 class="account">Customers Accounts:</h5>
        <div class="box" style ="background-color:white">
        <?php
        if(is_array($accounts)){
            foreach ($accounts as $account){
                $accountId = $account['account_number'];
                $campaigns = $objDB->getCampaignsFromDB($accountId);
                $user = new AdWordsUser();
                $user->SetClientCustomerId($accountId);
                $productGroupCount = 0;
                $totalBudget = 0;
                /*
                foreach ($campaigns as $campaign){
                    if($campaign->type == 'SHOPPING'){
                        $adgroups = $objDB->getAdgroupsFromDB($campaign->campaignid);
                        foreach ($adgroups as $adgroup){
                            $criterion = $objAdsHelper->GetAdgroupCritrion($user, $adgroup->adgroupid);
                            $productGroupCount = $productGroupCount + ((count($criterion)-1)/2);
                        }
                        
                    }
                }
                $totalBudget = $objAdsHelper->getTotalBudget($user);
                */
                
                
            
         
         ?>
          <div class="inner-box">
            <div class="row">
              <div class="col-md-8 col-sm-8">
                <ul class="account-list" id="account_{{account.customer_id}}">
                  <li>Campaigns:<span><?= $account['campaign_count']; ?></span></li>
                  <li>AdGroups:<span><?= $account['adgroup_count']; ?></span></li>
                  <li>Ads:<span><?= $productGroupCount; ?></span></li>
                  <!--<li>Ads:<span>{{account.ads}}</span></li>-->
                  <li>Budget:$<span><?= $totalBudget;?></span></li>
                  <!--<li>Budget:$<span>{{account.budget}}</span></li>-->
                </ul>
              </div>
              <div class="col-md-4 col-sm-4">
              	<button type="button" class="btn btn-default discount-btn create_ad"
                data-id="{{account.id}}" data-customerid="<?= $account['account_number']; ?>" value="<?= $account['account_number']; ?>">Create Ads</button>
                <!-- <a href="/?id={{account.id}}"><button type="button" class="btn btn-default discount-btn">Disconnect</button></a> -->
                <div id="customer_{{account.customer_id}}" class="customer_id_lable"><span class="label label-success" style="color:#fff;font-size:11px;"><?= $account['name']; ?></span></div>
              </div>
              <div class="customer_id"><?= $account['account_number']; ?>
                <a class="customer_lable" id="customer_id_<?= $account['account_number']; ?><?= $account['account_number']; ?>" data-id="{{account.customer_id}}" data-name="{{account.label}}" >
                  <i style="color: #8C8C8C;" class="fa fa-cog fa-2x faa-spin animated-hover">
                  </i>
                </a>
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
              <button type="button" class="btn btn-default discount-btn2">Manage Your Adword Accounts</button>
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
                    <p>Campaigns Created:<span class="budget" id="campaign_no_create">0</span></p>
                    <p>Campaigns Updated:<span class="budget" id="campaign_no_update">0</span></p>
                    <p>Adgroups Created:<span class="budget" id="adgroup_no_create">0</span></p>
                    <p>Adgroups Updated:<span class="budget" id="adgroup_no_updated">0</span></p>
                    <p>Ads Created:<span class="budget" id="ads_no_created">0</span></p>
                    <p><span><a href="" id="import_validation">Import validation with status</a></span>
                  </div>
                  <div class="col-md-7">
                    <div class="activity-box">
                    <div class="activity-content"></div>
                    <div class="function-btn">
                      <button type="button" class="btn btn-default activity-btn" id="start_upload">Start</button>
                      <button type="button" class="btn btn-default activity-btn" id="revert">Revert</button>
                      <!-- <button type="button" class="btn btn-default activity-btn">Pause</button> -->
                      <button type="button" class="btn btn-default activity-btn" id="enable">Enable</button>
                    </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                    <form class="dropzone" id="upload" action="fileUploader.php" method="POST" enctype="multipart/form-data">
                  <div class="drag-file fallback" id="bob"><h3>Drag And Drop File</h3>
                      
                      {% csrf_token %}
                      <div class="fallback">
                      <input type="hidden" name='id' id="account_id">
                      <input type="hidden" name='customerid' id='account_customerid'>
                      <input name="file" type="file">
                      </div>
                    
                  </div>
                        <div style="height: 0px;width: 0px;">
                            <input style="height: 0px;width: 0px;" type="hidden" name="IHAccountId" id="IHAccountId" value="0" />
                        </div>
                        </form>
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
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"Label Account</h4>
            </div>
              <div class="modal-body">
                <form id="account_form">
                  {% csrf_token %}
                  <div class="form-group">
                    <label for="customer_id">Customer Id</label>
                    <input type="text" class="form-control" id="customer_id_field"
                    disabled>
                    <input type="hidden" name="customer_id_field" id="customer_id_field1">
                  </div>
                  <div class="form-group">
                    <label for="cusotomer_lable">Account Name</label>
                    <input type="text" class="form-control" id="customer_id_lable1" name="customer_id_lable">
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
        
        /*
      $( "#start_upload" ).click(function ( e ) {
        if ($('input[type=file]').val()!=""){
          $(".activity-content").html(" Started ...");
          $("#start_upload").attr("disabled", true);
          $("#revert").attr("disabled", true);
          $("#enable").attr("disabled", true);
          var filename = $('input[type=file]')[0].value;
          var id =$("#account_id").val();
          var customerid = $("#account_customerid").val();
          var reader = new FileReader();
          reader.onload = function (e) {
            var rows = e.target.result.split("\n");
            rows = rows.filter(function(n){ return n.split(",")[0] != ""});
            error_arr = myFunction(id,customerid,filename,rows,[],"");
            array = myFunction(id,customerid,filename,error_arr[0],error_arr[1],"working in error rows ");
            if (array.length>0){
              alert("Error in array :" + array)
            }
            $("#start_upload").removeAttr("disabled");
            $("#revert").removeAttr("disabled");
            $("#enable").removeAttr("disabled");
           }
          reader.readAsText($('input[type=file]')[0].files[0]);
        }else{
          alert("Please Choose a CSV file")
        }
      });
      function myFunction(id,customerid,filename,rows,rows1,msg) {
        var error_arr = new Array();
        var error_rows = new Array()
        var camp = "";
        data_row = {};
        for (var i = 0; i < rows.length; i++) {
          camp+=rows[i+1]
          data_row = { camp:camp,id:id,customerid:customerid,filename:filename};
          if((i+1)%5==0){
            camp=""
            $.ajax({
                  type: "GET",
                  url: "/create_camapign/",
                  async: false,
                  cache: false,
                  data: data_row
              })
            .success(function( data ) {
              if (data.error != ""){
                for (j = i-3;j<i+2 ; j++){
                  if (rows1.length>0){
                    error_rows.push(rows1[j+1])
                  }else{
                    error_rows.push(j+1)
                    error_arr.push(rows[j+1])
                  }
                }
                alert(data.error);
              }else{
              $("#campaign_no_create").html(data.campaigns_created);
              $("#campaign_no_update").html(data.campaigns_updated);
              $("#adgroup_no_create").html(data.adgroup_created);
              $("#ads_no_created").html(data.adgroup_created);
              }
              if (msg.length>1){
              if (i+2<(rows.length-1)){
                $(".activity-content").html(data.campaigns_created + " Campaigns Created "+data.adgroup_created+" Adgroups Created </br> "+msg);
              }else{
                $(".activity-content").html(data.campaigns_created + " Campaigns Created "+data.adgroup_created+" Adgroups Created ");
              }
            }else{
              if (i+2<(rows.length-1)){
                $(".activity-content").html(data.campaigns_created + " Campaigns Created "+data.adgroup_created+" Adgroups Created </br> Workign on row "+(i+3)+"/"+(rows.length));
              }else{
                $(".activity-content").html(data.campaigns_created + " Campaigns Created "+data.adgroup_created+" Adgroups Created ");
              }
            }
            });
          }
          if (i+2 < rows.length){
            if (camp!=""){
              camp+=";";
            }
          }else{
              $.ajax({
                  type: "GET",
                  url: "/create_camapign/",
                  async: false,
                  cache: false,
                  data: data_row
              })
            .success(function( data ) {
              if (data.error != ""){
                for (j = i-3;j<i+2 ; j++){
                  if (rows1.length>0){
                    error_rows.push(rows1[j+1])
                  }else{
                    error_rows.push(j+1)
                    error_arr.push(rows[j+1])
                  }
                }
              }else{
              $(".activity-content").html(data.campaigns_created + " Campaigns Created "+data.adgroup_created+" Adgroups Created");
              $("#campaign_no_create").html(data.campaigns_created);
              $("#campaign_no_update").html(data.campaigns_updated);
              $("#adgroup_no_create").html(data.adgroup_created);
              $("#ads_no_created").html(data.adgroup_created);
              }
            });
            break;
          }
        }
        if (msg.length>1){
          return error_rows;
        }else{
          return [error_arr, error_rows];
      }
      }
      $( "#enable" ).click(function ( e ) {
        var data = new FormData($("#upload")[0]);
        if ($('input[type=file]').val()!=""){
          $(".activity-content").html(" Enabeling ads");
          $("#start_upload").attr("disabled", true);
          $("#revert").attr("disabled", true);
          $("#enable").attr("disabled", true);
          $.ajax({
            url: '/enable_camapign/',
            data: data,
            processData: false,
            contentType: false,
            type: 'POST'
          })
          setTimeout(function(){
            $(".activity-content").html("All ads enabled");
            $("#start_upload").removeAttr("disabled");
            $("#revert").removeAttr("disabled");
            $("#enable").removeAttr("disabled");
          }, 120000);
        }else{
          alert("Please Choose a CSV file")
        }
      });
      $( "#revert" ).click(function ( e ) {
        var data = new FormData($("#upload")[0]);
        if ($('input[type=file]').val()!=""){
          $(".activity-content").html(" Reverting Changes ");
          $("#start_upload").attr("disabled", true);
          $("#revert").attr("disabled", true);
          $("#enable").attr("disabled", true);
          $.ajax({
            url: '/revert_camapign/',
            data: data,
            processData: false,
            contentType: false,
            type: 'POST',
          })
          setTimeout(function(){
            alert("All changes Revert")
            $("#start_upload").removeAttr("disabled");
            $("#revert").removeAttr("disabled");
            $("#enable").removeAttr("disabled");
            location.reload();
          }, 120000);
        }else{
          alert("Please Choose a CSV file")
        }
      });
      $(".create_ad").click(function(){
        id = $(this).data('id');
        customerid = $(this).data('customerid');
        $("#account_id").val(id);
        $("#account_customerid").val(customerid);
        $(".activity-content").html("");
        $('input[type=file]').val("")
        $("#myModal").modal('show');
      })
      $(".customer_lable").click(function(){
        id = $(this).data('id');
        name = $(this).data('name');
        $("#customer_id_field").val(id);
        $("#customer_id_field1").val(id);
        $("#customer_id_lable1").val(name);
        $("#accountModel").modal("show");
      })
      $( "#submit_lable" ).click(function ( e ) {
        var data = new FormData($("#account_form")[0]);
        $.ajax({
          url: '/label_account/',
          data: data,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function(data){
            $("#customer_"+data.id).html(data.name);
            $("#customer_id_"+data.id).data('name',data.name);
            $("#accountModel").modal("hide");
          }
        })
      });
      
      */
//         var myDropzone = new Dropzone("#upload");
//         myDropzone.
         
         
         
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
    
    $(".create_ad").click(function(){
        $("#IHAccountId").val($(this).data('customerid'));
        $(".activity-content").html("Please wait...");
        $("#start_upload").attr("disabled", true);
        $("#revert").attr("disabled", true);
        $("#enable").attr("disabled", true);
        $.ajax({
            url: 'updateStatus.php?account='+$(this).val(),
            dataType: 'json',
            processData: false,
            contentType: false,
            type: 'GET',
            success: function(data){
//                alert(data.uploadFinished);
                $(".activity-content").html("");
                $("#campaign_no_create").html(data.campaignCreated);
                $("#campaign_no_update").html(data.campaignUpdated);
                $("#adgroup_no_create").html(data.adgroupCreated);
                $("#adgroup_no_updated").html(data.adgroupUpdated);
                $("#ads_no_created").html(data.productGroupCount);
               
                $("#import_validation").attr("href",data.upload_name);
              
      		    $("#import_validation").html("Import validation with status on "+data.uploadFinished);
      		   
                    if('0000-00-00 00:00:00' != data.uploadFinished){
                    $("#start_upload").attr("disabled", false);
                    $("#revert").attr("disabled", false);
                    $("#enable").attr("disabled", false);
                }else{
                    $("#start_upload").attr("disabled", false);
                    $("#revert").attr("disabled", false);
                    $("#enable").attr("disabled", false);
                }
            }
        });
        $("#myModal").modal('show');
    });
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

    </script>
  </body>
</html>
