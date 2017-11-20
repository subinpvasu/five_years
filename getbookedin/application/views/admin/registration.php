<!DOCTYPE html>
<html>
<head>
    <title><?php echo $this->lang->line('registration') . ' - ' . $company_name; ?></title>
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
    <script
        type="text/javascript"
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/admin.js"></script>

    <script type="text/javascript">
        var EALang = <?php echo json_encode($this->lang->language); ?>;
    </script>

    <?php // INCLUDE CSS FILES ?>
    <link
        rel="stylesheet"
        type="text/css"
        href="<?php echo $this->config->item('base_url'); ?>/assets/css/libs/bootstrap/bootstrap.css">
    <link
        rel="stylesheet"
        type="text/css"
        href="<?php echo $this->config->item('base_url'); ?>/assets/css/libs/bootstrap/bootstrap-responsive.css">

    <?php // SET FAVICON FOR PAGE ?>
    <link
        rel="icon"
        type="image/x-icon"
        href="<?php echo $this->config->item('base_url'); ?>/assets/img/favicon.ico">

    <style>
        body {
            background-color: #CAEDF3;
        }

        #admin {
            width: 630px;
            margin: 150px auto 0 auto;
            background: #FFF;
            border: 1px solid #DDDADA;
            padding: 70px;
        }

        label {
        }

        .admin-login{
            margin-left: 20px;
        }
    </style>
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

        $(document).ready(function() {

        });

    </script>


</head>
<body>

<div id="admin" class="frame-container">
    <div class="details-view user-view">
        <h2><?php echo $this->lang->line('registration'); ?></h2>
        <p><?php echo $this->lang->line('step_three_title'); ?></p>
        <hr>

        <input type="hidden" id="admin-id" class="record-id" />

        <div class="alert hidden"></div>
        <div class="form-message alert" style="display:none;"></div>

        <div class="row-fluid">
            <div class="admin-details span6">
                <label for="admin-first-name"><?php echo $this->lang->line('first_name'); ?> *</label>
                <input type="text" id="admin-first-name" class="span11 required"
                       placeholder="<?php echo $this->lang->line('first_name'); ?>" />

                <label for="admin-last-name"><?php echo $this->lang->line('last_name'); ?> *</label>
                <input type="text" id="admin-last-name" class="span11 required"
                       placeholder="<?php echo $this->lang->line('last_name'); ?>"/>

                <label for="admin-email"><?php echo $this->lang->line('email'); ?> *</label>
                <input type="text" id="admin-email" class="span11 required"
                       placeholder="<?php echo $this->lang->line('email'); ?>"/>

                <label for="admin-mobile-number"><?php echo $this->lang->line('mobile_number'); ?></label>
                <input type="text" id="admin-mobile-number" class="span11"
                       placeholder="<?php echo $this->lang->line('mobile_number'); ?>"/>

                <label for="admin-phone-number"><?php echo $this->lang->line('phone_number'); ?> *</label>
                <input type="text" id="admin-phone-number" class="span11 required"
                       placeholder="<?php echo $this->lang->line('phone_number'); ?>" />

                <label for="admin-address"><?php echo $this->lang->line('address'); ?></label>
                <input type="text" id="admin-address" class="span11"
                       placeholder="<?php echo $this->lang->line('address'); ?>"/>

                <label for="admin-city"><?php echo $this->lang->line('city'); ?></label>
                <input type="text" id="admin-city" class="span11"
                       placeholder="<?php echo $this->lang->line('city'); ?>"/>

                <label for="admin-state"><?php echo $this->lang->line('state'); ?></label>
                <input type="text" id="admin-state" class="span11"
                       placeholder="<?php echo $this->lang->line('state'); ?>"/>

                <label for="admin-zip-code"><?php echo $this->lang->line('zip_code'); ?></label>
                <input type="text" id="admin-zip-code" class="span11"
                       placeholder="<?php echo $this->lang->line('zip_code'); ?>"/>

                <label for="admin-notes"><?php echo $this->lang->line('notes'); ?></label>
                    <textarea id="admin-notes" class="span11" rows="3"
                              placeholder="<?php echo $this->lang->line('notes'); ?>"></textarea>
            </div>
            <div class="admin-settings span6">
<!--                <label for="user-username">--><?php //echo $this->lang->line('username'); ?><!-- *</label>-->
<!--                <input type="text" id="admin-username" class="span9 required"-->
<!--                       placeholder="--><?php //echo $this->lang->line('username'); ?><!--"/>-->

                <label for="admin-password"><?php echo $this->lang->line('password'); ?> *</label>
                <input type="password" id="admin-password" class="span9 required"
                       placeholder="<?php echo $this->lang->line('password'); ?>"/>

                <label for="admin-password-confirm"><?php echo $this->lang->line('retype_password'); ?> *</label>
                <input type="password" id="admin-password-confirm" class="span9 required"
                       placeholder="<?php echo $this->lang->line('retype_password'); ?>"/>

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

                <a href="<?php echo $base_url; ?>/index.php/admin/login" class="admin-login">
                    <?php echo $this->lang->line('go_to_login'); ?></a>

            </div>

        </div>
    </div>


</div>
<script
    type="text/javascript"
    src="<?php echo $this->config->item('base_url'); ?>/assets/js/general_functions.js"></script>

</body>


