 <?php
        // ------------------------------------------------------------
        // INCLUDE CSS FILES 
        // ------------------------------------------------------------ ?>
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
        href="<?php echo $this->config->item('base_url'); ?>/assets/css/libs/jquery/jquery-ui.min.css">
    <link 
        rel="stylesheet" 
        type="text/css" 
        href="<?php echo $this->config->item('base_url'); ?>/assets/css/libs/jquery/jquery.qtip.min.css">
    <link 
        rel="stylesheet" 
        type="text/css" 
        href="<?php echo $this->config->item('base_url'); ?>/assets/css/backend.css">
    <link 
        rel="stylesheet" 
        type="text/css" 
        href="<?php echo $this->config->item('base_url'); ?>/assets/css/general.css">
    <link 
        rel="stylesheet" 
        type="text/css" 
        href="<?php echo $this->config->item('base_url'); ?>/assets/css/libs/jquery/jquery.jscrollpane.css">
    <?php
        // ------------------------------------------------------------
        // INCLUDE JAVASCRIPT FILES 
        // ------------------------------------------------------------ ?>
     <script 
        type="text/javascript" 
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/libs/jquery/jquery.min.js"></script>
    <script 
        type="text/javascript" 
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/libs/jquery/jquery-ui.min.js"></script>
    <script 
        type="text/javascript" 
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/libs/jquery/jquery.qtip.min.js"></script>
    <script 
        type="text/javascript" 
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/libs/bootstrap/bootstrap.min.js"></script>
    <script 
        type="text/javascript" 
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/libs/date.js"></script>
    <script 
        type="text/javascript" 
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/libs/jquery/jquery.jscrollpane.min.js"></script>
    <script 
        type="text/javascript" 
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/libs/jquery/jquery.mousewheel.js"></script>
        
    <script type="text/javascript">
        // Global JavaScript Variables - Used in all backend pages.
        var availableLanguages = ["english"];
        var EALang = {"page_title":"Book Appointment With","step_one_title":"Select Service & Provider","select_service":"Select Service","select_provider":"Select Provider","duration":"Duration","minutes":"Minutes","price":"Price","back":"Back","step_two_title":"Select Appointment Date And Time","no_available_hours":"There are no available appointment hours for the selected date. Please choose another date.","appointment_hour_missing":"Please select an appointment hour before continuing!","step_three_title":"Fill In Your Information","first_name":"First Name","last_name":"Last Name","email":"Email","phone_number":"Phone Number","address":"Address","city":"City","zip_code":"Zip Code","notes":"Notes","fields_are_required":"Fields with * are required!","step_four_title":"Confirm Appointment","confirm":"Confirm","update":"Update","cancel_appointment_hint":"Press the \"Cancel\" button to remove the appointment from the company schedule.","cancel":"Cancel","appointment_registered":"Your appointment has been successfully registered!","cancel_appointment_title":"Cancel Appointment","appointment_cancelled":"Your appointment has been successfully cancelled!","appointment_cancelled_title":"Appointment Cancelled","reason":"Reason","appointment_removed_from_schedule":"The following appointment was removed from the company's schedule.","appointment_details_was_sent_to_you":"An email with the appointment details has been sent to you.","add_to_google_calendar":"Add to Google Calendar","appointment_booked":"Your appointment has been successfully booked!","thank_you_for_appointment":"Thank you for arranging an appointment with us. Below you can see the appointment details. Make changes by clicking the appointment link.","appointment_details_title":"Appointment Details","customer_details_title":"Customer Details","service":"Service","provider":"Provider","customer":"Customer","start":"Start","end":"End","name":"Name","phone":"Phone","appointment_link_title":"Appointment Link","success":"Success!","appointment_added_to_google_calendar":"Your appointment has been added to your Google Calendar account.","view_appointment_in_google_calendar":"Click here to view your appointment on Google Calendar.","appointment_added_to_your_plan":"A new appointment has been added to your plan.","appointment_link_description":"You can make changes by clicking the appointment link below.","appointment_not_found":"Appointment Not Found!","appointment_does_not_exist_in_db":"The appointment you requested does not exist in the system database anymore.","display_calendar":"Display Calendar","calendar":"Calendar","users":"Users","settings":"Settings","log_out":"Log Out","synchronize":"Synchronize","enable_sync":"Enable Sync","disable_sync":"Disable Sync","reload":"Reload","appointment":"Appointment","unavailable":"Unavailable","week":"Week","month":"Month","today":"Today","not_working":"Out of work hours","break":"Break","add":"Add","edit":"Edit","hello":"Hello","all_day":"All Day","manage_appointment_record_hint":"Manage all the appointment records of the available providers and services.","select_filter_item_hint":"Select a provider or a service and view the appointments on the calendar.","enable_appointment_sync_hint":"Enable appointment synchronization with provider's Google Calendar account.","manage_customers_hint":"Manage the registered customers and view their booking history.","manage_services_hint":"Manage the available services and categories of the system.","manage_users_hint":"Manage the backend users (admins, providers, secretaries).","settings_hint":"Set system and user settings.","log_out_hint":"Log out of the system.","unavailable_periods_hint":"During unavailable periods the provider won't accept new appointments.","new_appointment_hint":"Create a new appointment and store it into the database.","reload_appointments_hint":"Reload calendar appointments.","trigger_google_sync_hint":"Trigger the Google Calendar synchronization process.","appointment_updated":"Appointment updated successfully!","undo":"Undo","appointment_details_changed":"Appointment details have changed.","appointment_changes_saved":"Appointment changes have been successfully saved!","save":"Save","new":"New","select":"Select","hide":"Hide","type_to_filter_customers":"Type to filter customers.","clear_fields_add_existing_customer_hint":"Clear the fields and enter a new customer.","pick_existing_customer_hint":"Pick an existing customer.","new_appointment_title":"New Appointment","edit_appointment_title":"Edit Appointment","delete_appointment_title":"Delete Appointment","write_appointment_removal_reason":"Please take a minute to write the reason you are deleting the appointment:","appointment_saved":"Appointment saved successfully!","new_unavailable_title":"New Unavailable Period","edit_unavailable_title":"Edit Unavailable Period","unavailable_saved":"Unavailable period saved successfully!","start_date_before_end_error":"Start date value is bigger than end date!","invalid_email":"Invalid email address!","customers":"Customers","details":"Details","no_records_found":"No records found...","services":"Services","duration_minutes":"Duration (Minutes)","currency":"Currency","category":"Category","no_category":"No Category","description":"Description","categories":"Categories","admins":"Admins","providers":"Providers","secretaries":"Secretaries","mobile_number":"Mobile Number","state":"State","username":"Username","password":"Password","retype_password":"Retype Password","receive_notifications":"Receive Notifications","passwords_mismatch":"Passwords mismatch!","admin_saved":"Admin saved successfully!","provider_saved":"Provider saved successfully!","secretary_saved":"Secretary saved successfully!","admin_deleted":"Admin deleted successfully!","provider_deleted":"Provider deleted successfully!","secretary_deleted":"Secretary deleted successfully!","service_saved":"Service saved successfully!","service_category_saved":"Service category saved successfully!","service_deleted":"Service deleted successfully!","service_category_deleted":"Service category deleted successfully!","customer_saved":"Customer saved successfully!","customer_deleted":"Customer deleted successfully!","current_view":"Current View","working_plan":"Working Plan","reset_plan":"Reset Plan","monday":"Monday","tuesday":"Tuesday","wednesday":"Wednesday","thursday":"Thursday","friday":"Friday","saturday":"Saturday","sunday":"Sunday","breaks":"Breaks","add_breaks_during_each_day":"Add the working breaks during each day. During breaks the provider will not accept any appointments.","day":"Day","actions":"Actions","reset_working_plan_hint":"Reset the working plan back to the default values.","company_name":"Company Name","company_name_hint":"Company name will be displayed everywhere on the system (required).","company_email":"Company Email","company_email_hint":"This will be the company email address. It will be used as the sender and the reply address of the system emails (required).","company_link":"Company Link","company_link_hint":"Company link should point to the official website of the company (required).","go_to_booking_page":"Go To Booking Page","settings_saved":"Settings saved successfully!","general":"General","business_logic":"Business Logic","current_user":"Current User","about_ea":"About E!A","edit_working_plan_hint":"Mark below the days and hours that your company will accept appointments. You will be able to adjust appointments in non working hours but the customers will not be able to book appointments by themselves in non working periods. This working plan will be the default for every new provider record but you will be able to change each provider's plan separately by editing his record. After that you can add break periods.","edit_breaks_hint":"Add the working breaks during each day. These breaks will be applied for all new providers.","book_advance_timeout":"Book Advance Timeout","book_advance_timeout_hint":"Define the timeout (in minutes) before the customers can book or re-arrange appointments with the company.","timeout_minutes":"Timeout (Minutes)","about_ea_info":"Easy!Appointments is a highly customizable web application that allows your customers to book appointments with you via the web. Moreover, it provides the ability to sync your data with Google Calendar so you can use them with other services.","current_version":"Current Version","support":"Support","about_ea_support":"If you encounter any problems when using Easy!Appointments you can search the official Google Group for answers. You might also need to create a new issue on the Google Code page in order to help the development progress.","official_website":"Official Website","google_plus_community":"Google+ Community","support_group":"Support Group","project_issues":"Project Issues","license":"License","about_ea_license":"Easy!Appointments is licensed under the GPLv3 license. By using the code of Easy!Appointments in any way you are agreeing to the terms described in the following url:","logout_success":"You have been successfully logged out! Click on one of the following buttons to navigate to a different page.","book_appointment_title":"Book Appointment","backend_section":"Backend Section","you_need_to_login":"Welcome! You will need to login in order to view backend pages.","enter_username_here":"Enter your username here ...","enter_password_here":"Enter your password here ...","login":"Login","forgot_your_password":"Forgot Your Password?","login_failed":"Login failed, please enter the correct credentials and try again.","type_username_and_email_for_new_password":"Type your username and your email address to get your new password.","enter_email_here":"Enter your email here ...","regenerate_password":"Regenerate Password","go_to_login":"Go Back To Login Page","new_password_sent_with_email":"Your new password has been sent to you with an email.","new_account_password":"New Account Password","new_password_is":"Your new account password is $password. Please store this email to be able to retrieve your password if necessary. You can also change this password with a new one in the settings page.","delete_record_prompt":"Are you sure that you want to delete this record? This action cannot be undone.","delete_admin":"Delete Admin","delete_customer":"Delete Customer","delete_service":"Delete Service","delete_category":"Delete Service Category","delete_provider":"Delete Provider","delete_secretary":"Delete Secretary","delete_appointment":"Delete Appointment","delete_unavailable":"Delete Unavailable Period","delete":"Delete","unexpected_issues":"Unexpected Issues","unexpected_issues_message":"The operation could not complete due to unexpected issues.","close":"Close","page_not_found":"Page Not Found","page_not_found_message":"Unfortunately the page you requested does not exist. Please check your browser URL or head to another location using the buttons below.","error":"Error","no_privileges":"No Privileges","no_provileges_message":"You do not have the required privileges to view this page. Please navigate to a different section.","backend_calendar":"Backend Calendar","start_date_time":"Start Date \/ Time","end_date_time":"End Date \/ Time","licensed_under":"Licensed Under","unexpected_issues_occurred":"Unexpected issues occurred!","service_communication_error":"A server communication error occurred, please try again.","no_privileges_edit_appointments":"You do not have the required privileges to edit appointments.","unavailable_updated":"Unavailable time period updated successfully!","appointments":"Appointments","unexpected_warnings":"Unexpected Warnings","unexpected_warnings_message":"The operation completed but some warnings appeared.","filter":"Filter","clear":"Clear","uncategorized":"Uncategorized","username_already_exists":"Username already exists.","password_length_notice":"Password must be at least $number characters long.","general_settings":"General Settings","personal_information":"Personal Information","system_login":"System Login","user_settings_are_invalid":"User settings are invalid! Please review your settings and try again.","add_break":"Add Break","january":"January","february":"February","march":"March","april":"April","may":"May","june":"June","july":"July","august":"August","september":"September","october":"October","november":"November","december":"December","previous":"Previous","next":"Next","now":"Now","select_time":"Select Time","time":"Time","hour":"Hour","minute":"Minute","google_sync_completed":"Google synchronization completed successfully!","google_sync_failed":"Google synchronization failed: Could not establish server connection.","select_google_calendar":"Select Google Calendar","select_google_calendar_prompt":"Select the calendar that you want to sync your appointments. If you do not want to select a specific calendar the default one will be used.","google_calendar_selected":"Google calendar has been successfully selected!","oops_something_went_wrong":"Oops! Something Went Wrong!","could_not_add_to_google_calendar":"Your appointment could not be added to your Google Calendar account.","ea_update_success":"Easy!Appointments has been successfully updated!"};
            EALang = <?php echo json_encode($this->lang->language); ?>;
        var appointmetDuration = <?php echo $appointment_duration; ?>;
    </script>

    <script
        type="text/javascript"
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/libs/jquery/jquery-ui-timepicker-addon.js"></script>
	<script
        type="text/javascript"
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/general_functions.js"></script>
	
	<link rel="stylesheet" type="text/css"
        href="<?php echo $this->config->item('base_url'); ?>/assets/css/libs/jquery/fullcalendar.css" />

    <script
        type="text/javascript"
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/libs/jquery/fullcalendar.min.js"></script>

    <script
        type="text/javascript"
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/libs/jquery/jquery-ui-timepicker-addon.js"></script>
        
    <script
        type="text/javascript"
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/userview_backend_calendar.js"></script>
       
    <script
        type="text/javascript"
        src="<?php echo $this->config->item('base_url'); ?>/assets/js/backend.js"></script>

    <script type="text/javascript">
        var GlobalVariables = {
                'csrfToken'             : <?php echo json_encode($this->security->get_csrf_hash()); ?>,
                'availableProviders'    : <?php echo json_encode($available_providers); ?>,
                'availableServices'     : <?php echo json_encode($available_services); ?>,
                'baseUrl'               : "<?php echo $this->config->item('base_url'); ?>",
                'bookAdvanceTimeout'    : 30,
                'editAppointment'       : <?php echo json_encode($edit_appointment); ?>,
                'customers'             : <?php echo json_encode($customers); ?>,
                'secretaryProviders'    : <?php echo json_encode($secretary_providers); ?>,
                'availableAdminUsers'   : <?php echo json_encode($available_adminusers); ?>,
                'subdomain'             : <?php echo json_encode($subdomain); ?>,
                'adminuserHeader'       : <?php echo json_encode($adminuser_header); ?>,
                'user'                  : {
                    'id'        : <?php echo $this->session->userdata('who'); ?>,
                    'email'     : <?php echo '"' . $this->session->userdata('user_email') . '"'; ?>,
                    'role_slug' : <?php echo '"' . $this->session->userdata('role_slug') . '"'; ?>,
                    'privileges':{"appointments":{"view":true,"add":true,"edit":true,"delete":true},"customers":{"view":true,"add":true,"edit":true,"delete":true},"services":{"view":true,"add":true,"edit":true,"delete":true},"users":{"view":true,"add":true,"edit":true,"delete":true},"system_settings":{"view":true,"add":true,"edit":true,"delete":true},"user_settings":{"view":true,"add":true,"edit":true,"delete":true}}        }
            };

            $(document).ready(function() {
                UserviewBackendCalendar.initialize(true);
            });

            $(document).ready(function(){
                $(".fc-header").css('width','');
            });

            function updateAdmin(val)
            {
                document.getElementById("admin_user").value=val;
            }

           $(document).ready(function(){
                $("#admin_user").val($("#select-filter-item").val());
                $("#select-filter-item").change(function(){
                    $("#admin_user").val($("#select-filter-item").val());
                    });

               $('#hs_header').css('background-color', '#'+GlobalVariables.adminuserHeader.header_back_color );
               $('.hs_copyright').css('background-color', '#'+GlobalVariables.adminuserHeader.footer_back_color );
               $('#hs_header .hs_menu li > a').css('color', '#'+GlobalVariables.adminuserHeader.header_color );
           });
    </script>
     <style type="text/css">
         #calendar-page #calendar-toolbar {
             border-bottom: 1px solid #D6D6D6;
             background: #3A3A3A none repeat scroll 0% 0%;
             padding: 10px;
             height: 59px;
             color: #FFF;
         }
         #calendar-page #calendar {
             margin: 6px 0px;
         }
     </style>


   <div class="col-lg-9 col-md-8 col-sm-8">

