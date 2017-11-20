<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title><?php echo $this->lang->line('header_information') . ' - ' . $company_name; ?></title>
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

    <!-- Colour picker -->
    <script type="text/javascript"
            src="<?php echo $base_url; ?>/assets/js/jscolor.js"></script>

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

        #page {
            width: 630px;
            margin: 150px auto 0 auto;
            background: #FFF;
            border: 1px solid #DDDADA;
            padding: 70px;
        }

        label {
        }
        .page-settings input[type="text"] {
            /*max-width: 40%;*/
        }
        .base_label {
            display: inline;
            font-size: 1.25em;
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
                'id'        : <?php if(isset($user_id)) echo '"'. $user_id .'"'; else echo '""'; ?>,
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

<div id="page" class="frame-container">
    <div class="details-view user-view">
        <?php echo form_open_multipart('admin/ajax_save_header', 'id="header-form"'); ?>
        <h2><?php echo $this->lang->line('header_information'); ?></h2>
        <p><?php echo $this->lang->line('step_three_title'); ?></p>
        <hr>

        <input type="hidden" id="admin-id" name="admin-id" class="record-id" value="<?php if(isset($user_id))echo $user_id; else echo '""'; ?>" />

        <div class="alert hidden"></div>
        <div class="form-message alert" style="display:none;"></div>

        <div class="row-fluid">

            <div class="page-settings span8">

                <br>

                <label for="logo"><?php echo $this->lang->line('logo_select'); ?></label>
                <style type="text/css">
                    .fileUpload {
                        position: relative;
                        overflow: hidden;
                        margin: 10px;
                    }
                    .fileUpload input.upload {
                        position: absolute;
                        top: 0;
                        right: 0;
                        margin: 0;
                        padding: 0;
                        font-size: 20px;
                        cursor: pointer;
                        opacity: 0;
                        filter: alpha(opacity=0);
                    }
                    #uploadFile {
                        margin: 0;
                    }
                </style>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#userfile').change(function() {

                            $('#uploadFile').val($(this).val().substring($(this).val().lastIndexOf('\\')+1, $(this).val().length));
                        });
                    });
                    function previewFile(){
                        var preview = document.querySelector('.filepreview'); //selects the query named img
                        var file    = document.querySelector('input[type=file]').files[0]; //sames as here
                        var reader  = new FileReader();

                        preview.alt = "";

                        reader.onloadend = function () {
                            preview.src = reader.result;

                        }

                        if (file) {
                            reader.readAsDataURL(file); //reads the data as a URL
                        } else {
                            preview.src = "";
                        }

                    }

                    previewFile();  //calls the function named previewFile()
                </script>

                <input type="text" id="uploadFile" name="uploadFile" class="span7"  placeholder="Choose File" disabled="disabled" value="sample" />

                <div class="fileUpload btn btn-primary">
                    <span>Upload</span>
                    <input id="userfile" name="userfile" type="file" class="upload" onchange="previewFile()" />

                </div>

                <label for="header_color"><?php echo $this->lang->line('header_colour'); ?></label>
                <input type="text" id="header_color" name="header_color" class="color span8" />

                <label for="header_back_color"><?php echo $this->lang->line('header_back_colour'); ?></label>
                <input type="text" id="header_back_color" name="header_back_color" class="color span8" />

                <label for="header_caption"><?php echo $this->lang->line('header_caption'); ?></label>
                <input type="text" id="header_caption" name="header_caption" class="span8" placeholder="<?php echo $this->lang->line('enter_header_caption'); ?>"  />

                <label for="footer_back_color"><?php echo $this->lang->line('footer_back_colour'); ?></label>
                <input type="text" id="footer_back_color" name="footer_back_color" class="color span8" />


                <br><br>

                <input type="submit" id="save-page" class="btn btn-primary" value="<?php echo $this->lang->line('save'); ?>" />

<!--                <button id="save-page" class="btn btn-primary">-->
<!--                    <i class="icon-ok icon-white"></i>-->
<!--                    --><?php //echo $this->lang->line('save'); ?>
<!--                </button>-->
<!--                <button id="cancel-page" class="btn">-->
<!--                    <i class="icon-ban-circle"></i>-->
<!--                    --><?php //echo $this->lang->line('cancel'); ?>
<!--                </button>-->

                <br>
                <br>


            </div>
            <div class="page-settings span4">
                <br><br>
                <img src="" height="200" alt="Image preview..." class="filepreview" >
            </div>

        </div>
        </form>
    </div>


</div>
<script
    type="text/javascript"
    src="<?php echo $this->config->item('base_url'); ?>/assets/js/general_functions.js"></script>

</body>


