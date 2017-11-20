<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/js/adminuser_backend_settings.js"></script>
<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/js/working_plan.js"></script>
<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/js/libs/jquery/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/js/libs/jquery/jquery.jeditable.min.js"></script>

<!-- Colour picker -->
<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/js/jscolor.js"></script>

<script type="text/javascript">
    var GlobalVariables = {
        'csrfToken': <?php echo json_encode($this->security->get_csrf_hash()); ?>,
        'baseUrl': <?php echo '"' . $base_url . '"'; ?>,
        'userSlug': <?php echo '"' . $role_slug . '"'; ?>,
        'settings': {
            'system': <?php echo json_encode($system_settings); ?>,
            'user': <?php echo json_encode($user_settings); ?>,
            'adminuser': <?php echo json_encode($adminuser_settings); ?>,
            'header': <?php echo json_encode($adminuser_header); ?>
        },
        'user'                  : {
            'id'        : <?php echo $user_id; ?>,
            'email'     : <?php echo '"' . $user_email . '"'; ?>,
            'role_slug' : <?php echo '"' . $role_slug . '"'; ?>,
            'privileges': <?php echo json_encode($privileges); ?>
        }
    };

    $(document).ready(function() {
        AdminUserBackendSettings.initialize(true);
    });
</script>

<div id="settings-page" class="row-fluid">
    <ul class="nav nav-tabs">
        <?php if ($privileges[PRIV_SYSTEM_SETTINGS]['view'] == TRUE and $role_slug == 'admin') { ?>
            <li class="general-tab tab"><a><?php echo $this->lang->line('general'); ?></a></li>
        <?php } ?>

        <?php if ($privileges[PRIV_SYSTEM_SETTINGS]['view'] == TRUE) { ?>
            <li class="business-logic-tab tab"><a><?php echo $this->lang->line('business_logic'); ?></a></li>
        <?php } ?>

        <?php if ($privileges[PRIV_USER_SETTINGS]['view'] == TRUE) { ?>
            <li class="user-tab tab"><a><?php echo $this->lang->line('current_user'); ?></a></li>
        <?php } ?>

        <!--        <li class="about-tab tab"><a>--><?php //echo $this->lang->line('about_ea'); ?><!--</a></li>-->
    </ul>


    <?php
    // --------------------------------------------------------------
    //
    // USER TAB
    //
    // --------------------------------------------------------------
    ?>
    <?php $hidden = ($privileges[PRIV_USER_SETTINGS]['view'] == TRUE) ? '' : 'hidden'; ?>
    <div id="user" class="tab-content <?php echo $hidden; ?>">
        <?php echo form_open_multipart('backend_api/ajax_save_profile_header_settings', 'id="profile-form"'); ?>
            <fieldset class="span5 personal-info-wrapper">
                <legend>
                    <?php echo $this->lang->line('personal_information'); ?>
                    <?php if ($privileges[PRIV_USER_SETTINGS]['edit'] == TRUE) { ?>

                    <?php } ?>
                </legend>

                <input type="hidden" id="user-id" name="user-id"/>

                <label for="first-name"><?php echo $this->lang->line('first_name'); ?> *</label>
                <input type="text" id="first-name" name="first-name"  class="span9 required" />

                <label for="last-name"><?php echo $this->lang->line('last_name'); ?> *</label>
                <input type="text" id="last-name" name="last-name" class="span9 required" />

                <label for="email"><?php echo $this->lang->line('email'); ?> *</label>
                <input type="text" id="email" name="email" class="span9 required" />

                <label for="mobile-number"><?php echo $this->lang->line('mobile_number'); ?></label>
                <input type="text" id="mobile-number" name="mobile-number" class="span9" />

                <label for="phone-number"><?php echo $this->lang->line('phone_number'); ?> *</label>
                <input type="text" id="phone-number" name="phone-number" class="span9 required" />

                <label for="address"><?php echo $this->lang->line('address'); ?></label>
                <input type="text" id="address" name="address" class="span9" />

                <label for="city"><?php echo $this->lang->line('city'); ?></label>
                <input type="text" id="city" name="city" class="span9" />

                <label for="state"><?php echo $this->lang->line('state'); ?></label>
                <input type="text" id="state" name="state" class="span9" />

                <label for="zip-code"><?php echo $this->lang->line('zip_code'); ?></label>
                <input type="text" id="zip-code" name="zip-code" class="span9" />

                <label for="notes"><?php echo $this->lang->line('notes'); ?></label>
                <textarea id="notes" name="notes" class="span9" rows="3"></textarea>

                <!--  <legend>--><?php //echo $this->lang->line('system_login'); ?><!--</legend>-->

                <!--  <label for="username">--><?php //echo $this->lang->line('username'); ?><!-- *</label>-->
                <!--  <input type="text" id="username" class="required" />-->

                <label for="password"><?php echo $this->lang->line('password'); ?></label>
                <input type="password" id="password" name="password" class="span9" />

                <label for="retype-password"><?php echo $this->lang->line('retype_password'); ?></label>
                <input type="password" id="retype-password" name="retype-password" class="span9" />

                <br>

                <button type="button" id="user-notifications" name="user-notifications" class="btn" value="0"
                        data-toggle="button" style="display: none;">
                    <i class="icon-envelope"></i>
                    <?php echo $this->lang->line('receive_notifications'); ?>
                </button>

                <br>
                <br>
            </fieldset>

            <fieldset class="span5 miscellaneous-wrapper">
                <legend><?php echo $this->lang->line('header_information'); ?></legend>

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

                <label for="logo"><?php echo $this->lang->line('logo_select'); ?></label>
                <input type="text" id="uploadFile" name="uploadFile"  placeholder="Choose File" disabled="disabled" class="span9" />

                <div class="fileUpload btn btn-primary">
                    <span>Upload</span>
                    <input name ="userfile" id="userfile" type="file" class="upload" onchange="previewFile()" />
                </div>


                <label for="header_back_color"><?php echo $this->lang->line('header_back_colour'); ?></label>
                <input type="text" id="header_back_color" name="header_back_color" class="color span9"  />

                <label for="header_color"><?php echo $this->lang->line('header_colour'); ?></label>
                <input type="text" id="header_color" name="header_color" class="color span9" />

                <label for="header_caption"><?php echo $this->lang->line('header_caption'); ?></label>
                <input type="text" id="header_caption" name="header_caption"  class="span9"  />

                <label for="footer_back_color"><?php echo $this->lang->line('footer_back_colour'); ?></label>
                <input type="text" id="footer_back_color" name="footer_back_color" class="color span9" />

                <label for="description"><?php echo $this->lang->line('description'); ?></label>
                <textarea id="description" name="description" class="span9" rows="3"></textarea>

                <br>
                <br>

                <input type="submit" id="save_profile" class="btn btn-primary" value="<?php echo $this->lang->line('save'); ?>" />
            </fieldset>

            <fieldset class="span5 miscellaneous-wrapper">
                <br><br>
                <img src="<?php echo $this->config->item('base_url').'/uploads/'.$adminuser_header['logo']; ?>" height="200" alt="Image preview..." class="filepreview" >
            </fieldset>
        </form>
    </div>

</div>