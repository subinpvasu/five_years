<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminuser extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        // Set user's selected language.
        if ($this->session->userdata('language')) {
            $this->config->set_item('language', $this->session->userdata('language'));
            $this->lang->load('translations', $this->session->userdata('language'));
        } else {
            $this->lang->load('translations', $this->config->item('language')); // default
        }

        //upload
        $this->load->helper(array('form', 'url'));

    }

    public function index($appointment_hash = '') {


        if(!$this->domainCheck()) return;
        $this->session->set_userdata('dest_url', $this->config->item('base_url') . '/index.php/adminuser');
        if (!$this->hasPrivileges(PRIV_APPOINTMENTS)) return;

        $this->load->model('appointments_model');
        $this->load->model('providers_model');
        $this->load->model('services_model');
        $this->load->model('customers_model');
        $this->load->model('settings_model');
        $this->load->model('roles_model');
        $this->load->model('user_model');
        $this->load->model('secretaries_model');
        $this->load->model('admin_model');

        $view['base_url'] = $this->config->item('base_url');
        $view['user_display_name'] = $this->user_model->get_user_display_name($this->session->userdata('user_id'));
        $view['active_menu'] = PRIV_APPOINTMENTS;
        $view['book_advance_timeout'] = $this->settings_model->get_setting('book_advance_timeout');
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $view['available_providers'] = $this->providers_model->get_available_providers();
        $view['available_services'] = $this->services_model->get_available_services();
        $view['customers'] = $this->customers_model->get_batch();
        $view['available_adminusers'] = $this->admin_model->get_available_adminusers();
        $view['appointment_duration'] = $this->admin_model->get_settings_name('duration', $this->session->userdata('user_id'));
        $this->setUserData($view);

        if ($this->session->userdata('role_slug') == DB_SLUG_SECRETARY) {
            $secretary = $this->secretaries_model->get_row($this->session->userdata('user_id'));
            $view['secretary_providers'] = $secretary['providers'];
        } else {
            $view['secretary_providers'] = array();
        }


        $results = $this->appointments_model->get_batch(array('hash' => $appointment_hash));
        if ($appointment_hash != '' && count($results) > 0) {
            $appointment = $results[0];
            $appointment['customer'] = $this->customers_model->get_row($appointment['id_users_customer']);
            $view['edit_appointment'] = $appointment; // This will display the appointment edit dialog on page load.
        } else {
            $view['edit_appointment'] = NULL;
        }


        $this->load->view('adminuser/header', $view);
        $this->load->view('adminuser/calendar', $view);
        $this->load->view('adminuser/footer', $view);
    }

    public function customers() {
        $this->session->set_userdata('dest_url', $this->config->item('base_url') . '/index.php/adminuser/customers');
        if (!$this->hasPrivileges(PRIV_CUSTOMERS)) return;

        $this->load->model('providers_model');
        $this->load->model('customers_model');
        $this->load->model('services_model');
        $this->load->model('settings_model');
        $this->load->model('user_model');
        $this->load->model('admin_model');

        $view['base_url'] = $this->config->item('base_url');
        $view['user_display_name'] = $this->user_model->get_user_display_name($this->session->userdata('user_id'));
        $view['active_menu'] = PRIV_CUSTOMERS;
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $view['customers'] = $this->customers_model->get_batch();
        $view['available_providers'] = $this->providers_model->get_available_providers();
        $view['available_services'] = $this->services_model->get_available_services();
        $view['appointment_duration'] = $this->admin_model->get_settings_name('duration', $this->session->userdata('user_id'));
        $this->setUserData($view);

        $this->load->view('adminuser/header', $view);
        $this->load->view('adminuser/customers', $view);
        $this->load->view('adminuser/footer', $view);
    }

    public function profile() {
        $this->session->set_userdata('dest_url', $this->config->item('base_url') . '/index.php/adminuser/profile');
        if (!$this->hasPrivileges(PRIV_SYSTEM_SETTINGS, FALSE)
            && !$this->hasPrivileges(PRIV_USER_SETTINGS)) return;

        $this->load->model('settings_model');
        $this->load->model('user_model');
        $this->load->model('admin_model');

        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');

        $view['base_url'] = $this->config->item('base_url');
        $view['user_display_name'] = $this->admin_model->get_admin_display_name($user_id);
        $view['active_menu'] = PRIV_SYSTEM_SETTINGS;
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $view['role_slug'] = $this->session->userdata('role_slug');
        $view['system_settings'] = $this->settings_model->get_settings();
        $view['user_settings'] = $this->user_model->get_settings($user_id);
        $view['adminuser_settings'] = $this->admin_model->get_settings($user_id);
        $view['adminuser_header'] = $this->admin_model->get_header($user_id);
        $view['appointment_duration'] = $this->admin_model->get_settings_name('duration', $this->session->userdata('user_id'));
        $this->setUserData($view);

        $this->load->view('adminuser/header', $view);
        $this->load->view('adminuser/upload', $view);
        $this->load->view('adminuser/footer', $view);

    }

    public function user() {
        $this->session->set_userdata('dest_url', $this->config->item('base_url'). '/index.php/adminuser/user');
        if(!$this->hasPrivileges(PRIV_USERS)) return;

        $this->load->model('providers_model');
        $this->load->model('secretaries_model');
        $this->load->model('admins_model');
        $this->load->model('services_model');
        $this->load->model('settings_model');
        $this->load->model('user_model');
        $this->load->model('admin_model');

        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');

        $view['base_url'] = $this->config->item('base_url');
        $view['user_display_name'] = $this->user_model->get_user_display_name($this->session->userdata('user_id'));
        $view['active_menu'] = PRIV_USERS;
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $view['admins'] = $this->admins_model->get_batch();
        $view['providers'] = $this->providers_model->get_batch();
        $view['secretaries'] = $this->secretaries_model->get_batch();
        $view['services'] = $this->services_model->get_batch();
        $view['working_plan'] = $this->settings_model->get_setting('company_working_plan');
        $view['adminuser_settings'] = $this->admin_model->get_settings($user_id);
        $view['adminuser_header'] = $this->admin_model->get_header($user_id);
        $view['appointment_duration'] = $this->admin_model->get_settings_name('duration', $this->session->userdata('user_id'));
        $this->setUserData($view);

        $this->load->view('adminuser/header', $view);
        $this->load->view('adminuser/user', $view);
        $this->load->view('adminuser/footer', $view);
    }

    public function home($appointment_hash = '') {

        if($this->session->userdata('who')) {
            header('Location: ' . $this->config->item('base_url') . '/index.php/user/register');
        }else {
            header('Location: ' . $this->config->item('base_url') . '/index.php/user/index');
        }

        $this->session->set_userdata('dest_url', $this->config->item('base_url'). '/index.php/adminuser/home');

        $this->load->model('appointments_model');
        $this->load->model('providers_model');
        $this->load->model('services_model');
        $this->load->model('customers_model');
        $this->load->model('settings_model');
        $this->load->model('roles_model');
        $this->load->model('user_model');
        $this->load->model('secretaries_model');
        $this->load->model('admin_model');

        $view['base_url'] = $this->config->item('base_url');
        if($this->session->userdata('user_id') != "" ) {
            $view['user_display_name'] = $this->user_model->get_user_display_name($this->session->userdata('user_id'));
            $view['adminuser_settings'] = $this->admin_model->get_settings($this->session->userdata('user_id'));
            $view['adminuser_header'] = $this->admin_model->get_header($this->session->userdata('user_id'));
        } else {
            $view['user_display_name'] = "";
            $view['adminuser_settings'] = "";
            $view['adminuser_header'] = "";
        }
        $view['active_menu'] = PRIV_APPOINTMENTS;
        $view['book_advance_timeout'] = $this->settings_model->get_setting('book_advance_timeout');
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $view['available_providers'] = $this->providers_model->get_available_providers();
        $view['available_services'] = $this->services_model->get_available_services();
        $view['customers'] = $this->customers_model->get_batch();
        $view['available_adminusers'] = $this->admin_model->get_available_adminusers();
        $view['appointment_duration'] = $this->admin_model->get_settings_name('duration', $this->session->userdata('user_id'));
        $this->setUserData($view);



//        if ($this->session->userdata('role_slug') == DB_SLUG_SECRETARY) {
//            $secretary = $this->secretaries_model->get_row($this->session->userdata('user_id'));
//            $view['secretary_providers'] = $secretary['providers'];
//        } else {
//            $view['secretary_providers'] = array();
//        }


        $results = $this->appointments_model->get_batch(array('hash' => $appointment_hash));
        if ($appointment_hash != '' && count($results) > 0) {
            $appointment = $results[0];
            $appointment['customer'] = $this->customers_model->get_row($appointment['id_users_customer']);
            $view['edit_appointment'] = $appointment; // This will display the appointment edit dialog on page load.
        } else {
            $view['edit_appointment'] = NULL;
        }

        //        $this->load->view('userhome/header', $view);
//        $this->load->view('userhome/calendar', $view);
//        $this->load->view('userhome/footer', $view);

        $this->load->helper(array('form', 'url'));
        $this->load->view('template/header', $view);
        $this->load->view('template/header_menu', $view);
        $this->load->view('template/index', $view);
        $this->load->view('template/footer', $view);

    }


    public function setUserData(&$view) {
        $this->load->model('roles_model');

        // Get privileges
        $view['user_id'] = $this->session->userdata('user_id');
        $view['user_email'] = $this->session->userdata('user_email');
        $view['role_slug'] = $this->session->userdata('role_slug');
        $view['privileges'] = $this->roles_model->get_privileges($this->session->userdata('role_slug'));
    }

    /**
     * @param $page
     * @param bool $redirect
     * @return bool
     */
    private function hasPrivileges($page, $redirect = TRUE) {
        // Check if user is logged in.
        $user_id = $this->session->userdata('user_id');
        if ($user_id == FALSE) { // User not logged in, display the login view.
            if ($redirect) {
                //header('Location: ' . $this->config->item('base_url') . '/index.php/user/login');
//                header('Location: ' . $this->config->item('base_url') . '/index.php/admin/login');
                header('Location: ' . $this->config->item('base_url') . '/index.php/admin');
            }
            return FALSE;
        }

        // Check if the user has the required privileges for viewing the selected page.
        $role_slug = $this->session->userdata('role_slug');
        $role_priv = $this->db->get_where('ea_roles', array('slug' => $role_slug))->row_array();
        if ($role_priv[$page] < PRIV_VIEW) { // User does not have the permission to view the page.
            if ($redirect) {
                header('Location: ' . $this->config->item('base_url') . '/index.php/user/no_privileges');
            }
            return FALSE;
        }

        return TRUE;
    }

    private function domainCheck() {
        $subdomain_arr = explode('.', $_SERVER['HTTP_HOST']); //creates the various parts
        if (count($subdomain_arr) > 2) {
            $subdomain_name = $subdomain_arr[0];

            if($subdomain_name == 'www') {
                $subdomain_name = $subdomain_arr[1];
            }


            $this->load->model('subdomain_model');

            $result = $this->subdomain_model->get_domain_info($subdomain_name);
            if($result) {
//                header('Location: ' . $this->config->item('base_url') . '/index.php/adminuser/home');
                header('Location: ' . $this->config->item('base_url') . '/index.php/user/index');

            }else {
//                header('Location: ' . 'http://appointment.com/index.php/admin/no_subdomain');
                header('Location: ' . $this->config->item('base_url') .'/index.php/admin/no_subdomain');
            }
            return FALSE;

        }

        return TRUE;

    }


}