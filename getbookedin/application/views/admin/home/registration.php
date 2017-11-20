<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- favicon links -->
    <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
    <link rel="icon" type="image/ico" href="favicon.ico" />
    <!--Google web fonts-->
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>

    <!-- main css -->
    <link rel="stylesheet" href="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/css/main.css" media="screen"/>
    <link rel="stylesheet" id="theme-color" type="text/css" href="#"/>

    <script
        type="text/javascript"
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/libs/jquery/jquery.min.js"></script>
    <script
        type="text/javascript"
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/admin.js"></script>
    <script type="text/javascript">
        var EALang = <?php echo json_encode($this->lang->language); ?>;
    </script>

    <!--page title-->
    <title><?php echo $this->lang->line('registration') . ' | ' . 'GetBookedin'; ?></title>
    <style type="text/css">
        p {
            font-size: 15px;
            line-height: 24px;
        }
        #hs_header nav {
            border: none;
        }
        .booking {
        background-image: url("<?php echo $this->config->item('base_url'); ?>/assets/adminhome/images/booking.png");
            background-position: -522px 10px;
            background-repeat: no-repeat;
            height: 382px;

        }
        body {
            font-family: "Square Market",Helvetica,Arial,sans-serif;
        }
        h4 {
            font-size: 28px;
            font-weight: 100;
            margin-bottom: 15px;
        }
        .caption_logo {
            font-size: 28px;
            font-weight: 100;
            color: #ffffff;
        }
        .get_but {
            background-color: #00ac7a;
            color: #EEEEEE;
            font-size: 15px;
            font-weight: 800;
            padding: 15px 10px;
        }
        .get_but:hover {
            color: #ffffff;
        }
        .feature {
            text-align: center;
            background-color: #f8f8f8;
        }
        .feature:hover h4,
        .feature:hover b {
            color: #00ac7a;
        }
        .calendar {
            background-image: url("<?php echo $this->config->item('base_url'); ?>/assets/adminhome/images/calendar.png");
            height: 702px;
            background-repeat: no-repeat;
            background-position: center center;
        }
        .hs_slider_title {
            font-size: 50px;
            font-weight: 100;
        }
        .lead {
            font-size: 25px;
            font-weight: 100;
            text-shadow: none;
        }
        input.span3, input.span11, textarea.span11 {
            width: 256px;
            background-color: #ffffff;
            border: 1px solid #cccccc;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
            transition: border 0.2s linear 0s, box-shadow 0.2s linear 0s;
            border-radius: 4px;
            color: #555555;
            display: inline-block;
            font-size: 14px;
            height: 30px;
            line-height: 20px;
            margin-bottom: 10px;
            padding: 4px 6px;
            vertical-align: middle;
        }
        textarea.span11 {
            height: auto;
        }
        .alert, .alert h4 {
            color: #c09853;
        }
        .alert {
            background-color: #fcf8e3;
            border: 1px solid #fbeed5;
            border-radius: 4px;
            margin-bottom: 20px;
            padding: 8px 35px 8px 14px;
            text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);

        }
    </style>


    <?php // SET FAVICON FOR PAGE ?>
    <link
        rel="icon"
        type="image/x-icon"
        href="<?php echo $this->config->item('base_url'); ?>/assets/img/favicon.ico">

    <script type="text/javascript">
        var GlobalVariables = {
            'csrfToken': <?php echo json_encode($this->security->get_csrf_hash()); ?>,
            'baseUrl': <?php echo '"' . $base_url . '"'; ?>,
            'admins': <?php echo json_encode($admins); ?>,
            'providers': <?php echo json_encode($providers); ?>,
            'secretaries': <?php echo json_encode($secretaries); ?>,
            'services': <?php echo json_encode($services); ?>,
            'workingPlan': $.parseJSON(<?php echo json_encode($working_plan); ?>),
            'user'                  : {
                'id'        : <?php if(isset($user_id))echo $user_id; else echo '""'; ?>,
                'email'     : <?php echo '"' . $user_email . '"'; ?>,
                'role_slug' : <?php echo '"' . $role_slug . '"'; ?>,
                'privileges': <?php echo json_encode($privileges); ?>
            }
        };

    </script>

</head>
<body>
<!--Pre loader start-->
<div id="preloader">
    <div id="status"><img src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/images/loader.gif" id="preloader_image" width="36" height="36" alt="loading image"/></div>
</div>
<!--pre loader end-->

<!--header start-->
<header id="hs_header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 clearfix">
                <div class="col-lg-2 col-md-2 col-sm-12">
                    <div id="hs_logo" > <a href="<?php echo $base_url; ?>/index.php/admin"> <p class="caption_logo">GetBookedIn</p>
<!--                            <img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/logo.png" alt=""> -->
                        </a> </div>
                    <!-- #logo -->
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4">

                </div>
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <button type="button" class="hs_nav_toggle navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">Menu<i class="fa fa-bars"></i></button>
                    <nav>
                        <ul class="hs_menu collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                            <li><a href="<?php echo $base_url; ?>/index.php/admin" >Home</a></li>
                            <li><a href="<?php echo $base_url; ?>/index.php/admin/login" >login</a></li>
                            <li><a href="<?php echo $base_url; ?>/index.php/admin/registration" >Register</a></li>
                            <li><a href="#">&nbsp;</a></li>
                            <li><a href="#">&nbsp;</a></li>

                        </ul>
                    </nav>
                </div>

            </div>
            <!-- .col-md-12 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container -->

