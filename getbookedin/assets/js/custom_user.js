/**
 * Created by user on 13-07-2015.
 */
/**
 * Custom created for custom user account generation
 * Used for Registration
 */
var UserSetting = {
    MIN_PASSWORD_LENGTH: 7
};
$(document).ready(function() {
    /**
     * Event: Save user button click
     * create new user
     */
    $('#save-user').click(function() {
        var user = {
            'first_name': $('#user-first-name').val(),
            'last_name': $('#user-last-name').val(),
            'email': $('#user-email').val(),
            'mobile_number': $('#user-mobile-number').val(),
            'phone_number': $('#user-phone-number').val(),
            'address': $('#user-address').val(),
            'city': $('#user-city').val(),
            'state': $('#user-state').val(),
            'zip_code': $('#user-zip-code').val(),
            'notes': $('#user-notes').val(),
            'settings': {
                'username': $('#user-username').val()
            }
        };

        //default service id
        user.services = [];
        user.services.push(13);

        // Include password if changed.
        if ($('#user-password').val() !== '') {
            user.settings.password = $('#user-password').val();
        }

        // Include id if changed.
        if ($('#user-id').val() !== '') {
            user.id = $('#user-id').val();
        }

        if (!UserSetting.validate()) return;

        UserSetting.save(user);

  //      BackendUsers.helper.save(user);
    });

    /**
     * Event: Cancel button click
     */
    $('#cancel-user').click(function() {
        UserSetting.resetForm();
    });



});

/**
 *
 * Save User record to database
 * @param {Object} user
 */
UserSetting.save = function(customer) {

    var postUrl = GlobalVariables.baseUrl+ '/index.php/backend_api/ajax_save_user';
    var postData = {
        'csrfToken': GlobalVariables.csrfToken,
        'user': JSON.stringify(customer)
    };

    $.post(postUrl, postData, function(respnse) {
        ///////////////////////////////////////////////////////////////////////
        console.log('Saved user:', respnse);
        //////////////////////////////////////////////////////////////////////

        if(!GeneralFunctions.handleAjaxExceptions(respnse)) return;

        //Backend.displayNotification(EALang['customer_saved']);
        UserSetting.resetForm();
        $('#users .form-message').text(EALang['customer_saved']);
        $('#users .form-message').show();
    }, 'json');
}

/**
 *
 * To validate the user details
 * @param user Object user details
 * @returns {boolean}
 */
UserSetting.validate = function() {
    $('#users .required').css('border', '');
    $('#user-password, #user-password-confirm').css('border', '');

    try {
        // Validate required fields.
        var missingRequired = false;
        $('#users .required').each(function() {
            if ($(this).val() == '' || $(this).val() == undefined) {
                $(this).css('border', '2px solid red');
                missingRequired = true;
            }
        });
        if (missingRequired) {
            throw EALang['fields_are_required'];
        }

        // Validate passwords.
        if ($('#user-password').val() != $('#user-password-confirm').val()) {
            $('#user-password, #user-password-confirm').css('border', '2px solid red');
            throw EALang['passwords_mismatch'];
        }

        if ($('#user-password').val().length < UserSetting.MIN_PASSWORD_LENGTH
            && $('#user-password').val() != '') {
            $('#user-password, #user-password-confirm').css('border', '2px solid red');
            throw EALang['password_length_notice'].replace('$number', UserSetting.MIN_PASSWORD_LENGTH);
        }

        // Validate user email.
        if (!GeneralFunctions.validateEmail($('#user-email').val())) {
        $('#user-email').css('border', '2px solid red');
        throw EALang['invalid_email'];
        }

        // Check if username exists
        if ($('#user-username').attr('already-exists') ==  'true') {
            $('#user-username').css('border', '2px solid red');
            throw EALang['username_already_exists'];
        }

        return true;
    } catch(exc) {
        $('#users .form-message').text(exc);
        $('#users .form-message').show();
        return false;
    }
}

/**
 * Reset user form to initial state
 */
UserSetting.resetForm = function() {

    $('#users .form-message').hide();
    $('#users .required').css('border', '');
    $('#user-password, #provider-password-confirm').css('border', '');
    $('#users .add-break, #reset-working-plan').prop('disabled', true);

    $('#users .user-view').find('input, textarea').val('');
    $('#users input[type="checkbox"]').prop('checked', false);
    $('#users .breaks tbody').empty();
}