<div id="calendar-page">
   <div id="calendar-toolbar">
        <div id="calendar-filter" >
            <label for="select-filter-item">
            <!--  Select Sub-domain :-->
                <?php echo $adminuser_header['header_caption'];?>
            </label>
          <select style="display: none;" id="select-filter-item"
                    title="<?php echo $this->lang->line('select_filter_item_hint'); ?>" onchange="updateAdmin(this.value)">
          </select>
        </div>
        
        <div id="calendar-actions">
            <div class="btn-group">
                <?php //if ($privileges[PRIV_USERS]['edit'] == TRUE) { ?>
                <?php if (($role_slug == DB_SLUG_ADMIN || $role_slug == DB_SLUG_PROVIDER)
                        && $this->config->item('ea_google_sync_feature') == TRUE) { ?>
                <button id="google-sync" class="btn btn-primary" 
                        title="<?php echo $this->lang->line('trigger_google_sync_hint'); ?>">
                    <i class="icon-refresh icon-white"></i>
                    <span><?php echo $this->lang->line('synchronize'); ?></span>
                </button>

                <button id="enable-sync" class="btn" data-toggle="button" 
                        title="<?php echo $this->lang->line('enable_appointment_sync_hint'); ?>">
                    <i class="icon-calendar"></i>
                    <span><?php echo $this->lang->line('enable_sync'); ?></span>
                </button>
                <?php } ?>
                
           <!--       <button id="reload-appointments" class="btn" 
                        title="<?php echo $this->lang->line('reload_appointments_hint'); ?>">
                    <i class="icon-repeat"></i>
                    <span><?php echo $this->lang->line('reload'); ?></span>
                </button>-->
            </div>
            
            <?php //if ($privileges[PRIV_APPOINTMENTS]['add'] == TRUE) { ?>
            <div class="btn-group">
              <!--   <button id="insert-appointment" class="btn btn-info" 
                        title="<?php echo $this->lang->line('new_appointment_hint'); ?>">
                    <i class="icon-plus icon-white"></i>
                    <span><?php echo $this->lang->line('appointment'); ?></span>
                </button> -->

             <!--    <button id="insert-unavailable" class="btn" 
                        title="<?php echo $this->lang->line('unavailable_periods_hint'); ?>">
                    <i class="icon-plus"></i>
                    <span><?php echo $this->lang->line('unavailable'); ?></span>
                </button> -->
            </div>
            <?php // } ?>
        </div> 
    </div>
    <div id="calendar"></div> <?php // Main calendar container ?>
