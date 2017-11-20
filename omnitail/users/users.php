<?php 
include('../config/config.php');
require_once './userHelper.php';

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
    <link rel="stylesheet" href="../static/css/bootstrap.min.css">
    <link rel="stylesheet" href="../static/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="../static/css/style.css">
    <script src="../static/js/bootstraps/jquery.js"></script>
    <script src="../static/js/bootstraps/bootstrap.min.js"></script>
  </head>
  <body>
      <?php include('../header.php'); ?>
      <section>
      <div class="container" >
        <h5 class="account">Customers Accounts:</h5>
        <div class="box" style ="background-color:white">
         <?php 
            $userObj = new userHelper();
            $users = $userObj->getUsers();
            $i=0;
            foreach ($users as $user) {
          ?>
          <div class="inner-box">
            <div class="row">
              <div class="col-md-10 col-sm-10">
                  <ul class="account-list" style="margin-left: 20px;" id="account_<?php echo $user->id; ?>">
                  <li style="white-space: nowrap;"><span><?php echo ++$i.")"; ?></span> &nbsp; Name : <span><?php echo $user->name ?></li>
                  <li style="white-space: nowrap;">Email : <span><?php echo $user->email ?></span></li>
                  <li style="white-space: nowrap;"><a href="#" class="create_ad" data-id="<?php echo $user->id; ?>" data-operation="edit"  data-username="<?php echo $user->name ?>" data-useremail="<?php echo $user->email ?>" >Edit</a> | <a href="#" class="btnRmv" data-id="<?php echo $user->id; ?>" data-operation="delete"  data-username="<?php echo $user->name ?>" data-useremail="<?php echo $user->email ?>" >Remove</a></li>
                </ul>
              </div>
              <div class="col-md-2 col-sm-2">
              	
               
              </div>

            </div>
          </div>
          <?php    
            }
          ?>
          <div class="inner-box">
            <center>
              <a href="#">
              <button type="button" class="btn btn-default discount-btn2 create_ad" data-id="0" data-operation="save" data-username="" data-useremail="">Create New User</button>
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
                    <div class="col-md-2" ></div>
                    <div class="col-md-7" style="text-align: right;">
                    <form id="userFrm" name="userFrm" action="" method="POST">
					
					  
                      <div class="form-group"> <span style="color:red" id="errorText"></span></div>
                      <div class="form-group">
                          <label for="userName">Enter name:</label>
                      <input type="text" id="userName" name="userName" />
                      <input type="hidden" id="operation" name="operation" value="save"/>
                      <input type="hidden" id="userid" name="userid" value="0"/>
                      </div>
                      <div class="form-group">
                      <label for="userEmail">Enter email:</label>
                      <input type="text" id="userEmail" name="userEmail" />
                      </div>
                      <div class="form-group">
                      <label for="userPassword">Enter password:</label>
                      <input type="password" id="userPassword" name="userPassword" />
                      </div>
                      <div class="form-group">
                      <label for="userPasswordRepeat">Re-enter Password</label>
                      <input type="password" id="userPasswordRepeat" name="userPasswordRepeat" />
                      </div>
                      <!--<input type="submit" id="createNew" name="createNew" />-->
                  </form>

                    <button type="button" class="btn btn-default activity-btn" id="btnSave">Save</button>

                  </div>
                  <div class="col-md-3">

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
      $( "#btnSave" ).click(function ( e ) {
          
         var dataValues = {
           'name': $("#userName").val(),
           'email': $("#userEmail").val(),
           'password': $("#userPassword").val(),
           'userPasswordRepeat': $("#userPasswordRepeat").val(),
           'operation': $("#operation").val(),
           'userid': $("#userid").val(),
         };
         
         var postUrl = 'userOperations.php';
         var postData = {
            'user': JSON.stringify(dataValues)
         };
         
         console.log(dataValues);
         $.post(postUrl, postData, function(response) {
             
             console.log(response);
			 if(response.succ != 1 ) $("#errorText").html(response.status) ;
			 else { 
                             $("#errorText").html('<span style="color:green">'+response.status+'</span>'); 
                             //code before the pause
                            setTimeout(function(){ //do what you need here
                             $("#myModal").modal('hide'); 
                             location.reload(); }, 500); }
             
         }, 'json');
		 
	  });
	  
      $(".create_ad").click(function(){
        $("#errorText").html('');
        $("#operation").val($(this).data('operation'));
        $("#userid").val($(this).data('id'));
        $("#userName").val($(this).data('username'));
        $("#userEmail").val($(this).data('useremail'));		
		
        $("#myModal").modal('show');
      }) ;
	  
	 $(".btnRmv").click(function(){
        $con = confirm("Do you Really Want To Delete User :  "+$(this).data('useremail')+" ?" );
		if($con){
			
         var dataValues = { 
           'operation': $(this).data('operation'),
           'userid': $(this).data('id'),
         };
         
         var postUrl = 'userOperations.php';
         var postData = {
            'user': JSON.stringify(dataValues)
         };
         
         console.log(dataValues);
         $.post(postUrl, postData, function(response) {
             
             console.log(response);
			 if(response.succ != 1 ) alert(response.status) ;
			 else {location.reload(); }
             
         }, 'json');
			
		}
		
      }) ;
      
    </script>
  </body>
</html>
