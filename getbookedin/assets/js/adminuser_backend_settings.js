/**
 * Contains the functionality of the backend settings page. Can either work for 
 * system or user settings, but the actions allowed to the user are restricted to
 * his role (only admin has full privileges).
 * 
 * @namespace AdminUserBackendSettings
 */
var AdminUserBackendSettings = {
    SETTINGS_SYSTEM: 'SETTINGS_SYSTEM',
    SETTINGS_USER: 'SETTINGS_USER',
    SETTINGS_HEADER: 'SETTINGS_HEADER',
    
    /**
     * Use this WorkingPlan class instance to perform actions on the page's working plan
     * tables.
     */
    wp: {},
    
    /**
     * Tab settings object.
     * 
     * @type {object}
     */
    settings: {},
    
    /**
     * Initialize Page
     * 
     * @param {bool} bindEventHandlers (OPTIONAL)Determines whether to bind the default event
     * handlers (default = true).
     * @returns {undefined}
     */
    initialize: function(bindEventHandlers) {
        if (bindEventHandlers == undefined) bindEventHandlers = true;
        
        // Apply setting values from database.
        $.each(GlobalVariables.settings.system, function(index, setting) {
            $('input[data-field="' + setting.name + '"]').val(setting.value);
        });
        
        var workingPlan = {};
        $.each(GlobalVariables.settings.system, function(index, setting) {
            if (setting.name == 'company_working_plan') {
                workingPlan = $.parseJSON(setting.value); 
                return false;
            }
        });
        
        AdminUserBackendSettings.wp = new WorkingPlan();
        AdminUserBackendSettings.wp.setup(workingPlan);
        AdminUserBackendSettings.wp.timepickers(false);
        
        // Book Advance Timeout Spinner
        $('#book-advance-timeout').spinner({
            'min': 0
        });
        
        // Load user settings into form
        $('#user-id').val(GlobalVariables.settings.adminuser.id);
        $('#first-name').val(GlobalVariables.settings.adminuser.first_name);
        $('#last-name').val(GlobalVariables.settings.adminuser.last_name);
        $('#email').val(GlobalVariables.settings.adminuser.email);
        $('#mobile-number').val(GlobalVariables.settings.adminuser.mobile_number);
        $('#phone-number').val(GlobalVariables.settings.adminuser.phone_number);
        $('#address').val(GlobalVariables.settings.adminuser.address);
        $('#city').val(GlobalVariables.settings.adminuser.city);
        $('#state').val(GlobalVariables.settings.adminuser.state);
        $('#zip-code').val(GlobalVariables.settings.adminuser.zip_code);
        $('#notes').val(GlobalVariables.settings.adminuser.notes);

        //$('#uploadFile').val(GlobalVariables.settings.header.logo);
        $('#header_color').val(GlobalVariables.settings.header.header_color);
        $('#header_back_color').val(GlobalVariables.settings.header.header_back_color);
        $('#header_caption').val(GlobalVariables.settings.header.header_caption);
        $('#footer_back_color').val(GlobalVariables.settings.header.footer_back_color);
        $('#description').val(GlobalVariables.settings.header.description);
        //$('#header').css('background-color', '#'+GlobalVariables.settings.header.header_color );
        
        //$('#username').val(GlobalVariables.settings.user.settings.username);
        $('#password, #retype-password').val('');
        
        if (GlobalVariables.settings.adminuser.settings.notifications == true) {
            $('#user-notifications').addClass('active');
        } else {
            $('#user-notifications').removeClass('active');
        }
        
        // Set default settings helper.
        AdminUserBackendSettings.settings = new SystemSettings();
        
        if (bindEventHandlers) {
            AdminUserBackendSettings.bindEventHandlers();
            $('#settings-page .nav li').first().addClass('active');
            $('#settings-page .nav li').first().find('a').trigger('click');
        }
        
        // Apply Privileges
        if (GlobalVariables.user.privileges.system_settings.edit == false) {
            $('#general, #business-logic').find('select, input, textarea').prop('readonly', true);
            $('#general, #business-logic').find('button').prop('disabled', true);
        }
        
        if (GlobalVariables.user.privileges.user_settings.edit == false) {
            $('#user').find('select, input, textarea').prop('readonly', true);
            $('#user').find('button').prop('disabled', true);
        }
        
        Backend.placeFooterToBottom();
    },
            
    /**
     * Bind the backend/settings default event handlers. This method depends on the 
     * backend/settings html, so do not use this method on a different page.
     */
    bindEventHandlers: function() {
        AdminUserBackendSettings.wp.bindEventHandlers();
        
        /**
         * Event: Tab "Click"
         * 
         * Change the visible tab contents.
         */
        $('.tab').click(function() {
            // Bootstrap has a bug with toggle buttons. Their toggle state is lost when the
            // button is hidden or shown. Show before anything else we need to store the toggle 
            // and apply it whenever the user tab is clicked..
            var areNotificationsActive = $('#user-notifications').hasClass('active');
            
            $(this).parent().find('.active').removeClass('active');
            $(this).addClass('active');
            $('.tab-content').hide();
            
            if ($(this).hasClass('general-tab')) { 
                $('#general').show();
                AdminUserBackendSettings.settings = new SystemSettings();
            } else if ($(this).hasClass('business-logic-tab')) { 
                $('#business-logic').show();
                AdminUserBackendSettings.settings = new SystemSettings();
            } else if ($(this).hasClass('user-tab')) {
                $('#user').show();
                AdminUserBackendSettings.settings = new UserSettings();
               
                // Apply toggle state to user notifications button.
                if (areNotificationsActive) {
                    $('#user-notifications').addClass('active');
                } else {
                    $('#user-notifications').removeClass('active');   
                }
            } else if ($(this).hasClass('about-tab')) {
                $('#about').show();
            }
            
            Backend.placeFooterToBottom();
        });
        
        /**
         * Event: Save Settings Button "Click"
         * 
         * Store the setting changes into the database.
         */

        $('.save-settings').click(function() {


            var settings = AdminUserBackendSettings.settings.get();
            settings.header = AdminUserBackendSettings.settings.getHeaderSettings();
            //settings.header_settings = AdminUserBackendSettings.settings.getHeaderSettings();
            //////////////////////////////////////////////
            console.log('settings:', settings);
            /////////////////////////////////////////////
            AdminUserBackendSettings.settings.save(settings);
            //////////////////////////////////////////////
            console.log('Settings To Save: ', settings);
            //////////////////////////////////////////////


        });

        $('.save-header').click(function() {
            var header = AdminUserBackendSettings.settings.getHeaderSettings();
            /////////////////////////////////////
            console.log(header);
            /////////////////////////////////////

            AdminUserBackendSettings.settings.saveHeader(header);

        });
        
        /**
         * Event: Username "Focusout" 
         * 
         * When the user leaves the username input field we will need to check if the username 
         * is not taken by another record in the system. Usernames must be unique.
         */
        $('#email').focusout(function() {
            var $input = $(this);
            
            if ($input.prop('readonly') == true || $input.val() == '') return;
            
            var postUrl = GlobalVariables.baseUrl + '/index.php/backend_api/ajax_validate_useremail';
            var postData = { 
                'csrfToken': GlobalVariables.csrfToken,
                'username': $input.val(), 
                'user_id': $input.parents().eq(2).find('#user-id').val()
            };
            
            $.post(postUrl, postData, function(response) {
                ///////////////////////////////////////////////////////
                //console.log('Validate Username Response:', response);
                ///////////////////////////////////////////////////////
                if (!GeneralFunctions.handleAjaxExceptions(response)) return;
                if (response == false) {
                    $input.css('border', '2px solid red');
                    Backend.displayNotification(EALang['username_already_exists']);
                    $input.attr('already-exists', 'true');
                } else {
                    $input.css('border', '');
                    $input.attr('already-exists', 'false');
                }
            }, 'json');
        });
    }
};

