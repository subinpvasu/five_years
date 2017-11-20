    <script type="text/javascript">
        //Set header changes
        $(document).ready(function(){
            $('#hs_header').css('background-color', '#<?php echo $adminuser_header['header_back_color']; ?>' );
            $('.hs_copyright').css('background-color', '#<?php echo $adminuser_header['footer_back_color']; ?>' );
            $('.hs_social ul li a').css('color', '#<?php echo $adminuser_header['header_color']; ?>' );
            $("#hs_logo img").attr("src", '<?php echo $this->config->item('base_url').'/uploads/'.$adminuser_header['logo']; ?>');
        });
    </script>
<!-- Modal -->
<div id="loginModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Login here</h4>
      </div>
<!--        <form method="post" action="<?php echo $this->config->item('base_url'); ?>/index.php/appointments/login"
onsubmit="return validation_login()">-->
        
      <div class="modal-body">
        
          <div>
              <label for="email">Email</label>
              <input type="email" class="form-control" value="" id="username" name="login_email">
          </div>
          <div>
              <label for="new_password">Password</label>
              <input type="password" class="form-control" value="" id="password" name="login_password">
          </div>
        
          <div class="bg-warning" style="font-weight: bold;color:brown;" id="error_text_login"></div>

          <div class="modal-footer">
            <b>Don't have an account?</b>
              <a href="" data-toggle="modal" data-target="#registerModal" data-dismiss="modal"><b>Register</b></a>

            <input type="button" class="btn btn-primary" value="Login" name="save" id="login_form">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
      </div>
    </div>
</div>
</div>


<input type="hidden" id="csrfone" value="<?php echo $this->security->get_csrf_token_name(); ?>"/>
<input type="hidden" id="csrftwo" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
<div id="registerModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Register here</h4>
      </div>
     <?php echo form_open('/user/register'); ?>
    <!--<form method="post" action="<?php echo $this->config->item('base_url'); ?>/index.php/appointments/index" >-->
      <div class="modal-body">
          <div>
              <label for="firstname">First Name *</label>
              <input type="text" class="form-control" id="firstname" value="" name="firstname">
          </div>
    
          <div>
              <label for="lastname">Last Name *</label>
              <input type="text" class="form-control" id="lastname" value="" name="lastname">
          </div>
   
          <div>
              <label for="gender">Gender</label>
              <select name="gender" id="gender" class="form-control">
                  <option value="female">Female</option>
                  <option value="male">Male</option>
                  <option value="other">Don't want to disclose</option>
              </select>
          </div>
          <div>
              <label for="mobile">Mobile</label>
              <input type="text" class="form-control" value="" id="mobile" name="mobile">
          </div>
          <div>
              <label for="email">Email *</label>
              <input type="email" class="form-control" value="" name="email" id="email">
          </div>
         
          <div>
              <label for="new_password">New Password *</label>
              <input type="password" class="form-control" value="" id="new_password" name="new_password">
          </div>
          <div>
              <label for="confirm_password">Confirm Password *</label>
              <input type="password" class="form-control" value="" id="confirm_password" name="confirm_password">
          </div>
 
          <div>
              <label for="preferred_communication_mode">Preferred communication mode</label> <br />
              Email <input type="radio" value="0" name="preferred_communication_mode" id ="prefered_communication_mode_email" checked="checked" />
              &nbsp; &nbsp; SMS <input type="radio" value="1" name="preferred_communication_mode" id ="prefered_communication_mode_sms"   />
              &nbsp; &nbsp; Both <input type="radio" value="2" name="preferred_communication_mode" id ="prefered_communication_mode_both"   /><br />
          </div>
          <div class="modal-footer">
              <input type="submit" class="btn btn-primary" value="Register" name="save" onclick="return validation_register();">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
     
      </div>
      <?php  echo form_close();  ?>
    </div>
  </div>
</div>

<input type="hidden" id="baseurl" value="<?php echo $this->config->item('base_url'); ?>"/>
<input type="hidden" value="<?php echo $this->config->item('base_url'); ?>/index.php/user/register" id="homepage"/>
<!--header start-->
<header id="hs_header" >  <!-- class="hc_fixed_header fixed" -->
  <div class="container">

        <div class="col-lg-2 col-md-2 col-sm-12">
          <div id="hs_logo" >
              <a href="#">
                  <img src="<?php echo $this->config->item('base_url'); ?>/assets/images/logo.png" alt=""> </a>
          </div>
          <!-- #logo --> 
        </div>
        <?php
            if(!is_numeric($this->session->userdata('who')))
               { ?>

        <div class="col-lg-8 col-md-8 col-sm-12">
          <button type="button" class="hs_nav_toggle navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">Menu
              <i class="fa fa-bars"></i></button>
          <nav>
            <ul class="hs_menu collapse navbar-collapse" id="bs-example-navbar-collapse-1"></ul>
          </nav>
        </div>
        <?php } else { // after login menu?>
          
        <div class="col-lg-8 col-md-8 col-sm-12">
            <button type="button" class="hs_nav_toggle navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">Menu
                <i class="fa fa-bars"></i></button>
          <nav>
            <ul class="hs_menu collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <li><a href="<?php echo $this->config->item('base_url'); ?>/index.php/user/index" class="active" >Home</a></li>
              <li><a href="<?php echo $this->config->item('base_url'); ?>/index.php/user/profile">profile</a></li>
              <li><a href="<?php echo $this->config->item('base_url'); ?>/index.php/user/register">appointments</a></li>
              <li><a href="<?php echo $this->config->item('base_url'); ?>/index.php/user/change_password">change password</a></li>
              <li><a href="#" id="logout">logout</a></li>
            </ul>
          </nav>
        </div>
        <?php  } ?>
        <div class="col-lg-2 col-md-2 col-sm-4">
          <div class="hs_social">
            <ul>
                <?php 
                if(!is_numeric($this->session->userdata('who')))
                { ?>
              <li><a href="" data-toggle="modal" data-target="#loginModal">Login</i></a></li>
              <li><a href="" data-toggle="modal" data-target="#registerModal">Register</i></a></li>
                <?php } else { } ?>
            </ul>
          </div>

          <!-- #logo --> 
        </div>
      <!-- .col-md-12 -->
    <!-- .row --> 
  </div>
  <!-- .container -->
</header>