</div>

<?php
    // --------------------------------------------------------------------
    //
    // MANAGE APPOINTMENT
    //
    // --------------------------------------------------------------------
?>
<div id="manage-appointment" class="modal fade" data-keyboard="true" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" 
                aria-hidden="true">&times;</button>
        <h3><?php echo $this->lang->line('edit_appointment_title'); ?></h3>
    </div>
    
    <div class="modal-body">
        <div class="modal-message alert" style="display: none;"></div>
        
        <form class="form-horizontal">
            <fieldset>
                <legend><?php echo $this->lang->line('appointment_details_title'); ?></legend>
                
                <input id="appointment-id" type="hidden" />
                
                
                <div class="control-group">
                    <label for="select-service" class="control-label" style="display: none"><?php echo $this->lang->line('service'); ?> *</label>
                    <div class="controls">
                   <input type="hidden" value="13" id="select-service" style="display: none" />
                         <select  class="span4 rest" style="display: none">
                            <?php 
                                // Group services by category, only if there is at least one service 
                                // with a parent category.
                                foreach($available_adminusers as $service) {
                                    if ($service['category_id'] != NULL) {
                                        $has_category = TRUE;
                                        break;
                                    }
                                }
                                
                                if ($has_category) {
                                    $grouped_services = array();

                                    foreach($available_adminusers as $service) {
                                        if ($service['category_id'] != NULL) {
                                            if (!isset($grouped_services[$service['category_name']])) {
                                                $grouped_services[$service['category_name']] = array();
                                            }

                                            $grouped_services[$service['category_name']][] = $service;
                                        } 
                                    }

                                    // We need the uncategorized services at the end of the list so
                                    // we will use another iteration only for the uncategorized services.
                                    $grouped_services['uncategorized'] = array();
                                    foreach($available_adminusers as $service) {
                                        if ($service['category_id'] == NULL) {
                                            $grouped_services['uncategorized'][] = $service;
                                        }
                                    }

                                    foreach($grouped_services as $key => $group) {
                                        $group_label = ($key != 'uncategorized')
                                                ? $group[0]['category_name'] : 'Uncategorized';
                                        
                                        if (count($group) > 0) {
                                            echo '<optgroup label="' . $group_label . '">';
                                            foreach($group as $service) {
                                                echo '<option value="' . $service['id'] . '">' 
                                                    . $service['subdomain_name'] . '</option>';
                                            }
                                            echo '</optgroup>';
                                        }
                                    }
                                }  else {
                                    foreach($available_adminusers as $service) {

                                            echo '<option value="' . $service['id'] . '" >'
                                                . $service['subdomain']['subdomain_name'] . '</option>';

                                    }
                                }
                            ?>
                        </select> 
                       
                        <input type="hidden" value="" id="admin_user" class="required span4 rest">
                         <input type="hidden"  value="13" id="select-service" class="required span4 rest"> 
                        <input type="hidden" readonly="readonly" value="86"  id="select-provider" class="required span4 "> 
                    </div>
                </div>
                
                 <div class="control-group">