/**
 * "System Settings" Tab Helper
 * @class SystemSettings
 */
var SystemSettings = function() {};

/**
 * Save the system settings. This method is run after changes are detected on the 
 * tab input fields.
 * 
 * @param {array} settings Contains the system settings data.
 */
SystemSettings.prototype.save = function(settings) {
    var postUrl = GlobalVariables.baseUrl + '/index.php/backend_api/ajax_save_settings';
    var postData = {
        'csrfToken': GlobalVariables.csrfToken,
        'settings': JSON.stringify(settings),
        'type': AdminUserBackendSettings.SETTINGS_SYSTEM
    };
    
    $.post(postUrl, postData, function(response) {
        ///////////////////////////////////////////////////////////
        console.log('Save General Settings Response:', response);
        ///////////////////////////////////////////////////////////
        
        if (!GeneralFunctions.handleAjaxExceptions(response)) return;
       
        Backend.displayNotification(EALang['settings_saved']);
        
        // Update the logo title on the header.
        $('#header-logo span').text($('#company-name').val());
        
        // We need to refresh the working plan.
        var workingPlan = AdminUserBackendSettings.wp.get();
        $('.breaks').empty();
        AdminUserBackendSettings.wp.setup(workingPlan);
        AdminUserBackendSettings.wp.timepickers(false);
        
    }, 'json');
};

/**
 * Prepare the system settings array. This method uses the DOM elements of the 
 * backend/settings page, so it can't be used in another page.
 * 
 * @returns {array} Returns the system settings array.
 */
SystemSettings.prototype.get = function() {
    var settings = [];
    
    // General Settings Tab
    $('#general input').each(function() {
        settings.push({
            'name': $(this).attr('data-field'),
            'value': $(this).val()
        });
    });
    
    // Business Logic Tab
    settings.push({
        'name': 'company_working_plan',
        'value': JSON.stringify(AdminUserBackendSettings.wp.get())
    });
    
    settings.push({
        'name': 'book_advance_timeout',
        'value': $('#book-advance-timeout').val()
    });
    
    return settings;
};

/**
 * Validate the settings data. If the validation fails then display a 
 * message to the user.
 * 
 * @returns {bool} Returns the validation result.
 */
