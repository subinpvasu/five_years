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
    <title>Account</title>
    <link rel="stylesheet" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="static/css/style.css">
    <script src="static/js/bootstraps/jquery.js"></script>
    <script src="static/js/bootstraps/bootstrap.min.js"></script>
    <script>
    //setTimezone("America/Detroit");
$(document).ready(function(){
	 $.ajax({
		 url: "processor.php",
		type:'post',
		data:{
			previous:1
			  
		},
		  success: function(result){
			  var obj = JSON.parse(result);


var tmp='';
for(var i=0;i<obj.length;i++)
{
	$(".datadown").each(function(){
		if($(this).attr("name")==obj[i].id && obj[i].shop==0)
		{
		$(this).removeClass("hidden");

		var date = new Date(obj[i].tm*1000);
		var hours = date.getHours();			
		var minutes = "0" + date.getMinutes();			
		var seconds = "0" + date.getSeconds();			
		var formattedTime = date.getMonth()+1+'/'+date.getDate()+'/'+date.getFullYear()+' '+hours + ':' + minutes.substr(-2);

		$(this).html("Bid strategy generated on - "+formattedTime);
		$(this).attr("href", "omnitail/cron/tmp/"+obj[i].file);
		}
	}); 

	$(".dataup").each(function(){
		if($(this).attr("name")==obj[i].id && obj[i].shop==1)
		{
			
		$(this).removeClass("hidden");

		var date = new Date(obj[i].tm*1000);
		var hours = date.getHours();			
		var minutes = "0" + date.getMinutes();			
		var seconds = "0" + date.getSeconds();			
		var formattedTime = date.getMonth()+1+'/'+date.getDate()+'/'+date.getFullYear()+' '+hours + ':' + minutes.substr(-2);

		$(this).html("Bid strategy (Shopping) on - "+formattedTime);//<span class='glyphicon glyphicon-download-alt'></span>
		$(this).attr("href", "omnitail/cron/tmp/"+obj[i].file);
		}
	}); 


	
	
}


			  
			  }
	 });
	
});




    
    $(document).ready(function(){
$(".downbid").click(function(){
	$(this).text("Downloading...");
	/* $(".downbid").prop('disabled', true);
	$(".datadown").prop('disabled', true); */
	var number=$(this).val();
	var avail = false;
	 $.ajax({
		 url: "downloadSimulations.php",
		type:'post',
		data:{
			account:number,
			master:<?php echo $whosaccount;?>
			  
		},
		  success: function(result){
			  /* $.ajax({
					 url: "processor.php",
					type:'post',
					data:{
						status:'yes',
						account:number
					},
					  success: function(result){
						 
						  var obj = JSON.parse(result);
						  var tmp='';
						  for(var i=0;i<obj.length;i++)
						  {
						  if(obj[i].result>0)
						  {
							  if(obj[i].shop==0)
							  {
							  $(".datadown").each(function(){
									if($(this).attr("name")==number)
									{
										$(this).removeClass("hidden");
										$(this).text("Bid strategy generated on - "+obj[i].datestring);
										$(this).attr("href", obj[i].url);
										avail=true;
									}
								});
							  }
							  if(obj[i].shop==1)
							  {
								  $(".dataup").each(function(){
										if($(this).attr("name")==number)
										{
											$(this).removeClass("hidden");
											$(this).text("Bid strategy (Shopping) on - "+obj[i].datestring);
											$(this).attr("href", obj[i].url);
											avail=true;
										}
									});
							  }
							 if(obj[i].shop>=0)
							 {
												  
								$(".downbid").each(function(){
									if($(this).val()==number)
									{
										$(this).text("Generate Bid Strategy");
										//$(this).addClass("hidden");
										/* $(".downbid").prop('disabled', false);
										 $(".downbid").prop('disabled', false); *//*
									}
								}); 
							 }
							 else
							 {
								 $(".downbid").each(function(){
										if($(this).val()==number && avail==false)
										{
											$(this).text("Bid Strategy not available");
											/* $(".downbid").prop('disabled', false);
											 $(".downbid").prop('disabled', false); *//*
											
										}
							  
							  });
							 }


					  
						  }
						 
						  else
						  {
							  $(".downbid").each(function(){
									if($(this).val()==number && avail==false)
									{
										$(this).text("Bid Strategy not available");
										/* $(".downbid").prop('disabled', false);
										 $(".downbid").prop('disabled', false); *//*
										
									}
						  
						  });
						  }
				       
				    }
					  }
				    }); */
	    }
	    });
});

$(".datadown").click(function(){
	var digit = $(this).attr("name");
	//$(this).addClass("hidden");
	$(".downbid").each(function(){
		if($(this).val()==digit)
		{
			$(this).removeClass("hidden");
			$(this).text("Generate Bid Strategy");
			/* $(".downbid").prop('disabled', false);
			 $(".downbid").prop('disabled', false); */
		}
	}); 
});


 $(".active").click(function(){

	var r = confirm("Are you sure you want to change the status of the account?");
	if(r){
		var status=1;
		if($(this).prop('checked'))
		{
	status=1;
		}
		else
		{
	status=0;
		}
		
		var number=$(this).val();
		
	 $.ajax({
		 url: "processor.php",
		type:'post',
		data:{
			account:number,
			active:status,
			account_status:1
			  
		},
		  success: function(result){
			  if(result==1)
			  {
window.location.reload(true);
			  }
			  else
			  {
alert(result);
			  }
		  }
	 });
	}
	else
	{
return false;
	}
});
       });

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
            <a href="skutools.php"><button class="btn btn-default">SKU Tools</button></a>
        </div>
        <div>
            <a href="home.php"><button class="btn btn-default">Dashboard</button></a>
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
      <div class="col-md-5" style="text-align: right;">
      <h4 class="account" >Account Status : <input type="checkbox" class="active" value="<?php echo $whosaccount;?>"  <?php echo get_account_status($whosaccount)==1?"checked":"unchecked"; ?> style="margin-right: 10px;"  data-toggle="tooltip" title="Account Status : <?php echo get_account_status($whosaccount)=='1'?'ACTIVE':'INACTIVE'; ?>"  data-placement="right"   /><?php echo get_account_status($whosaccount)=='1'?'ACTIVE':'INACTIVE'; ?></h4>
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
              	<!-- <button type="button" class="btn btn-default discount-btn create_ad"
                data-id="{{account.id}}" data-customerid="{{account.customer_id}}">Create Ads</button> -->
                <button type="button" value="<?php echo $account->account_number;?>" class="btn btn-default discount-btn downbid">Generate Bid Strategy</button>
                <a href="" name="<?php echo $account->account_number;?>"style="text-decoration:underline;display: block;" class="datadown hidden">Bid Strategy</a>
                <a href="" name="<?php echo $account->account_number;?>"style="text-decoration:underline;" class="dataup hidden">Bid Strategy</a>
                
               <!--  <div id="customer_{{account.customer_id}}" class="customer_id_lable">{{account.label}}</div> -->
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
    <section>
      <div class="container">
        <div class="modal fade" id="myModal" role="dialog" style=" z-index:2">
          <div class="modal-dialog">
            <div class="modal-content modal-activity-box">
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-5">
                    <p>Campings Created:<span class="budget" id="campaign_no_create">0</span></p>
                    <p>Campings Updated:<span class="budget" id="campaign_no_update">0</span></p>
                    <p>Campings Paused:<span class="budget" id="campaign_no_paused">0</span></p>
                    <p>Adgroups Created:<span class="budget" id="adgroup_no_create">0</span></p>
                    <p>Adgroups Updated:<span class="budget" id="adgroup_no_updated">0</span></p>
                    <p>Adgroups Paused:<span class="budget" id="adgroup_no_paused">0</span></p>
                    <p>Ads Created:<span class="budget" id="ads_no_created">0</span></p>
                    <p>Ads Paused:<span class="budget" id="ads_no_updated">0</span></p>
                  </div>
                  <div class="col-md-7">
                    <div class="activity-box">
                    <div class="activity-content"></div>
                    <div class="function-btn">
                      <button type="button" class="btn btn-default activity-btn" id="start_upload">Start</button>
                      <button type="button" class="btn btn-default activity-btn" id="revert">Revert</button>
                      <button type="button" class="btn btn-default activity-btn">Pause</button>
                      <button type="button" class="btn btn-default activity-btn" id="enable">Enable</button>
                    </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="drag-file"><h3>Drag And Drop File</h3>
                    <form id="upload" action="/create_camapign/" method="POST" enctype="multipart/form-data">
                      {% csrf_token %}
                      <input type="hidden" name='id' id="account_id">
                      <input type="hidden" name='customerid' id='account_customerid'>
                      <input name="csvfile" type="file">
                    </form>
                  </div>
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
              <h4 class="modal-title">Label Account</h4>
            </div>
              <div class="modal-body">
                <form id="account_form">
                  {% csrf_token %}
                  <div class="form-group">
                    <label for="customer_id">Customer Id</label>
                    <input type="text" class="form-control" id="customer_id_field" name="customer_id_field" disabled>
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
  </body>
</html>