<!--                    <label for="select-provider" class="control-label">--><?php //echo $this->lang->line('provider'); ?><!-- *</label>-->
<!--                    <div class="controls">-->
<!--                        <select id="select-provider" class="required span4 "></select>-->
<!--                    </div>-->
                     <label for="select-adminuser" class="control-label"><?php echo $this->lang->line('adminuser'); ?> *</label>
                     <div class="controls">
                         <select id="select-adminuser" class="required span4"></select>
                     </div>
                </div>
                
                <div class="control-group">
                    <label for="start-datetime" class="control-label"><?php echo $this->lang->line('start_date_time'); ?></label>
                    <div class="controls">
                        <input type="text" id="start-datetime" class="rest" readonly style="background-color: #FFF;"/>
                    </div>
                </div>
                
                <div class="control-group">
                    <label for="end-datetime" class="control-label"><?php echo $this->lang->line('end_date_time'); ?></label>
                    <div class="controls">
                        <input type="text" id="end-datetime" class="rest" readonly style="background-color: #FFF;"/>
                    </div>
                </div>
                
                <div class="control-group">
                    <label for="appointment-notes" class="control-label"><?php echo $this->lang->line('notes'); ?></label>
                    <div class="controls">
                        <textarea id="appointment-notes" class="span4" rows="3"></textarea>
                    </div>
                </div>
            </fieldset>

           
             

              <input id="customer-id" type="hidden" value="<?php echo $this->session->userdata('who'); ?>">
                
               <?php //print_r($user);?>
                    <input type="hidden" id="first-name" class="required" value="<?php echo $user[0]->first_name; ?>" />
                    <input type="hidden" id="last-name" class="required" value="<?php echo $user[0]->last_name; ?>" />
                    <input type="hidden" id="email" class="required" value="<?php echo $user[0]->email; ?>"/>
                    <input type="hidden" id="phone-number" class="required" value="<?php echo $user[0]->mobile_number; ?>"/>
                    <input type="hidden" id="gender" class="required" value="<?php echo $user[0]->gender; ?>"/>
                    <input type="hidden" id="customer-notes" value="<?php echo $user[0]->notes; ?>"/>
                    <input type="hidden" id="csrftwo" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
        </form>
    </div>
    
    <div class="modal-footer">
        <button id="save-appointment" class="btn btn-primary">
            <?php echo $this->lang->line('save'); ?>
        </button>
        <button id="cancel-appointment" class="btn">
            <?php echo $this->lang->line('cancel'); ?>
        </button>
    </div>