SystemSettings.prototype.validate = function() {
    $('#general .required').css('border', '');
    
    try {
        // Validate required fields.
        var missingRequired = false;
        $('#general .required').each(function() {
            if ($(this).val() == '' || $(this).val() == undefined) {
                $(this).css('border', '2px solid red');
                missingRequired = true;
            }
        });
        if (missingRequired) {
            throw EALang['fields_are_required'];
        }
        
        // Validate company email address.
        if (!GeneralFunctions.validateEmail($('#company-email').val())) {
            $('#company-email').css('border', '2px solid red');
            throw EALang['invalid_email'];
        }
        
        return true;
    } catch(exc) {
        Backend.displayNotification(exc);
        return false;
    }
};

/**
 * "User Settings" Tab Helper
 * @class UserSettings
 */
var UserSettings = function() {};

/**
 * Get the settings data for the user settings.
 * 
 * @returns {object} Returns the user settings array.
 */
UserSettings.prototype.get = function() {
    var user = {
        'id': $('#user-id').val(),
        'first_name': $('#first-name').val(),
        'last_name': $('#last-name').val(),
        'email': $('#email').val(),
        'mobile_number': $('#mobile-number').val(),
        'phone_number': $('#phone-number').val(),
        'address': $('#address').val(),
        'city': $('#city').val(),
        'state': $('#state').val(),
        'zip_code': $('#zip-code').val(),
        'notes': $('#notes').val(),
        'settings': {
            //'username': $('#username').val(),
            'notifications': $('#user-notifications').hasClass('active')
        }
    };
    
    if ($('#password').val() != '') {
        user.password = $('#password').val();
    }
    
    return user;
};

UserSettings.prototype.getHeaderSettings = function () {
    var header = {
        'id_admin': $('#user-id').val(),
        //'logo': $('#uploadFile').val(),
        'logo': $('#userfile').val(),
        'header_color': $('#header_color').val(),
        'header_back_color': $('#header_back_color').val(),
        'header_caption': $('#header_caption').val(),
        'footer_back_color': $('#footer_back_color').val(),
        'description': $('#description').val()
    };
    return header;
};

/**
 * Store the user settings into the database.
 * 
 * @param {array} settings Contains the user settings.
 */
UserSettings.prototype.save = function(settings) {
    if (!AdminUserBackendSettings.settings.validate(settings)) {
        Backend.displayNotification(EALang['user_settings_are_invalid']);
        return; // Validation failed, do not procceed.
    }


    var postUrl = GlobalVariables.baseUrl + '/index.php/backend_api/ajax_save_profile_settings';
    var postData = {
        'csrfToken': GlobalVariables.csrfToken,
        'type': AdminUserBackendSettings.SETTINGS_USER,
        'settings': JSON.stringify(settings)
    };


    $.post(postUrl, postData, function(response) {
        //////////////////////////////////////////////////////////
        console.log('Save User Settings Response: ', response);
        //////////////////////////////////////////////////////////

        if (!GeneralFunctions.handleAjaxExceptions(response)) return;
        Backend.displayNotification(EALang['settings_saved']);



        // Update footer greetings.
        $('#footer-user-display-name').text('Hello, ' + $('#first-name').val() + ' ' + $('#last-name').val() + '!');

    }, 'json');
};

UserSettings.prototype.saveHeader = function(admin_header) {

    var postUrl = GlobalVariables.baseUrl + '/index.php/backend_api/ajax_save_header_settings';
    var postData = {
        'csrfToken': GlobalVariables.csrfToken,
        'type': AdminUserBackendSettings.SETTINGS_HEADER,
        'header': JSON.stringify(admin_header)
    };

    $.post(postUrl, postData, function(response) {
        //////////////////////////////////////////////////////////////
        console.log('Save user header settings:', response);
        /////////////////////////////////////////////////////////////

        if(!GeneralFunctions.handleAjaxExceptions(response)) return;
        Backend.displayNotification((EALang['settings_saved']));

    }, 'json');

};

/**
 * Validate the settings data. If the validation fails then display a 
 * message to the user.
 * 
 * @returns {bool} Returns the validation result.
 */
UserSettings.prototype.validate = function() {
    $('#user .required').css('border', '');
    $('#user').find('#password, #retype-password').css('border', '');

    try {
        // Validate required fields.
        var missingRequired = false;
        $('#user .required').each(function() {
            if ($(this).val() == '' || $(this).val() == undefined) {
                $(this).css('border', '2px solid red');
                missingRequired = true;
            }
        });
        if (missingRequired) {
            throw EALang['fields_are_required'];
        }
        
        // Validate passwords (if provided).
        if ($('#password').val() != $('#retype-password').val()) {
            $('#password, #retype-password').css('border', '2px solid red');
            throw EALang['passwords_mismatch'];
        }
        
        // Validate user email.
        if (!GeneralFunctions.validateEmail($('#email').val())) {
            $('#email').css('border', '2px solid red');
            throw EALang['invalid_email'];
        }
        
        if ($('#email').attr('already-exists') === 'true') {
            $('#email').css('border', '2px solid red');
            throw EALang['username_already_exists'];
        }
        
        return true;
    } catch(exc) {
        Backend.displayNotification(exc);
        return false;
    }
};
