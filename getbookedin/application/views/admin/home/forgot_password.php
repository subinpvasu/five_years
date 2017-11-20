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

    <script type="text/javascript">
        var EALang = <?php echo json_encode($this->lang->language); ?>;
    </script>

    <!--page title-->
    <title><?php echo $this->lang->line('forgot_your_password'); ?> | GetBookedin</title>
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
        input.span3 {
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
        $(document).ready(function() {
            var GlobalVariables = {
                'csrfToken': <?php echo json_encode($this->security->get_csrf_hash()); ?>,
                'baseUrl': <?php echo '"' . $base_url . '"'; ?>,
                'AJAX_SUCCESS': 'SUCCESS',
                'AJAX_FAILURE': 'FAILURE'
            };

            var EALang = <?php echo json_encode($this->lang->language); ?>;

            /**
             * Event: Login Button "Click"
             *
             * Make an ajax call to the server and check whether the user's credentials are right.
             * If yes then redirect him to his desired page, otherwise display a message.
             */
            $('form').submit(function(event) {
                event.preventDefault();

                var postUrl = GlobalVariables.baseUrl + '/index.php/admin/ajax_forgot_password';
                var postData = {
                    'csrfToken': GlobalVariables.csrfToken,
                    'email': $('#email').val()
                };

                $('.alert').addClass('hidden');
                $('#get-new-password').prop('disabled', true);

                $.post(postUrl, postData, function(response) {
                    //////////////////////////////////////////////////////////
                    console.log('Regenerate Password Response: ', response);
                    //////////////////////////////////////////////////////////

                    $('#get-new-password').prop('disabled', false);
                    if (!GeneralFunctions.handleAjaxExceptions(response)) return;

                    if (response == GlobalVariables.AJAX_SUCCESS) {
                        $('.alert').addClass('alert-success');
                        $('.alert').text(EALang['new_password_sent_with_email']);
                    } else {
                        $('.alert').text('The operation failed. Please enter a valid '
                        + 'email address in order to get a new password.');
                    }
                    $('.alert').removeClass('hidden');
                }, 'json');
            });
        });
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

    <div class="container">
        <!--service start-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="hs_service">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2"></div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <h4><?php echo $this->lang->line('forgot_your_password'); ?></h4>
                            <p><?php echo $this->lang->line('type_email_for_new_password'); ?></p>
                            <hr>

                            <div class="alert hidden"></div>

                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2"></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2"></div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
<!--                            <div class="alert hidden"></div>-->

                            <form id="login-form">
                                <br>
                                <label for="email"><?php echo $this->lang->line('email'); ?></label>
                                <input type="text" id="email"
                                       placeholder="<?php echo $this->lang->line('enter_email_here'); ?>"
                                       class="span3" />

                                <br><br><br>

                                <button type="submit" id="get-new-password" class="btn btn-primary btn-large">
                                    <?php echo $this->lang->line('regenerate_password'); ?>
                                </button>

                                <br><br>
                                <!--    Custom added link to register        -->
                                <a href="<?php echo $base_url; ?>/index.php/admin/registration" class="">
                                    <?php echo $this->lang->line('new'); ?></a>
                                |
                                <a href="<?php echo $base_url; ?>/index.php/admin/login" class="user-login">
                                    <?php echo $this->lang->line('go_to_login'); ?></a>
<!--                                <a href="--><?php //echo $base_url; ?><!--/index.php/admin/forgot_password" class="forgot-password">-->
<!--                                    --><?php //echo $this->lang->line('forgot_your_password'); ?><!--</a>-->
<!--                                |-->
<!--                                <span id="select-language" class="badge badge-inverse">-->
<!--                                    --><?php //echo ucfirst($this->config->item('language')); ?>
<!--                                </span>-->
                                <br><br>
                            </form>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-2"></div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script
        type="text/javascript"
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/general_functions.js"></script>



    <div class="hs_margin_40"></div>

    <div class="clearfix"></div>

    <div class="hs_margin_60"></div>
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