</div>

<?php
    // --------------------------------------------------------------------
    //
    // MANAGE UNAVAILABLE
    //
    // --------------------------------------------------------------------
?>
<div id="manage-unavailable" class="modal  fade" data-keyboard="true" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" 
                aria-hidden="true">&times;</button>
        <h3><?php echo $this->lang->line('new_unavailable_title'); ?></h3>
    </div>
    
    <div class="modal-body">
        <div class="modal-message alert" style="display: none;"></div>
        
        <form class="form-horizontal">
            <fieldset>
                <input id="unavailable-id" type="hidden" />
                
                <div class="control-group">
                    <label for="unavailable-start" class="control-label">
                        <?php echo $this->lang->line('start'); ?>
                    </label>
                    <div class="controls">
                        <input type="text" id="unavailable-start" />
                    </div>
                </div>
                
                <div class="control-group">
                    <label for="unavailable-end" class="control-label">
                        <?php echo $this->lang->line('end'); ?>
                    </label>
                    <div class="controls">
                        <input type="text" id="unavailable-end" />
                    </div>
                </div>
                
                <div class="control-group">
                    <label for="unavailable-notes" class="control-label">
                        <?php echo $this->lang->line('notes'); ?>
                    </label>
                    <div class="controls">
                        <textarea id="unavailable-notes" rows="3" class="span3"></textarea>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    
    <div class="modal-footer">
        <button id="save-unavailable" class="btn btn-primary">
            <?php echo $this->lang->line('save'); ?>
        </button>
        <button id="cancel-unavailable" class="btn">
            <?php echo $this->lang->line('cancel'); ?>
        </button>
    </div>
</div>

<?php
    // --------------------------------------------------------------------
    //
    // SELECT GOOGLE CALENDAR
    //
    // --------------------------------------------------------------------
?>
<div id="select-google-calendar" class="modal hide fade" data-keyboard="true" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" 
                aria-hidden="true">&times;</button>
        <h3><?php echo $this->lang->line('select_google_calendar'); ?></h3>
    </div>
    
    <div class="modal-body">
        <p>
            <?php echo $this->lang->line('select_google_calendar_prompt'); ?>
        </p>
        <select id="google-calendar"></select>
    </div>
    
    <div class="modal-footer">
        <button id="select-calendar" class="btn btn-primary">
            <?php echo $this->lang->line('select'); ?>
        </button>
        <button id="close-calendar" class="btn">
            <?php echo $this->lang->line('close'); ?>
        </button>
    </div>
</div>
</div>
</div>
</div>
