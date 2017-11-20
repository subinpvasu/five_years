<!DOCTYPE html>
<html>
<head>
    <title><?php echo $this->lang->line('login') . ' - ' . $company_name; ?></title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <?php // INCLUDE JS FILES ?>
    <script
        type="text/javascript"
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/libs/jquery/jquery.min.js"></script>
    <script
        type="text/javascript"
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/libs/bootstrap/bootstrap.min.js"></script>
    <script
        type="text/javascript"
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/libs/date.js"></script>

    <?php // INCLUDE CSS FILES ?>
    <link
        rel="stylesheet"
        type="text/css"
        href="<?php echo $this->config->item('base_url'); ?>/assets/css/libs/bootstrap/bootstrap.css">
    <link
        rel="stylesheet"
        type="text/css"
        href="<?php echo $this->config->item('base_url'); ?>/assets/css/libs/bootstrap/bootstrap-responsive.css">
    <link
        rel="stylesheet"
        type="text/css"
        href="<?php echo $this->config->item('base_url'); ?>/assets/css/general.css">

    <?php // SET FAVICON FOR PAGE ?>
    <link
        rel="icon"
        type="image/x-icon"
        href="<?php echo $this->config->item('base_url'); ?>/assets/img/favicon.ico">

    <style>
        body {
            background-color: #CAEDF3;
        }

        #login-frame {
            width: 630px;
            margin: 150px auto 0 auto;
            background: #FFF;
            border: 1px solid #DDDADA;
            padding: 70px;
        }

        #login-icon {
            float: right;
            margin-top: 17px;
        }

        label {
            font-weight: bold;
        }

        .forgot-password {
            /*             margin-left: 20px; */
        }
    </style>

    <script type="text/javascript">
        var GlobalVariables = {
            'csrfToken': <?php echo json_encode($this->security->get_csrf_hash()); ?>,
            'baseUrl': <?php echo '"' . $base_url . '"'; ?>,
            'destUrl': <?php echo '"' . $dest_url . '"'; ?>,
            'AJAX_SUCCESS': 'SUCCESS',
            'AJAX_FAILURE': 'FAILURE'
        };

        var EALang = <?php echo json_encode($this->lang->language); ?>;
        var availableLanguages = <?php echo json_encode($this->config->item('available_languages')); ?>;

        $(document).ready(function() {
            GeneralFunctions.enableLanguageSelection($('#select-language'));

            /**
             * Event: Login Button "Click"
             *
             * Make an ajax call to the server and check whether the user's credentials are right.
             * If yes then redirect him to his desired page, otherwise display a message.
             */
            $('#login-form').submit(function(event) {
                event.preventDefault();

                var postUrl = GlobalVariables.baseUrl + '/index.php/admin/ajax_check_login';
                var postData = {
                    'csrfToken': GlobalVariables.csrfToken,
                    'username': $('#email').val(),
                    'password': $('#password').val()
                };

                $('.alert').addClass('hidden');

                $.post(postUrl, postData, function(response) {
                    //////////////////////////////////////////////////
                    console.log('Check Login Response: ', response);
                    //////////////////////////////////////////////////


                    if (!GeneralFunctions.handleAjaxExceptions(response)) return;

                    if (response == GlobalVariables.AJAX_SUCCESS) {
                        window.location.href = GlobalVariables.destUrl;
                    } else {
                        $('.alert').text(EALang['login_failed']);
                        $('.alert').removeClass('hidden');
                    }
                }, 'json');
            });
        });
    </script>
</head>
<body>
<div id="login-frame" class="frame-container">
    <h2><?php echo $this->lang->line('admin_section'); ?></h2>
    <p><?php echo $this->lang->line('admin_need_login'); ?></p>
    <hr>
    <div class="alert hidden"></div>
    <form id="login-form">
        <label for="email"><?php echo $this->lang->line('email'); ?></label>
        <input type="text" id="email"
               placeholder="<?php echo $this->lang->line('enter_email_here'); ?>"
               class="span3" />

        <label for="password"><?php echo $this->lang->line('password'); ?></label>
        <input type="password" id="password"
               placeholder="<?php echo $this->lang->line('enter_password_here'); ?>"
               class="span3" />

        <br>

        <button type="submit" id="login" class="btn btn-primary">
            <?php echo $this->lang->line('login'); ?>
        </button>

        <br><br>
        <!--    Custom added link to register        -->
        <a href="<?php echo $base_url; ?>/index.php/admin/registration" class="">
            <?php echo $this->lang->line('new'); ?></a>
        |
        <a href="<?php echo $base_url; ?>/index.php/admin/forgot_password" class="forgot-password">
            <?php echo $this->lang->line('forgot_your_password'); ?></a>
        |
            <span id="select-language" class="badge badge-inverse">
	        	<?php echo ucfirst($this->config->item('language')); ?>
	        </span>
    </form>
</div>

<script
    type="text/javascript"
    src="<?php echo $this->config->item('base_url'); ?>/assets/js/general_functions.js"></script>
</body>
</html>