</header>
<!--header end-->

<div class="container">
    <!--service start-->

    <!--service end-->
    <div class="clearfix"></div>
    <div id="admin">

    <div class="container">
        <!--service start-->
        <div class="row user-view">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="hs_service">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2"></div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <h4><?php echo $this->lang->line('registration'); ?></h4>
                            <p><?php echo $this->lang->line('step_three_title'); ?></p>
                            <hr>

                            <input type="hidden" id="admin-id" class="record-id" />
                            <div class="alert hidden"></div>
                            <div class="form-message alert" style="display:none;"></div>

                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2"></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2"></div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
<!--                            <div class="alert hidden"></div>-->
                            <div class="admin-details span6">

                                <label for="admin-first-name"><?php echo $this->lang->line('first_name'); ?> *</label><br>
                                <input type="text" id="admin-first-name" class="span11 required"
                                       placeholder="<?php echo $this->lang->line('first_name'); ?>" /><br>

                                <label for="admin-last-name"><?php echo $this->lang->line('last_name'); ?> *</label><br>
                                <input type="text" id="admin-last-name" class="span11 required"
                                       placeholder="<?php echo $this->lang->line('last_name'); ?>"/><br>

                                <label for="admin-email"><?php echo $this->lang->line('email'); ?> *</label><br>
                                <input type="text" id="admin-email" class="span11 required"
                                       placeholder="<?php echo $this->lang->line('email'); ?>"/><br>

                                <label for="admin-mobile-number"><?php echo $this->lang->line('mobile_number'); ?></label><br>
                                <input type="text" id="admin-mobile-number" class="span11"
                                       placeholder="<?php echo $this->lang->line('mobile_number'); ?>"/><br>

                                <label for="admin-phone-number"><?php echo $this->lang->line('phone_number'); ?> *</label><br>
                                <input type="text" id="admin-phone-number" class="span11 required"
                                       placeholder="<?php echo $this->lang->line('phone_number'); ?>" /><br>

                                <label for="admin-address"><?php echo $this->lang->line('address'); ?></label><br>
                                <input type="text" id="admin-address" class="span11"
                                       placeholder="<?php echo $this->lang->line('address'); ?>"/><br>

                                <label for="admin-city"><?php echo $this->lang->line('city'); ?></label><br>
                                <input type="text" id="admin-city" class="span11"
                                       placeholder="<?php echo $this->lang->line('city'); ?>"/><br>

                                <label for="admin-state"><?php echo $this->lang->line('state'); ?></label><br>
                                <input type="text" id="admin-state" class="span11"
                                       placeholder="<?php echo $this->lang->line('state'); ?>"/><br>

                                <label for="admin-zip-code"><?php echo $this->lang->line('zip_code'); ?></label><br>
                                <input type="text" id="admin-zip-code" class="span11"
                                       placeholder="<?php echo $this->lang->line('zip_code'); ?>"/><br>

                                <label for="admin-notes"><?php echo $this->lang->line('notes'); ?></label><br>
                                <textarea id="admin-notes" class="span11" rows="3"
                                  placeholder="<?php echo $this->lang->line('notes'); ?>"></textarea><br>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="admin-settings span6">
                                <!--                <label for="user-username">--><?php //echo $this->lang->line('username'); ?><!-- *</label>-->
                                <!--                <input type="text" id="admin-username" class="span9 required"-->
                                <!--                       placeholder="--><?php //echo $this->lang->line('username'); ?><!--"/>-->

                                <label for="admin-password"><?php echo $this->lang->line('password'); ?> *</label><br>
                                <input type="password" id="admin-password" class="span11 required"
                                       placeholder="<?php echo $this->lang->line('password'); ?>"/><br>

                                <label for="admin-password-confirm"><?php echo $this->lang->line('retype_password'); ?> *</label><br>
                                <input type="password" id="admin-password-confirm" class="span11 required"
                                       placeholder="<?php echo $this->lang->line('retype_password'); ?>"/><br>

                                <br>

                                <br><br>

                                <button id="save-admin" class="btn btn-primary">
                                    <i class="icon-ok icon-white"></i>
                                    <?php echo $this->lang->line('save'); ?>
                                </button>
                                <button id="cancel-admin" class="btn">
                                    <i class="icon-ban-circle"></i>
                                    <?php echo $this->lang->line('cancel'); ?>
                                </button>

                                <br>
                                <br>

<!--                                <a href="--><?php //echo $base_url; ?><!--/index.php/admin/login" class="admin-login">-->
<!--                                    --><?php //echo $this->lang->line('go_to_login'); ?><!--</a>-->

                            </div>

                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-2"></div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>

    <script
        type="text/javascript"
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/general_functions.js"></script>


</div>

<div class="hs_copyright"></div>
<!--main js file start-->
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/js/owl.carousel.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/js/jquery.bxslider.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/js/jquery.mixitup.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/js/smoothscroll.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/js/single-0.1.0.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/js/custom.js"></script>
<!--main js file end-->
</body>

</html>